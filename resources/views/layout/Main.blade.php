<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="PowerUp" />

    <title>SLIMZA || Dietary Products</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />

    <!-- All CSS files -->
    <link rel="stylesheet" href="css/font-awesome.css" />
    <link rel="stylesheet" href="css/slick-theme.css" />
    <link rel="stylesheet" href="css/slick-slider.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/slick-animation.css" />
    <link rel="stylesheet" href="css/app.css" />
  </head>

  <body class="tt-smooth-scroll" style="background-color:black">
    <!-- Preloader -->
    <div id="preloader">
      <div class="loading loading07">
        <span data-text="S">S</span>
        <span data-text="L">L</span>
        <span data-text="I">I</span>
        <span data-text="M">M</span>
        <span data-text="Z">Z</span>
        <span data-text="A">A</span>
      </div>
    </div>
    <!-- Preloader -->
     @include('layout.header')
    @yield('content')
    <div id="sidebar-cart-curtain" class="close-popup"></div>
    <!-- Shopping Cart Popup End -->
     @include('layout.footer')
    <!-- Jquery Js -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/slickAnimation.js"></script>

    <script src="js/app.js"></script>
  </body>
</html>
