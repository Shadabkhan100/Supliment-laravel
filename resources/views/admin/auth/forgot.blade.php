@extends('admin.auth.layout')

@section('content')

<div class="card auth-card">

  <div class="auth-header">
    RESET PASSWORD
  </div>

  <div class="auth-body">

    <form method="POST" action="{{ route('admin.forgot') }}">
      @csrf

      <div class="input-field">
        <i class="material-icons prefix">email</i>
        <input type="email" name="email" required>
        <label>Enter Email</label>
      </div>

      <button class="btn btn-custom waves-effect">Send Reset Link</button>

      <div class="link">
        <a href="{{ route('admin.login.form') }}">Back to Login</a>
      </div>
    </form>

  </div>
</div>

@endsection