@extends('admin.main')

@section('title', 'Orders Management')
@section('page-title', 'Orders Management')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css">

<style>


.live-green-marker{
    width:18px;
    height:18px;
    background:#16c60c;
    border-radius:50%;
    position:relative;
    box-shadow:0 0 8px rgba(22,198,12,.5);
}

.live-green-marker::before,
.live-green-marker::after{
    content:"";
    position:absolute;
    inset:0;
    border-radius:50%;
    background:rgba(22,198,12,.35);
    animation:livePulse 2s infinite;
}

.live-green-marker::after{
    animation-delay:1s;
}

@keyframes livePulse{

    from{
        transform:scale(1);
        opacity:1;
    }

    to{
        transform:scale(3.5);
        opacity:0;
    }

}
#drawerOverlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.45);
    opacity:0;
    visibility:hidden;
    transition:.3s;
    z-index:1040;
}

#drawerOverlay.show{
    opacity:1;
    visibility:visible;
}

#orderDrawer{
    position:fixed;
    top:0;
    right:-50%;
    width:50%;
    max-width:700px;
    height:100vh;
    background:#fff;
    box-shadow:-5px 0 20px rgba(0,0,0,.15);
    transition:.35s ease;
    z-index:1050;
    display:flex;
    flex-direction:column;
}

#orderDrawer.show{
    right:0;
}

.drawer-header{
    padding:18px 20px;
    border-bottom:1px solid #eee;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.drawer-body{
    padding:20px;
    overflow-y:auto;
    flex:1;
}

.drawer-close{
    border:none;
    background:none;
    font-size:22px;
    cursor:pointer;
    color:#666;
}

.drawer-close:hover{
    color:#dc3545;
}

