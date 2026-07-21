<style>
.option-box {
    border: 1px solid #ddd;
    transition: 0.2s ease-in-out;
}

.option-box.option-selected {
    border: 2px solid #9eef0b !important;
    box-shadow: 0 0 10px rgba(158, 239, 11, 0.3);
    transform: scale(1.01);
}

.purchase-card {
    border: 2px solid #ddd;
    padding: 15px;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.2s ease-in-out;
}

.purchase-card.active {
    border: 2px solid #9eef0b;
    box-shadow: 0 0 10px rgba(158, 239, 11, 0.3);
}
.option-box {
    position: relative;
}

/* BADGE STYLE */
.option-badge {
    position: absolute;
    top: 10px;
    right: 10px;

    background: linear-gradient(135deg, #9eef0b, #7ad600);
    color: #000;

    font-size: 11px;
    font-weight: 600;

    padding: 4px 10px;
    border-radius: 20px;

    box-shadow: 0 4px 10px rgba(0,0,0,0.15);

    z-index: 10;
    white-space: nowrap;
}
@media (max-width: 450px) {
    .purchase-card .fw-bold {
        font-size: 12px;
    }

    .purchase-card .small {color:white;
        font-size: 9.4px !important;
    }
  .small22 {
        font-size: 9px !important;
    }

    .purchase-card img {
        width: 20px;
        height: 20px;
    }
.option-badge {


    font-size: 8px;
  

    padding: 2px 7px;
 
}


.purchase-card {
       padding: 8px 4px;
   }


    .purchase-card .small32 {
        margin-top: -9px;
      
    }
}




/* Bottom Sheet */
.subscribe-dialog{
    position:fixed;
    left:0;
    right:0;
    bottom:0;

    margin:0;
    width:100%;
    max-width:100%;

    transform:translateY(100%);
    transition:transform .4s cubic-bezier(.22,1,.36,1);
}

#subscribeModal.show .subscribe-dialog{
    transform:translateY(0);     
}
 #subscribeModal.show{margin-top: 150px;}
#subscribeModal .modal-content{

  border: none;
    border-radius: 22px 22px 0 0;
    min-height: 80vh;
    background: #fff;
    padding: 0px 0px 37px 0px;
    overflow: auto;
}

/* remove side gaps */
#subscribeModal{
    padding:0 !important;
}

/* close button */
.subscribe-close{

    position:absolute;

    top:18px;

    right:18px;

    width:42px;

    height:42px;

    border:none;

    border-radius:50%;

    background:#fff;

    box-shadow:0 4px 18px rgba(0,0,0,.18);

    font-size:20px;

    cursor:pointer;

    z-index:100;
}

/* backdrop blur */
#subscribeModal.show{
    backdrop-filter:blur(4px);
}

/* smooth animation */
#subscribeModal.fade .modal-dialog{
    transition:transform .35s cubic-bezier(.16,1,.3,1);
}
</style>

@php
    $defaultDiscount = 20; 
    $isSubscribed = $product->subscribed;
    $isActive = $isSubscribed && $product->subscription->status === 'active';
@endphp

<!-- ================= PURCHASE TYPE CARDS ================= -->
<div class="row g-3 mb-3">

<div class="col-6">
    <div class="purchase-card w-100 d-flex justify-content-between align-items-center
    {{ !$isActive ? 'active' : '' }}"
    id="oneTimeCard">
         <img src="{{ asset('images/icons/bag.png') }}" alt="Bag" width="24">
        <div> 
            <div class="fw-bold" style="color:white">One Time Purchase</div>
            <div style="color:white;font-size:8px;margin-top:-6px" ">Pay once for your order</div>
        </div>
        
    </div>
</div>




