@extends('layout.Main')

@section('content')
<style>
.bundle-table-wrapper {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.bundle-table {
    min-width: 700px;
    white-space: nowrap;
}

.bundle-table th,
.bundle-table td {
    vertical-align: middle;
}

.bundle-select {
    min-width: 250px;
}

.bundle-drawer{

    position:fixed;
    top:0;
    right:-50%;
    width:50%;
    max-width:700px;
    height:100vh;

    background:#fff;

    box-shadow:-10px 0 30px rgba(0,0,0,.15);

    z-index:9999;

    transition:.35s ease;

    display:flex;
    flex-direction:column;

}

.bundle-drawer.open{
    right:0;
}

.drawer-overlay{

    position:fixed;
    inset:0;

    background:rgba(0,0,0,.4);

    opacity:0;
    visibility:hidden;

    transition:.3s;

    z-index:9998;

}

.drawer-overlay.show{

    opacity:1;
    visibility:visible;

}

.drawer-header{

    padding:20px;

    border-bottom:1px solid #eee;

    display:flex;
    justify-content:space-between;
    align-items:center;

}

.drawer-close{

    border:none;
    background:none;

    font-size:24px;

    cursor:pointer;

}

.drawer-body{

    flex:1;

    overflow:auto;

    padding:20px;

}

.drawer-item{

    display:flex;

    gap:15px;

    margin-bottom:20px;

    padding-bottom:15px;

    border-bottom:1px solid #eee;

}

.drawer-item img{

    width:80px;
    height:80px;

    object-fit:cover;

    border-radius:10px;

}

.drawer-footer{

    padding:20px;

    border-top:1px solid #eee;

}

@media(max-width:768px){

.bundle-drawer{

    width:100%;
    right:-100%;

}

}



.product-card{
    cursor:pointer;
    transition:.25s ease;
    border:2px solid transparent;
    border-radius:12px;
}

.product-card.selected{
    border:2px solid #28a745;
    box-shadow:0 0 12px rgba(40,167,69,.2);
}
.qty-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.qty-wrapper .qty {
    width: 45px;
    height: 36px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-weight: 600;
    background: #fff;
    padding: 0;
}

.qty-btn {
    width: 34px;
    height: 34px;
    border: 1px solid #ddd;
    background: #f8f9fa;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    font-weight: 700;
    transition: .2s;
}

.qty-btn:hover {
    background: #198754;
    color: #fff;
    border-color: #198754;
}

.qty-btn:active {
    transform: scale(.95);
}
.old-price {
    font-size: 13px;
    color: #999;
    text-decoration: line-through;
    font-weight: 400;
    margin-top: 3px;
}
.discount-row{
    flex-wrap: nowrap;
}

.discount-col{
    flex: 1 1 0;
    max-width: 33.333%;
}

.discount-box{
    padding: 28px 15px;
}

.small-text{
    font-size: 18px;
    font-weight: 700;
}

.discount-box h2{
    font-size: 42px;
    font-weight: 800;
    margin: 8px 0;
}

.discount-box span{
    font-size: 16px;
}

.best-value{
    font-size: 12px;
    padding: 5px 14px;
}
.bundle-builder{
    background:black;
}

.bundle-title{
    font-size:52px;
    font-weight:800;
    color:#9eef0b;
    letter-spacing:1px;
}

.bundle-subtitle{
    font-size:22px;
    color:#555;
    margin-top:15px;
}

.discount-box{

    position:relative;

    border:2px solid #ddd;

    border-radius:18px;

    background:white;

    text-align:center;

    padding:28px;

    transition:.3s;

    height:100%;
}
.discount-box{
    cursor:pointer;
    transition:all .25s ease;
}

.discount-box.active{
    background:#28a745;
    color:#fff;
    border-color:#28a745;
}

.discount-box.active .small-text,
.discount-box.active span,
.discount-box.active h2{
    color:#fff;
}
.discount-box.active{

    background:#235326;

    color:#fff;

    border:none;

}



.best-value{

    width: 76%;
    color: black;
    position: absolute;
    top: -16px;
    left: 50%;
    transform: translateX(-50%);
    background: #9eef0b;
    padding: 6px 20px;
    border-radius: 18px;
    font-weight: 700;
    font-size: 16px;
}

}

.discount-box h2{

    font-size:48px;

    font-weight:800;

    margin:8px 0;

}

.discount-box span{

    font-size:18px;

}

