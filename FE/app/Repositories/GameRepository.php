<?php

  namespace App\Repositories;

  use App\Enums\StatusEnum;
  use App\Exceptions\ApiResponseException;
  use App\Interfaces\GameRepositoryInterface;
  use App\Models\Feature;
  use App\Models\Game;
  use App\Models\GameCategory;
  use App\Models\GameFeature;
  use App\Models\GameMechanics;
  use App\Models\GamePicture;
  use App\Traits\QueryTrait;

  use App\Traits\UploadFilesTrait;
  use DB;
  use Illuminate\Http\Request;

  class GameRepository implements GameRepositoryInterface
  {
    use QueryTrait, UploadFilesTrait;

    private $games_gallery_path = '';

    public function __construct()
    {
      $this->games_gallery_path = config('website.paths.games');
    }

    public function index(array $params = [])
    {
      $search = [
        [
          "condition" => isset($params['search']) && $params['search'] != "" && strlen($params['search']) > 2,
          "query" => "(game_name LIKE '%{$params['search']}%' OR game_id LIKE '%{$params['search']}%')"
        ],
        [
          "condition" => true,
          "query" => "DELETED = 0"
        ]
      ];

      if (isset($params['category_id']) && (int)$params['category_id']) {
        $search[] = [
          "condition" => true,
          "query" => "category_id = " . $params['category_id']
        ];
      }

      if (isset($params['game_status']) && in_array($params['game_status'], array_column(StatusEnum::cases(), 'value'),)) {
        $search[] = [
          "condition" => true,
          "query" => "game_status = '" . $params['game_status'] . "'"
        ];
      }

      if (isset($params['featured_game']) && in_array($params['featured_game'], [0, 1])) {
        $search[] = [
          "condition" => true,
          "query" => "featured_game = " . (int)$params['featured_game']
        ];
      }
      return $this->getFilteredList(Game::query()->with('category'), $params, $search);
    }

    public function getById($id)
    {
      return Game::findOrFail($id);
    }

    public function getBySlug($slug, $relations = [])
    {
      $Game = Game::where('slug', $slug)->with('details')->where("DELETED", 0);

      if (count($relations)) {
        $Game->with($relations);
      }
      return $Game->first();
    }

    public function getlastDraft()
    {
      return Game::where('game_status', StatusEnum::DRAFT->value)
        ->where('created_at', '>=', now()->subDays(1))
        ->where('DELETED', 0)
        ->first();
    }

    public function store(array $data)
    {
//      Game::where('game_status', StatusEnum::DRAFT->value)
//        ->where('created_at', '>=', now()->subDays(1))
//        ->delete();

      return Game::create($data);
    }

    public function update(array $data, $id)
    {
      return Game::whereId($id)->update($data);
    }

    public function delete($id)
    {
      $this->softDeleteByID(Game::query(), $id);
    }

    public function addFeatureToGame(array $params = [])
    {
      if (!isset($params['feature_id']) || !isset($params['game_id']))
        throw new ApiResponseException("Invalid params");

      $Exists = DB::table('game_features')
        ->where('feature_id', (int)$params['feature_id'])
        ->where('game_id', (int)$params['game_id'])
        ->first();

      if ($Exists)
        throw new ApiResponseException("Feature already exist for this game");

      $Feature = Feature::find($params['feature_id']);
      $DefaultContent = "";
      if ($Feature) {
        $DefaultContent = $Feature->content;
      }

      $NewFeature = DB::table("game_features")
        ->insert([
          'feature_id' => $params['feature_id'],
          'game_id' => $params['game_id'],
          'content' => $DefaultContent
        ]);

      return $NewFeature;
    }

    public function getGameFeatures($gameID)
    {
      return GameFeature::query()
        ->with('feature')
        ->where('game_id', $gameID)->get();
    }

    public function updateGameFeature($params)
    {
      return GameFeature::where('game_id', $params['game_id'])
        ->where('feature_id', $params['feature_id'])
        ->update($params);
    }

    public function deleteGameFeature($params)
    {
      return GameFeature::query()->where('game_id', $params['game_id'])
        ->where('feature_id', $params['feature_id'])
        ->delete();
    }

    public function addPhotoGallery($params)
    {
      if (!isset($params['file'])) {
        throw new ApiResponseException("Invalid File");
      }

      $Game = Game::find((int)$params['game_id']);

      if (!$Game) {
        throw new ApiResponseException("Invalid Game");
      }

      $Photo = new GamePicture();
      $Photo->game_id = (int)$params['game_id'];
      $Photo->name = $Game->game_name;
      $Photo->order_index = 0;
      $Photo->details = (isset($params['details'])) ? $params['details'] : '';

      if (isset($params['file']) && $params['file'] !== 'null') {
        $thumbnail = $this->uploadThumbnail($params['file'], $this->games_gallery_path . $params['game_id'] . '/', $Game->game_name);
        $Photo->thumbnail_url = $thumbnail;
      }

      if ($Photo->save()) {
        return $Photo;
      }

      throw new ApiResponseException("Something went wrong");
    }

    public function getGallery($gameID)
    {
      return GamePicture::where('game_id', $gameID)->get();
    }

    public function deletePhotoGallery($imgID)
    {
      $Image = GamePicture::find($imgID);

      if (!$Image) {
        throw new ApiResponseException("Invalid Image ID");
      }

      $this->deleteFile($this->games_gallery_path . '/' . $Image->game_id . '/' . $Image->thumbnail_url);

      if ($Image->delete()) {
        return ['deleted_file' => $this->games_gallery_path . '/' . $Image->game_id . '/' . $Image->thumbnail_url];
      }

      throw new ApiResponseException("Something went wrong");
    }

    public function getRelatedGamesByCatgory($categoryID, $currentGameID, $limit = 3)
    {
      return Game::query()
        ->where('DELETED', 0)
        ->where('game_status', StatusEnum::PUBLISHED->value)
        ->where('category_id', $categoryID)
        ->where('id', '!=', $currentGameID)
        ->with(['features', 'category'])
        ->limit($limit)
        ->get();
    }

    public function filterGames(array $params, array $relations, $sort = []): array
    {
      $start = (isset($params['start'])) ? $params['start'] : 0;
      $length = (isset($params['length']) && $params['length'] > 0) ? $params['length'] : 50;
      $offset = ($start - 1) * $length;

      $Items = Game::query()->where('DELETED', 0)
        ->where('game_status', StatusEnum::PUBLISHED->value)
        ->when(isset($params['category_id']) && (int)$params['category_id'] > 0, function ($query) use ($params) {
          return $query->where('category_id', (int)$params['category_id']);
        })
        ->when(isset($params['search']) && strlen($params['search']) > 2, function ($query) use ($params) {
          return $query->whereRaw('game_name LIKE "%' . $params['search'] . '%"');
        })
        ->when(isset($params['is_highlighted']), function ($query) use ($params) {
          return $query->where('is_highlighted', (int)$params['is_highlighted']);
        })
        ->when(isset($params['featured_game']), function ($query) use ($params) {
          return $query->where('featured_game', (int)$params['featured_game']);
        })
        ->when(isset($params['is_featured']), function ($query) use ($params) {
          return $query->where('is_featured', (int)$params['is_featured']);
        })
        ->when(isset($params['homepage_slider']), function ($query) use ($params) {
          return $query->where('homepage_slider', (int)$params['homepage_slider']);
        })
        ->when(isset($params['is_branded']), function ($query) use ($params) {
          return $query->where('is_branded', (int)$params['is_branded']);
        })
        ->when(isset($params['rtp']), function ($query) use ($params) {
          return $query->where('rtp', $params['rtp']);
        })
        ->when(isset($params['mechanics']), function ($query) use ($params) {
          return $query->where('mechanics_id', $params['mechanics']);
        })
        ->when(isset($params['volatility']), function ($query) use ($params) {
          return $query->where('volatility', $params['volatility']);
        })
        ->when(isset($params['show_upcoming']), function ($query) use ($params) {
          if ($params['show_upcoming']) {
            return $query->whereRaw('release_date > NOW()');
          }
        })
        ->when(isset($params['max_multiplier_win']) && is_array($params['max_multiplier_win']), function ($query) use ($params) {
          $start = (int)$params['max_multiplier_win'][0];
          $end = (int)$params['max_multiplier_win'][1];

          return $query->whereBetween('max_multiplier', [$start, $end]);
        })
        ->when(isset($params['categories']) && count($params['categories']), function ($query) use ($params) {
          return $query->whereIn('category_id', $params['categories']);
        });

      if (isset($params['features']) && is_array($params['features'])) {
        $Items->whereHas('features', function ($query) use ($params) {
          $query->whereIn('game_features.feature_id', $params['features']);
        })->get();
      }

      if (isset($params['certified_countries'])) {
        $Items->whereHas('jurisdictions', function ($query) use ($params) {
          return $query->whereIn('jurisdiction_id', [$params['certified_countries']]);
        });
      }

      $Items->with('details', function ($query) use ($params) {
        $query->when(isset($params['has_jackpot']) && $params['has_jackpot'] != -1, function ($query) use ($params) {
          return $query->where('has_jackpot', (int)$params['has_jackpot']);
        })
          ->when(isset($params['has_free_spins']) && $params['has_free_spins'] == 1, function ($query) use ($params) {
            return $query->where('has_free_spins', (int)$params['has_free_spins']);
          })
          ->when(isset($params['has_instant_bonus']) && $params['has_instant_bonus'] == 1, function ($query) use ($params) {
            return $query->where('has_instant_bonus', (int)$params['has_instant_bonus']);
          })
          ->when(isset($params['min_bet']) && is_array($params['min_bet']), function ($query) use ($params) {
            $start = (int)$params['min_bet'][0];
            $end = (int)$params['min_bet'][1];

            return $query->whereBetween('min_total_bet', [$start, $end]);
          });
      });

      if (count($sort)) {
        $Items->orderBy($sort['column'], $sort['direction']);
      }

      if (count($relations)) {
        $Items->with($relations);
      }

      $Total = $Items->count();
      $ItemsQuery = $Items
        ->limit($length)
        ->offset($offset);

      return [
        'total' => $Total,
        'items' => $ItemsQuery->get(),
        'sql' => $ItemsQuery->toRawSql()
      ];
    }

    public function mechanicsList(Request $request): array
    {
      return $this->vDatatable(GameMechanics::class, [
        'pagination' => $request->only(['start', 'length']),
        'like' => [
          'name' => $request->get('search')
        ]
      ]);
    }

    public function allMechanics()
    {
      return GameMechanics::all();
    }

    public function saveMechanics(Request $request)
    {
      $ID = $request->has('id') ? $request->get('id') : 0;
      if ($ID) {
        return GameMechanics::find($ID)->update($request->only(['name']));
      }
      return GameMechanics::create($request->only(['name']));
    }

    public function deleteMechanics(Request $request)
    {
      $this->deleteByID(GameMechanics::query(), $request->get('id'));
    }

    public function getCategoriesWithGames()
    {
      $Categories = GameCategory::with([
        'games' => function ($query) {
          return $query->where('game_status', StatusEnum::PUBLISHED->value)->where('DELETED', 0);
        }
      ])
        ->where('DELETED', 0)
        ->whereHas('games', function ($query) {
          return $query->where('game_status', StatusEnum::PUBLISHED->value)->where('DELETED', 0);
        })->get();
      return $Categories;
    }
  }
