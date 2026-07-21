@extends('layout.Main')

@section('content')
@php
$cartPayload = $cartItems->map(function ($item) {
return [
'product_id' => $item->product_id,
'product_option' => $item->option,
'quantity' => $item->quantity,
'purchase_type' => $item->purchase_type,
];
})->values();
@endphp
<style>
.checkoutBtnX1 {
  position: relative;
  min-width: 220px;
}

.btn-spinner {
  display: inline-block;
  width: 16px;
  height: 16px;
  border: 2px solid rgba(255, 255, 255, .3);
  border-top-color: #fff;
  border-radius: 50%;
  animation: spin .8s linear infinite;
  margin-right: 8px;
  vertical-align: middle;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.checkoutBtnX1.loading {
  opacity: .85;
  cursor: not-allowed;
}

/* ================= CART WRAPPER ================= */
.cartWrapX1 {
  padding: 40px 10px;
}

/* ================= ITEM CARD ================= */
.cartItemCardX1 {
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 18px;
  padding: 18px;
  margin-bottom: 16px;
  display: flex;
  gap: 15px;
  align-items: center;
  transition: 0.25s;
}

.cartItemCardX1:hover {
  transform: translateY(-3px);
  border-color: #9eef0b;
}

/* ================= IMAGE ================= */
.cartImgX1 {
  width: 85px;
  height: 85px;
  border-radius: 12px;
  overflow: hidden;
  flex-shrink: 0;
  background: #111;
}

.cartImgX1 img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* ================= PRODUCT INFO ================= */
.cartInfoX1 {
  flex: 1;
}

.cartTitleX1 {
  color: #fff;
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 5px;
}

.cartMetaX1 {
  color: #aaa;
  font-size: 13px;
}

/* ================= PRICE ================= */
.cartPriceX1 {
  text-align: right;
  min-width: 120px;
}

.cartPriceMainX1 {
  color: #9eef0b;
  font-size: 18px;
  font-weight: 800;
}

.cartPriceSubX1 {
  color: #aaa;
  font-size: 12px;
}

/* ================= SUMMARY BOX ================= */
.cartSummaryX1 {
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 18px;
  padding: 20px;
  position: sticky;
  top: 20px;
}

.summaryTitleX1 {
  color: #fff;
  font-size: 18px;
  font-weight: 700;
  margin-bottom: 15px;
}

.summaryRowX1 {
  display: flex;
  justify-content: space-between;
  padding: 8px 0;
  color: #ccc;
}

.summaryTotalX1 {
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  margin-top: 10px;
  padding-top: 10px;
  font-weight: 800;
  color: #9eef0b;
  font-size: 18px;
}

/* ================= EMPTY ================= */
.emptyCartX1 {
  text-align: center;
  padding: 60px 20px;
  color: #aaa;
}

.emptyCartX1 h3 {
  color: #fff;
  margin-top: 10px;
}

.checkoutWrapX1 {
  display: none;
  justify-content: center;
  padding: 30px 0;
}

.checkoutCardX1 {
  width: 100%;
  max-width: 1100px;
  background: #111;
  border-radius: 24px;
  padding: 30px;
  border: 1px solid rgba(255, 255, 255, .08);
}

.checkoutHeaderX1 {
  display: flex;
  align-items: center;
  gap: 15px;
  margin-bottom: 25px;
}

.backBtnX1 {
  width: 50px;
  height: 50px;
  border: none;
  border-radius: 50%;
  background: #9eef0b;
  color: #000;
}

.checkoutSectionX1 {
  background: #171717;
  border-radius: 18px;
  padding: 20px;
  margin-bottom: 20px;
}

.checkoutSectionX1 h6 {
  color: #9eef0b;
  margin-bottom: 15px;
}

.inputWrapX1 {
  position: relative;
  margin-bottom: 15px;
}

.inputWrapX1 i {
  position: absolute;
  left: 15px;
  top: 50%;
  transform: translateY(-50%);
  color: #888;
}

.inputWrapX1 input {
  width: 100%;
  height: 55px;
  background: #0d0d0d;
  border: 1px solid #333;
  color: #fff;
  border-radius: 12px;
  padding-left: 45px;
}

#map {
  width: 100%;
  height: 300px;
  border-radius: 15px;
  overflow: hidden;
}

.checkoutSummaryX1 {
  background: #171717;
  border-radius: 18px;
  padding: 20px;
  margin-top: 20px;
}

.summaryLineX1 {
  display: flex;
  justify-content: space-between;
  color: #fff;
}

.checkoutBtnX1 {
  width: 100%;
  margin-top: 20px;
  height: 60px;
  border: none;
  border-radius: 14px;
  background: #9eef0b;
  color: #000;
  font-weight: 700;
}