<div class="col-6">
<div id="subscriptionCardWrapper">

    <div class="purchase-card w-100 d-flex justify-content-between align-items-center
        {{ $isActive ? 'active' : '' }}"
        id="subscribeCard"
        style="
            cursor:pointer;
            border:2px solid {{ $isSubscribed ? ($isActive ? '#9eef0b' : '#dc3545') : '#ddd' }};
        ">

        @if($isSubscribed)

           <img src="{{ asset('images/icons/time.png') }}" alt="Subscription" width="24">

              <div >
                <div class="fw-bold" style="color:{{ $isActive ? '#9eef0b' : '#dc3545' }};">
                  {{ $isActive ? 'Already Subscribed' : 'Subscription Paused' }}
               </div>

         @if($isActive)
             <button type="button"
                class="btn btn-sm btn-danger mt-1 cancelSubscriptionBtn"
                data-product="{{ $product->id }}"
                data-user="{{ auth()->id() }}"
                data-status="cancel"
                style="font-size:7px;padding:2px 10px;border-radius:20px;">
                Cancel Subscription
             </button>
         @else
          <small style="font-size:8px;color:#dc3545;">
              Subscription Cancelled
          </small>
       @endif
    </div>

        @else

            <img src="{{ asset('images/icons/return.png') }}" alt="Subscribe" width="24">

            <div>
                <div class="fw-bold text-white">
                    Subscribe &amp; Save
                </div>

                <div style="font-size:8px;color:white;margin-top:-6px;">
                    Save {{ $defaultDiscount }}% on every order
                </div>
            </div>

        @endif

    </div>
</div>
 
</div>
</div>








<input type="hidden" id="purchaseType" value="one_time">

<!-- ================= PACK OPTIONS ================= -->
<div class="row g-3">

@if(!empty($product->options) && is_array($product->options))

    @foreach($product->options as $opt)

        @php
            $pack = (int) ($opt['pack'] ?? 1);
            $price = (float) ($opt['price'] ?? 0);
            $discount = (float) ($opt['discount'] ?? 0);

            $basePrice = $discount > 0
                ? $price - ($price * $discount / 100)
                : $price;
        @endphp

        <div class="col-md-6">

            <div style="background-color:black" class="d-flex border rounded p-1 align-items-center gap-3 option-box"
                       data-price="{{ $basePrice }}"
                       data-base-price="{{ $basePrice }}" data-pack="{{ $pack }}"
                       data-option='@json($opt)'
                      style="cursor:pointer;"> 
                    
                <!-- IMAGE -->
                <div style="width:60px;height:60px;flex-shrink:0;overflow:hidden;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <img src="{{ $opt['image'] ?? '/placeholder.png' }}"
                         style="width:100%;height:100%;object-fit:cover;">
                </div>

                <!-- CONTENT -->
                <div class="flex-grow-1">

                    <div class="small" style="color:white">
                          @php
                       $days = $opt['duration'] ?? 0;
                     @endphp
                   {{ $days % 30 == 0 ? ($days / 30) . ' Month Supply' . ($days / 30 > 1 ? 's' : '') : $days . ' Days Supply' }}
                       
                    </div>
                    <div class="small22" style="color:#9eef0b;">
                         Buy {{ $pack }} to get {{ $pack }} Complimentary
                     </div>

                  

                     <div class="small mt-2" style="color:white;">
                       {{ $pack * 2 }} Packs Total
                   </div>
                   <span class="small">
                          <span class="small per-pouch" style="color:white;"></span>
                   </span>
                </div>

                <!-- PRICE -->
               <div class="d-flex flex-column" style="margin-top: 44px">
    <div class="fw-bold price-box" style="color:white">
        {{ number_format($basePrice, 2) }}
    </div>

    @if($product->old_price)
        <p style="color:white" class=" text-decoration-line-through old-price mb-0">
            {{ number_format($product->old_price * max($pack,1) , 2) }}
        </p>
    @endif

 @if($loop->index == 0)
    <div class="option-badge">
        Standard Value
    </div>

@elseif($loop->index == 1)
    <div class="option-badge">
        Most Popular
    </div>
@elseif($loop->index == 2)
    <div class="option-badge">
        Best Value
    </div>
@endif
</div>
              
                 
            </div>
           
        </div>

    @endforeach

@else

    <div class="col-12 text-muted">
        No pack options available
    </div>

@endif

</div>





<div class="modal fade" id="subscribeModal">

    <div class="modal-dialog modal-dialog-scrollable subscribe-dialog">

        <div class="modal-content">

            <button class="subscribe-close"
                    data-bs-dismiss="modal">

                ✕

            </button>

            <div class="modal-body">
                @include("modules.subscription")

            </div>

        </div>

    </div>