.small-text{

    font-weight:700;

    font-size:20px;

}

.section-title{

    display:flex;

    align-items:center;

    justify-content:center;

    margin-top:40px;

    margin-bottom:40px;

}

.section-title span{

    flex:1;

    height:1px;

    background:#ddd;

}

.section-title h3{

    margin:0 25px;

    font-weight:700;

    color:#333;

}

.product-card{

    background:#fff;

    border:1px solid #ddd;

    border-radius:12px;

    text-align:center;

    padding:20px;

    transition:.3s;

    height:100%;

}

.product-card:hover{

    transform:translateY(-5px);

    box-shadow:0 15px 40px rgba(0,0,0,.08);

}

.product-card img{

    width:120px;

    height:120px;

    object-fit:contain;

    margin-bottom:15px;

}

.product-card h4{

    font-size:22px;

    font-weight:700;

    margin-bottom:5px;

}

.product-card small{

    display:block;

    font-size:15px;

    color:#666;

}

.price{

    color:#1f5c2d;

    font-size:20px;

    font-weight:800;

    margin-top:12px;

}

.bundle-note{

    font-size:16px;

    color:#666;

}

@media(max-width:991px){



.best-value{

  font-size:7px;
 

}
.bundle-title{

font-size:38px;

}

.bundle-subtitle{

font-size:18px;

}

.discount-box{

padding:22px;

}

.discount-box h2{

font-size:38px;

}

.product-card{

margin-bottom:15px;

}

.product-card img{

width:95px;

height:95px;

}

.price{

font-size:18px;

}

}

@media(max-width:576px){

.bundle-title{

font-size:30px;

}

.bundle-subtitle{

font-size:16px;

}

.discount-box{

padding:18px;

}

.discount-box h2{

font-size:32px;

}

.small-text{

font-size:18px;

}

.product-card{

padding:15px;

}

.product-card h4{

font-size:18px;

}

.price{

font-size:18px;

}

}


.bundle-box{

background:#fff;

border:1px solid #ddd;

border-radius:12px;

overflow:hidden;

}

.bundle-header{

background:#235326;

color:#fff;

font-size:30px;

font-weight:700;

padding:18px;

text-align:center;

}

.bundle-table{

margin:0;

}

.bundle-table thead{

background:#235326;

color:#fff;

}

.bundle-table th{

padding:15px;

font-size:15px;

}

.bundle-table td{

padding:18px;

vertical-align:middle;

}

.bundle-table strong{

font-size:17px;

}

.description{

font-size:14px;

color:#666;

margin-top:5px;

}

.bundle-select{

height:52px;

border-radius:8px;

}

.qty{

text-align:center;

font-weight:700;

height:52px;

}

.bundle-footer-note{

background:#fafafa;

border-top:1px solid #eee;

padding:18px;

font-size:15px;

}

.summary-box{

background:#fff;

border:1px solid #ddd;

border-radius:12px;

padding:25px;

height:100%;

}

.summary-box h3{

text-align:center;

font-size:28px;

font-weight:700;

margin-bottom:25px;

}

.summary-icon{

width:80px;

height:80px;

border-radius:50%;

border:2px solid #ddd;

display:flex;

align-items:center;

justify-content:center;

margin:auto;

font-size:34px;

color:#235326;

}

.summary-message{

text-align:center;

font-size:22px;

font-weight:700;

margin-top:20px;

}

.summary-small{

text-align:center;

color:#777;

margin-bottom:25px;

}

.summary-row{

display:flex;

justify-content:space-between;

margin:15px 0;

font-size:18px;

}

.discount{

color:#d93025;

}

.total{

font-size:26px;

font-weight:700;

color:#235326;

}

.discount-guide{

margin-top:30px;

background:#235326;

color:#fff;

border-radius:10px;

padding:20px;

text-align:center;

}

.discount-guide h6{

font-size:18px;

margin-bottom:15px;

font-weight:700;

}


.example-card{

background:#fff;

border:1px solid #ddd;

border-radius:14px;

padding:22px;

height:100%;

position:relative;

transition:.3s;

}

.example-card:hover{

transform:translateY(-6px);

box-shadow:0 15px 35px rgba(0,0,0,.08);

}

.example-header{

font-size:22px;

font-weight:700;

text-align:center;

margin-bottom:20px;

}

.best-tag{

position:absolute;

top:-12px;

left:50%;

transform:translateX(-50%);

background:#f7c948;

padding:6px 18px;

border-radius:40px;

font-size:13px;

font-weight:700;

}

