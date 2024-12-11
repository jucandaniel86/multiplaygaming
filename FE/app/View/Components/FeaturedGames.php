<?php

  namespace App\View\Components;

  use App\Interfaces\GameRepositoryInterface;
  use Closure;
  use Illuminate\Contracts\View\View;
  use Illuminate\View\Component;

  class FeaturedGames extends Component
  {
    public string $title;
    public $games;

    private GameRepositoryInterface $gamesRespository;

    /**
     * Create a new component instance.
     */
    public function __construct(GameRepositoryInterface $gameRepository, $title, array $games = [])
    {
      $this->gamesRespository = $gameRepository;
      $this->title = $title;

      if (!isset($games) || !is_array($games) || !count($games)) {
        $_games = $this->gamesRespository->filterGames([
          'featured_game' => 1
        ], ['category']);
        if ($_games['items']) {
          $this->games = $_games['items'];
          return;
        }
      }

      $this->games = $games;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
      return view('components.featured-games', [
        'games' => $this->games,
      ]);
    }
  }
