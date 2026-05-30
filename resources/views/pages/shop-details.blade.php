@extends('layout.Main')

@section('content')

@php
    // fallback safety
    $products = $products ?? [];
@endphp

<main class="main-wrapper">

    <!-- TITLE BANNER -->
    <section class="title-banner">
        <div class="container">
            <h2 class="white fw-600 text-center">
                {{ ucfirst(str_replace('-', ' ', $category_slug)) }}
            </h2>
        </div>
    </section>

    <!-- SHOP SECTION -->
    <section class="feature-products py-40">
        <div class="container-fluid">

            <!-- FILTER ROW (UNCHANGED DESIGN) -->
            <div class="row row-gap-4 mb-32">

                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="drop-container shop-dropdown p-24">
                        <div class="wrapper-dropdown w-100 d-flex align-items-center justify-content-between">
                            <span class="selected-display h6 fw-600 black">Availability</span>
                            <ul class="topbar-dropdown bg-lightest-gray w-100">
                                <li class="item black">Available</li>
                                <li class="item black">Not Available</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="drop-container shop-dropdown p-24">
                        <div class="wrapper-dropdown w-100 d-flex align-items-center justify-content-between">
                            <span class="selected-display h6 fw-600 black">Product Categories</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="drop-container shop-dropdown p-24">
                        <div class="wrapper-dropdown w-100 d-flex align-items-center justify-content-between">
                            <span class="selected-display h6 fw-600 black">Filter by Price</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="drop-container shop-dropdown p-24">
                        <div class="wrapper-dropdown w-100 d-flex align-items-center justify-content-between">
                            <span class="selected-display h6 fw-600 black">Weight</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- SEARCH ONLY (REPLACED YOUR EMAIL SEARCH WITH PRODUCT SEARCH) -->
            <div class="row row-gap-3 align-items-center mb-16">

                <div class="col-xl-3 col-lg-5">
                    <div class="newsletter-form">
                        <input type="text"
                               id="productSearch"
                               class="form-control search-input"
                               placeholder="Search products...">
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-5 col-8">
                    <p class="black fw-500">
                        Showing <span id="showingCount">{{ count($products) }}</span> products
                    </p>
                </div>

            </div>

            <!-- PRODUCTS GRID -->
            <div class="row row-gap-4" id="productGrid">

                @forelse($products as $product)

                    <div class="col-xl-3 col-lg-4 col-sm-6 product-item"
                         data-name="{{ strtolower($product->name) }}">

                        <div class="product-block">

                            <!-- IMAGE -->
                            <div class="image-box mb-16">
                                <img src="{{ $product->image ?? $product->main_image }}"
                                     alt="{{ $product->name }}">

                                @if(!empty($product->old_price))
                                    <div class="sale-label subtitle">
                                        -{{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}%
                                    </div>
                                @endif
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
window.currentCurrency = "{{ session('currency', 'USD') }}";

function formatPrice(price) {

  const currency = window.currentCurrency || window.currencyConfig.default || "USD";
  const config = window.currencyConfig?.currencies?.[currency];

  if (!config) return price;

  const converted = price * config.rate;

  return `${config.symbol} ${converted.toFixed(2)}`;
}

document.addEventListener('DOMContentLoaded', function () {

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

document.addEventListener('DOMContentLoaded', function () {

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