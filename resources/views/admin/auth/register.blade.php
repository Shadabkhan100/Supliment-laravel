@extends('admin.auth.layout')

@section('content')

<div class="card auth-card">

  <div class="auth-header">
    ADMIN REGISTER
  </div>

  <div class="auth-body">

    <form method="POST" action="{{ route('admin.register') }}">
      @csrf

      <div class="input-field">
        <i class="material-icons prefix">person</i>
        <input type="text" name="name" required>
        <label>Name</label>
      </div>

      <div class="input-field">
        <i class="material-icons prefix">email</i>
        <input type="email" name="email" required>
        <label>Email</label>
      </div>

      <div class="input-field">
        <i class="material-icons prefix">lock</i>
        <input type="password" name="password" required>
        <label>Password</label>
      </div>

      <button class="btn btn-custom waves-effect">Register</button>

      <div class="link">
        <a href="{{ route('admin.login.form') }}">Already have account?</a>
      </div>
    </form>

  </div>
</div>

@endsection