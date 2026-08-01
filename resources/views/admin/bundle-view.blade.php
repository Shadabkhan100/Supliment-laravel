@extends('admin.main')

@section('title', 'Bundle Management')
@section('page-title', 'Bundle Management')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">




<style>

#statusMessage{
    position: fixed;
    top: 20px;
    right: 20px;
    min-width: 320px;
    padding: 15px 20px;
    border-radius: 8px;
    color: #fff;
    display: none;
    z-index: 99999;
    box-shadow: 0 5px 25px rgba(0,0,0,.25);
}

.status-loading{
    background: #0d6efd;
}

.status-success{
    background: #198754;
}

.status-error{
    background: #dc3545;
}


.bundleDrawerOverlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.5);
    opacity:0;
    visibility:hidden;
    transition:.3s;
    z-index:9998;
}

.bundleDrawerOverlay.active{
    opacity:1;
    visibility:visible;
}

.bundleDrawer{
    position:fixed;
    top:0;
    right:-550px;
    width:550px;
    max-width:100%;
    height:100vh;
    background:#141414;
    z-index:9999;
    transition:.35s ease;
    overflow-y:auto;
    box-shadow:-5px 0 30px rgba(0,0,0,.25);
}

.bundleDrawer.active{
    right:0;
}

.bundleDrawerHeader{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px;
    border-bottom:1px solid rgba(255,255,255,.08);
}

.bundleDrawerHeader h4{
    color:#fff;
    margin:0;
}

.bundleDrawerHeader button{
    border:none;
    background:none;
    color:#fff;
    font-size:20px;
}

.bundleDrawerBody{
    padding:20px;
}

.bundleCard{
    background:#1d1d1d;
    border-radius:12px;
    padding:15px;
    margin-bottom:15px;
}

.bundleTitle{
    color:#fff;
    margin-bottom:15px;
}

.bundleInfoRow{
    display:flex;
    justify-content:space-between;
    padding:8px 0;
    border-bottom:1px solid rgba(255,255,255,.05);
}

.bundleInfoRow span:first-child{
    color:#999;
}

.bundleInfoRow span:last-child{
    color:#fff;
}

.bundleProduct{
    display:flex;
    gap:15px;
    margin-bottom:15px;
}

.bundleProduct img{
    width:75px;
    height:75px;
    border-radius:10px;
    object-fit:cover;
}

.bundleProductTitle{
    color:#fff;
    font-weight:700;
}

.bundleProductMeta{
    color:#999;
    font-size:13px;
}

@media(max-width:768px){

    .bundleDrawer{
        width:100%;
    }

}



</style>


<div id="statusMessage"></div>
<div class="card shadow-sm">

    <div class="card-header">

        <div class="row g-3">

            <div class="col-md-5">
                <input
                    type="text"
                    id="bundleSearch"
                    class="form-control"
                    placeholder="Search order, customer, phone..."
                >
            </div>

            <div class="col-md-3">

                <select
                    id="statusFilter"
                    class="form-select"
                >
                    <option value="">All Statuses</option>
                    <option value="Pending">Pending</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Delivered">Delivered</option>
                </select>

            </div>

        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Products</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                @foreach ($bundleOrders as $order)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>#{{ $order->id }}</td>

                        <td>
                            {{ $order->first_name }}
                            {{ $order->last_name }}
                        </td>

                        <td>{{ $order->phone }}</td>

                        <td>

                            @foreach ($order->products as $product)

                                <div class="mb-2">

                                    <img
                                        src="{{ $product['main_image'] }}"
                                        width="40"
                                    >

                                    {{ $product['name'] }}

                                </div>

                            @endforeach

                        </td>

                        <td>
                            £{{ number_format($order->total, 2) }}
                        </td>

                        <td>

                            @if ($order->payment_status)

                                <span class="badge bg-success">
                                    Paid
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Pending
                                </span>

                            @endif

                        </td>

                        <td>

                            <select
                                class="form-select bundle-status"
                                data-id="{{ $order->id }}"
                            >

                                <option
                                    value="Pending"
                                    @selected($order->order_status=='Pending')
                                >
                                    Pending
                                </option>

                                <option
                                    value="Shipped"
                                    @selected($order->order_status=='Shipped')
                                >
                                    Shipped
                                </option>

                                <option
                                    value="Delivered"
                                    @selected($order->order_status=='Delivered')
                                >
                                    Delivered
                                </option>

                            </select>

                        </td>

                        <td>
                            {{ $order->created_at->format('d M Y') }}
                        </td>

                        <td>

                            <button
                                class="btn btn-primary bundle-view"
                                data-id="{{ $order->id }}"
                            >
                                <i class="fa fa-eye"></i>
                            </button>

                            <button
                                class="btn btn-danger bundle-delete"
                                data-id="{{ $order->id }}"
                            >
                                <i class="fa fa-trash"></i>
                            </button>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>




<!-- ================= BUNDLE DRAWER ================= -->

<div class="bundleDrawerOverlay" id="bundleDrawerOverlay"></div>

<div class="bundleDrawer" id="bundleDrawer">

    <div class="bundleDrawerHeader">

        <h4>Bundle Order Details</h4>

        <button id="closeBundleDrawer">
            <i class="fa fa-times"></i>
        </button>

    </div>

    <div class="bundleDrawerBody" id="bundleDrawerBody">

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




