@extends('layout.Main')

@section('content')

<style>

@media (max-width: 637px) {
    #modal-content {
        margin-top: 1437px !important;
    }
}

/* ================= CART WRAPPER ================= */
.cartWrapX1{
    padding:40px 0;
}

/* ================= ITEM CARD ================= */
.cartItemCardX1{
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:18px;
    padding:18px;
    margin-bottom:16px;
    display:flex;
    gap:15px;
    align-items:center;
    transition:0.25s;
}

.cartItemCardX1:hover{
    transform:translateY(-3px);
    border-color:#9eef0b;
}

/* ================= IMAGE ================= */
.cartImgX1{
    width:85px;
    height:85px;
    border-radius:12px;
    overflow:hidden;
    flex-shrink:0;
    background:#111;
}

.cartImgX1 img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* ================= PRODUCT INFO ================= */
.cartInfoX1{
    flex:1;
}

.cartTitleX1{
    color:#fff;
    font-size:16px;
    font-weight:700;
    margin-bottom:5px;
}

.cartMetaX1{
    color:#aaa;
    font-size:13px;
}

/* ================= PRICE ================= */
.cartPriceX1{
    text-align:right;
    min-width:120px;
}

.cartPriceMainX1{
    color:#9eef0b;
    font-size:18px;
    font-weight:800;
}

.cartPriceSubX1{
    color:#aaa;
    font-size:12px;
}

/* ================= SUMMARY BOX ================= */
.cartSummaryX1{
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:18px;
    padding:20px;
    position:sticky;
    top:20px;
}

.summaryTitleX1{
    color:#fff;
    font-size:18px;
    font-weight:700;
    margin-bottom:15px;
}

.summaryRowX1{
    display:flex;
    justify-content:space-between;
    padding:8px 0;
    color:#ccc;
}

.summaryTotalX1{
    border-top:1px solid rgba(255,255,255,0.1);
    margin-top:10px;
    padding-top:10px;
    font-weight:800;
    color:#9eef0b;
    font-size:18px;
}

/* ================= EMPTY ================= */
.emptyCartX1{
    text-align:center;
    padding:60px 20px;
    color:#aaa;
}

.emptyCartX1 h3{
    color:#fff;
    margin-top:10px;
}
</style>

<div class="container cartWrapX1">

    <div class="row g-4">

        <!-- LEFT: CART ITEMS -->
        <div class="col-lg-8">

            @php
                $grandTotal = 0;
            @endphp

            @forelse($cartItems as $item)

                @php
                    $product = $item->product;
                    $price = $product->price ?? 0;
                    $qty = $item->quantity ?? 1;

                    // FINAL SUBTOTAL (base logic)
                    $subtotal = $price * $qty;

                    $grandTotal += $subtotal;
                @endphp

                <div class="cartItemCardX1">

                    <!-- IMAGE -->
                    <div class="cartImgX1">
                        <img src="{{ $product->main_image_url ?? '/placeholder.png' }}">
                    </div>

                    <!-- INFO -->
                    <div class="cartInfoX1">
                        <div class="cartTitleX1">
                            {{ $product->name ?? 'Product Not Found' }}
                        </div>

                        <div class="cartMetaX1">
                            Qty: {{ $qty }} | SKU: {{ $product->sku ?? '-' }}
                        </div>
                    </div>

                    <!-- PRICE -->
                    <div class="cartPriceX1">

                        <!-- SUBTOTAL -->
                        <div class="cartPriceMainX1 currency-price"
                             data-value="{{ $subtotal }}">
                            £{{ number_format($subtotal,2) }}
                        </div>

                        <!-- UNIT PRICE -->
                        <div class="cartPriceSubX1 currency-price"
                             data-value="{{ $price }}">
                            £{{ number_format($price,2) }} each
                        </div>

                        <!-- VIEW -->
                        <div class="mt-3">
                         <a
                          href="javascript:void(0)"
                          class="btn btn-sm btn-outline-light view-product-btn mx-1"
                          data-cart-id="{{ $item->id }}"
                          data-bs-toggle="modal"
                          data-bs-target="#productModal"
                           >
                        <i class="fas fa-eye"></i>
                        </a>    
                     <a
    href="javascript:void(0)"
    class="btn btn-sm btn-outline-danger delete-cart-btn mx-1"
    data-cart-id="{{ $item->id }}"
>
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
                    <span class="currency-price"
                          data-value="{{ $grandTotal }}">
                        £{{ number_format($grandTotal,2) }}
                    </span>
                </div>

                <div class="summaryRowX1">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>

                <div class="summaryRowX1">
                    <span>Discount</span>
                    <span>£0.00</span>
                </div>

                <div class="summaryTotalX1">
                    Total:
                    <span class="currency-price"
                          data-value="{{ $grandTotal }}">
                        £{{ number_format($grandTotal,2) }}
                    </span>
                </div>

                <button class="settings-btn mt-3 w-100">
                    Proceed to Checkout
                </button>

            </div>

        </div>

    </div>

</div>






<div class="modal fade" id="productModal" tabindex="-1" >
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


<script>
window.currencyConfig = @json(config('currency'));
window.currentCurrency = "{{ session('currency', 'GBP') }}";

function formatCurrency(value) {

    const currency = window.currentCurrency || "GBP";
    const config = window.currencyConfig?.currencies?.[currency];

    if (!config) return value;

    const converted = value * config.rate;

    return `${config.symbol} ${converted.toFixed(2)}`;
}

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.currency-price').forEach(el => {

        const raw = parseFloat(el.dataset.value);

        if (!isNaN(raw)) {
            el.innerText = formatCurrency(raw);
        }

    });

});





document.addEventListener('click', function (e) {

    const btn = e.target.closest('.view-product-btn');
    if (!btn) return;

    window.__cartItemId = btn.dataset.cartId;

});





document.addEventListener('click', async function (e) {

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

            // remove item from UI instantly
            btn.closest('.cartItemCardX1').remove();

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
</script>
@endsection