<?php

  namespace App\Http\Controllers;

  use App\Enums\StatusEnum;
  use App\Interfaces\FeatureInterface;
  use App\Interfaces\GameCategoryInterface;
  use App\Interfaces\GameRepositoryInterface;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\File;
  use Illuminate\View\View;

  class GamesController extends BaseController
  {
    private GameRepositoryInterface $service;

    public function __construct(GameRepositoryInterface $service)
    {
      parent::__construct();

      $this->service = $service;

      $this->css->add_raw(File::get(public_path('/assets/css/components/featured-games.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/pages/games.css')));
    }

    /**
     * @url /games
     * @param string $slug
     * @param GameCategoryInterface $gameCategory
     * @param FeatureInterface $feature
     * @return View
     */
    public function index(GameCategoryInterface $gameCategory, FeatureInterface $feature, string $slug = ""): View
    {

      $categories = $gameCategory->index();
      $features = $feature->getFeaturesDropdown();
      $games = $this->service->filterGames([
        'game_status' => StatusEnum::PUBLISHED->value,
      ], ['category'],
        ['column' => 'release_date', 'direction' => 'desc']
      );
      $isCategory = false;
      $categoryID = 0;

      if ($slug !== "") {
        $isCategory = true;

        foreach ($categories as $category) {
          if ($category->slug == $slug) {
            $categoryID = $category->id;
            break;
          }
        }
        $games = $this->service->filterGames([
          'category_id' => $categoryID
        ], ['category']);
      }

      if ($isCategory) {
        $Category = $gameCategory->getById($categoryID);
      }

      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->title($isCategory ? $Category->name : config('seo.games.title'))
        ->description($isCategory ? $Category->meta_description : config('seo.games.description'));

      return view('pages.games.index', [
        'categories' => $categories,
        'features' => $features,
        'games' => $games['items'],
        'isCategory' => $isCategory,
        'categoryID' => $categoryID
      ]);
    }

    /**
     * @param string $slug
     * @param GameRepositoryInterface $gameRepository
     * @return View
     */
    public function game(string $slug, GameRepositoryInterface $gameRepository): View
    {
      $game = $gameRepository->getBySlug($slug, ['category', 'features', 'gallery']);

      if (!$game || $game->DELETED == 1) {
        abort(404);
      }

      //seo
      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->title($game->meta_title)
        ->description($game->meta_description);

      if ($game->thumbnail_url) {
        seo()->image($game->thumbnail_url);
      }

      //related games
      $relatedGames = null;
      if ($game->category_id) {
        $relatedGames = $gameRepository->getRelatedGamesByCatgory($game->category_id, $game->id);
      }
      //css
      $this->css->add_raw(File::get(public_path('/assets/css/pages/game-page.css')));

      return view('pages.games.single', ['game' => $game, 'relatedGames' => $relatedGames]);
    }
  }
