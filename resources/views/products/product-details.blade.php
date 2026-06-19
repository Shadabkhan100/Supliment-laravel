@extends('layout.Main')

@section('content')
<link rel="stylesheet" href="/css/slick.css">
<link rel="stylesheet" href="/css/slick-theme.css">
<style>

/* remove slick default icon */
.slick-dots li button:before {
  content: '' !important;
}

/* dot base */
.slick-dots li button {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: #444;   /* inactive dot color */
  padding: 0;
  border: none;
}

/* active dot */
.slick-dots li.slick-active button {
  background: #9eef0b; /* green active dot */
  transform: scale(1.2);
}

/* spacing */
.slick-dots li {
  margin: 0 5px;
}
.slick-prev,
.slick-next {
  width: 40px;
  height: 40px;
  z-index: 10;
}

.slick-prev:before,
.slick-next:before {
  font-size: 25px;
  color: #9eef0b !important; /* green arrows */
  opacity: 1;
}

.slick-prev {
  left: 10px;
}

.slick-next {
  right: 10px;
}
/* REMOVE ANY BACKGROUND FROM SLICK STRUCTURE */
.product-detail-slider,
.product-detail-slider .slick-list,
.product-detail-slider .slick-track,
.product-detail-slider .slick-slide {
  background: transparent !important;
   
}

/* FIX SLIDE ALIGNMENT */
.product-detail-slider .slick-slide {
  display: flex !important;
  align-items: center;
  justify-content: center;
  height: 310px !important;
  outline: none;
}

/* IMAGE ONLY (NO BOX EFFECT) */
.product-detail-slider img {
  display: block;
  max-height: 100%;
  max-width: 100%;
  object-fit: contain;
  background: transparent !important;
}

/* force image to stay inside frame */
.product-detail-slider .detail-image img {
  max-height: 400px;
  max-width: 100%;
  object-fit: contain;
}

.shipping-features {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 20px;
  text-align: center;
  padding: 15px 10px;
}

.feature-item {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}

.feature-item img {
  width: 40px;
  height: 40px;
  object-fit: contain;
}

.feature-item p {
  font-size: 13px;
  margin: 0;
  color: white;
}

/* responsive */
@media (max-width: 350px) {
  .shipping-features {
    flex-direction: column;
    gap: 15px;
  }
}

.product-slider-asnav {
  display: block;
  margin-bottom: 15px;
}

.product-slider-asnav .nav-image {
  padding: 5px;
  cursor: pointer;
}

.product-slider-asnav .nav-image img {
  width: 100%;
  height: 80px;
  object-fit: contain;

  border-radius: 6px;
}
.slick-prev,
.slick-next {
  z-index: 9999 !important;
  pointer-events: auto !important;
}

.slick-slider {
  position: relative;
}
/* FORCE HORIZONTAL TRACK */
.product-slider-asnav .slick-track {
  display: flex !important;
}

/* ACCORDION HEADER (TITLE AREA) */
#productAccordion .accordion-button {
  background-color: #111;
  /* dark background */
  color: #9eef0b;
  /* green title */
  font-weight: 600;
  box-shadow: none;
}

/* collapsed state (closed) */
#productAccordion .accordion-button.collapsed {
  background-color: #111;
  color: #9eef0b;
}

/* when active/open */
#productAccordion .accordion-button:not(.collapsed) {
  background-color: #1a1a1a;
  color: #9eef0b;
}

/* remove bootstrap blue border/outline */
#productAccordion .accordion-button:focus {
  box-shadow: none;
  border-color: transparent;
}

/* accordion body (content area) */
#productAccordion .accordion-body {
  background-color: #0d0d0d;
  color: #fff;
}

#productAccordion .accordion-button::after {
  filter: brightness(0) invert(1) sepia(1) hue-rotate(60deg) saturate(5);
}
</style>
<main class="main-wrapper">

  <!-- TITLE BANNER -->


  <!-- PRODUCT DETAIL START -->
  <section class="shop-detail-page py-40">
    <div class="container-fluid">
      <div class="detail-wrapper">
        <div class="row row-gap-3">
          <!-- LEFT IMAGE SECTION -->
          <div class="col-xl-6">
            <div class="product-image-container">