.example-products{

display:flex;

justify-content:center;

align-items:center;

gap:10px;

flex-wrap:wrap;

}

.example-products img{

width:70px;

height:70px;

object-fit:contain;

}

.example-products p{

font-size:13px;

text-align:center;

margin-top:6px;

margin-bottom:0;

font-weight:600;

}

.plus{

font-size:22px;

font-weight:700;

color:#777;

}

.price-line{

display:flex;

justify-content:space-between;

margin:10px 0;

font-size:16px;

}

.discount-text{

color:#d93025;

}

.final-price{

font-size:16px;

font-weight:700;

color:black;

border-top:1px solid #eee;

padding-top:12px;

margin-top:10px;

}

.feature-box{

background:#fff;

border:1px solid #ddd;

border-radius:12px;

padding:25px;

text-align:center;

height:100%;

transition:.3s;

}

.feature-box:hover{

transform:translateY(-4px);

box-shadow:0 10px 25px rgba(0,0,0,.08);

}

.feature-box i{

font-size:42px;

color:#235326;

margin-bottom:15px;

}

.feature-box h5{

font-weight:700;

margin-bottom:8px;

}

.feature-box p{

margin:0;

color:#666;

}

@media(max-width:767px){

.example-products{

gap:5px;

}

.example-products img{

width:55px;

height:55px;

}

.feature-box{

padding:18px;

}

.feature-box i{

font-size:30px;

}

}
</style>

<section class="bundle-builder py-5">

    <div class="container">

        <!-- Heading -->

        <div class="text-center mb-5">

            <h1 class="bundle-title">
                BUILD YOUR BUNDLE
            </h1>

            <p class="bundle-subtitle">
                Mix & match your favorites. The more you bundle, the more you save!
            </p>

        </div>

        <!-- Discount Cards -->

        <div class="row g-2 justify-content-center mb-5 discount-row">

            <div class="col discount-col">

                <div class="discount-box"
     data-items="2"
     data-discount="10"
     onclick="selectDiscount(this)">

                    <div class="small-text">
                        ANY 2 ITEMS
                    </div>

                    <h2>
                        10% OFF
                    </h2>

                    <span>
                        ALL BUNDLES
                    </span>

                </div>

            </div>

            <div class="col discount-col">

                <div class="discount-box"
     data-items="3"
     data-discount="15"
     onclick="selectDiscount(this)">

                    <div class="small-text">
                        ANY 3 ITEMS
                    </div>

                    <h2>
                        15% OFF
                    </h2>

                    <span>
                        ALL BUNDLES
                    </span>

                </div>

            </div>

            <div class="col discount-col">

               <div class="discount-box active"
     data-items="4"
     data-discount="20"
     onclick="selectDiscount(this)">

                    <div class="best-value">
                        ⭐ BEST VALUE
                    </div>

                    <div class="small-text">
                        ANY 4 ITEMS
                    </div>

                    <h2>
                        20% OFF
                    </h2>

                    <span>
                        ALL BUNDLES
                    </span>

                </div>

            </div>

        </div>


        <!-- Products Heading -->

        <div class="section-title">

            <span></span>

            <h3>
                OUR PRODUCTS
            </h3>

            <span></span>

        </div>


        <!-- Products -->

<div class="row g-4 mt-2">

 @foreach($products->shuffle()->take(6) as $product)

<div class="col-lg col-md-4 col-6">

    <div class="product-card"
     onclick='toggleProduct(this, @json($product))'>

    <img src="{{ $product['main_image'] ?? 'https://placehold.co/220x220?text=Product' }}"
         alt="{{ $product['name'] }}">

    <h6>{{ strtoupper($product['name']) }}</h6>

    <small>(CHOOSE 1)</small>

    @if(!empty($product['old_price']) && $product['old_price'] > $product['price'])
        <div class="old-price product-price"
             data-price="{{ $product['old_price'] }}">
            {{ $product['old_price'] }}
        </div>
    @endif

    <div class="price product-price"
         data-price="{{ $product['price'] }}">
        {{ $product['price'] }}
    </div>

</div>

</div>

@endforeach

