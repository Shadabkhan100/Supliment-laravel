@extends('layout.Main')

@section('content')

@php
// fallback safety
$products = $products ?? [];
@endphp
<style>
.title-banner {
  position: relative;
  width: 100%;
  height: 500px;
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}



/* Text layer */
.title-banner .content {
  position: relative;
  z-index: 2;
}

.title-banner h2 {
  color: #fff;
  font-size: 36px;
  font-weight: 700;
  letter-spacing: 1px;
}
</style>
<main class="main-wrapper">

  <!-- TITLE BANNER -->
  <section class="title-banner" style="background-image: url('{{ $category->image ?? '/default.jpg' }}');">

    <div class="overlay"></div>

    <div class="container content">
    </div>
  </section>

  <!-- SHOP SECTION -->
  <section class="feature-products py-40">
    <div class="container-fluid">

      @include("modules.searchTags")

      <!-- SEARCH ONLY (REPLACED YOUR EMAIL SEARCH WITH PRODUCT SEARCH) -->
      <div class="row row-gap-3 align-items-center mb-16">

        <div class="col-xl-3 col-lg-5">
          <div class="newsletter-form">
            <input type="text" id="productSearch" class="form-control search-input" placeholder="Search products..." style="text-color:white;">
          </div>
        </div>



      </div>

      <!-- PRODUCTS GRID -->
      <div class="row row-gap-4" id="productGrid">

        @forelse($products as $product)

        <div class="col-xl-3 col-lg-4 col-sm-6 product-item" data-name="{{ strtolower($product->name) }}">

          <div class="product-block">

            <!-- IMAGE -->
            <div class="image-box mb-16">
        <a href="/product-details/{{ Str::slug($product->name) }}/{{ $product->id }}">
    <img src="{{ $product->image ?? $product->main_image }}" alt="{{ $product->name }}">
</a>

              @if(!empty($product->old_price))
              <div class="sale-label subtitle">
                -{{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}%
              </div>
              @endif

              <div class="shopping-btns">

                <a href="javascript:;" class="open-quick-view" data-bs-toggle="modal" data-bs-target="#productQuickView"
                  data-product='@json($product)'>

                  <i class="fa-regular fa-eye"></i>
                </a>

                <a href="javascript:;">
                  <i class="fa-light fa-heart"></i>
                </a>


              </div>
            </div>

            <!-- CONTENT -->
            <div class="content-box">

              <p class="eyebrow mb-12">
                {{ $product->category_name ?? '' }}
              </p>


              <a href="{{ url('product-details/' . \Illuminate\Support\Str::slug($product->name) . '/' . $product->id) }}"
                class="product-title h6 fw-500 mb-12">
                {{ $product->name }}
              </a>

              <!-- PRICE -->
              <div class="d-flex align-items-center justify-content-between">
                <h5 class="black">
                  @if(!empty($product->old_price))
                  <span class="h6 text-decoration-line-through dark-gray old-price">
                    {{ $product->old_price }}
                  </span>
                  @endif

                  <span class="main-price">
                    {{ $product->price }}
                  </span>
                </h5>
                  <a href="#"
   class="open-quick-view sm-btn light"
   data-bs-toggle="modal"
   data-bs-target="#productQuickView"
   data-product='@json($product)'>

                <svg xmlns="http://www.w3.org/2000/svg"
                     width="20"
                     height="20"
                     viewBox="0 0 20 20"
                     fill="none">

                  <path
                    d="M18.6356 17.8959C18.1471 14.4776 16.9554 6.13472 16.9554 6.13472C16.9141 5.84569 16.6666 5.63102 16.3746 5.63102H13.8194V3.70419C13.6313 -1.23661 6.54869 -1.23285 6.36241 3.70419V5.63102H3.80728C3.51533 5.63102 3.26784 5.84569 3.22654 6.13472C3.22654 6.13472 2.03482 14.4776 1.5463 17.8959C1.47062 18.4253 1.62823 18.9606 1.97862 19.3644C2.32901 19.7684 2.83657 20 3.37121 20H16.8107C17.3453 20 17.8528 19.7683 18.2033 19.3644C18.5536 18.9606 18.7113 18.4254 18.6356 17.8959ZM7.53575 3.70419C7.66462 0.318209 12.5184 0.320751 12.6461 3.70419V5.63102H7.53575V3.70419ZM17.317 18.5956C17.1896 18.7425 17.005 18.8267 16.8107 18.8267H3.37121C3.17683 18.8267 2.99231 18.7425 2.86489 18.5956C2.73755 18.4488 2.68029 18.2543 2.70779 18.0619C3.12415 15.1487 4.05121 8.65872 4.3161 6.80432H6.36245V8.10277C6.39132 8.88031 7.50716 8.87973 7.53575 8.10277V6.80432H12.6461V8.10277C12.675 8.88031 13.7908 8.87973 13.8194 8.10277V6.80432H15.8658C16.1307 8.65872 17.0578 15.1487 17.4741 18.0619C17.5016 18.2543 17.4443 18.4488 17.317 18.5956Z"
                                class="fill-black"

                  </path>


                </svg>

              </a>
              </div>

            </div>

          </div>
        </div>

        @empty
        <div class="col-12 text-center">
          <h5 class="white">No products found</h5>
        </div>
        @endforelse

      </div>

    </div>
  </section>

</main>

<!-- ================= SEARCH FILTER SCRIPT ================= -->
<script>
window.currencyConfig = @json(config('currency'));
window.currentCurrency = "{{ session('currency', 'GBP') }}";

function formatPrice(price) {

  const currency = window.currentCurrency || window.currencyConfig.default || "GBP";
  const config = window.currencyConfig?.currencies?. [currency];

  if (!config) return price;

  const converted = price * config.rate;

  return `${config.symbol} ${converted.toFixed(2)}`;
}
document.addEventListener("click", function (e) {
    const btn = e.target.closest(".open-quick-view");

    if (!btn) return;

    const product = JSON.parse(btn.dataset.product);

    console.log(product);
});
document.addEventListener('DOMContentLoaded', function() {

  // convert main prices
  document.querySelectorAll('.main-price').forEach(el => {
    const value = parseFloat(el.innerText);
    if (!isNaN(value)) {
      el.innerText = formatPrice(value);
    }
  });

  // convert old prices
  document.querySelectorAll('.old-price').forEach(el => {
    const value = parseFloat(el.innerText);
    if (!isNaN(value)) {
      el.innerHTML = formatPrice(value);
    }
  });

});

document.addEventListener('DOMContentLoaded', function() {

  const searchInput = document.getElementById('productSearch');
  const products = document.querySelectorAll('.product-item');
  const countBox = document.getElementById('showingCount');

  function filterProducts() {

    const value = searchInput.value.toLowerCase();
    let visibleCount = 0;

    products.forEach(item => {

      const name = item.getAttribute('data-name');

      if (name.includes(value)) {
        item.style.display = "block";
        visibleCount++;
      } else {
        item.style.display = "none";
      }
    });

    countBox.innerText = visibleCount;
  }

  searchInput.addEventListener('keyup', filterProducts);

});
</script>

@endsection