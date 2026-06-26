<!doctype html>
<html lang="en">
  <head>
      <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- SEO META -->
    <title>SLIMZA | Premium Dietary Supplements & Wellness Products</title>

    <meta name="title" content="SLIMZA | Premium Dietary Supplements & Wellness Products" />

   <meta name="description" content="SLIMZA is a premium wellness brand offering natural dietary supplements, herbal teas, vitamins, and fitness nutrition products. We focus on high-quality ingredients designed to support weight management, energy, digestion, and overall wellbeing. Shop trusted health solutions with fast delivery across the UK, Middle East including UAE, Saudi Arabia, Qatar, and Kuwait." />

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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<style>

.policyBarX9 {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(15, 17, 21, 0.98);
    color: #fff;
    padding: 16px 20px;
    display: none;
    justify-content: space-between;
    align-items: center;
    z-index: 999999;
    border-top: 1px solid rgba(255,255,255,0.1);
}

.policyTextX9 {
    font-size: 14px;
    color: #ddd;
}

.policyActionsX9 {
    display: flex;
    gap: 10px;
}

.acceptBtnX9 {
    background: #9eef0b;
    border: none;
    padding: 8px 16px;
    font-weight: 700;
    color: #000;
    border-radius: 8px;
    cursor: pointer;
}

.rejectBtnX9 {
    background: transparent;
    border: 1px solid #666;
    padding: 8px 16px;
    color: #fff;
    border-radius: 8px;
    cursor: pointer;
}

</style>
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
    @include("modules.checkout-modal")


<div id="policyBarX9" class="policyBarX9">
    <div class="policyTextX9">
        By using this site, you agree to our Terms & Conditions and Privacy Policy.
    </div>

    <div class="policyActionsX9">
        <button id="rejectPolicyX9" class="rejectBtnX9">Reject</button>
        <button id="acceptPolicyX9" class="acceptBtnX9">Agree</button>
    </div>
</div>












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

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
document.addEventListener("DOMContentLoaded", function () {

    const bar = document.getElementById("policyBarX9");
    const acceptBtn = document.getElementById("acceptPolicyX9");
    const rejectBtn = document.getElementById("rejectPolicyX9");

    const storageKey = "site_policy_agreed";

    // =========================
    // 1. Check localStorage
    // =========================
    const existing = localStorage.getItem(storageKey);

    // Show ONLY if nothing exists
    if (existing === null) {
        bar.style.display = "flex";
    }

    // =========================
    // 2. Accept Policy
    // =========================
    acceptBtn.addEventListener("click", function () {
        localStorage.setItem(storageKey, "1");
        bar.style.display = "none";
    });

    // =========================
    // 3. Reject Policy
    // =========================
    rejectBtn.addEventListener("click", function () {
        localStorage.setItem(storageKey, "0");
        bar.style.display = "none";
    });

});
// 🔥 QUICK VIEW SCRIPT HERE
document.addEventListener("click", function (e) {

  const btn = e.target.closest(".open-quick-view");
  if (!btn) return;

  const encoded = btn.dataset.product;
  const product = JSON.parse(decodeURIComponent(encoded));
    
   window.currentQuickViewProduct = product;
  window.selectedProductId = product.id; 
  // MAIN IMAGE
  document.getElementById("qv-main-image").src = product.main_image || '';

  document.getElementById("qv-add-to-cart").dataset.id = product.id;

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

window.isLoggedIn = @json(auth()->check());



document.addEventListener("click", function (e) {

  const btn = e.target.closest(".add-to-cart");
  if (!btn) return;

  e.preventDefault();

  const productId = btn.dataset.id;

  const basePayload = {
    product_id: productId,
    option: window.selectedOption || null,
    purchase_type: window.purchaseMode || "one_time",
    quantity: document.querySelector('input[name="quantity"]')?.value || 1
  };

  console.log("CLICKED ADD TO CART", basePayload);

  // =========================
  // AUTH USER
  // =========================
  if (window.isLoggedIn) {
    sendCart(basePayload);
    return;
  }

  // =========================
  // GUEST FLOW (FIXED)
  // =========================
  fetch('/ensure-guest-id', {
    method: 'GET',
    credentials: "include",
    headers: { 'Accept': 'application/json' }
  })
  .then(res => res.json())
  .then(data => {

    console.log("GUEST RESPONSE:", data);

    if (!data.guest_id) {
      Swal.fire({
        toast: true,
        icon: "error",
        title: "Guest session failed",
        timer: 3000
      });
      return;
    }

    // ✅ IMPORTANT FIX (THIS WAS MISSING)
    basePayload.guest_id = data.guest_id;

    sendCart(basePayload);

  })
  .catch(err => {
    console.error("Guest error:", err);
  });

});



function sendCart(payload) {

  fetch("/cart/add", {
    method: "POST",
    credentials: "include",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify(payload)
  })
  .then(async (res) => {

    const data = await res.json().catch(() => ({}));

    console.log("SERVER RESPONSE:", res.status, data);

    if (!res.ok || data.status === false) {

      Swal.fire({
        toast: true,
        icon: "error",
        title: data.message || "Cart failed",
        timer: 3000
      });

      return;
    }

    Swal.fire({
      toast: true,
      icon: "success",
      title: data.message || "Added to cart",
      timer: 2500
    });

  })
  .catch(err => {
    console.error("Cart error:", err);
  });
}









document.addEventListener("click", function(e){

    const btn = e.target.closest("#qv-order-now");

    if(!btn) return;

    e.preventDefault();

    const quantity =
        document.querySelector('input[name="quantity"]')?.value || 1;

    const checkoutData = {

        product: {
            id: window.selectedProductId,
            option: window.selectedOption || null,
            purchase_type: window.purchaseMode || "one_time",
            quantity: quantity
        }

    };

    localStorage.setItem(
        "checkout_cart",
        JSON.stringify(checkoutData)
    );

    openCheckoutModal();
});


window.openCheckoutModal = function () {

    const quickViewEl = document.getElementById("productQuickView");
  
    if (quickViewEl) {
        const modal = bootstrap.Modal.getOrCreateInstance(quickViewEl);
        modal.hide();
    }

    document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());
    document.body.classList.remove("modal-open");

    document.getElementById("checkoutModal").classList.add("active");
    document.body.classList.add("checkout-open");
  window.fillAuthUserData();
}

function closeCheckoutModal() {
    document.getElementById("checkoutModal").classList.remove("active");
    document.body.classList.remove("checkout-open");
}


function getLocalCart() {
  return JSON.parse(localStorage.getItem("guest_cart")) || [];
}

function saveLocalCart(cart) {
  localStorage.setItem("guest_cart", JSON.stringify(cart));
}
</script>




  </body>
</html>