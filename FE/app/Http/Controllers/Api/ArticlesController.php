<?php

  namespace App\Http\Controllers\Api;

  use App\Classes\ApiResponseClass;
  use App\Enums\StatusEnum;
  use App\Exceptions\ApiResponseException;
  use App\Http\Controllers\Controller;
  use App\Http\Requests\SaveArticleCategoryRequest;
  use App\Http\Requests\StoreArticleRequest;
  use App\Interfaces\ArticleCategoryInterface;
  use App\Interfaces\ArticleRepositoryInterface;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;

  use DB;

  class ArticlesController extends Controller
  {
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
      $this->articleRepository = $articleRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
      $data = $this->articleRepository->index($request->all());

      return ApiResponseClass::sendResponse($data, '', 200);
    }

    /**
     * @param StoreArticleRequest $request
     * @return JsonResponse
     */
    public function store(StoreArticleRequest $request): JsonResponse
    {
      DB::beginTransaction();
      $details = [
        'title' => $request->title,
        'short_title' => $request->short_title,
        'meta_title' => $request->title,
        'article_status' => StatusEnum::DRAFT,
        'article_type' => $request->article_type,
        'created_by' => auth()->user()->id,
      ];

      try {
        $Article = $this->articleRepository->store($details);

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Article,
          'The article was created as DRAFT at ' . now()->toDateTimeLocalString() . ' with ID ' . $Article->id,
          201
        );

      } catch (ApiResponseException $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendError(['error' => $ex->getMessage()], 'Error');
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getLastDraft(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->articleRepository->getlastDraft($request->article_type), 'Success');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getGameById(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->articleRepository->getById($request->get('id')), 'Success');
    }

    /**
     * @param SaveArticleCategoryRequest $request
     * @param ArticleRepositoryInterface $category
     * @return JsonResponse
     */
    public function saveCategory(SaveArticleCategoryRequest $request, ArticleCategoryInterface $category): JsonResponse
    {
      DB::beginTransaction();
      $details = [
        'name' => $request->name,
        'meta_title' => $request->has('meta_title') ? $request->meta_title : $request->title,
        'is_active' => $request->has('is_active') ? (int)$request->is_active : 1,
      ];

      try {
        $savedCategory = $category->save($details, $request->get('id'));

        DB::commit();
        return ApiResponseClass::sendResponse(
          $savedCategory,
          'Category was saved successfuly',
          201
        );

      } catch (\Exception $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendError(['error' => $ex->getMessage()], 'Error');
      }
    }

    /**
     * @param Request $request
     * @param ArticleCategoryInterface $category
     * @return JsonResponse
     */
    public function deleteCategory(Request $request, ArticleCategoryInterface $category): JsonResponse
    {
      return ApiResponseClass::sendResponse($category->delete($request->get('id')), 'The category was deleted successfuly');
    }

    /**
     * @param Request $request
     * @param ArticleCategoryInterface $category
     * @return JsonResponse
     */
    public function categoriesList(Request $request, ArticleCategoryInterface $category): JsonResponse
    {
      $data = $category->itemList($request->all());

      return ApiResponseClass::sendResponse($data, '', 200);
    }

    /**
     * @param ArticleCategoryInterface $category
     * @return JsonResponse
     */
    public function categoriesSelector(ArticleCategoryInterface $category): JsonResponse
    {
      return ApiResponseClass::sendResponse($category->index(), '');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
      DB::beginTransaction();
      $details = $request->except(['id', 'DELETED',
        'deleted_by', 'created_at', 'updated_at', 'created_by', 'banner', 'thumbnail',
        'banner', 'banner_url', 'thumbnail_url'
      ]);

      try {
        $Article = $this->articleRepository->update($details, $request->get('id'));

        DB::commit();
        return ApiResponseClass::sendResponse(
          $Article,
          'The article is saved successfuly',
          201
        );

      } catch (\Exception $ex) {
        ApiResponseClass::rollback($ex);
        return ApiResponseClass::sendError(['error' => $ex->getMessage()], 'Error');
      }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteArticle(Request $request): JsonResponse
    {
      return ApiResponseClass::sendResponse($this->articleRepository->delete($request->get('id')), 'The article was deleted successfuly');
    }
  }
