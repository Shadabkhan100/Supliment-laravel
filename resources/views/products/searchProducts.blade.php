@extends('layout.Main')

@section('content')

<div class="container py-4">

    <!-- Page Title -->
    <h2 class="mb-4">
        Search Result for:
        <span style="color:#ff6600;">
            {{ ucfirst(str_replace('-', ' ', $tag)) }}
        </span>
    </h2>

  <div class="row row-gap-3">

@foreach($products as $product)

  <div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="product-block">

      <div class="image-box mb-16">

       <a href="{{ url('product-details/' . \Illuminate\Support\Str::slug($product['name']) . '/' . $product['id']) }}">
    <img src="{{ $product['image'] ?? $product['main_image'] }}" alt="{{ $product['name'] }}">
</a>

        @if(!empty($product['old_price']) && $product['old_price'] > $product['price'])
          <div class="sale-label subtitle">
            -{{ round((($product['old_price'] - $product['price']) / $product['old_price']) * 100) }}%
          </div>
        @endif

        <div class="shopping-btns">
<a href="javascript:;"
   class="open-quick-view"
   data-bs-toggle="modal"
   data-bs-target="#productQuickView"
   data-product='@json($product)'>

   <i class="fa-regular fa-eye"></i>
</a>

          <a href="javascript:;" class="">
            <i class="fa-light fa-heart"></i>
          </a>

                 </div>

      </div>

      <div class="content-box">

        <p class="eyebrow mb-12">
          {{ $product['category_name'] ?? 'Uncategorized' }}
        </p>

 <a href="/product-details/{{ strtolower(preg_replace('/-+/', '-', preg_replace('/[^a-z0-9\s-]/', '', preg_replace('/\s+/', '-', trim($product['name']))))) }}/{{ $product['id'] }}"
   class="product-title h6 fw-500 mb-12">
    {{ $product['name'] }}
</a>
        <div class="d-flex align-items-center gap-8 mb-16">
          <p class="caption">
            <i class="fa-solid fa-star-sharp color-quant"></i>
            <i class="fa-solid fa-star-sharp color-quant"></i>
            <i class="fa-solid fa-star-sharp color-quant"></i>
            <i class="fa-solid fa-star-sharp color-quant"></i>
            <i class="fa-solid fa-star-sharp color-quant"></i>
          </p>
        </div>

        <div class="d-flex align-items-center justify-content-between">

<h5 class="black">
    @if(!empty($product['old_price']) && $product['old_price'] > $product['price'])
        <span class="old-price h6 text-decoration-line-through dark-gray">
            {{ $product['old_price'] }}
        </span>
    @endif

    <span class="main-price">{{ $product['price'] }}</span>
</h5>

      <a href="#"
   class="open-quick-view sm-btn light"
   data-bs-toggle="modal"
   data-bs-target="#productQuickView"
   data-product='@json($product)'>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                 viewBox="0 0 20 20" fill="none">
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

@endforeach

</div>
</div>
<script>

window.currencyConfig = @json(config('currency'));
window.currentCurrency = "{{ session('currency', 'GBP') }}";

function formatPrice(price) {

  const currency = window.currentCurrency || window.currencyConfig.default || "GBP";
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
document.addEventListener("click", function (e) {
    const btn = e.target.closest(".open-quick-view");

    if (!btn) return;

    const product = JSON.parse(btn.dataset.product);

    console.log(product);
});

</script>


@endsection



