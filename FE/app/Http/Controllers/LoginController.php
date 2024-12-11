<?php

  namespace App\Http\Controllers;

  use App\Http\Requests\ClientAreaRequest;
  use App\Models\User;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Hash;

  class LoginController extends Controller
  {
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
        ->title("login");

      return view('pages.login');
    }

    public function postLogin(ClientAreaRequest $request)
    {
      $data = $request->validated();

      if (!auth()->attempt($data)) {
        return redirect()->back()->withErrors(['email' => 'Invalid Email/Password combination']);
      }

      return redirect()->route('fe.clientArea');
    }

    public function getLogout()
    {
      auth()->logout();

      return redirect()->route('login');
    }
  }
