<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>

  <!-- Materialize CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">

  <!-- Google Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <style>
    body {
      background: linear-gradient(135deg, #0f172a, #111827);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .auth-card {
      width: 420px;
      border-radius: 16px;
      overflow: hidden;
    }

    .auth-header {
      background: #9eef0b;
      padding: 20px;
      text-align: center;
      font-weight: bold;
      color: #000;
    }

    .auth-body {
      padding: 25px;
      background: #fff;
    }

    .btn-custom {
      background: #9eef0b !important;
      color: #000 !important;
      width: 100%;
      border-radius: 8px;
    }

    .link {
      text-align: center;
      margin-top: 10px;
    }

    .link a {
      color: #555;
    }
  </style>

  @stack('styles')
</head>

<body>

  @yield('content')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  @stack('scripts')
</body>
</html>