@php
    $images = [];

    // first push main image
    if(!empty($product->main_image)) {
        $images[] = $product->main_image;
    }

    // then push gallery images
    if(!empty($product->gallery_images)) {
        foreach($product->gallery_images as $img) {
            $images[] = $img;
        }
    }
@endphp

<div class="product-detail-slider">

    @foreach($images as $img)
        <div class="detail-image">
            <img src="{{ $img }}" alt="{{ $product->name }}">
        </div>
    @endforeach

</div>

            </div>
          </div>

          <!-- RIGHT TEXT SECTION -->
          <div class="col-xl-6">

            <div class="product-text-container product-text-page">

              <p class="eyebrow mb-12">
                {{ $product->category_name }}
              </p>

              <h3 class="text-white fw-700 mb-16">
                {{ $product->name }}
              </h3>

              <!-- RATING (static for now) -->
              <div class="d-flex align-items-center flex-wrap gap-16 mb-16">
                <h6 class="color-quant">
                  ★★★★<span class="light-gray">★</span>
                  <span class="text-16 fw-400 dark-text-white">
                    ({{ $product->reviews_count ?? 0 }} Reviews)
                  </span>
                </h6>
              </div>

              <!-- PRICE -->
              <div class="d-flex align-items-center gap-16 mb-16">

                @if($product->old_price)
                <h6 class="dark-gray text-decoration-line-through old-price">
                  {{ number_format($product->old_price, 2) }}
                </h6>
                @endif

                <h4 class="text-white main-price">
                  {{ number_format($product->price, 2) }}
                </h4>

              </div>
              @include("products.buying-options")
              <!-- DESCRIPTION SHORT -->
              <p class="quick-view-text mb-16" style="color:white">
                {{ \Illuminate\Support\Str::limit(strip_tags($product->description), 180) }}
              </p>

              <!-- STOCK -->
              <div class="instock-label mb-16" style="color:white">
                {{ $product->stock }} in stock, ready to ship
              </div>

              <!-- WEIGHTS -->
              <h6 class="fw-600 text-white mb-12">Weight</h6>

              <div class="select-size mb-32">
                @if(!empty($product->weights))
                @foreach($product->weights as $index => $weight)
                <input style="color:white" class="hidden radio-label" type="radio" name="sizes" id="weight{{ $index }}"
                  @if($loop->first) checked @endif>

                <label style="color:white" class="button-label" for="weight{{ $index }}">
                  {{ $weight }} g
                </label>
                @endforeach
                @endif
              </div>

              <!-- QUANTITY -->
              <p class="subtitle font-primary fw-600 text-white mb-8">Quantity:</p>

              <div class="quantity quantity-wrap mb-16" style="color:white;border-color:white">
                <div class="input-area quantity-wrap">
                  <input class="decrement" type="button" value="-" style="color:white">
                  <input type="text" name="quantity" value="1" class="number" style="color:white;border-color:white">
                  <input class="increment" type="button" value="+" style="color:white">
                </div>
              </div>

              <!--<p class="text-white font-primary fw-600 mb-16 h6">
                SKU:
                <span class="dark-gray font-sec text-16">
                  {{ $product->sku }}
                </span>
              </p>-->



              <!-- FEATURES -->
              <div class="d-flex align-items-center gap-12 mb-16">
                <p style="color:white">30 day returns policy</p>
              </div>

            


              <!-- BUTTONS -->
              <div class="row row-gap-3 mb-16 mt-4">
                <div class="col-sm-6">
                 <a href="javascript:;"  class="add-to-cart cus-btn-2 text-center add-to-cart w-100" data-id="{{ $product->id }}">
                 Add to Cart
                 </a>
                </div>

                <div class="col-sm-6">
                  <a href="javascript:;" class="cus-btn text-center w-100" id="qv-order-now">
                    Buy It Now
                  </a>
                </div>

              </div>

              <div class="shipping-features">
                <div class="feature-item">
                  <img src="/images/icons/delivery.png" alt="">
                  <p>Next Day Delivery (12pm cut-off)</p>
                </div>

                <div class="feature-item">
                  <img src="/images/icons/parcel.png" alt="">
                  <p>Royal Mail Tracked 24H Shipping</p>
                </div>

                <div class="feature-item">
                  <img src="/images/icons/guarantee.png" alt="">
                  <p>30-Day Money Back Guarantee</p>
                </div>
              </div>
              <!-- PRODUCT EXTRA DETAILS ACCORDION -->
              <div class="accordion mt-3" id="productAccordion">

                <!-- DESCRIPTION -->
               <div class="accordion-item">
  <h2 class="accordion-header" id="headingDesc">
    <button class="accordion-button" type="button"
      data-bs-toggle="collapse"
      data-bs-target="#collapseDesc">
      Description
    </button>
  </h2>

  <div id="collapseDesc" class="accordion-collapse collapse"
       data-bs-parent="#productAccordion">

    <div class="accordion-body">
      {!! $product->description !!}
    </div>

  </div>
