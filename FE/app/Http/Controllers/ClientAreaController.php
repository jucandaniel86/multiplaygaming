<?php

  namespace App\Http\Controllers;

  use App\Http\Requests\UpdateUserDetailsRequest;
  use App\Models\User;
  use Illuminate\Database\Eloquent\ModelNotFoundException;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\File;
  use luizbills\CSS_Generator\Generator as CSS_Generator;

  class ClientAreaController extends Controller
  {
    public function index()
    {
      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->title("Client Area");

      return view('pages.client-area');
    }

    public function pages()
    {
      seo()
        ->twitter(true)
        ->locale(app()->getLocale())
        ->url(url()->full())
        ->extension('facebook', true, 'facebook')
        ->title("Client Area");

      return view('pages.client-area');
    }

    /**
     * @param UpdateUserDetailsRequest $request
     * @return JsonResponse
     */
    public function updateUserDetails(UpdateUserDetailsRequest $request): JsonResponse
    {
      try {
        $userID = auth()->user()->id;
        $User = User::find($userID);
        $User->first_name = $request->get('first_name');
        $User->last_name = $request->get('last_name');
        $User->save();

        return response()->json([
          'success' => true,
          'msg' => 'Your data has been successfully saved',
          'errors' => [],
          'user' => $User
        ]);
      } catch (ModelNotFoundException $exception) {
        return response()->json([
          'success' => false,
          'msg' => $exception->getMessage()
        ]);
      }

    }

    public function postSupport(Request $request): JsonResponse
    {
      $loggedUser = auth()->user();

      if (!$loggedUser) {
        return response()->json(['success' => false, 'msg' => 'Invalid Request']);
      }

      $email = $loggedUser->email;
      $name = $loggedUser->name !== "" ? $loggedUser->name : $loggedUser->first_name . ' ' . $loggedUser->last_name;

      $to = config('website.support_email');
      $subject = 'Client Area Support :: ' . env('APP_NAME');

      $headers = 'From: ' . config('website.support_email') . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

      $message = view('mails.support', [
        'name' => $name,
        'email' => $email,
        'subject' => $request->get('subject'),
        'message' => $request->get('message'),
      ])->render();

      mail($to, $subject, $message, $headers);


      return response()->json(['message' => 'Your details was successfuly submited', 'success' => true]);

    }
  }