</div>



<script>
let isSubscribedActive = @json($isActive);
let discount = {{ $defaultDiscount }};

const oneTimeCard = document.getElementById("oneTimeCard");
const subscribeCard = document.getElementById("subscribeCard");
const purchaseType = document.getElementById("purchaseType");
const optionBoxes = document.querySelectorAll(".option-box");


function updateSubscriptionCard() {

    $("#subscriptionCardWrapper").html(`
        <div class="purchase-card active w-100 d-flex justify-content-between align-items-center"
             id="subscribeCard"
             style="cursor:pointer;border:2px solid #9eef0b;">

            <img src="/images/icons/time.png" width="24">

            <div>

                <div class="fw-bold" style="color:#9eef0b;">
                    Already Subscribed
                </div>

                <button
                    type="button"
                    class="btn btn-sm btn-danger mt-1 cancelSubscriptionBtn"
                    data-product="{{ $product->id }}"
                    data-user="{{ auth()->id() }}"
                    data-status="cancel"
                    style="font-size:7px;padding:2px 10px;border-radius:20px;">
                    Cancel Subscription
                </button>

            </div>

        </div>
    `);

    isSubscribedActive = true;

    window.purchaseMode = "subscribe";

    $("#purchaseType").val("subscribe");

    updatePrices("subscribe");

   refreshMainProductPrice();
}

document.addEventListener("DOMContentLoaded", function () {




     




    let discount = {{ $defaultDiscount }};
 

    window.selectedOption = null;
    window.purchaseMode = "one_time";

    // =========================
    // CURRENCY CONFIG
    // =========================
    window.currencyConfig = @json(config('currency'));
    window.currentCurrency = "{{ session('currency', 'GBP') }}";

    // =========================
    // FORMAT PRICE (GLOBAL SAFE)
    // =========================
    function formatPrice(price) {

        const currency = window.currentCurrency || window.currencyConfig?.default || "GBP";
        const config = window.currencyConfig?.currencies?.[currency];

        if (!config) return price;

        const converted = price * config.rate;
        return `${config.symbol} ${converted.toFixed(2)}`;
    }

    // =========================
    // UPDATE MAIN PRICE
    // =========================
    function updateMainPrice(price){

    const mainPriceEl=document.querySelector(".main-price");

    mainPriceEl.dataset.price = price;

    mainPriceEl.innerText = formatPrice(price);

}

    

    // =========================
    // BUY MODE SWITCH
    // =========================
    oneTimeCard?.addEventListener("click", function () {

        oneTimeCard.classList.add("active");
        subscribeCard.classList.remove("active");

       window.purchaseMode = isSubscribedActive ? "subscribe" : "one_time";
      purchaseType.value = isSubscribedActive ? "subscribe" : "one_time";

        if (isSubscribedActive) {

    subscribeCard.classList.add("active");
    oneTimeCard.classList.remove("active");

    updatePrices("subscribe");

} else {

    oneTimeCard.classList.add("active");
    subscribeCard.classList.remove("active");

    updatePrices("one_time");
}
    });

$(document).on("click", "#subscribeCard", function () {

    if (isSubscribedActive) {
        return;
    }

    bootstrap.Modal.getOrCreateInstance(
        document.getElementById("subscribeModal")
    ).show();

});

    // =========================
    // OPTION SELECTION
    // =========================
    optionBoxes.forEach(box => {

        box.addEventListener("click", function () {

            optionBoxes.forEach(b => b.classList.remove("option-selected"));
            this.classList.add("option-selected");

            const opt = JSON.parse(this.dataset.option);
            const basePrice = parseFloat(this.dataset.basePrice);

            let packText = this.querySelector(".fw-bold")?.innerText || "1";
            let pack = parseInt(packText.replace(/\D/g, '')) || 1;

            let finalPrice = basePrice;

            if (window.purchaseMode === "subscribe") {
                finalPrice = basePrice - (basePrice * discount / 100);
            }

            window.selectedOption = {
                ...opt,
                finalPrice,
                pack
            };

            updateMainPrice(finalPrice);


            console.log("Selected option:", window.selectedOption);
        });

    });

    // =========================
    // AUTO SELECT LOWEST PRICE
    // =========================
    let lowestBox = null;
    let lowestPrice = Infinity;

    optionBoxes.forEach(box => {

        let price = parseFloat(box.dataset.basePrice);

        if (!isNaN(price) && price < lowestPrice) {
            lowestPrice = price;
            lowestBox = box;
        }
    });

    if (lowestBox) {
        lowestBox.classList.add("option-selected");

        window.selectedOption = JSON.parse(lowestBox.dataset.option);
    }

    // INITIAL LOAD
    updatePrices("one_time");

});


    function updatePrices(type) {

        optionBoxes.forEach(box => {

            let basePrice = parseFloat(box.dataset.basePrice);

            let pack = parseInt(box.dataset.pack) || 1;

            let finalPrice = basePrice;

            // subscription discount
            if (type === "subscribe") {
                finalPrice = basePrice - (basePrice * discount / 100);
            }

            let perPouch = finalPrice / pack;

            const priceBox = box.querySelector(".price-box");
           

            if (priceBox) {
                priceBox.innerText = formatPrice(finalPrice);
            }

         const perPouchBox = box.querySelector(".per-pouch");

          if (perPouchBox) {
            perPouchBox.innerHTML = `${formatPrice(perPouch)} <small>per pouch</small>`;
          }
        });
      refreshMainProductPrice();
    }


