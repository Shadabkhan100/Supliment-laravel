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
</style>

@php
    $defaultDiscount = 20; // subscribe discount
@endphp

<!-- ================= PURCHASE TYPE CARDS ================= -->
<div class="row g-3 mb-3">

    <div class="col-6">
        <div class="purchase-card active w-100" id="oneTimeCard">
            <div class="fw-bold">One Time Purchase</div>
            <div class="text-muted small">Pay once for your order</div>
        </div>
    </div>

    <div class="col-6">
        <div class="purchase-card w-100" id="subscribeCard">
            <div class="fw-bold">Subscribe & Save</div>
            <div class="text-success small">Save {{ $defaultDiscount }}% on every order</div>
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

            <div class="d-flex border rounded p-3 align-items-center gap-3 position-relative option-box"
                 data-base-price="{{ $basePrice }}"
                 data-option='@json($opt)'
                 style="cursor:pointer;">

                <!-- IMAGE -->
                <div style="width:80px;height:80px;flex-shrink:0;overflow:hidden;border-radius:10px;background:#f5f5f5;display:flex;align-items:center;justify-content:center;">
                    <img src="{{ $opt['image'] ?? '/placeholder.png' }}"
                         style="width:100%;height:100%;object-fit:cover;">
                </div>

                <!-- CONTENT -->
                <div class="flex-grow-1">

                    <div class="fw-bold">
                        {{ $pack }} x Pack
                    </div>

                    <div class="mt-1">
                        <span class="badge bg-light text-dark border per-pouch">
                            £{{ number_format($basePrice / max($pack,1), 2) }} per pouch
                        </span>
                    </div>

                    <div class="text-muted small mt-2">
                        {{ $opt['duration'] ?? '' }} Days
                    </div>

                </div>

                <!-- PRICE -->
                <div class="fw-bold fs-5 price-box">
                    £{{ number_format($basePrice, 2) }}
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

<script>
document.addEventListener("DOMContentLoaded", function () {

    let discount = {{ $defaultDiscount }};

    const oneTimeCard = document.getElementById("oneTimeCard");
    const subscribeCard = document.getElementById("subscribeCard");
    const purchaseType = document.getElementById("purchaseType");

    const optionBoxes = document.querySelectorAll(".option-box");

    // GLOBAL VARIABLES (IMPORTANT)
    window.selectedOption = null;
    window.purchaseMode = "one_time";

    function updatePrices(type) {

        optionBoxes.forEach(box => {

            let basePrice = parseFloat(box.dataset.basePrice);
            let pack = parseInt(box.querySelector(".fw-bold").innerText) || 1;

            let finalPrice = basePrice;

            if (type === "subscribe") {
                finalPrice = basePrice - (basePrice * discount / 100);
            }

            let perPouch = finalPrice / pack;

            box.querySelector(".price-box").innerText =
                "£" + finalPrice.toFixed(2);

            box.querySelector(".per-pouch").innerText =
                "£" + perPouch.toFixed(2) + " per pouch";
        });
    }

    // SELECT BUYING MODE
    oneTimeCard.addEventListener("click", function () {
        oneTimeCard.classList.add("active");
        subscribeCard.classList.remove("active");

        window.purchaseMode = "one_time";
        purchaseType.value = "one_time";

        updatePrices("one_time");
    });

    subscribeCard.addEventListener("click", function () {
        subscribeCard.classList.add("active");
        oneTimeCard.classList.remove("active");

        window.purchaseMode = "subscribe";
        purchaseType.value = "subscribe";

        updatePrices("subscribe");
    });

    // SELECT PACK OPTION
    optionBoxes.forEach(box => {
        box.addEventListener("click", function () {

            optionBoxes.forEach(b => b.classList.remove("option-selected"));
            this.classList.add("option-selected");

            window.selectedOption = JSON.parse(this.dataset.option);

            console.log("Selected option:", window.selectedOption);
        });
    });

});
</script>