<?php

  namespace App\Http\Controllers;

  use App\Enums\StatusEnum;
  use App\Interfaces\CarrerRepositoryInterface;
  use Illuminate\Support\Facades\File;
  use Illuminate\View\View;


  class CarrerController extends BaseController
  {
    public function __construct()
    {
      parent::__construct();
      $this->css->add_raw(File::get(public_path('/assets/css/pages/careers.css')));
    }

    /**
     * @param string $slug
     * @param int $id
     * @param CarrerRepositoryInterface $carrerRepository
     * @return View
     */
    public function single(string $slug, int $id, CarrerRepositoryInterface $carrerRepository): View
    {
      $job = $carrerRepository->getBySlug($slug, $id);
      if (!$job) {
        abort(404);
      }

      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->title($job->job_title);

      $jobs = $carrerRepository->index([
        'search' => '',
        'job_status' => StatusEnum::PUBLISHED->value,
      ]);

      return view('pages.carrers.single', [
        'job' => $job,
        'jobs' => $jobs['items']
      ]);
    }

  }