@media(max-width:768px){

    #orderDrawer{
        width:100%;
        right:-100%;
    }

}
.page-card{
    background:#fff;
    border-radius:20px;
    padding:25px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.stats-box{
    display:flex;
    gap:15px;
    margin-bottom:20px;
}

.stat-card{
    flex:1;
    background:#fff;
    border-radius:15px;
    padding:20px;
    box-shadow:0 3px 12px rgba(0,0,0,.08);
}

.filters{
    display:flex;
    gap:15px;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.filters input,
.filters select{
    min-width:220px;
}

.table img{
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:10px;
}

.badge-status{
    padding:8px 12px;
    border-radius:30px;
    font-size:12px;
}

.status-pending{
    background:#fff3cd;
    color:#856404;
}

.status-shipped{
    background:#cff4fc;
    color:#055160;
}

.status-delivered{
    background:#d1e7dd;
    color:#0f5132;
}

.status-suspended{
    background:#f8d7da;
    color:#842029;
}
</style>
<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin="">
</script>
<div class="page-card">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Orders Management</h3>
            <small class="text-muted">
                Manage all customer orders
            </small>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters">

        <input type="text"
               class="form-control"
               id="searchInput"
               placeholder="Search by name, phone, email">

        <select class="form-select" id="statusFilter">
            <option value="">All Order Status</option>
            <option>Pending</option>
            <option>Shipped</option>
            <option>Delivered</option>
            <option>Suspended</option>
        </select>

        <select class="form-select" id="paymentFilter">
            <option value="">All Payment Status</option>
            <option>Paid</option>
            <option>Pending</option>
            <option>Failed</option>
        </select>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle" id="ordersTable">

            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Qty</th>
                    <th>Purchase Type</th>
                    <th>Payment</th>
                    <th>Order Status</th>
                    <th>Date</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>

            <tbody>

        @foreach($orders as $order)

<tr data-status="{{ $order['order_status'] }}"
    data-payment="{{ $order['payment_status'] }}">

    <td>#{{ $order['id'] }}</td>

    <td>
        <strong>{{ $order['name'] }}</strong><br>
        <small>{{ $order['email'] }}</small>
    </td>

    <td>{{ $order['phone'] }}</td>

    <td>{{ $order['quantity'] }}</td>

    <td>{{ $order['purchase_type'] }}</td>

    <td>
        <span class="badge bg-success">
            {{ $order['payment_status'] ? 'Paid' : 'Pending' }}
        </span>
    </td>

    <td>
        <select class="form-select status-dropdown"
                data-id="{{ $order['id'] }}">

            <option value="Pending" {{ $order['order_status']=='Pending'?'selected':'' }}>Pending</option>
            <option value="Shipped" {{ $order['order_status']=='Shipped'?'selected':'' }}>Shipped</option>
            <option value="Delivered" {{ $order['order_status']=='Delivered'?'selected':'' }}>Delivered</option>
            <option value="Suspended" {{ $order['order_status']=='Suspended'?'selected':'' }}>Suspended</option>

        </select>
    </td>

    <td>
        {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }}
    </td>

  <td>
    <div class="d-flex flex-wrap gap-2 justify-content-center">

        <a href="javascript:void(0)"
   onclick='openOrderDrawer(@json($order))'
   class="btn btn-primary btn-sm d-flex align-items-center">
    <i class="fas fa-eye me-1"></i>
    View
</a>

        <!-- Refund -->
        @if($order['payment_status'])
        <button
            class="btn btn-warning btn-sm refundBtn d-flex align-items-center"
            onclick="refundOrder(this, {{ $order['id'] }})">
            <i class="fas fa-undo-alt me-1"></i>
            Refund
        </button>
        @endif

        <!-- Delete -->
        <button
            class="btn btn-danger btn-sm d-flex align-items-center"
            onclick="deleteOrder({{ $order['id'] }})">
            <i class="fas fa-trash-alt me-1"></i>
            Delete
        </button>

    </div>
</td>



</tr>

@endforeach

            </tbody>

        </table>

    </div>

</div>
<!-- Overlay -->
<div id="drawerOverlay"></div>

<!-- Drawer -->
<div id="orderDrawer">

    <div class="drawer-header">
        <h5 class="mb-0">Order Details</h5>

        <button type="button" class="drawer-close" onclick="closeOrderDrawer()">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="drawer-body">
        Hello World
    </div>

</div>
@endsection


@section('scripts')





<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
<script>

async function deleteOrder(id)
{
    // confirmation first (professional UX)
    if (!confirm("Are you sure you want to delete this order? This action cannot be undone.")) {
        return;
    }

    try {
        const response = await fetch(`/api/order/delete/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        });

        const data = await response.json();

        if (response.ok && data.success) {

            // success message
            alert(data.message || "Order deleted successfully");

            // remove row from table (optional UI update)
            const row = document.querySelector(`[data-row-id="${id}"]`);
            if (row) row.remove();

        } else {
            alert(data.message || "Failed to delete order");
        }

    } catch (error) {
        console.error(error);
        alert("Something went wrong while deleting the order");
    }
}

$(document).ready(function () {

    /* STATUS UPDATE */
    $('.status-dropdown').change(function () {

        let orderId = $(this).data('id');
        let status = $(this).val();

        $.ajax({
            url: '/update-status/' + orderId,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },

            success: function (response) {
                console.log("Success:");
                console.log(response);
            },

            error: function (xhr, status, error) {

                console.log("========== AJAX ERROR ==========");
                console.log("HTTP Status:", xhr.status);
                console.log("Status Text:", status);
                console.log("Error:", error);

                console.log("Raw Response:");
                console.log(xhr.responseText);

                try {
                    let json = JSON.parse(xhr.responseText);

                    console.log("JSON Response:");
                    console.log(json);

                    console.log("Message:", json.message);
                    console.log("Exception:", json.exception);
                    console.log("File:", json.file);
                    console.log("Line:", json.line);
                    console.log("Trace:", json.trace);

                } catch (e) {
                    console.log("Response is not valid JSON.");
                }
            }
        });

    });

    /* SEARCH */
    $('#searchInput').on('keyup', function () {

        let value = $(this).val().toLowerCase();

        $('#ordersTable tbody tr').filter(function () {

            $(this).toggle(
                $(this).text().toLowerCase().indexOf(value) > -1
            );

        });

    });

    /* STATUS FILTER */
    $('#statusFilter').change(function () {

        let status = $(this).val();

        $('#ordersTable tbody tr').each(function () {

            let rowStatus = $(this).data('status');

            if (status === '' || rowStatus === status) {
                $(this).show();
            } else {
                $(this).hide();
            }

        });

    });

    /* PAYMENT FILTER */
    $('#paymentFilter').change(function () {

        let payment = $(this).val();

        $('#ordersTable tbody tr').each(function () {

            let rowPayment = $(this).data('payment');

            if (payment === '' || rowPayment === payment) {
                $(this).show();
            } else {
                $(this).hide();
            }

        });

    });

});





function refundOrder(button, id) {

    Swal.fire({
        title: "Refund this order?",
        html: `
            <div style="text-align:left">
                <p><strong>This action cannot be undone.</strong></p>

                <ul>
                    <li>The customer will receive a full refund.</li>
                    <li>The refunded amount will be deducted from your Stripe account.</li>
                    <li>The order will be permanently deleted from your system.</li>
                </ul>

                <p style="color:#dc3545;font-weight:bold;">
                    Are you sure you want to continue?
                </p>
            </div>
        `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Refund Order",
        confirmButtonColor: "#dc3545",
        cancelButtonText: "Cancel"

    }).then(async (result) => {

        if (!result.isConfirmed) return;

        const originalText = button.innerHTML;

        button.disabled = true;
        button.innerHTML = `
            <span class="spinner-border spinner-border-sm"></span>
            Refunding...
        `;

        try {

            const response = await fetch(`/admin/order/${id}/refund`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json"
                }
            });

            const data = await response.json();

            if (!response.ok || !data.status) {
                throw new Error(data.message || "Refund failed.");
            }

            Swal.fire({
                icon: "success",
                title: "Refund Successful",
                html: `
                    <b>The customer has been refunded successfully.</b><br><br>
                    The payment has been refunded through Stripe and the order has been permanently removed from your database.
                `,
                confirmButtonColor: "#28a745"
            }).then(() => {
                location.reload();
            });

        } catch (error) {
             console.log(error)
            button.disabled = false;
            button.innerHTML = originalText;

            Swal.fire({
                icon: "error",
                title: "Refund Failed",
                text: error.message || "Unable to process the refund."
            });

        }

    });

}

function openOrderDrawer(order) {
const adminLat = 17.319183989317914;
const adminLng = 42.33244612525538;

function getDistanceKm(lat1, lon1, lat2, lon2) {

    const R = 6371; // Earth's radius in km

    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;

    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) *
        Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);

    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    return (R * c).toFixed(2);
}

const distanceKm =
    order.lat && order.lng
        ? getDistanceKm(
            adminLat,
            adminLng,
            parseFloat(order.lat),
            parseFloat(order.lng)
        )
        : '-';





    $('#drawerOverlay').addClass('show');
    $('#orderDrawer').addClass('show');

    const statusBadge = `
        <span class="badge bg-${
            order.status == 'Delivered' ? 'success' :
            order.status == 'Cancelled' ? 'danger' :
            order.status == 'Out for Delivery' ? 'primary' :
            order.status == 'Preparing' ? 'info' :
            'warning'
        } px-3 py-2">
            ${order.status ?? 'Pending'}
        </span>
    `;
const productPrice = parseFloat(order.product?.price || 0);
const quantity = parseInt(order.quantity || 0);
const totalPrice = (productPrice * quantity).toFixed(2);

const shipmentStatus = (order.shipment_status || 'Pending').toLowerCase();

const shipmentBadge = `
<span class="badge bg-${
    shipmentStatus === 'delivered' ? 'success' :
    shipmentStatus === 'out for delivery' ? 'primary' :
    shipmentStatus === 'shipped' ? 'info' :
    shipmentStatus === 'cancelled' ? 'danger' :
    shipmentStatus === 'processing' ? 'warning' :
    'secondary'
} px-3 py-2">
${order.shipment_status ?? 'Pending'}
</span>`;


const isPaid =
    order.payment_status === true ||
    order.payment_status === 1 ||
    order.payment_status === '1' ||
    order.payment_status === 'true';

const paymentBadge = `
<span class="badge bg-${isPaid ? 'success' : 'warning'} px-3 py-2">
    ${isPaid ? 'Paid' : 'Pending'}
</span>`;

  $('.drawer-body').html(`

<div class="container-fluid">

    <!-- ORDER SUMMARY -->
    <div class="card shadow-sm mb-3">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                <i class="fas fa-shopping-bag me-2"></i>
                Order #${order.id}
            </h5>

            ${statusBadge}

        </div>

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-6">
                    <strong>Shipment Status</strong><br>
                    ${shipmentBadge}
                </div>

                <div class="col-md-6">
                    <strong>Payment Status</strong><br>
                    ${paymentBadge}
                </div>

            </div>

        </div>

    </div>


    <!-- CUSTOMER -->
    <div class="card shadow-sm mb-3">

        <div class="card-header">
            <i class="fas fa-user me-2"></i>
            Customer Information
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <strong>Name</strong><br>
                    ${order.name ?? '-'}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Phone</strong><br>
                    ${order.phone ?? '-'}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Email</strong><br>
                    ${order.email ?? '-'}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Payment Method</strong><br>
                    ${order.payment_method ?? '-'}
                </div>

            </div>

        </div>

    </div>


    <!-- PRODUCT -->
    <div class="card shadow-sm mb-3">

        <div class="card-header">
            <i class="fas fa-box-open me-2"></i>
            Product Details
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <strong>Product</strong><br>
                    ${order.product?.name ?? '-'}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Category</strong><br>
                    ${order.product?.category_name ?? '-'}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Unit Price</strong><br>
                    ${productPrice.toFixed(2)}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Quantity</strong><br>
                    ${quantity}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Total Price</strong><br>
                    <span class="fw-bold text-primary">
                        ${totalPrice}
                    </span>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Paid Amount</strong><br>
                    <span class="fw-bold text-success">
                        ${order.paid_amount ?? '0.00'}
                    </span>
                </div>

            </div>

        </div>

    </div>


    <!-- DELIVERY -->
    <div class="card shadow-sm mb-3">

        <div class="card-header">
            <i class="fas fa-map-marker-alt me-2"></i>
            Delivery Information
        </div>

        <div class="card-body">

            <p>${order.address ?? '-'}</p>

            <div class="row">

               <div class="col-md-6 mb-3">
    <strong>Distance from Warehouse</strong><br>

    <span id="distanceBadge" class="badge bg-primary px-3 py-2">
        Calculating...
    </span>
</div>

<div class="col-md-6 mb-3">
    <strong>Estimated Route</strong><br>

    <span id="timeBadge" class="badge bg-info px-3 py-2">
        Calculating...
    </span>
</div>

            </div>

            <div id="orderMap"
                 style="
                    height:320px;
                    border-radius:10px;
                    overflow:hidden;
                 ">
            </div>

            <a target="_blank"
               href="https://www.google.com/maps?q=${order.lat},${order.lng}"
               class="btn btn-success mt-3">

                <i class="fas fa-location-arrow me-2"></i>

                Open in Google Maps

            </a>

        </div>

    </div>


    <!-- NOTES -->
    <div class="card shadow-sm">

        <div class="card-header">
            <i class="fas fa-sticky-note me-2"></i>
            Customer Notes
        </div>

        <div class="card-body">

            ${order.notes ?? 'No notes available.'}

        </div>

    </div>

</div>

`);

   if (order.lat && order.lng) {

console.log(L);
console.log(L.Routing);
    setTimeout(function () {

        const adminLat = 17.319183989317914;
        const adminLng = 42.33244612525538;

        const customerLat = parseFloat(order.lat);
        const customerLng = parseFloat(order.lng);

        const map = L.map('orderMap');

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const customerIcon = L.divIcon({
            className: '',
            html: `<div class="live-green-marker"></div>`,
            iconSize: [20,20]
        });

        const truckIcon = L.divIcon({
            className: '',
            html: `
                <div style="
                    width:42px;
                    height:42px;
                    border-radius:50%;
                    background:#0d6efd;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    color:#fff;
                    font-size:18px;
                    box-shadow:0 4px 12px rgba(0,0,0,.25);
                ">
                    <i class="fas fa-truck"></i>
                </div>
            `,
            iconSize:[42,42],
            iconAnchor:[21,21]
        });

        const control = L.Routing.control({

            waypoints: [

                L.latLng(adminLat, adminLng),
                L.latLng(customerLat, customerLng)

            ],

            routeWhileDragging:false,
            draggableWaypoints:false,
            addWaypoints:false,
            fitSelectedRoutes:true,
            show:false,

            createMarker:function(i,wp){

                return L.marker(wp.latLng,{
                    icon:i===0 ? truckIcon : customerIcon
                });

            },

            lineOptions:{
                styles:[
                    {
                        color:'#0d6efd',
                        weight:6,
                        opacity:0.9
                    }
                ]
            }

        }).addTo(map);

        control.on('routesfound', function(e){

            const route = e.routes[0];

            const distanceKm = (route.summary.totalDistance / 1000).toFixed(2);

            const durationMin = Math.ceil(route.summary.totalTime / 60);

            $('#distanceBadge').html(`
                <i class="fas fa-route me-1"></i>
                ${distanceKm} km
            `);

            $('#timeBadge').html(`
                <i class="fas fa-clock me-1"></i>
                ${durationMin} mins
            `);

        });

    },200);

}

}

function closeOrderDrawer(){

    $('#drawerOverlay').removeClass('show');
    $('#orderDrawer').removeClass('show');

}

$('#drawerOverlay').click(function(){
    closeOrderDrawer();
});
window.addEventListener('load', function () {
    console.log("Leaflet Version:", L.version);

    console.log("Routing =", window.L.Routing);

    console.log(typeof window.L.Routing);
});
</script>

@endsection