<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Enums\StatusEnum;
  use App\Enums\VolatilityEnum;
  use App\Exceptions\ApiResponseException;
  use App\Http\Controllers\Controller;
  use App\Http\Requests\SaveArticleCategoryRequest;
  use App\Http\Requests\SaveCategoryRequest;
  use App\Http\Requests\SaveFeatureRequest;
  use App\Http\Requests\StoreGameRequest;
  use App\Http\Resources\FeatureResource;
  use App\Http\Resources\GameCategoryResource;
  use App\Http\Resources\GameResource;
  use App\Interfaces\FeatureInterface;
  use App\Interfaces\GameCategoryInterface;
  use App\Interfaces\GameRepositoryInterface;
  use App\Models\Game;
  use App\Models\GameDetails;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;
  use DB;
  use Illuminate\Support\Js;
  use Psy\Util\Json;

  class GamesController extends Controller
  {
    private GameRepositoryInterface $gameRepository;

    /**
     * @param GameRepositoryInterface $gameRepository
     */
    public function __construct(GameRepositoryInterface $gameRepository)
    {
      $this->gameRepository = $gameRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
      $data = $this->gameRepository->index($request->all());

      return ApiResponseClass::sendResponse($data, '', 200);
    }

    /**
     * @param StoreGameRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreGameRequest $request): JsonResponse
    {
      DB::beginTransaction();
      $details = [
        'game_name' => $request->game_name,
        'meta_title' => $request->game_name,
        'game_status' => StatusEnum::DRAFT,
        'created_by' => auth()->user()->id,
        'volatility' => VolatilityEnum::NA->value,
      ];

      try {
        $game = $this->gameRepository->store($details);

        DB::commit();
        return ApiResponseClass::sendResponse(
          new GameResource($game),
          'Game was created as DRAFT at ' . now()->toDateTimeLocalString() . ' with ID ' . $game->id,
          201
        );

      } catch (\Exception $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendResponse(['error' => $ex->getMessage()], 'Error');
      }
    }

    /**
     * @return JsonResponse
     */
    public function getLastDraft(): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->gameRepository->getlastDraft(), 'Success');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getGameById(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->gameRepository->getById($request->get('id')), 'Success');
    }

    /**
     * @param SaveCategoryRequest $request
     * @param GameCategoryInterface $category
     * @return JsonResponse
     */
    public function saveCategory(SaveArticleCategoryRequest $request, GameCategoryInterface $category): JsonResponse
    {
      DB::beginTransaction();
      $details = [
        'name' => $request->name,
        'meta_title' => $request->has('meta_title') ? $request->meta_title : $request->name,
        'is_active' => $request->has('is_active') ? (int)$request->is_active : 1,
      ];

      try {
        $savedCategory = $category->save($details, $request->get('id'));

        DB::commit();
        return ApiResponseClass::sendResponse(
          new GameCategoryResource($savedCategory),
          'Category was saved successfuly',
          201
        );

      } catch (\Exception $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendResponse(['error' => $ex->getMessage()], 'Error');
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteCategory(Request $request, GameCategoryInterface $category): JsonResponse
    {
      return ApiResponseClass::sendResponse($category->delete($request->get('id')), 'The category was deleted successfuly');
    }

    /**
     * @param Request $request
     * @param GameCategoryInterface $category
     * @return JsonResponse
     */
    public function categoriesList(Request $request, GameCategoryInterface $category): JsonResponse
    {
      $data = $category->itemList($request->all());

      return ApiResponseClass::sendResponse($data, '', 200);
    }

    /**
     * @param GameCategoryInterface $category
     * @return JsonResponse
     */
    public function gameCategoriesSelector(GameCategoryInterface $category): JsonResponse
    {
      return ApiResponseClass::sendResponse(GameCategoryResource::collection($category->index()), '');
    }

    /**
     * @param SaveFeatureRequest $request
     * @param FeatureInterface $feature
     * @return JsonResponse
     */
    public function saveFeature(SaveFeatureRequest $request, FeatureInterface $feature): JsonResponse
    {
      DB::beginTransaction();
      $details = [
        'name' => $request->name,
        'long_name' => $request->long_name,
        'content' => $request->get('content'),
        'is_active' => (int)$request->is_active,
        'is_highlighted' => (int)$request->is_highlighted,
      ];

      try {
        $savedFeature = $feature->save($details, $request->get('id'));

        DB::commit();
        return ApiResponseClass::sendResponse(
          new FeatureResource($savedFeature),
          'Feature was saved successfuly',
          201
        );

      } catch (\Exception $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendResponse(['error' => $ex->getMessage()], 'Error');
      }
    }

    /**
     * @param Request $request
     * @param FeatureInterface $feature
     * @return JsonResponse
     */
    public function featuresList(Request $request, FeatureInterface $feature): JsonResponse
    {
      return ApiResponseClass::sendResponse($feature->index($request->all()), 'Success');
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
      $product = $this->gameRepository->getById($request->get('id'));

      return ApiResponseClass::sendResponse(new GameResource($product), '', 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
      DB::beginTransaction();
      $details = $request->except(['id', 'DELETED', 'deleted_by', 'created_at', 'updated_at', 'created_by', 'thumbnail_url', 'demo_img_url', 'description_img_url', 'thumbnail', 'demo_img', 'description_img', 'thumbnail_small', 'thumbnail_small_url']);

      if (isset($details['volatility'])) {
        $details['volatility_order_points'] = VolatilityEnum::valuePoints($details['volatility']);
      }

      try {
        $game = $this->gameRepository->update($details, $request->get('id'));

        DB::commit();
        return ApiResponseClass::sendResponse(
          $game,
          'The game is saved successfuly',
          201
        );

      } catch (\Exception $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendResponse(['error' => $ex->getMessage()], 'Error');
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteGame(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->gameRepository->delete($request->get('id')), 'The game was deleted successfuly');
    }

    /**
     * @param Request $request
     * @param FeatureInterface $feature
     * @return JsonResponse
     */
    public function deleteFeature(Request $request, FeatureInterface $feature): JsonResponse
    {
      return ApiResponseClass::sendResponse($feature->delete($request->get('id')), 'The feature was deleted successfuly');
    }

    /**
     * @param FeatureInterface $feature
     * @return JsonResponse
     */
    public function getFeaturesDropdown(FeatureInterface $feature): JsonResponse
    {
      return ApiResponseClass::sendResponse($feature->getFeaturesDropdown(), '');
    }

    public function addFeatureToGame(Request $request): JsonResponse
    {
      DB::beginTransaction();
      $details = $request->only(['feature_id', 'game_id']);

      try {
        $feature = $this->gameRepository->addFeatureToGame($details);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $feature,
          'The feature is saved successfuly',
          201
        );
      } catch (ApiResponseException $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendResponse(['error' => $ex->getMessage()], 'Error');
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getGameFeatures(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->gameRepository->getGameFeatures($request->get('game_id')), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateGameFeature(Request $request): JsonResponse
    {
      DB::beginTransaction();
      $details = $request->only(['feature_id', 'game_id', 'content']);

      try {
        $feature = $this->gameRepository->updateGameFeature($details, '');

        DB::commit();
        return ApiResponseClass::sendResponse(
          $feature,
          'The feature is saved successfuly',
          201
        );
      } catch (ApiResponseException $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendResponse(['error' => $ex->getMessage()], 'Error');
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteGameFeature(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->gameRepository->deleteGameFeature($request->only(['game_id', 'feature_id'])), 'Feature was deleted successfuly');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addPhotoGallery(Request $request): JsonResponse
    {
      DB::beginTransaction();
      $details = $request->all();

      try {
        $Image = $this->gameRepository->addPhotoGallery($details, '');

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Image,
          'The images was saved successfuly',
          201
        );
      } catch (ApiResponseException $ex) {
        return ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendResponse(['error' => $ex->getMessage()], 'Error');
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getGallery(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->gameRepository->getGallery($request->get('game_id')), '');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deletePhotoGallery(Request $request): JsonResponse
    {
      try {
        return ApiResponseClass::sendResponse($this->gameRepository->deletePhotoGallery($request->get('img_id')), 'The photo was deleted successfuly');
      } catch (ApiResponseException $exception) {
        return ApiResponseClass::sendError(['error' => $exception->getMessage()], 'Error');
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateDetails(Request $request): JsonResponse|array
    {
      DB::beginTransaction();

      try {
        $Data = GameDetails::updateOrCreate([
          'game_id' => $request->get('game_id')
        ],
          $request->except('game_id', 'rtps', 'hit_frequency', 'devices', 'jurisdictions') + [
            'rtps' => json_encode($request->get('rtps')),
            'hit_frequency' => json_encode($request->get('hit_frequency')),
            'devices' => json_encode($request->get('devices'))
          ]
        );

        if ($request->has('jurisdictions')) {
          $Game = Game::find($request->get('game_id'));
          $Game->jurisdictions()->sync($request->get('jurisdictions'));
        }

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Data,
          'Details was saved successfuly',
          201
        );

      } catch (ApiResponseException $ex) {
        ApiResponseClass::rollback($ex, $ex->getMessage());
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDetails(Request $request)
    {
      $data = Game::where('id', $request->get('game_id'))->with([
        'details',
        'jurisdictions'
      ])->firstOrFail();
      return ApiResponseClass::sendResponse($data, '');
    }
  }