</div>

        <div class="text-center mt-4 bundle-note">

            * You can select only 1 option from Tea and 1 option from Matcha.
             
        </div>
          <div class="row mt-5">

    <!-- LEFT -->

    <div class="col-lg-8">

        <div class="bundle-box">

            <div class="bundle-header">

                BUILD YOUR BUNDLE

            </div>

        <div class="bundle-table-wrapper">

    <table class="table bundle-table">
        <thead>
            <tr>
                <th width="40%">CATEGORY</th>
                <th>SELECT YOUR OPTION</th>
                <th width="90">QTY</th>
            </tr>
        </thead>

        <tbody>

            @foreach(collect($categories)->shuffle()->take(6) as $index => $category)

                @php
                    $categoryProducts = collect($products)
                        ->where('category_id', $category['id']);
                @endphp

                <tr>

                    <td>
                        <strong>
                            {{ $index + 1 }}.
                            {{ strtoupper($category['name']) }}
                        </strong>
                    </td>

                    <td>
                        <select
                            class="form-select bundle-select"
                            data-category="{{ $category['id'] }}"
                            onchange="selectBundleProduct(this)">

                            <option value="">
                                Select {{ $category['name'] }}
                            </option>

                            @foreach($categoryProducts as $product)
                                <option
                                    value="{{ $product['id'] }}"
                                    data-product='@json($product)'>

                                    {{ $product['name'] }}

                                </option>
                            @endforeach

                        </select>
                    </td>

                    <td>
                        <div class="qty-wrapper">
                            <button type="button" class="qty-btn minus">
                                −
                            </button>

                            <input
                                type="text"
                                class="qty"
                                value="0"
                                readonly>

                            <button type="button" class="qty-btn plus">
                                +
                            </button>
                        </div>
                    </td>

                </tr>

            @endforeach

        </tbody>
    </table>

</div>

            <div class="bundle-footer-note">

                <i class="fa fa-info-circle"></i>

                You can add up to 4 different items in your bundle.

                <br>

                No duplicate products in the same bundle.

            </div>

        </div>

    </div>

    <!-- RIGHT -->

    <div class="col-lg-4 mt-4 mt-lg-0">

        <div class="summary-box">

            <h3>

                BUNDLE SUMMARY

            </h3>

            <div class="summary-icon">

                <i class="fa fa-shopping-bag"></i>

            </div>

            <div class="summary-message">

                Your bundle is empty

            </div>

            <div class="summary-small">

                Select your items from the left to see your summary.

            </div>

            <hr>

            <div class="summary-row">

                <span>ITEMS SELECTED</span>

                <strong id="itemCount">0</strong>

            </div>

            <div class="summary-row">

                <span>SUBTOTAL</span>

                <strong id="subtotal">$0.00</strong>

            </div>

             <div class="summary-row discount">
                 <span id="discountLabel">DISCOUNT (20%)</span>

                <strong id="discount">-$0.00</strong>

            </div>

            <hr>

           <div class="summary-row total">
    <span>TOTAL</span>

    <div class="text-end">
        <div class="old-price" id="oldTotal" style="display:none;"></div>
        <strong id="total">£0.00</strong>
    </div>
</div>

<div class="mt-3">
    <button class="btn btn-success w-100 btn-sm" id="viewBundleBtn">
        <i class="fa fa-shopping-bag"></i> View Bundle
    </button>
</div>

            <div class="discount-guide">

                <h6>

                    <i class="fa fa-tag"></i>

                    DISCOUNT GUIDE

                </h6>

                <div>2 Items = <strong>10% OFF</strong></div>

                <div>3 Items = <strong>15% OFF</strong></div>

                <div>4 Items = <strong>20% OFF</strong></div>

            </div>

        </div>

    </div>

</div>
    </div>












<!-- ========================================= -->
<!-- EXAMPLE BUNDLES -->
<!-- ========================================= -->

