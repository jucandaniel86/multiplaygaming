<?php

  namespace App\View\Components;

  use App\Interfaces\AnnouncesRepositoryInterface;
  use Closure;
  use Illuminate\Contracts\View\View;
  use Illuminate\View\Component;

  class AnnounceComponent extends Component
  {
    private $currentAnnounce;
    private AnnouncesRepositoryInterface $announcesRepository;

    /**
     * Create a new component instance.
     */
    public function __construct(AnnouncesRepositoryInterface $announcesRepository)
    {
      $this->announcesRepository = $announcesRepository;
      $this->currentAnnounce = $this->announcesRepository->getActiveAnnounce(false, true);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
      return view('components.announce-component', [
        'announce' => $this->currentAnnounce
      ]);
    }
  }
