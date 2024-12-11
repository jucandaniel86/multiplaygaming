<?php

  namespace App\Http\Controllers;

  use App\Enums\StatusEnum;
  use App\Interfaces\CarrerRepositoryInterface;
  use App\Interfaces\DepartmentsRepositoryInterface;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\File;
  use Illuminate\View\View;

  class AboutController extends BaseController
  {

    public function __construct()
    {
      parent::__construct();
      $this->css->add_raw(File::get(public_path('/assets/css/pages/about.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/pages/careers.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/pages/games.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/components/highlight-component.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/components/scrolled-content.css')));
    }

    public function company(): View
    {
      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->title("Company");

      $this->css->add_raw(File::get(public_path('/assets/css/components/paralax-component.css')));
      $this->css->add_raw(File::get(public_path('/assets/css/pages/marketing.css')));

      return view('pages.about.company');
    }

    /**
     * @param CarrerRepositoryInterface $carrerRepository
     * @param DepartmentsRepositoryInterface $departmentsRepository
     * @return View
     */
    public function careers(CarrerRepositoryInterface $carrerRepository, DepartmentsRepositoryInterface $departmentsRepository): View
    {
      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->title("Careers");

      $this->css->add_raw(File::get(public_path('/assets/css/pages/marketing.css')));

      $departments = $departmentsRepository->index(true);
      $jobs = $carrerRepository->index([
        'start' => 1,
        'length' => 6,
        'search' => '',
        'job_status' => StatusEnum::PUBLISHED->value,
      ]);
      $MoreButton = $jobs['total'] > 6;

      return view('pages.about.carrers', [
        'departments' => $departments,
        'jobs' => $jobs['items'],
        'moreButton' => $MoreButton
      ]);
    }

    /**
     * @return View
     */
    public function responsibleGaming(): View
    {
      seo()->title('Responisble Gaming');
      $this->css->add_raw(File::get(public_path('/assets/css/pages/marketing.css')));
      return view('pages.about.responsible-gaming');
    }
  }
