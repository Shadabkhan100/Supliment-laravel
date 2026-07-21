<div class="p-4">

    <!-- Header -->
    <div class="text-center mb-4">
       <div class="text-center py-3">
    <img src="{{ asset('images/icons/offer.png') }}"
         alt="Subscribe & Save"
         style="width:80px;height:80px;object-fit:contain;">
</div>
        <h3 class="fw-bold my-2">Subscribe & Save</h3>
        <p class="text-muted mb-0">
            Save <strong>{{ $defaultDiscount }}%</strong> on every recurring order and never run out.
        </p>
    </div>

    <!-- Benefits -->
    <div class="border rounded-4 p-3 mb-4 bg-light">

        <div class="d-flex align-items-center mb-3">
            <div class="me-3 fs-4">💰</div>
            <div>
                <div class="fw-bold">Save {{ $defaultDiscount }}% Every Order</div>
                <small class="text-muted">Lower price than one-time purchases.</small>
            </div>
        </div>

        <div class="d-flex align-items-center mb-3">
            <div class="me-3 fs-4">📦</div>
            <div>
                <div class="fw-bold">Automatic Deliveries</div>
                <small class="text-muted">Receive your products on schedule.</small>
            </div>
        </div>

        <div class="d-flex align-items-center mb-3">
            <div class="me-3 fs-4">📅</div>
            <div>
                <div class="fw-bold">Choose Delivery Frequency</div>
                <small class="text-muted">Every week, every 2 weeks or monthly.</small>
            </div>
        </div>

        <div class="d-flex align-items-center mb-3">
            <div class="me-3 fs-4">✏️</div>
            <div>
                <div class="fw-bold">Manage Anytime</div>
                <small class="text-muted">Pause, skip, change or cancel whenever you like.</small>
            </div>
        </div>

        <div class="d-flex align-items-center">
            <div class="me-3 fs-4">🔒</div>
            <div>
                <div class="fw-bold">Secure Payments</div>
                <small class="text-muted">Recurring billing handled securely by our payment provider.</small>
            </div>
        </div>

    </div>

    <!-- Frequency -->
    <h5 class="fw-bold mb-3">Delivery Frequency</h5>

    <div class="mb-4">

        <label class="subscription-option border rounded-3 p-3 w-100 mb-2 d-flex align-items-center">
            <input type="radio" name="subscription_frequency" value="weekly" class="me-3">
            <div>
                <strong>Every Week</strong><br>
                <small class="text-muted">Best value for regular users</small>
            </div>
        </label>

        <label class="subscription-option border rounded-3 p-3 w-100 mb-2 d-flex align-items-center">
            <input type="radio" name="subscription_frequency" value="2weeks" class="me-3">
            <div>
                <strong>Every 2 Weeks</strong><br>
                <small class="text-muted">Most Popular</small>
            </div>
        </label>

        <label class="subscription-option border rounded-3 p-3 w-100 d-flex align-items-center">
            <input type="radio" name="subscription_frequency" value="monthly" class="me-3" checked>
            <div>
                <strong>Every Month</strong><br>
                <small class="text-muted">Perfect for long-term use</small>
            </div>
        </label>

    </div>

    <!-- Savings -->
    <div class="alert alert-success rounded-4 text-center mb-4">
        <h5 class="mb-1">🎉 You're Saving {{ $defaultDiscount }}%</h5>
        <small>Your discount is automatically applied to every recurring order.</small>
    </div>

    <!-- Fine Print -->
    <div class="small text-muted mb-4">
        • Cancel anytime.<br>
        • Skip or pause future deliveries.<br>
        • Update your payment method whenever you want.<br>
        • Billing occurs automatically based on your selected schedule.
    </div>

    <!-- Button -->
   <div class="row g-2" style="margin-bottom: 87px;">

    <div class="col-6">
        <button type="button"
            class="btn btn-outline-secondary w-100 py-2 rounded-pill fw-semibold">
            <i class="bi bi-x-circle me-2"></i>
            Cancel
        </button>
    </div>

    <div class="col-6">
   <button type="button"
        id="subscribeNowBtn"
        class="btn w-100 py-2 rounded-pill fw-bold"
        style="background:#9eef0b;color:#000;border:1px solid #9eef0b;">
    <i class="fas fa-sync-alt me-2"></i>
    <span class="btn-text">Subscribe</span>
</button>
    </div>

</div>

</div>


<script>

$(document).on("click", "#subscribeNowBtn", function () {

    const btn = $(this);

    const frequency = $("input[name='subscription_frequency']:checked").val();

    if (!frequency) {
        alert("Please select a delivery frequency.");
        return;
    }

    const data = {
        _token: "{{ csrf_token() }}",
        product_id: window.selectedProductId,
        frequency: frequency,
        discount: "{{ $defaultDiscount }}"
    };

    console.log(data);

    btn.prop("disabled", true);

    btn.find(".btn-text").html(`
        <span class="spinner-border spinner-border-sm me-2"></span>
        Subscribing...
    `);

    $.ajax({

        url: "/subscription/create",

        type: "POST",

        data: data,

        success: function (res) {

    btn.prop("disabled", false);
    btn.find(".btn-text").text("Subscribe");

    if (!res.status) {

        Swal.fire({
            icon: "warning",
            title: "Already Subscribed",
            text: res.message,
            confirmButtonColor: "#9eef0b"
        });

        return;
    }

    bootstrap.Modal
        .getInstance(document.getElementById("subscribeModal"))
        .hide();

   if(res.status){

        Swal.fire({
            icon:"success",
            title:"Subscribed",
            text:res.message
        });

       updateSubscriptionCard();

window.purchaseMode = "subscribe";

refreshMainProductPrice();

updatePrices("subscribe");

        bootstrap.Modal.getInstance(
            document.getElementById("subscribeModal")
        ).hide();
    }


},

        error: function (xhr) {

            btn.prop("disabled", false);

            btn.find(".btn-text").text("Subscribe");

            console.log(xhr);
            console.log(xhr.responseText);

            Swal.fire({
                icon: "error",
                title: "Something went wrong",
                text: "Please try again."
            });

        }

    });

});

</script>