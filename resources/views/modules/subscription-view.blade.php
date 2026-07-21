<style>

/* ================= SUBSCRIPTIONS ================= */

.subscriptionGridX9{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:18px;
}

.subscriptionCardX9{
    position:relative;
    background:rgba(255,255,255,.04);
    border:1px solid rgba(255,255,255,.08);
    border-radius:16px;
    padding:16px;
    transition:.25s;
}

.subscriptionCardX9:hover{
    border-color:#9eef0b;
    transform:translateY(-3px);
}

.subscriptionRowX9{
    display:flex;
    gap:15px;
    align-items:center;
}

.subscriptionImageX9{
    width:90px;
    height:90px;
    flex-shrink:0;
}

.subscriptionImageX9 img{
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius:12px;
}

.subscriptionContentX9{
    flex:1;
}

.subscriptionTitleX9{
    color:#fff;
    font-size:15px;
    font-weight:700;
    line-height:1.4;
    margin-bottom:4px;
}

.subscriptionCategoryX9{
    color:#9ca3af;
    font-size:12px;
    margin-bottom:10px;
}

.subscriptionBottomX9{
    display:flex;
    justify-content:space-between;
    align-items:end;
}

.subscriptionInfoX9{
    color:#d1d5db;
    font-size:12px;
    line-height:20px;
}

.discountBadgeX9{
    background:#9eef0b;
    color:#000;
    font-weight:700;
    padding:6px 10px;
    border-radius:8px;
    font-size:11px;
}

.statusBadgeX9{
    position:absolute;
    top:10px;
    right:10px;
    background:#16a34a;
    color:#fff;
    padding:4px 10px;
    border-radius:20px;
    font-size:10px;
    font-weight:700;
}

.cancelBadgeX9{
    position:absolute;
    top:42px;
    right:10px;
    border:none;
    background:#dc3545;
    color:#fff;
    padding:4px 10px;
    border-radius:20px;
    font-size:10px;
    font-weight:700;
    cursor:pointer;
}

.cancelBadgeX9:hover{
    background:#bb2d3b;
}

@media(max-width:991px){

.subscriptionGridX9{
    grid-template-columns:1fr;
}

}

@media(max-width:575px){

.subscriptionRowX9{
    gap:12px;
}

.subscriptionImageX9{
    width:75px;
    height:75px;
}

.subscriptionTitleX9{
    font-size:13px;
}

.subscriptionInfoX9{
    font-size:11px;
}

.discountBadgeX9{
    font-size:10px;
    padding:5px 8px;
}

.statusBadgeX9{
    font-size:9px;
}

.cancelBadgeX9{
    font-size:9px;
}

}

</style>

    @if(count($subscriptions))

        <div class="subscriptionGridX9">

            @foreach($subscriptions as $subscription)

                <div class="subscriptionCardX9"
                     id="subscriptionCard{{ $subscription['id'] }}">

                    <!-- Status -->
                    <span class="statusBadgeX9">
                        {{ ucfirst($subscription['status']) }}
                    </span>

                    <!-- Cancel -->
                    <button
                        type="button"
                        class="cancelBadgeX9 cancelSubscriptionBtn"
                        data-id="{{ $subscription['id'] }}"
                        data-product="{{ $subscription['product_id'] }}"
                        data-user="{{ auth()->id() }}">
                        Cancel
                    </button>

                    <div class="subscriptionRowX9">

                        <!-- IMAGE -->
                        <div class="subscriptionImageX9">

                            <img
                                src="{{ $subscription['product']['main_image'] }}"
                                alt="{{ $subscription['product']['name'] }}">

                        </div>

                        <!-- CONTENT -->
                        <div class="subscriptionContentX9">

                            <div class="subscriptionTitleX9">
                                {{ $subscription['product']['name'] }}
                            </div>

                            <div class="subscriptionCategoryX9">
                                {{ $subscription['product']['category_name'] }}
                            </div>

                            <div class="subscriptionBottomX9">

                                <div>

                                    <div class="subscriptionInfoX9">
                                        Frequency :
                                        <strong>{{ ucfirst($subscription['frequency']) }}</strong>
                                    </div>

                                    <div class="subscriptionInfoX9">
                                        Price :
                                        <strong>
                                            £{{ number_format($subscription['product']['price'],2) }}
                                        </strong>
                                    </div>

                                </div>

                                <div class="discountBadgeX9">

                                    {{ $subscription['discount'] }}% OFF

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="userEmptyX9">

            <i class="fas fa-box-open"></i>

            <h4>No Active Subscriptions</h4>

            <p>You don't have any active subscription.</p>

        </div>

    @endif




<script>

$(document).on("click", ".cancelSubscriptionBtn", function () {

    let btn = $(this);

    let card = btn.closest(".subscriptionCardX9");

    Swal.fire({
        title: "Cancel Subscription?",
        text: "This subscription will be cancelled immediately.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, Cancel",
        cancelButtonText: "Keep Subscription"
    }).then((result) => {

        if (!result.isConfirmed) return;

        btn.prop("disabled", true).text("...");

        $.ajax({

            url: "/subscription/cancel",

            type: "POST",

            data: {

                _token: $('meta[name="csrf-token"]').attr("content"),

                product_id: btn.data("product"),

                user_id: btn.data("user")

            },

            success: function (res) {

                if (res.status) {

                    Swal.fire({

                        icon: "success",

                        title: "Cancelled",

                        text: res.message,

                        timer: 1500,

                        showConfirmButton: false

                    });

                    card.css({
                        transition: ".35s",
                        opacity: "0",
                        transform: "scale(.9)"
                    });

                    setTimeout(function () {

                        card.remove();

                        // If no cards remain
                        if ($(".subscriptionCardX9").length === 0) {

                            $(".subscriptionGridX9").html(`
                                <div class="userEmptyX9" style="grid-column:1/-1;">
                                    <i class="fas fa-box-open"></i>
                                    <h4>No Active Subscriptions</h4>
                                    <p>You don't have any active subscription.</p>
                                </div>
                            `);

                        }

                    }, 350);

                } else {

                    Swal.fire({

                        icon: "warning",

                        title: "Warning",

                        text: res.message

                    });

                    btn.prop("disabled", false).text("Cancel");

                }

            },

            error: function (xhr) {

                let msg = "Something went wrong.";

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }

                Swal.fire({

                    icon: "error",

                    title: "Error",

                    text: msg

                });

                btn.prop("disabled", false).text("Cancel");

            }

        });

    });

});


</script>