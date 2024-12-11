<?php

  namespace App\Http\Controllers\Auth;

  use App\Http\Controllers\Controller;
  use App\Models\User;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;
  use function auth;
  use function response;

  class LoginController extends Controller
  {
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request): JsonResponse
    {
      $User = User::where('email', $request->get('email'))->first();
      if (!$User) {
        return response()->json([
          'error' => 'Invalid email address'
        ], 401);
      }

      try {
        if (auth()->attempt($request->only(['email', 'password']))) {
          //generate the token for the user
          $user_login_token = auth()->user()->createToken('access@' . $User->email)->accessToken;
//          Log::info($user_login_token);
          //now return this token on success login attempt
          return response()->json(['token' => $user_login_token], 200);
        }
      } catch (\Exception $exception) {
        return response()->json([
          'error' => $exception->getMessage(),
          'details' => $exception->getTrace()
        ], 401);
      }

    }
  }