<div class="container mt-5">

    <div class="section-title mb-4">

        <span></span>

        <h3>EXAMPLE BUNDLES</h3>

        <span></span>

    </div>

    <div class="row g-4">

        <!-- Bundle 1 -->

        <div class="col-lg-4">

            <div class="example-card">

                <div class="example-header">

                    ANY 2 ITEMS – 10% OFF

                </div>

                <div class="example-products">

                    <div>

                        <img src="https://placehold.co/120x120?text=Tea+A">

                        <p>Tea A</p>

                    </div>

                    <span class="plus">+</span>

                    <div>

                        <img src="https://placehold.co/120x120?text=Matcha">

                        <p>Matcha Vanilla</p>

                    </div>

                </div>

                <hr>

                <div class="price-line">

                    <span>Subtotal</span>

                    <strong>$25.00</strong>

                </div>

                <div class="price-line discount-text">

                    <span>Discount (10%)</span>

                    <strong>-$2.50</strong>

                </div>

                <div class="price-line final-price">

                    <span>YOU PAY</span>

                    <strong>$22.50</strong>

                </div>

            </div>

        </div>

        <!-- Bundle 2 -->

        <div class="col-lg-4">

            <div class="example-card">

                <div class="example-header">

                    ANY 3 ITEMS – 15% OFF

                </div>

                <div class="example-products">

                    <div>

                        <img src="https://placehold.co/120x120?text=Tea+B">

                        <p>Tea B</p>

                    </div>

                    <span class="plus">+</span>

                    <div>

                        <img src="https://placehold.co/120x120?text=Matcha">

                        <p>Matcha Strawberry</p>

                    </div>

                    <span class="plus">+</span>

                    <div>

                        <img src="https://placehold.co/120x120?text=Shilajit">

                        <p>Shilajit Resin</p>

                    </div>

                </div>

                <hr>

                <div class="price-line">

                    <span>Subtotal</span>

                    <strong>$50.00</strong>

                </div>

                <div class="price-line discount-text">

                    <span>Discount (15%)</span>

                    <strong>-$7.50</strong>

                </div>

                <div class="price-line final-price">

                    <span>YOU PAY</span>

                    <strong>$42.50</strong>

                </div>

            </div>

        </div>

        <!-- Bundle 3 -->

        <div class="col-lg-4">

            <div class="example-card best">

                <div class="best-tag">

                    ⭐ BEST VALUE

                </div>

                <div class="example-header">

                    ANY 4 ITEMS – 20% OFF

                </div>

                <div class="example-products">

                    <div>

                        <img src="https://placehold.co/120x120?text=Tea">

                        <p>Tea A</p>

                    </div>

                    <span class="plus">+</span>

                    <div>

                        <img src="https://placehold.co/120x120?text=Matcha">

                        <p>Matcha Chocolate</p>

                    </div>

                    <span class="plus">+</span>

                    <div>

                        <img src="https://placehold.co/120x120?text=Shilajit">

                        <p>Shilajit Resin</p>

                    </div>

                    <span class="plus">+</span>

                    <div>

                        <img src="https://placehold.co/120x120?text=Collagen">

                        <p>Collagen</p>

                    </div>

                </div>

                <hr>

                <div class="price-line">

                    <span>Subtotal</span>

                    <strong>$70.00</strong>

                </div>

                <div class="price-line discount-text">

                    <span>Discount (20%)</span>

                    <strong>-$14.00</strong>

                </div>

                <div class="price-line final-price">

                    <span>YOU PAY</span>

                    <strong>$56.00</strong>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ========================================= -->
<!-- FEATURES -->
<!-- ========================================= -->

<div class="container my-5">

    <div class="row g-3">

        <div class="col-lg-3 col-6">

            <div class="feature-box">

                <i class="fa fa-leaf"></i>

                <h5>PREMIUM QUALITY</h5>

                <p>Carefully sourced ingredients</p>

            </div>

        </div>

        <div class="col-lg-3 col-6">

            <div class="feature-box">

                <i class="fa fa-shield"></i>

                <h5>SAFE & SECURE</h5>

                <p>Your payment is protected</p>

            </div>

        </div>

        <div class="col-lg-3 col-6">

            <div class="feature-box">

                <i class="fa fa-truck"></i>

                <h5>FAST SHIPPING</h5>

                <p>Quick delivery</p>

            </div>

        </div>

        <div class="col-lg-3 col-6">

            <div class="feature-box">

                <i class="fa fa-heart-o"></i>

                <h5>CUSTOMER SUPPORT</h5>

                <p>We're always here to help</p>

            </div>

        </div>

    </div>

</div>


<div class="bundle-drawer" id="bundleDrawer">
<div id="bundle-user-form-template" style="display:none;">
    @include('modules.bundle-order-user-form')
</div>
    <div class="drawer-header">
        <h4>
            <i class="fa fa-shopping-bag"></i>
            Your Bundle
        </h4>

        <button class="drawer-close" onclick="closeBundleDrawer()">
            <i class="fa fa-times"></i>
        </button>
    </div>

    <div class="drawer-body" id="drawerProducts">

    </div>

