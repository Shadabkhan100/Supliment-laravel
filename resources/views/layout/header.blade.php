<!-- Header Menu Start -->
<header>
  <!-- Main Header Start -->
  <div class="header-section bg-white dark-black main-menu">
    <div class="container-fluid">
      <div class="header-top">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-6">
            <a href="{{ url('contact') }}"
               class="top-bar-links text-16 medium d-flex align-items-center gap-2">
              <i class="fa-regular fa-envelope"></i>
              <span>info@slimza.com</span>
            </a>
          </div>

          <div class="col-lg-6 col-md-6 d-lg-block d-none text-center">
            <p>
              <span class="text-16 semibold">Black Friday Sale:</span>
              Save up to 60% with code <span class="text-16 semibold">Slimza.</span>
            </p>
          </div>

          <div class="col-lg-3 col-md-6 col-6 header-end">

            <div class="drop-container">
              <div class="wrapper-dropdown dark-black" id="dropdown2">
                <span class="selected-display d-inline-flex align-items-center gap-8" id="destination2">
                  <img src="{{ asset('images/usd.png') }}" alt="">
                  USD
                </span>

                <svg id="drp-arrow2" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" xmlns="http://www.w3.org/2000/svg"
                     class="arrow transition-all ml-auto rotate-180">
                  <path d="M7 14.5l5-5 5 5"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"/>
                </svg>

                <ul class="topbar-dropdown bg-lightest-gray">
                  <li class="item dark-black d-flex align-items-center gap-8">
                    <img src="{{ asset('images/usd.png') }}" alt=""> USD
                  </li>
                  <li class="item dark-black d-flex align-items-center gap-8">
                    <img src="{{ asset('images/aed.png') }}" alt=""> AED
                  </li>
                  <li class="item dark-black d-flex align-items-center gap-8">
                    <img src="{{ asset('images/lb.png') }}" alt=""> LB
                  </li>
                  <li class="item dark-black d-flex align-items-center gap-8">
                    <img src="{{ asset('images/dem.png') }}" alt=""> DEM
                  </li>
                </ul>
              </div>
            </div>

            <div class="drop-container d-sm-block d-none">
              <div class="wrapper-dropdown dark-black" id="dropdown">
                <span class="selected-display" id="destination">English</span>

                <svg id="drp-arrow" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" xmlns="http://www.w3.org/2000/svg"
                     class="arrow transition-all ml-auto rotate-180">
                  <path d="M7 14.5l5-5 5 5"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"/>
                </svg>

                <ul class="topbar-dropdown bg-lightest-gray">
                  <li class="item dark-black">English</li>
                  <li class="item dark-black">Spanish</li>
                  <li class="item dark-black">Italian</li>
                  <li class="item dark-black">Arabic</li>
                </ul>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="header-bottom-area bg-light-black">
      <div class="container-fluid">
        <div class="row align-items-center">

          <div class="col-xl-3 col-md-6 col-4">
            <a href="{{ url('/') }}" class="header-logo">
              <img src="{{ asset('images/logo.png') }}" alt="">
            </a>
          </div>

          <div class="col-xl-6 d-xl-block d-none">
            <nav class="navigation d-flex align-items-center justify-content-center">
              <div class="menu-button-right">
                <div class="main-menu__nav">
                  <ul class="main-menu__list">

                    <li><a href="{{ url('/') }}" class="active">Home</a></li>

                    <li class="dropdown">
                      <a href="javascript:void(0);">
                        Shop <i class="fa-light fa-chevron-down d-lg-block d-none"></i>
                      </a>
                      <ul class="sub-menu">
                        <li><a href="{{ url('shop-grid') }}">Shop Grid</a></li>
                        <li><a href="{{ url('shop-grid-sidebar') }}">Shop Grid Sidebar</a></li>
                        <li><a href="{{ url('product-detail') }}">Product Detail</a></li>
                      </ul>
                    </li>

                    <li><a href="{{ url('about') }}">About Us</a></li>

                    <li class="dropdown">
                      <a href="javascript:void(0);">
                        Blogs <i class="fa-light fa-chevron-down d-lg-block d-none"></i>
                      </a>
                      <ul>
                        <li><a href="{{ url('blog-grid') }}">Blog Grid</a></li>
                        <li><a href="{{ url('blog-grid-sidebar') }}">Blog Grid Sidebar</a></li>
                        <li><a href="{{ url('blog-detail') }}">Blog Detail</a></li>
                      </ul>
                    </li>

                    <li class="dropdown">
                      <a href="javascript:void(0);">
                        Pages <i class="fa-light fa-chevron-down d-lg-block d-none"></i>
                      </a>
                      <ul class="sub-menu">
                        <li><a href="{{ url('contact') }}">Contact Us</a></li>
                        <li><a href="{{ url('404') }}">404</a></li>
                        <li><a href="{{ url('coming-soon') }}" class="active">Coming soon</a></li>
                      </ul>
                    </li>

                  </ul>
                </div>
              </div>
            </nav>
          </div>

          <div class="col-xl-3 col-md-6 col-8">
            <div class="header-buttons">

              <div class="logo-icon d-sm-block d-none">
                <form action="{{ url('/') }}">
                  <div class="search-block">
                    <input type="search"
                           class="input-search form-control"
                           name="search"
                           id="search"
                           placeholder="Search...">

                    <a href="javascript:;" id="magnifying-btn">
                      <i class="fa-light fa-magnifying-glass"></i>
                    </a>
                  </div>
                </form>
              </div>

              <a href="{{ url('contact') }}" class="account-btn">
                <i class="fa-light fa-user"></i>
              </a>

              <a href="javascript:;" class="cart-button">
                <i class="fa-light fa-cart-shopping"></i>
              </a>

              <a href="#" class="main-menu__toggler mobile-nav__toggler">
                <img src="{{ asset('images/menu-2.png') }}" alt="">
              </a>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Main Header End -->

  <!-- Sticky Header Start-->
  <div class="stricky-header stricked-menu main-menu">
    <div class="sticky-header__content"></div>
  </div>
  <!-- Sticky Header End -->
</header>
<!-- Header Menu End -->

<!-- Back To Top Start -->
<a href="#main-wrapper" id="backto-top" class="back-to-top">
  <i class="fa-light fa-chevron-up"></i>
</a>

<!-- Mobile Menu Start -->
<div class="mobile-nav__wrapper">
  <div class="mobile-nav__overlay mobile-nav__toggler"></div>

  <div class="mobile-nav__content">
    <span class="mobile-nav__close mobile-nav__toggler">
      <i class="fa fa-times"></i>
    </span>

    <div class="logo-box">
      <a href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="">
      </a>
    </div>

    <div class="mobile-nav__container"></div>

    <ul class="mobile-nav__contact list-unstyled">
      <li>
        <i class="fas fa-envelope"></i>
        <a href="mailto:example@company.com">slimza@info.com</a>
      </li>
      <li>
        <i class="fa fa-phone-alt"></i>
        <a href="tel:+12345678">Live Chat</a>
      </li>
    </ul>

    <div class="mobile-nav__social">
      <a href=""><i class="fa-brands fa-x-twitter"></i></a>
      <a href=""><i class="fab fa-facebook"></i></a>
      <a href=""><i class="fab fa-instagram"></i></a>
    </div>
  </div>
</div>
<!-- Mobile Menu End -->