@media (max-width: 637px) {
  #modal-content {
    margin-top: 1437px !important;
  }

  .checkoutWrapX1 {
    display: none;
    justify-content: center;
    padding: 40px 13px;
  }

}
</style>

<div class="container cartWrapX1" id="cartWrapX1">

  <div class="row g-4">

    <!-- LEFT: CART ITEMS -->
    <div class="col-lg-8">

      @php
      $grandTotal = 0;
      @endphp

      @forelse($cartItems as $item)

      @php
      $product = $item->product;
      $qty = $item->quantity ?? 1;
      $option = $item->option ?? [];
      $pack = $option['pack'] ?? 1;

      // ✅ SAFE: always get price from cart first
      $unitPrice = $item->unit_price ?? $item->price ?? ($product->price ?? 0);

      $subtotal = $unitPrice * $qty;

      $grandTotal += $subtotal;
      @endphp

      <div class="cartItemCardX1">

        <!-- IMAGE -->
        <div class="cartImgX1">
          <img src="{{ $item->option['image'] ?? $product->main_image_url ?? '/placeholder.png' }}">
        </div>

        <!-- INFO -->
        <div class="cartInfoX1">
          <div class="cartTitleX1">
            {{ $product->name ?? 'Product Not Found' }}
          </div>

          <div class="cartMetaX1">
            Qty: {{ $qty }} | {{ $pack }} Packs
          </div>
        </div>

        <!-- PRICE -->
        <div class="cartPriceX1">

          <!-- SUBTOTAL -->
          <div class="cartPriceMainX1 currency-price" data-value="{{ $subtotal }}">
            {{ number_format($item->subtotal, 2) }}
          </div>

          <!-- UNIT PRICE -->
          <!-- UNIT PRICE -->
          <div class="cartPriceSubX1 currency-price" data-value="{{ $unitPrice / max($pack,1) }}">
            {{ number_format($unitPrice / max($pack,1), 2) }} each
          </div>

          <!-- VIEW -->
          <div class="mt-3">
            <a href="javascript:void(0)" class="btn btn-sm btn-outline-light view-product-btn mx-1"
              data-cart-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#productModal">
              <i class="fas fa-eye"></i>
            </a>
            <a href="javascript:void(0)" class="btn btn-sm btn-outline-danger delete-cart-btn mx-1"
              data-cart-id="{{ $item->id }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>

        </div>

      </div>

      @empty

      <div class="emptyCartX1">
        <i class="fas fa-shopping-cart fa-3x"></i>
        <h3>Your cart is empty</h3>
        <p>Add some products to continue shopping</p>
      </div>

      @endforelse

    </div>

    <!-- RIGHT: SUMMARY -->
    <div class="col-lg-4">

      <div class="cartSummaryX1">

        <div class="summaryTitleX1">Order Summary</div>

        <div class="summaryRowX1">
          <span>Subtotal</span>
          <span class="currency-price" data-value="{{ $grandTotal }}">
            {{ number_format($grandTotal, 2) }}
          </span>
        </div>

        <div class="summaryRowX1">
          <span>Shipping</span>
          <span>Free</span>
        </div>
        @php
        $discount = 0; // or from coupon logic later
        @endphp
        <div class="summaryRowX1">
          <span>Discount</span>
          <span class="currency-price" data-value="{{ $discount }}">
            {{ number_format($discount, 2) }}
          </span>
        </div>

        <div class="summaryTotalX1">
          Total:
          <span class="currency-price" data-value="{{ $grandTotal }}">
            {{ number_format($grandTotal,2) }}
          </span>
        </div>

        <form action="{{ route('stripe.checkout') }}" method="POST">
          @csrf

          {{-- total price --}}
          <input type="hidden" name="total" value="{{ $grandTotal }}">

          {{-- cart IDs --}}
          <input type="hidden" name="cart_ids" value="{{ $cartItems->pluck('id')->implode(',') }}">

          <button type="submit" class="btn btn-success w-100 mt-3">
            Pay <span class="currency-price" data-value="{{ $grandTotal }}">
              {{ number_format($grandTotal,2) }}
            </span>
          </button>
        </form>

        <button type="button" id="proceedCheckoutBtn" class="btn btn-success w-100 mt-3">
          Proceed Checkout
        </button>


      </div>

    </div>

  </div>

</div>






<div class="modal fade" id="productModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white" id="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Product Details</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        @include("products.cart-product-details")
      </div>

    </div>
  </div>
</div>