function removeSubscriptionCard() {

    $("#subscriptionCardWrapper").html(`
        <div class="purchase-card w-100 d-flex justify-content-between align-items-center"
             id="subscribeCard"
             style="cursor:pointer;border:2px solid #ddd;">

            <img src="/images/icons/return.png" width="24">

            <div>
                <div class="fw-bold text-white">
                    Subscribe & Save
                </div>

                <div style="font-size:8px;color:white;margin-top:-6px;">
                    Save 20% on every order
                </div>
            </div>

        </div>
    `);

    isSubscribedActive = false;

    window.purchaseMode = "one_time";

    $("#purchaseType").val("one_time");

    $("#oneTimeCard").addClass("active");
const selectedBox = document.querySelector(".option-box.option-selected");

if (selectedBox) {

    const opt = JSON.parse(selectedBox.dataset.option);

    const basePrice = parseFloat(selectedBox.dataset.basePrice);

    window.selectedOption = {
        ...opt,
        finalPrice: basePrice
    };
}
    updatePrices("one_time");
    refreshMainProductPrice();

}

$(document).on("click",".cancelSubscriptionBtn",function(){

    let btn=$(this);

    Swal.fire({
        title:"Cancel Subscription?",
        text:"You can subscribe again anytime.",
        icon:"warning",
        showCancelButton:true,
        confirmButtonColor:"#dc3545",
        confirmButtonText:"Yes, Cancel"
    }).then((result)=>{

        if(!result.isConfirmed){
            return;
        }

        btn.prop("disabled",true).text("Cancelling...");

        $.ajax({

            url:"/subscription/cancel",

            type:"POST",

            data:{
                _token:$('meta[name="csrf-token"]').attr("content"),
                product_id:btn.data("product"),
                user_id:btn.data("user"),
                status:btn.data("status")
            },

            success:function(res){

                if(res.status){
                  console.log(res);
                    Swal.fire({
                        icon:"success",
                        title:"Cancelled",
                        text:res.message
                    }).then(()=>{
                       removeSubscriptionCard();
                    });

                }else{

                    Swal.fire({
                        icon:"warning",
                        title:"Warning",
                        text:res.message
                    });

                    btn.prop("disabled",false).text("Cancel Subscription");
                }

            },

            error:function(xhr){
                 console.log(xhr);

                let msg="Something went wrong.";

                if(xhr.responseJSON && xhr.responseJSON.message){
                    msg=xhr.responseJSON.message;
                }

                Swal.fire({
                    icon:"error",
                    title:"Error",
                    text:msg
                });

                btn.prop("disabled",false).text("Cancel Subscription");

            }

        });

    });

});
</script>