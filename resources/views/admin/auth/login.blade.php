@extends('admin.layout')

@section('content')

<div class="card auth-card">

  <div class="auth-header">
    ADMIN LOGIN
  </div>

  <div class="auth-body">

    <form method="POST" action="{{ route('admin.login.form') }}">
      @csrf

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

      <label>
        <input type="checkbox" />
        <span>Remember Me</span>
      </label>

      <br><br>

      <button class="btn btn-custom waves-effect">Login</button>
  
      <div class="link">
       <a href="/reset-password">Forgot Password?</a>
      </div>
    </form>

  </div>
</div>

@endsection