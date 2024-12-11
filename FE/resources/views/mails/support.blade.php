@extends('layouts.mail')
@section('content')
  <h1>Client Area Support</h1>
  <table width="100" cellpadding="3" style="width: 100%;">
    <tr>
      <td>Email</td>
      <td>{{ $email }}</td>
    </tr>
    <tr>
      <td>Name</td>
      <td>{{ $name }}</td>
    </tr>
    <tr>
      <td>Subject</td>
      <td>{{ $subject }}</td>
    </tr>
    <tr>
      <td>Message</td>
      <td>{{ $message }}</td>
    </tr>
  </table>
@endsection
