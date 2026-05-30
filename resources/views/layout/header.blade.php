
<!-- Slick CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">

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
@php
    $currency = session('currency', 'USD');
@endphp
    <li class="currency-item {{ $currency === 'USD' ? 'active' : '' }}" data-currency="USD">
        <img src="{{ asset('images/usd.png') }}" alt=""> USD
    </li>

    <li class="currency-item {{ $currency === 'SAR' ? 'active' : '' }}" data-currency="SAR">
        <img src="{{ asset('images/sar.png') }}" alt=""> SAR
    </li>

    <li class="currency-item {{ $currency === 'EUR' ? 'active' : '' }}" data-currency="EUR">
        <img src="{{ asset('images/eur.png') }}" alt=""> EUR
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

<li class="dropdown" id="shop-category-dropdown">

    <a href="javascript:void(0);">
        Shop
        <i class="fa-light fa-chevron-down d-lg-block d-none"></i>
    </a>

    <ul class="sub-menu" id="category-menu">
        <li>
            <a href="javascript:void(0);">Loading...</a>
        </li>
    </ul>

</li>

                    <li><a href="{{ url('about') }}">About Us</a></li>
                     <li><a href="{{ url('all-blogs') }}">Blogs</a></li>

                    <li class="dropdown">
                      <a href="javascript:void(0);">
                        Pages <i class="fa-light fa-chevron-down d-lg-block d-none"></i>
                      </a>
                      <ul class="sub-menu">




                        <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                        <li><a href="{{ url('/about-us') }}">About us</a></li>
                        <li><a href="{{ url('/faq') }}" class="active">FAQ</a></li>
                         <li><a href="{{ url('/return-policy') }}">Return & Refund Policy</a></li>
                        <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
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

<!-- jQuery FIRST -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Slick JS -->
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
window.currentCurrency = "{{ session('currency', 'USD') }}";
document.addEventListener('DOMContentLoaded', async function () {

    console.log('🚀 CATEGORY SCRIPT LOADED');

    const categoryMenus = document.querySelectorAll('#category-menu');

    if (!categoryMenus.length) {
        console.error('No category menus found');
        return;
    }

    try {

        const response = await fetch('/api/categories');
        const result = await response.json();

        const categories = result.data || [];

        console.log('Categories:', categories);

        categoryMenus.forEach(menu => {

            if (!categories.length) {
                menu.innerHTML = `<li><a href="#">No Categories Found</a></li>`;
                return;
            }

            menu.innerHTML = categories.map(cat => `
                <li>
                    <a href="/shop/${cat.name}/${cat.id}">
                        ${cat.name}
                    </a>
                </li>
            `).join('');

        });

        console.log('✅ Desktop + Mobile menus updated');

    } catch (error) {
        console.error('❌ Category Error:', error);

        categoryMenus.forEach(menu => {
            menu.innerHTML = `<li><a href="#">Failed To Load Categories</a></li>`;
        });
    }

});
</script>

<script src="{{ asset('js/currency.js') }}"></script>
<script>


document.querySelectorAll('.currency-item').forEach(item => {

    item.addEventListener('click', function () {

        let currency = this.getAttribute('data-currency');

        fetch("{{ route('change.currency') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                currency: currency
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload(); // refresh entire site with new currency
            }
        });

    });

});

document.addEventListener("DOMContentLoaded", function () {

    const currentCurrency = "{{ session('currency', 'USD') }}";

    const selected = document.querySelector("#destination2");

    const activeItem = document.querySelector(`.currency-item[data-currency="${currentCurrency}"]`);

    if (selected && activeItem) {

        const img = activeItem.querySelector("img")?.src;
        const text = activeItem.textContent.trim();

        selected.innerHTML = `
            <img src="${img}" alt="">
            ${text}
        `;
    }

});
</script>
<!-- Mobile Menu End -->