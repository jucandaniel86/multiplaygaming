<?php

  namespace App\View\Components;

  use App\Interfaces\PartnersRepositoryInterface;
  use Closure;
  use Illuminate\Contracts\View\View;
  use Illuminate\View\Component;

  class Partners extends Component
  {
    private PartnersRepositoryInterface $service;
    private $partners;
    private $title;
    private $partnerType;

    /**
     * Create a new component instance.
     */
    public function __construct(PartnersRepositoryInterface $service, $partnerType = "operator", $title = "")
    {
      $this->service = $service;
      $this->partners = $this->service->list([
        'partner_type' => $partnerType
      ]);
      $this->partnerType = $partnerType;

      if ($title == "") {
        $this->title = __('marketing.tools.partnersTitle');
        return;
      }

      $this->title = $title;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
      return view('components.partners', [
        'partners' => $this->partners['items'],
        'title' => $this->title,
        'partner_type' => $this->partnerType
      ]);
    }
  }