</div>
                <!-- SHIPPING INFO -->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingShip">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapseShip">
                      Shipping Info
                    </button>
                  </h2>
                  <div id="collapseShip" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                    <div class="accordion-body">
                      {{ $product->shipping_info }}
                    </div>
                  </div>
                </div>

                <!-- SUPPLEMENT FACTS -->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingSupp">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapseSupp">
                      Supplement Facts
                    </button>
                  </h2>
                  <div id="collapseSupp" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                    <div class="accordion-body">
                      {{ $product->supplement_facts }}
                    </div>
                  </div>
                </div>

                <!-- HOW TO USE -->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingUse">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapseUse">
                      How to Use
                    </button>
                  </h2>
                  <div id="collapseUse" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                    <div class="accordion-body">
                      {{ $product->how_to_use }}
                    </div>
                  </div>
                </div>
                <!-- INGREDIENTS -->
@if(!empty($product->ingredients))
<div class="accordion-item">
  <h2 class="accordion-header" id="headingIng">
    <button class="accordion-button collapsed" type="button"
      data-bs-toggle="collapse"
      data-bs-target="#collapseIng">
      Ingredients
    </button>
  </h2>

  <div id="collapseIng" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
    <div class="accordion-body">
      {{ $product->ingredients }}
    </div>
  </div>
</div>
@endif
                <!-- HALAL CERTIFICATION -->
                @if(!empty($product->halal_certification))
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingHalal">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapseHalal">
                      Halal Certification
                    </button>
                  </h2>
                  <div id="collapseHalal" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                    <div class="accordion-body">

                      <img src="{{ $product->halal_certification }}" style="
                width: 100%;
                max-width: 100%;
                height: 300px;
                object-fit: contain;
                border-radius: 12px;
                background: #fff;
             ">

                    </div>
                  </div>
                </div>
                @endif

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- DESCRIPTION + REVIEWS -->


</main>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/js/slick.min.js"></script>
<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
<script>
window.selectedProductId = {{ $product->id }};
window.currencyConfig = @json(config('currency'));
window.currentCurrency = "{{ session('currency', 'GBP') }}";
$(window).on('load', function () {

  const $slider = $('.product-detail-slider');

  if (!$slider.length) return;

  // destroy safely
  if ($slider.hasClass('slick-initialized')) {
    $slider.slick('unslick');
  }

  // IMPORTANT: re-check DOM before init
  setTimeout(() => {
    $slider.slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      dots: false,
      infinite: true,
      autoplay: false,
      speed: 500,
      adaptiveHeight: false
    });
  }, 200);

});
function formatPrice(value) {
  const currency = window.currentCurrency || window.currencyConfig.default || "GBP";
  const config = window.currencyConfig?.currencies?. [currency];
  console.log("Currency:", currency);
  console.log("Config found:", config);
  console.log("Symbol:", config?.symbol);
  if (!config) return value;

  const converted = value * config.rate;

  return `${config.symbol} ${converted.toFixed(2)}`;
}

function getNumber(text) {
  return parseFloat(text.replace(/[^0-9.]/g, ''));
}

document.addEventListener('DOMContentLoaded', function() {

  // MAIN PRICE
  document.querySelectorAll('.main-price').forEach(el => {
    const value = getNumber(el.innerText);
    if (!isNaN(value)) {
      el.innerText = formatPrice(value);
    }
  });

  // OLD PRICE
  document.querySelectorAll('.old-price').forEach(el => {
    const value = getNumber(el.innerText);
    if (!isNaN(value)) {
      el.innerText = formatPrice(value);
    }
  });

});


</script>
@include("modules.you-may-like")
@endsection