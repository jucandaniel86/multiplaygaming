<?php

  namespace App\Http\Controllers;

  use App\Enums\PartnerTypesEnum;
  use App\Interfaces\PartnersRepositoryInterface;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\File;
  use Illuminate\View\View;

  class PartnersController extends BaseController
  {

    public function __construct()
    {
      parent::__construct();
      $this->css->add_raw(File::get(public_path('/assets/css/pages/marketing.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/pages/partners.css')));
    }

    public function clients(): View
    {
      seo()->title('Clients');
      return view('pages.partners.clients');
    }

    /**
     * @param PartnersRepositoryInterface $partnersRepository
     * @return View
     */
    public function studios(PartnersRepositoryInterface $partnersRepository): View
    {
      seo()->title('Studios');

      $partners = $partnersRepository->list([
        'partner_category' => PartnerTypesEnum::STUDIOS->value,
        'partner_type' => 'platform'
      ]);

      return view('pages.partners.studios', [
        'partners' => $partners['items']
      ]);
    }
  }
