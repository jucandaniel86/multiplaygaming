<?php

  namespace App\Http\Controllers;

  use App\Interfaces\ArticleRepositoryInterface;
  use App\Interfaces\CarrerRepositoryInterface;
  use App\Interfaces\GameCategoryInterface;
  use App\Interfaces\GameRepositoryInterface;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\File;
  use Illuminate\View\View;

  class StaticPagesController extends BaseController
  {
    /**
     * @return View
     */
    public function privacyPolicy(): View
    {
      //config seo
      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->title("Privacy Policy");

      //load css
      $this->css->add_raw(File::get(public_path('/assets/css/pages/marketing.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/pages/privacy.css')));

      return view('pages.static.privacy');
    }


    /**
     * @param GameRepositoryInterface $gameRepository
     * @param ArticleRepositoryInterface $articleRepository
     * @param CarrerRepositoryInterface $carrerRepository
     * @param GameCategoryInterface $gameCategory
     * @return View
     */
    public function sitemap(GameRepositoryInterface $gameRepository, ArticleRepositoryInterface $articleRepository, CarrerRepositoryInterface $carrerRepository, GameCategoryInterface $gameCategory): View
    {
      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->title("Sitemap");

      $articles = $articleRepository->filterArticles([], ['category']);
      $games = $gameRepository->filterGames([], ['category']);
      $career = $carrerRepository->filterJobs([], ['department']);
      $categories = $gameCategory->index();

      $marketing = array_values(array_filter(config('website.website_menu'), function ($item) {
        if ($item['label'] === "marketing") return $item;
      }));
      $partners = array_values(array_filter(config('website.website_menu'), function ($item) {
        if ($item['label'] === "partners") return $item;
      }));
      $company = array_values(array_filter(config('website.website_menu'), function ($item) {
        if ($item['label'] === "about") return $item;
      }));

      $this->css->add_raw(File::get(public_path('/assets/css/pages/sitemap.css')));
 
      return view('pages.static.sitemap', [
        'articles' => $articles,
        'games' => $games['items'],
        'career' => $career['items'],
        'gameCategories' => $categories,
        'marketing' => isset($marketing[0]) ? $marketing[0]['childs'] : [],
        'partners' => isset($partners[0]) ? $partners[0]['childs'] : [],
        'company' => isset($company[0]) ? $company[0]['childs'] : []
      ]);
    }
  }
