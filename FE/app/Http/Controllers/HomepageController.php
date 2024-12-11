<?php

  namespace App\Http\Controllers;

  use App\Enums\ArticleTypesEnum;
  use App\Enums\StatusEnum;
  use App\Interfaces\ArticleRepositoryInterface;
  use App\Interfaces\GameRepositoryInterface;
  use Illuminate\Http\Request;
  use Illuminate\Support\Arr;
  use Illuminate\Support\Facades\File;

  use Spatie\TranslationLoader\LanguageLine;

  class HomepageController extends BaseController
  {
    public function __construct()
    {
      parent::__construct();
      //load css
      $this->css->add_raw(File::get(public_path('/assets/css/components/more-articles.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/components/highlight-component.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/components/scrolled-content.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/components/featured-games.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/pages/games.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/components/homepageslider.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/components/about.css')));
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
      //SEO Configuration
      seo()
        ->title(env('APP_NAME'))
//        ->description('Generates social image using Flipp and sets it as the cover photo')
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook');

      return view('index');
    }

    public function homepage(ArticleRepositoryInterface $articleRepository, GameRepositoryInterface $gameRepository)
    {
      seo()
        ->title(config('seo.homepage.title'))
        ->description(config('seo.homepage.description'))
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook');

      $latestnews = $articleRepository->filterArticles([
        'article_type' => ArticleTypesEnum::NEWS->value,
        'article_status' => StatusEnum::PUBLISHED->value,
      ], [], [
        'column' => 'id',
        'direction' => 'DESC'
      ], 3);

//      $test = __('menu');
//
//      foreach (Arr::dot($test) as $key => $value) {
//        if (is_array($value)) $value = json_encode($value);
//
//        LanguageLine::updateOrCreate(
//          ['group' => 'menu', 'key' => $key],
//          [
//            'group' => 'menu',
//            'key' => $key,
//            'text' => ['en' => $value],
//          ]);
//      }

      $lastarticles = $articleRepository->filterArticles([
        'article_type' => ArticleTypesEnum::ARTICLES->value,
        'article_status' => StatusEnum::PUBLISHED->value,
      ], [], [
        'column' => 'id',
        'direction' => 'DESC'
      ], 3);

      $featuredGames = $gameRepository->filterGames([
        'game_status' => StatusEnum::PUBLISHED->value,
        'featured_game' => 1,
      ], ['category']);

      $sliderGames = $gameRepository->filterGames([
        'game_status' => StatusEnum::PUBLISHED->value,
        'homepage_slider' => 1,
      ], ['category']);

      return view('index', [
        'latestnews' => $latestnews,
        'lastarticles' => $lastarticles,
        'featuredGames' => $featuredGames['items'],
        'sliderGames' => $sliderGames['items']
      ]);
    }
  }
