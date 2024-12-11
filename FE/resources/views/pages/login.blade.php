<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <x-seo::meta/>

  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

  <link rel="stylesheet" href="{{ asset('assets/css/pages/login.css') }}"/>
</head>
<body>
<div class="login-content">
  <div class="login-wrap">
    <div class="top-nav-branding">
      <img src="{{ asset('assets/imgs/logo.png') }}" style="max-width: 100%;"/>
    </div>
    <div class="login-form-wrap">
      <div class="form-content-wrap">
        <h1 class="headline">Hello!</h1>
        <span class="login-text">Please login to proceed.</span>
        <div class="tml tml-login">
          @if($errors->any())
            <div class="tml-alerts">
              <ul class="tml-errors">
                @foreach($errors->all() as $error)
                  <li class="tml-error">
                    <b>Error:</b> {{ $error }}
                  </li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('fe.login') }}" method="post">

            <div class="tml-field-wrap tml-log-wrap">
              <label class="tml-label">Email Address</label>
              <input type="text" id="email" name="email" class="tml-field">
            </div>

            <div class="tml-field-wrap tml-log-wrap">
              <label class="tml-label">Password</label>
              <input type="password" id="password" name="password" class="tml-field">
            </div>

            <button type="submit" class="tml-button">Login</button>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
