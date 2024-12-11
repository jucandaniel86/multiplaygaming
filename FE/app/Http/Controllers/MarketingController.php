<?php

  namespace App\Http\Controllers;

  use App\Enums\ArticleTypesEnum;
  use App\Interfaces\ArticleRepositoryInterface;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\File;
  use Illuminate\View\View;

  class MarketingController extends BaseController
  {
    public function __construct()
    {
      parent::__construct();
      $this->css->add_raw(File::get(public_path('/assets/css/pages/marketing.css')));
    }

    public function tools(): View
    {
      seo()->title('Tools');
      return view('pages.marketing.tools');
    }

    /**
     * @return View
     */
    public function brandsExclusive(): View
    {
      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->title("Tailored Experiences");

      //load specific css files
      $this->css->add_raw(File::get(public_path('/assets/css/pages/games.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/components/featured-games.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/components/weeks.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/components/scrolled-content.css')));

      return view('pages.marketing.brandsExclusive');
    }

    /**
     * @param ArticleRepositoryInterface $articleRepository
     * @return View
     */
    public function gameSetsPromo(ArticleRepositoryInterface $articleRepository): View
    {
      //seo configuration
      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->title("Game Sets Promo");

      //load css files
      $this->css->add_raw(File::get(public_path('/assets/css/pages/games.css')));

      //get articles
      $articles = $articleRepository->filterArticles([
        'article_type' => ArticleTypesEnum::PROMO_GAMES->value,
      ], []);

      return view('pages.marketing.gameSetsPromo', [
        'articles' => $articles
      ]);
    }
  }
