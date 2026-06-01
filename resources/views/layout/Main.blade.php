<!doctype html>
<html lang="en">
  <head>
      <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- SEO META -->
    <title>SLIMZA | Premium Dietary Supplements & Wellness Products</title>

    <meta name="title" content="SLIMZA | Premium Dietary Supplements & Wellness Products" />

    <meta name="description"
        content="SLIMZA offers premium dietary supplements, vitamins, fitness nutrition, and wellness products. Shop high-quality health supplements with fast delivery across the Middle East including UAE, Saudi Arabia, Qatar, and Kuwait." />

    <meta name="keywords"
        content="dietary supplements, wellness products, vitamins, fitness supplements, nutrition products, weight management, health supplements UAE, Saudi supplements, Qatar vitamins, Kuwait health products, SLIMZA" />

    <meta name="author" content="SLIMZA" />

    <meta name="robots" content="index, follow" />

   <link rel="canonical" href="https://slimza.com/" />

    <!-- Open Graph -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://slimza.com/" />
    <meta property="og:title" content="SLIMZA | Premium Dietary Supplements & Wellness Products" />
    <meta property="og:description"
        content="Premium dietary supplements, vitamins, and wellness products across the Middle East." />
    <meta property="og:image" content="{{ asset('images/favicon.png') }}" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://slimza.com/" />
    <meta property="twitter:title" content="SLIMZA | Premium Dietary Supplements & Wellness Products" />
    <meta property="twitter:description"
        content="Shop premium wellness and fitness supplements across UAE, Saudi Arabia, Qatar, and Kuwait." />
    <meta property="twitter:image" content="{{ asset('images/favicon.png') }}" />
  <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}" />

    <!-- Performance (SEO boost, no UI impact) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <!-- All CSS files -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-animation.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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


    @include('layout.header')
    @yield('content')
    <div id="sidebar-cart-curtain" class="close-popup"></div>
    @include('layout.footer')
    @include("products.productQuickView")
    @include("products.comparepopup")
    @include("products.cart-popup")


@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: @json(session('success')),
        showConfirmButton: false,
        timer: 6000,
        timerProgressBar: true
    });
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: @json(session('error')),
        showConfirmButton: false,
        timer: 6000,
        timerProgressBar: true
    });
});
</script>
@endif

<script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('js/slickAnimation.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<!--Start of Tawk.to Script-->
<!-- <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/6a087755f2f4431c3320f1cc/1jooh4a18';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End of Tawk.to Script-->






<script>

// 🔥 QUICK VIEW SCRIPT HERE
document.addEventListener("click", function (e) {

  const btn = e.target.closest(".open-quick-view");
  if (!btn) return;

  const encoded = btn.dataset.product;
  const product = JSON.parse(decodeURIComponent(encoded));

  // MAIN IMAGE
  document.getElementById("qv-main-image").src = product.main_image || '';

  // CATEGORY
  document.getElementById("qv-category").innerText = product.category_name || '';

  // NAME
  document.getElementById("qv-name").innerText = product.name || '';

  // DESCRIPTION (clean HTML)
  const desc = stripHtml(product.description || '');
document.getElementById("qv-description").innerText =
  desc.split(' ').slice(0, 35).join(' ') + '...';

  // PRICE (with currency support)
document.getElementById("qv-price").innerText =
  formatPrice(product.price);

// OLD PRICE (with currency support)
document.getElementById("qv-old-price").innerText =
  product.old_price ? formatPrice(product.old_price) : '';

  // SKU
  document.getElementById("qv-sku").innerText = product.sku || '';

  // MAIN IMAGE UPDATE
  document.getElementById("qv-main-image").src = product.main_image || '';

  // GALLERY
  const gallery = document.getElementById("qv-gallery");
  gallery.innerHTML = '';

  if (product.gallery_images && product.gallery_images.length) {
    product.gallery_images.forEach(img => {
      const el = document.createElement("img");
      el.src = img;
      el.style.width = "60px";
      el.style.height = "60px";
      el.style.objectFit = "cover";
      el.style.borderRadius = "6px";
      el.style.cursor = "pointer";

      el.onclick = () => {
        document.getElementById("qv-main-image").src = img;
      };

      gallery.appendChild(el);
    });
  }

});

function stripHtml(html) {
  const div = document.createElement("div");
  div.innerHTML = html;
  return div.textContent || div.innerText || "";
}


function formatPrice(price) {

  const currency = window.currentCurrency || window.currencyConfig.default || "GBP";

  const config = window.currencyConfig?.currencies?.[currency];

  if (!config) {
    console.warn("Currency not found:", currency);
    return `$ ${price}`;
  }

  const converted = price * config.rate;

  return `${config.symbol} ${converted.toFixed(2)}`;
}


</script>




  </body>
</html>