<div class="drawer-footer">

    <div class="d-flex justify-content-between mb-3">
        <strong>Total</strong>
        <strong id="drawerTotal"></strong>
    </div>

    <button
    id="checkoutButton"
    class="btn btn-success w-100"
    onclick="checkoutBundle()">

    <span class="button-text">
        Checkout Bundle
    </span>

    <span
        class="spinner-border spinner-border-sm d-none loader"
        role="status"
        aria-hidden="true">
    </span>

</button>

</div>

</div>

<div class="drawer-overlay" id="drawerOverlay" onclick="closeBundleDrawer()"></div>
</section>
















<script>
window.currencyConfig = @json(config('currency'));
window.currentCurrency = "{{ session('currency', 'GBP') }}";
console.log(currentCurrency);
function formatPrice(price) {

  const currency = window.currentCurrency || window.currencyConfig.default || "GBP";

  const config = window.currencyConfig?.currencies?.[currency];

  if (!config) {
    console.warn("Currency not found:", currency);
    return `£ ${price}`;
  }

  const converted = price * config.rate;

  return `${config.symbol} ${converted.toFixed(2)}`;
}
document.querySelectorAll('.product-price').forEach(element => {
    const price = element.dataset.price;
    element.innerHTML = formatPrice(price);
});

let selectedDiscount = 20; // Default active box

function selectDiscount(box) {

    // Remove active from all boxes
    document.querySelectorAll('.discount-box').forEach(item => {
        item.classList.remove('active');
    });

    // Activate clicked box
    box.classList.add('active');

    // Store values
    selectedDiscount = Number(box.dataset.discount);
    const items = Number(box.dataset.items);

    console.log("Discount:", selectedDiscount + "%");
    console.log("Items:", items);
}


document.addEventListener("click", function (e) {

    if (
        !e.target.classList.contains("plus") &&
        !e.target.classList.contains("minus")
    ) return;

    const row = e.target.closest("tr");
    const select = row.querySelector(".bundle-select");
    const qtyInput = row.querySelector(".qty");

    // No product selected
    if (!select.value) {
        alert("Please select a product first.");
        return;
    }

    const categoryId = select.dataset.category;
    const product = selectedBundleProducts[categoryId];

    if (!product) return;

    let qty = product.qty || 1;

    if (e.target.classList.contains("plus")) {
        qty++;
    } else {
        qty = Math.max(1, qty - 1); // Minimum 1 while selected
    }

    product.qty = qty;
    qtyInput.value = qty;

    console.log(product.name, "Qty:", qty);

    updateSummary();
});



let selectedProducts = [];

function toggleProduct(card, product) {

    const index = selectedProducts.findIndex(p => p.id === product.id);

    if (index === -1) {

        selectedProducts.push(product);
        card.classList.add("selected");

        console.log("Selected Product:", product);

    } else {

        selectedProducts.splice(index, 1);
        card.classList.remove("selected");

        console.log("Removed Product:", product);

    }
updateSummary();
    console.log("Selected Products:", selectedProducts);
}

let selectedBundleProducts = {};

function selectBundleProduct(select) {

    const categoryId = select.dataset.category;
    const option = select.options[select.selectedIndex];

    if (!option.value) {
        delete selectedBundleProducts[categoryId];
        updateSummary();
        return;
    }

    const product = JSON.parse(option.dataset.product);

    // Preserve previous quantity if already selected
    product.qty = selectedBundleProducts[categoryId]?.qty || 1;

    selectedBundleProducts[categoryId] = product;

    // Update the input in this row
    const qtyInput = select.closest("tr").querySelector(".qty");
    qtyInput.value = product.qty;

    updateSummary();
}



function updateSummary() {

    // Merge both selections
    const bundleProducts = Object.values(selectedBundleProducts);

    const allProducts = [
        ...selectedProducts,
        ...bundleProducts
    ];

    // Number of selected items
    const itemCount = allProducts.length;

 // Total before discount
const subtotal = allProducts.reduce((sum, product) => {
    const qty = product.qty || 1;
    return sum + (Number(product.price) * qty);
}, 0);

// Old total (without discount)
const oldTotal = subtotal;

// Discount amount
const discountAmount = oldTotal * (selectedDiscount / 100);

// Final total
const total = oldTotal - discountAmount;


// Update discount label and amount
document.getElementById("discountLabel").innerHTML =
    `DISCOUNT (${selectedDiscount}% OFF)`;

document.getElementById("discount").innerHTML =
    "-" + formatPrice(discountAmount);






    // Empty message
    if (itemCount === 0) {
        document.querySelector(".summary-message").innerHTML = "Your bundle is empty";
        document.querySelector(".summary-small").innerHTML =
            "Select your items from the left to see your summary.";
    } else {
        document.querySelector(".summary-message").innerHTML =
            `${itemCount} item(s) selected`;

        document.querySelector(".summary-small").innerHTML =
            `Bundle discount: ${selectedDiscount}%`;
    }

    // Update values
    document.getElementById("itemCount").innerHTML = itemCount;
    document.getElementById("subtotal").innerHTML = formatPrice(subtotal);
    document.getElementById("discount").innerHTML = "-" + formatPrice(discountAmount);
    document.getElementById("total").innerHTML = formatPrice(total);

    console.log({
        itemCount,
        subtotal,
        discountAmount,
        total,
        selectedDiscount,
        allProducts
    });
}