<div id="checkoutWrapX1" class="checkoutWrapX1">

  <div class="checkoutCardX1">

    <!-- HEADER -->
    <div class="checkoutHeaderX1">

      <button type="button" id="backToCartBtn" class="backBtnX1">
        <i class="fas fa-arrow-left"></i>
      </button>

      <div>
        <h4>Checkout</h4>
        <p>Complete your order details</p>
      </div>

    </div>

    <!-- CONTACT -->
    <div class="checkoutSectionX1">

      <h6>
        <i class="fas fa-user-circle"></i>
        Contact Information
      </h6>

      <div class="row">

        <div class="col-md-6">
          <div class="inputWrapX1">
            <i class="fas fa-user"></i>
            <input type="text" id="name" value="{{ $authUser?->name }}" placeholder="Full Name">
          </div>
        </div>

        <div class="col-md-6">
          <div class="inputWrapX1">
            <i class="fas fa-envelope"></i>
            <input type="email" id="email" value="{{ $authUser?->email }}" placeholder="Email Address">
          </div>
        </div>

        <div class="col-md-6">
          <div class="inputWrapX1">
            <i class="fas fa-phone"></i>
            <input type="text" id="phone" value="{{ $authUser?->phone }}" placeholder="Phone Number">
          </div>
        </div>

      </div>

    </div>

    <!-- ADDRESS -->
    <div class="checkoutSectionX1">

      <h6>
        <i class="fas fa-map-marker-alt"></i>
        Delivery Address
      </h6>

      <div class="row">

        <div class="col-12">
          <div class="inputWrapX1">
            <i class="fas fa-home"></i>
            <input type="text" id="address1" placeholder="Address">
          </div>
        </div>

        <div class="col-md-4">
          <div class="inputWrapX1">
            <i class="fas fa-city"></i>
            <input type="text" id="city" placeholder="City">
          </div>
        </div>

        <div class="col-md-4">
          <div class="inputWrapX1">
            <i class="fas fa-mail-bulk"></i>
            <input type="text" id="postal" placeholder="Postal Code">
          </div>
        </div>

        <div class="col-md-4">
          <div class="inputWrapX1">
            <i class="fas fa-globe"></i>
            <input type="text" id="country" placeholder="Country">
          </div>
        </div>

      </div>

    </div>

    <!-- MAP -->
    <div class="checkoutSectionX1">

      <h6>
        <i class="fas fa-map"></i>
        Delivery Location
      </h6>

      <div id="map" style="width:100%; height:300px; border-radius:12px;"></div>

    </div>

    <!-- ORDER SUMMARY -->
    <div class="checkoutSummaryX1">

      <div class="summaryLineX1">
        <span>Items</span>
        <span>{{ $cartItems->count() }}</span>
      </div>

      <div class="summaryLineX1">
        <span>Total</span>
        <span>
          {{ number_format($grandTotal,2) }}
        </span>
      </div>

    </div>

    <button class="checkoutBtnX1">
      <i class="fas fa-lock"></i>
      Continue To Payment
    </button>

  </div>

</div>



<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
window.cartItemsPayload = @json($cartPayload);
</script>

<script>
window.currencyConfig = @json(config('currency'));
window.currentCurrency = "{{ session('currency', 'GBP') }}";

function formatCurrency(value) {

  const currency = window.currentCurrency || "GBP";
  const config = window.currencyConfig?.currencies?. [currency];

  if (!config) {
    return value.toFixed(2);
  }

  const converted = parseFloat(value) * parseFloat(config.rate);

  return `${config.symbol}${converted.toFixed(2)}`;
}

function updateAllPrices() {

  document.querySelectorAll('.currency-price').forEach(el => {

    const raw = parseFloat(el.dataset.value || 0);

    if (isNaN(raw)) return;

    let formatted = formatCurrency(raw);

    if (el.classList.contains('cartPriceSubX1')) {
      formatted += ' each';
    }

    el.innerText = formatted;
  });

}

document.addEventListener('DOMContentLoaded', function() {
  updateAllPrices();
});





document.addEventListener('click', function(e) {

  const btn = e.target.closest('.view-product-btn');
  if (!btn) return;

  window.__cartItemId = btn.dataset.cartId;

});





