<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{--  <link rel="stylesheet" href="{{ asset('assets/css/app.css?v=' . time() ) }}"/>--}}
  <style>{!! $css->get_output(true) !!}</style>
  <script>
    var baseURL = '{{ url('/') }}/';
  </script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>
  <script src="{{ asset('assets/js/app.js?v=' . time()) }}" type="module"></script>
  <x-seo::meta/>
  <x-facebook/>
</head>
<body>
<x-announce-component/>
<x-popups.plus18/>
@include('components.header')
@yield('content')
@include('components.footer')
</body>
</html>
