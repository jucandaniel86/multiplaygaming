<?php

  namespace App\Http\Controllers;

  use App\Enums\ArticleTypesEnum;
  use App\Enums\StatusEnum;
  use App\Interfaces\ArticleCategoryInterface;
  use App\Interfaces\ArticleRepositoryInterface;
  use Illuminate\View\View;
  use Illuminate\Support\Facades\File;

  class ArticlesController extends BaseController
  {

    public function __construct()
    {
      parent::__construct();
      $this->css->add_raw(File::get(public_path('/assets/css/components/more-articles.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/pages/articles.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/pages/about.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/pages/games.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/components/filters.css')));
    }

    /**
     * @param ArticleRepositoryInterface $articleRepository
     * @param ArticleCategoryInterface $articleCategory
     * @return View
     */
    public function articles(ArticleRepositoryInterface $articleRepository, ArticleCategoryInterface $articleCategory): View
    {
      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->description(config('seo.articles.description'))
        ->title(config('seo.articles.title'));

      $categories = $articleCategory->index();
      $articles = $articleRepository->filterArticles([
        'article_type' => ArticleTypesEnum::ARTICLES->value,
        'article_status' => StatusEnum::PUBLISHED->value,
      ], [], [
        'column' => 'id',
        'direction' => 'DESC'
      ]);

      return view('pages.articles.index', [
        'articles' => $articles,
        'categories' => $categories,
      ]);
    }

    /**
     * @param ArticleRepositoryInterface $articleRepository
     * @param ArticleCategoryInterface $articleCategory
     * @return View
     */
    public function news(ArticleRepositoryInterface $articleRepository, ArticleCategoryInterface $articleCategory): View
    {
      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->description(config('seo.news.description'))
        ->title(config('seo.news.title'));

      $categories = $articleCategory->index();
      $articles = $articleRepository->filterArticles([
        'article_type' => ArticleTypesEnum::NEWS->value,
      ], []);
      return view('pages.articles.news', [
        'categories' => $categories,
        'articles' => $articles
      ]);
    }

    /**
     * @param string $slug
     * @param ArticleRepositoryInterface $articleRepository
     * @return View
     */
    public function single(string $slug, $id, ArticleRepositoryInterface $articleRepository): View
    {
      $Article = $articleRepository->getById($id);

      if (!$Article || $Article->DELETED == 1) {
        abort(404);
      }

      //seo
      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->title($Article->title);

      if ($Article->thumbnail) {
        seo()->image($Article->thumbnail);
      }

      if ($Article->meta_description) {
        seo()->description($Article->meta_description);
      }

      //related articles
      $relatedArticles = null;
      if ($Article->category_id) {
        $relatedArticles = $articleRepository->filterArticles([
          'category_id' => $Article->category_id,
          'article_type' => $Article->article_type,
        ], ['category'], [], 4);
      } else {
        $relatedArticles = $articleRepository->filterArticles([
          'article_type' => $Article->article_type,
        ], ['category'], [], 4);
      }

      return view('pages.articles.single', [
        'article' => $Article,
        'relatedArticles' => $relatedArticles
      ]);
    }
  }