document.addEventListener('click', async function(e) {

  const btn = e.target.closest('.delete-cart-btn');
  if (!btn) return;

  const id = btn.dataset.cartId;

  const confirmDelete = await Swal.fire({
    title: "Are you sure?",
    text: "This item will be removed from your cart.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!"
  });

  if (!confirmDelete.isConfirmed) return;

  try {

    const res = await fetch(`/api/cart/delete/${id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
      }
    });

    const data = await res.json();

    if (data.success) {

      Swal.fire({
        title: "Deleted!",
        text: "Cart item removed successfully.",
        icon: "success",
        timer: 1500,
        showConfirmButton: false
      });

      const card = btn.closest('.cartItemCardX1');

      const subtotalEl = card.querySelector('.cartPriceMainX1');
      const removedAmount = parseFloat(subtotalEl.dataset.value || 0);
      card.remove();

      // Update summary
      document.querySelectorAll('.summaryRowX1 .currency-price, .summaryTotalX1 .currency-price')
        .forEach(el => {

          let current = parseFloat(el.dataset.value || 0);

          current -= removedAmount;

          if (current < 0) current = 0;

          el.dataset.value = current;
        });

      updateAllPrices();
      refreshCartCount();

    } else {

      Swal.fire({
        title: "Error",
        text: data.message || "Failed to delete item.",
        icon: "error"
      });

    }

  } catch (error) {

    Swal.fire({
      title: "Error",
      text: "Something went wrong.",
      icon: "error"
    });

    console.error(error);
  }

});








document.addEventListener('DOMContentLoaded', function() {

  const proceedBtn = document.getElementById('proceedCheckoutBtn');
  const backBtn = document.getElementById('backToCartBtn');

  const cartWrap = document.getElementById('cartWrapX1');
  const checkoutWrap = document.getElementById('checkoutWrapX1');

  if (proceedBtn) {

    proceedBtn.addEventListener('click', function() {

      cartWrap.style.display = 'none';
      checkoutWrap.style.display = 'flex';
      initMap();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });

    });

  }

  if (backBtn) {

    backBtn.addEventListener('click', function() {

      checkoutWrap.style.display = 'none';
      cartWrap.style.display = 'block';

      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });

    });

  }

});



let map;
let marker;
let selectedLat = null;
let selectedLng = null;

function initMap() {

  // prevent double init
  if (map) {
    setTimeout(() => {
      map.invalidateSize(); // FIX for hidden container issue
    }, 200);
    return;
  }

  // default location (Riyadh)
  const defaultLat = 24.7136;
  const defaultLng = 46.6753;

  map = L.map('map', {
    center: [defaultLat, defaultLng],
    zoom: 10,
    zoomControl: true
  });

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  // click event
  map.on('click', function(e) {

    selectedLat = e.latlng.lat;
    selectedLng = e.latlng.lng;

    // update marker
    if (marker) {
      marker.setLatLng(e.latlng);
    } else {
      marker = L.marker(e.latlng).addTo(map);
    }

    console.log("Selected:", selectedLat, selectedLng);
  });

  // FIX: map must recalc size after visible
  setTimeout(() => {
    map.invalidateSize();
  }, 300);
}




document.addEventListener('DOMContentLoaded', function() {

  const checkoutBtn = document.querySelector('.checkoutBtnX1');

  if (!checkoutBtn) return;

  checkoutBtn.addEventListener('click', async function() {

    checkoutBtn.disabled = true;
    checkoutBtn.classList.add('loading');

    checkoutBtn.innerHTML = `
    <span class="btn-spinner"></span>
    Creating Order...
`;

    const payload = {
      name: document.getElementById('name')?.value || '',
      email: document.getElementById('email')?.value || '',
      phone: document.getElementById('phone')?.value || '',

      address1: document.getElementById('address1')?.value || '',
      city: document.getElementById('city')?.value || '',
      postal: document.getElementById('postal')?.value || '',
      country: document.getElementById('country')?.value || '',

      lat: typeof selectedLat !== 'undefined' ? selectedLat : null,
      lng: typeof selectedLng !== 'undefined' ? selectedLng : null,

      items: Array.isArray(window.cartItemsPayload) ?
        window.cartItemsPayload : [],
    };

    try {
      const res = await fetch('/create-cart-order', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
      });

      const data = await res.json().catch(() => null);

      console.log('HTTP STATUS:', res.status);
      console.log('RESPONSE DATA:', data);

      if (!res.ok) {
        console.error('Server Error Response:', data);
        alert(data?.message || 'Server error occurred');
        checkoutBtn.disabled = false;
        checkoutBtn.classList.remove('loading');

        checkoutBtn.innerHTML = `
    <i class="fas fa-lock"></i>
    <span class="btn-text">Continue To Payment</span>
`;
        return;
      }

      if (data?.status) {

        const orderIds = data.order_ids || [];
        const total = data.total_price || 0;

        if (!orderIds.length) {
          alert('No orders created');

          return;
        }

        window.location.href =
          `/stripe/checkout?order_ids=${orderIds.join(',')}&total=${total}`;

      } else {
        console.error('Application Error:', data);
        alert(data?.message || 'Order creation failed');
        checkoutBtn.disabled = false;
        checkoutBtn.classList.remove('loading');

        checkoutBtn.innerHTML = `
    <i class="fas fa-lock"></i>
    <span class="btn-text">Continue To Payment</span>
`;
      }

    } catch (error) {
      console.error('Fetch Failed (Network/JS Error):', error);
      alert('Network error while creating order');
      checkoutBtn.disabled = false;
      checkoutBtn.classList.remove('loading');

      checkoutBtn.innerHTML = `
    <i class="fas fa-lock"></i>
    <span class="btn-text">Continue To Payment</span>
`;
    }
  });
});
</script>
@endsection