document.getElementById("viewBundleBtn").addEventListener("click", openBundleDrawer);

function openBundleDrawer(){

    const container=document.getElementById("drawerProducts");

    container.innerHTML="";

    const bundleProducts=Object.values(selectedBundleProducts);

    const allProducts=[
        ...selectedProducts,
        ...bundleProducts
    ];

    allProducts.forEach(product=>{

        const qty=product.qty || 1;

        container.innerHTML+=`

        <div class="drawer-item">

            <img src="${product.main_image}" alt="">

            <div class="flex-grow-1">

                <h6>${product.name}</h6>

                <div>Quantity : ${qty}</div>

                <div>Unit Price : ${formatPrice(product.price)}</div>

                <strong>${formatPrice(product.price*qty)}</strong>

            </div>

        </div>

        `;

    });

    document.getElementById("drawerTotal").innerHTML=
        document.getElementById("total").innerHTML;

    document.getElementById("bundleDrawer").classList.add("open");
    document.getElementById("drawerOverlay").classList.add("show");

}



function closeBundleDrawer(){

    document.getElementById("bundleDrawer").classList.remove("open");
    document.getElementById("drawerOverlay").classList.remove("show");

}



let currentStep = 1;

function checkoutBundle() {

    if (currentStep === 1) {

        // Save bundle to localStorage
        const cardProducts = selectedProducts.map(product => ({
            ...product,
            source: "card",
            qty: product.qty || 1
        }));

        const tableProducts = Object.values(selectedBundleProducts).map(product => ({
            ...product,
            source: "bundle_table",
            qty: product.qty || 1
        }));

        const products = [...cardProducts, ...tableProducts];

        const subtotal = products.reduce((sum, product) => {
            return sum + (Number(product.price) * Number(product.qty));
        }, 0);

        const discountAmount = subtotal * (selectedDiscount / 100);

        const total = subtotal - discountAmount;

        localStorage.setItem("bundleProducts", JSON.stringify({
            products,
            summary: {
                item_count: products.length,
                subtotal,
                discount_percentage: selectedDiscount,
                discount_amount: discountAmount,
                total
            }
        }));

        // Move to Step 2
        currentStep = 2;

const template = document.getElementById("bundle-user-form-template");

document.getElementById("drawerProducts").innerHTML =
    template.innerHTML.trim();

      document.getElementById("checkoutButton").innerHTML = `
    <span class="button-text">
        <i class="fa fa-arrow-right"></i> Continue
    </span>

    <span
        class="spinner-border spinner-border-sm d-none loader"
        role="status"
        aria-hidden="true">
    </span>
`;

        return;
    }

    if (currentStep === 2) {

    submitBundleOrder();

    return;
}
}



function showCustomerStep() {

    document.getElementById("drawerProducts").innerHTML = `

        <div class="text-center py-5">

            <h2>Hello World 👋</h2>

            <p>
                Customer Information Form will come here.
            </p>

        </div>

    `;

    document.querySelector(".drawer-footer").style.display = "none";

}




function showLoader(text = "Processing...") {

    const button = document.getElementById("checkoutButton");

    button.disabled = true;

    button.querySelector(".button-text").innerHTML = text;

    button.querySelector(".loader").classList.remove("d-none");
}

function hideLoader(text = "Continue") {

    const button = document.getElementById("checkoutButton");

    button.disabled = false;

    button.querySelector(".button-text").innerHTML = text;

    button.querySelector(".loader").classList.add("d-none");
}