<script>

const bundleOrders = @json($bundleOrders);

console.log(bundleOrders);

$(document).on("click", ".bundle-view", function () {
       console.log("Hello View Testing....");
    const id = Number($(this).data("id"));

    console.log("Clicked ID:", id);

    const order = bundleOrders.find(
        item => Number(item.id) === id
    );

    console.log(order);

    if (!order) {

        alert("Bundle order not found.");

        return;
    }

    let products = order.products || [];

    if (typeof products === "string") {

        try {

            products = JSON.parse(products);

        } catch (e) {

            console.error("Products parsing failed:", e);

            products = [];
        }
    }

    let productsHtml = "";

    products.forEach(function (product) {

        productsHtml += `
            <div class="bundleProduct">

                <img
                    src="${product.main_image || '/images/placeholder.png'}"
                    onerror="this.src='/images/placeholder.png'"
                >

                <div>

                    <div class="bundleProductTitle">
                        ${product.name || 'Unknown product'}
                    </div>

                    <div class="bundleProductMeta">
                        Quantity: ${product.qty || 1}
                    </div>

                    <div class="bundleProductMeta">
                        Price: £${product.price || 0}
                    </div>

                    <div class="bundleProductMeta">
                        SKU: ${product.sku || '-'}
                    </div>

                </div>

            </div>
        `;
    });

    $("#bundleDrawerBody").html(`

        <div class="bundleCard">

            <h5 class="bundleTitle">
                Customer Information
            </h5>

            <div class="bundleInfoRow">
                <span>Name</span>
                <span>${order.first_name || ""} ${order.last_name || ""}</span>
            </div>

            <div class="bundleInfoRow">
                <span>Email</span>
                <span>${order.email || "-"}</span>
            </div>

            <div class="bundleInfoRow">
                <span>Phone</span>
                <span>${order.phone || "-"}</span>
            </div>

            <div class="bundleInfoRow">
                <span>Country</span>
                <span>${order.country || "-"}</span>
            </div>

            <div class="bundleInfoRow">
                <span>City</span>
                <span>${order.city || "-"}</span>
            </div>

            <div class="bundleInfoRow">
                <span>Address</span>
                <span>${order.address_1 || "-"}</span>
            </div>

        </div>

        <div class="bundleCard">

            <h5 class="bundleTitle">
                Payment Information
            </h5>

            <div class="bundleInfoRow">
                <span>Subtotal</span>
                <span>£${order.subtotal || 0}</span>
            </div>

            <div class="bundleInfoRow">
                <span>Discount</span>
                <span>${order.discount_percentage || 0}%</span>
            </div>

            <div class="bundleInfoRow">
                <span>Discount Amount</span>
                <span>£${order.discount_amount || 0}</span>
            </div>

            <div class="bundleInfoRow">
                <span>Total</span>
                <span>£${order.total || 0}</span>
            </div>

            <div class="bundleInfoRow">
                <span>Payment Status</span>
                <span>
                    ${order.payment_status ? "Paid" : "Pending"}
                </span>
            </div>

            <div class="bundleInfoRow">
                <span>Order Status</span>
                <span>${order.order_status || "Pending"}</span>
            </div>

        </div>

        <div class="bundleCard">

            <h5 class="bundleTitle">

                Bundle Products (${order.item_count || 0})

            </h5>

            ${productsHtml}

        </div>

    `);

    $("#bundleDrawer").addClass("active");

    $("#bundleDrawerOverlay").addClass("active");

});

$("#closeBundleDrawer").on("click", function () {

    $("#bundleDrawer").removeClass("active");

    $("#bundleDrawerOverlay").removeClass("active");

});

$("#bundleDrawerOverlay").on("click", function () {

    $("#bundleDrawer").removeClass("active");

    $("#bundleDrawerOverlay").removeClass("active");

});


$(document).on("change", ".bundle-status", function () {

    let select = $(this);
    let id = select.data("id");
    let status = select.val();

    $("#statusMessage")
        .removeClass()
        .addClass("status-loading")
        .html(`
            <i class="fa fa-spinner fa-spin"></i>
            Updating the status. Please wait...
        `)
        .fadeIn();

$.ajax({
    url: `/admin/bundle-status/update/${id}/${status}`,
    type: "POST",

    data: {
        _token: $('meta[name="csrf-token"]').attr("content")
    },

    beforeSend: function () {
        console.log("Sending request...");
    },

    success: function (response) {

        console.log("SUCCESS:", response);

        $("#statusMessage")
            .removeClass()
            .addClass("status-success")
            .html(`
                <i class="fa fa-check-circle"></i>
                Status updated successfully.
            `);

        setTimeout(function () {
            $("#statusMessage").fadeOut();
        }, 5000);
    },

    error: function (xhr, status, error) {

        console.log("XHR:", xhr);
        console.log("STATUS:", status);
        console.log("ERROR:", error);
        console.log("RESPONSE:", xhr.responseText);

        $("#statusMessage")
            .removeClass()
            .addClass("status-error")
            .html(`
                <i class="fa fa-times-circle"></i>
                ${xhr.responseText}
            `);
    },

    complete: function (xhr, status) {

        console.log("COMPLETE");
        console.log("HTTP STATUS:", xhr.status);
        console.log("AJAX STATUS:", status);
    }
});
});




</script>
@endsection