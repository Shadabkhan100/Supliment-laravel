@extends('layout.Main')

@section('content')

<main class="main-wrapper">

    <!-- TITLE BANNER -->
    <section class="title-banner">
        <div class="container">
            <h2 class="white fw-600 text-center">
                Product Details - {{ $product->name }}
            </h2>
        </div>
    </section>

    <!-- PRODUCT DETAIL START -->
    <section class="shop-detail-page py-40">
        <div class="container-fluid">
            <div class="detail-wrapper">
                <div class="row row-gap-3">

                    <!-- LEFT IMAGE SECTION -->
                    <div class="col-xl-6">

                        <div class="product-image-container">

                            <!-- THUMB NAV -->
                            <div class="product-slider-asnav">
                                @if(!empty($product->gallery_images))
                                    @foreach($product->gallery_images as $img)
                                        <div class="nav-image">
                                            <img src="{{ $img }}" alt="{{ $product->name }}">
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- MAIN SLIDER -->
                            <div class="product-detail-slider">

                                <div class="detail-image">
                                    <img src="{{ $product->main_image }}" alt="{{ $product->name }}">
                                </div>

                                @if(!empty($product->gallery_images))
                                    @foreach($product->gallery_images as $img)
                                        <div class="detail-image">
                                            <img src="{{ $img }}" alt="{{ $product->name }}">
                                        </div>
                                    @endforeach
                                @endif

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

                            <!-- DESCRIPTION SHORT -->
                            <p class="quick-view-text mb-16" style="color:white">
                                {{ \Illuminate\Support\Str::limit(strip_tags($product->description), 180) }}
                            </p>

                            <!-- STOCK -->
                            <div class="instock-label color-ter mb-16">
                                {{ $product->stock }} in stock, ready to ship
                            </div>

                            <!-- WEIGHTS -->
                            <h6 class="fw-600 text-white mb-12">Weight</h6>

                            <div class="select-size mb-32">
                                @if(!empty($product->weights))
                                    @foreach($product->weights as $index => $weight)
                                        <input style="color:white" class="hidden radio-label"
                                               type="radio"
                                               name="sizes"
                                               id="weight{{ $index }}"
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
                                <div class="input-area quantity-wrap" >
                                    <input class="decrement" type="button" value="-" style="color:white" >
                                    <input type="text" name="quantity" value="1" class="number" style="color:white;border-color:white">
                                    <input class="increment" type="button" value="+" style="color:white">
                                </div>
                            </div>

                            <!-- SKU -->
                            <p class="text-white font-primary fw-600 mb-16 h6">
                                SKU:
                                <span class="dark-gray font-sec text-16">
                                    {{ $product->sku }}
                                </span>
                            </p>

                           

                            <!-- FEATURES -->
                            <div  class="d-flex align-items-center gap-12 mb-16">
                                <p style="color:white">90 day returns policy</p>
                            </div>

                            <div class="d-flex align-items-center gap-12 mb-16">
                                <p style="color:white">Free shipping on eligible orders</p>
                            </div>
  <section class="product-description pt-40 pb-80">
        <div class="container-fluid">

            <div class="tab-content">

                <!-- DESCRIPTION -->
                <div class="tab-pane fade show active">
                    <h4 class="mb-16 fw-600 text-white">Description:</h4>

                    {!! $product->description !!}
                </div>

            </div>
        </div>
    </section>



@include("products.buying-options")


                           <!-- BUTTONS -->
                            <div class="row row-gap-3 mb-16 mt-4">
                                <div class="col-sm-6">
                                    <a href="javascript:;"
                                       class="cus-btn-2 text-center w-100 cart-button22"
                                       data-id="{{ $product->id }}">
                                        Add to Cart
                                    </a>
                                </div>

                                <div class="col-sm-6">
                                    <a href="javascript:;"
                                       class="cus-btn text-center w-100">
                                        Buy It Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- DESCRIPTION + REVIEWS -->
  

</main>
<script>
window.currencyConfig = @json(config('currency'));
window.currentCurrency = "{{ session('currency', 'GBP') }}";

function formatPrice(value) {
    const currency = window.currentCurrency || window.currencyConfig.default || "GBP";
    const config = window.currencyConfig?.currencies?.[currency];
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

document.addEventListener('DOMContentLoaded', function () {

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

document.querySelector('.cart-button22').addEventListener('click', function () {

    const productId = this.dataset.id;

    if (!window.selectedOption) {
        alert("Please select a buying option first");
        return;
    }

    const payload = {
        product_id: productId,
        option: window.selectedOption,
        purchase_type: window.purchaseMode || "one_time",
        quantity: document.querySelector('input[name="quantity"]').value
    };

    console.log("ADDING TO CART:");
    console.log(payload);

    // Example AJAX (if needed)
   fetch('/cart/add', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify(payload)
})
.then(async res => {

    const data = await res.json();

    // ❌ NOT LOGGED IN
    if (res.status === 401) {

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: data.message,
            showConfirmButton: false,
            timer: 6000,
            timerProgressBar: true
        });

      


    }

    // ✅ SUCCESS
    if (data.status) {

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: data.message,
            showConfirmButton: false,
            timer: 6000,
            timerProgressBar: true
        });

    } else {

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: data.message || "Something went wrong",
            showConfirmButton: false,
            timer: 6000,
            timerProgressBar: true
        });
    }

})
.catch(() => {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: "Server error occurred",
        showConfirmButton: false,
        timer: 6000,
        timerProgressBar: true
    });
});

});

</script>

@endsection