async function getCoordinates() {

    const form = document.querySelector(
        "#drawerProducts #bundleUserForm"
    );

    const address = [
        form.querySelector('[name="postcode"]').value,
        form.querySelector('[name="country"]').value
    ]
    .filter(Boolean)
    .join(", ");

    console.log(address);

    const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(address)}&format=json`;

    const response = await fetch(url);

    const data = await response.json();

    if (data.length > 0) {
        return {
            lat: data[0].lat,
            lng: data[0].lon
        };
    }

    return {
        lat: null,
        lng: null
    };
}function collectBundleFormData() {
    
    const form = document.querySelector("#drawerProducts #bundleUserForm");

    if (!form) {
        return {};
    }

    return {
        first_name: form.querySelector('[name="first_name"]').value,
        last_name: form.querySelector('[name="last_name"]').value,
        email: form.querySelector('[name="email"]').value,
        phone: form.querySelector('[name="phone"]').value,
        company: form.querySelector('[name="company"]').value,
        address_1: form.querySelector('[name="address_1"]').value,
        address_2: form.querySelector('[name="address_2"]').value,
        city: form.querySelector('[name="city"]').value,
        state: form.querySelector('[name="state"]').value,
        postcode: form.querySelector('[name="postcode"]').value,
        country: form.querySelector('[name="country"]').value,
        notes: form.querySelector('[name="notes"]').value
    };
}






async function submitBundleOrder() {



    showLoader("Submitting order...");

    try {

        // Customer information
        const customer = collectBundleFormData();

        // Coordinates
        const coordinates = await getCoordinates();

        customer.lat = coordinates.lat;
        customer.lng = coordinates.lng;

        // Bundle information
        const bundle = JSON.parse(
            localStorage.getItem("bundleProducts")
        ) || {};

        const payload = {
            customer,
            bundle
        };

        const response = await fetch(
            "/order/bundle-order/create",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector(
                            'meta[name="csrf-token"]'
                        )
                        .content
                },
                body: JSON.stringify(payload)
            }
        );

        const result = await response.json();

        if (!response.ok) {
            throw new Error(
                result.message || "Something went wrong."
            );
        }
        console.log("Closing Drawer...");
closeBundleDrawer();
resetBundleBuilder();
console.log("Drawer Closed");
        Swal.fire({
            icon: "success",
            title: "Success",
            text: result.message
        });

        console.log(result);

    } catch (error) {

        console.error(error);

        Swal.fire({
            icon: "error",
            title: "Error",
            text: error.message
        });

    } finally {

        hideLoader("Continue");
    }
}







function resetBundleBuilder() {

    // Reset JS variables
    selectedProducts = [];
    selectedBundleProducts = {};
    currentStep = 1;
    selectedDiscount = 20;

    // Remove saved bundle
    localStorage.removeItem("bundleProducts");

    // Remove selected product cards
    document.querySelectorAll(".product-card").forEach(card => {
        card.classList.remove("selected");
    });

    // Reset all dropdowns
    document.querySelectorAll(".bundle-select").forEach(select => {
        select.selectedIndex = 0;
    });

    // Reset quantities
    document.querySelectorAll(".qty").forEach(input => {
        input.value = 0;
    });

    // Reset summary
    document.getElementById("itemCount").innerHTML = "0";
    document.getElementById("subtotal").innerHTML = formatPrice(0);
    document.getElementById("discount").innerHTML = "-" + formatPrice(0);
    document.getElementById("total").innerHTML = formatPrice(0);
    document.getElementById("drawerTotal").innerHTML = formatPrice(0);

    document.querySelector(".summary-message").innerHTML =
        "Your bundle is empty";

    document.querySelector(".summary-small").innerHTML =
        "Select your items from the left to see your summary.";

    // Restore first checkout button
    document.getElementById("checkoutButton").innerHTML = `
        <span class="button-text">
            Checkout Bundle
        </span>

        <span
            class="spinner-border spinner-border-sm d-none loader"
            role="status"
            aria-hidden="true">
        </span>
    `;

    // Restore default discount (20%)
    document.querySelectorAll(".discount-box").forEach(box => {
        box.classList.remove("active");
    });

    const defaultBox = document.querySelector('.discount-box[data-discount="20"]');
    if (defaultBox) {
        defaultBox.classList.add("active");
    }

    document.getElementById("discountLabel").innerHTML =
        "DISCOUNT (20% OFF)";

    // Empty drawer content
    document.getElementById("drawerProducts").innerHTML = "";
}
</script>

@endsection