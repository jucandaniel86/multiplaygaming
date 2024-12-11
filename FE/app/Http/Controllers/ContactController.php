<?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\File;

  class ContactController extends BaseController
  {
    public function __construct()
    {
      parent::__construct();
      $this->css->add_raw(File::get(public_path('/assets/css/pages/contact.css')));
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->title(config('seo.contact.title'));

      return view('pages.contact');
    }
  }
