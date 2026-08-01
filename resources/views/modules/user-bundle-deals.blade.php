<style>

.table-responsive{
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}

#bundleTable{
    min-width:1050px;
}

#bundleSearch,
#bundleStatus{
    min-width:220px;
}
.bundleDrawerOverlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.55);
    opacity:0;
    visibility:hidden;
    transition:.3s;
    z-index:9998;
}

.bundleDrawerOverlay.show{
    opacity:1;
    visibility:visible;
}

.bundleDrawer{
    position:fixed;
    top:0;
    right:-520px;
    width:520px;
    max-width:100%;
    height:100%;
    background:#111;
    color:#fff;
    z-index:9999;
    transition:.35s;
    overflow-y:auto;
}

.bundleDrawer.open{
    right:0;
}

.bundleDrawerHeader{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px;
    border-bottom:1px solid rgba(255,255,255,.1);
}

.bundleDrawerHeader h4{
    margin:0;
    font-size:18px;
    font-weight:700;
}

.bundleDrawerHeader button{
    background:none;
    border:0;
    color:#fff;
    font-size:24px;
}

.bundleDrawerBody{
    padding:20px;
}

.bundleCard{
    background:#181818;
    border:1px solid rgba(255,255,255,.08);
    border-radius:12px;
    padding:15px;
    margin-bottom:18px;
}

.bundleCard h6{
    color:#9eef0b;
    margin-bottom:12px;
}

.bundleRow{
    display:flex;
    justify-content:space-between;
    margin-bottom:8px;
    gap:15px;
}

.bundleProduct{
    display:flex;
    gap:15px;
    margin-bottom:15px;
    padding-bottom:15px;
    border-bottom:1px solid rgba(255,255,255,.08);
}

.bundleProduct img{
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:10px;
}

.bundleProduct:last-child{
    border-bottom:0;
}

@media(max-width:768px){

.bundleDrawer{
    width:100%;
}

}
</style>



<div class="card border-0 shadow-sm bg-transparent">

    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">

        <input
            type="text"
            class="form-control"
            id="bundleSearch"
            placeholder="Search Order..."
            style="max-width:260px;"
        >

        <select class="form-select" id="bundleStatus" style="max-width:220px;">
            <option value="">All Status</option>
            <option>Pending</option>
            <option>Processing</option>
            <option>Completed</option>
            <option>Cancelled</option>
        </select>

    </div>

    <div class="table-responsive">

        <table class="table table-dark table-hover align-middle mb-0" id="bundleTable">

            <thead>

            <tr>
                <th>#</th>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Items</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Date</th>
                <th width="80">Action</th>
            </tr>

            </thead>

            <tbody>

            @forelse($bundleOrders as $order)

                @php

                    $summary = is_array($order->summary)
                        ? $order->summary
                        : json_decode($order->summary,true);

                @endphp

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>#{{ $order->id }}</td>

                    <td>{{ $order->customer_name ?? $order->name ?? 'Guest User' }}</td>

                   <td>£ {{ number_format((float)($order->total ?? 0), 2) }}</td>

<td>{{ $order->discount_percentage ?? 0 }}%</td>

<td>{{ $order->item_count ?? count($order->products ?? []) }}</td>

                    <td>

                        @if($order->payment_status)

                            <span class="badge bg-success">Paid</span>

                        @else

                            <span class="badge bg-danger">Pending</span>

                        @endif

                    </td>

                    <td>

                        <span class="badge bg-info">

                            {{ $order->order_status ?? 'Pending' }}

                        </span>

                    </td>

                    <td>{{ $order->created_at->format('d M Y') }}</td>

                    <td>

                        <button
                            class="btn btn-sm btn-success bundle-view"
                            data-id="{{ $order->id }}"
                        >
                            <i class="fa fa-eye"></i>
                        </button>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="10" class="text-center py-5">
                        No Bundle Deals Found
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>


<div class="bundleDrawer" id="bundleDrawer">

    <div class="bundleDrawerHeader">
        <h4>Bundle Order Details</h4>

        <button id="closeBundleDrawer">
            <i class="fa fa-times"></i>
        </button>
    </div>

    <div class="bundleDrawerBody" id="bundleDrawerBody"></div>

</div>

<div class="bundleDrawerOverlay" id="bundleDrawerOverlay"></div>



<script>
const bundleOrders = @json($bundleOrders ?? []);

window.bundleOrders = bundleOrders;

console.log(bundleOrders);


document.getElementById('bundleSearch').addEventListener('keyup', function () {

    const value = this.value.toLowerCase();

    document.querySelectorAll('#bundleTable tbody tr').forEach(row => {

        row.style.display =
            row.innerText.toLowerCase().includes(value)
                ? ''
                : 'none';

    });

});


document.getElementById('bundleStatus').addEventListener('change', function () {

    const status = this.value.toLowerCase();

    document.querySelectorAll('#bundleTable tbody tr').forEach(row => {

        if (!status) {

            row.style.display = '';

            return;

        }

        row.style.display =
            row.innerText.toLowerCase().includes(status)
                ? ''
                : 'none';

    });

});

$(document).on("click", ".bundle-view", function () {

    const id = $(this).data("id");

    const order = window.bundleOrders.find(x => x.id == id);

    if (!order) return;

    openBundleDrawer(order);

});

function openBundleDrawer(order){

    let products="";

    order.products.forEach((product,index)=>{

        products+=`

        <div class="bundleProduct">

            <img src="${product.main_image}">

            <div class="flex-grow-1">

                <div><strong>${product.name}</strong></div>

                <div>Quantity : ${product.qty}</div>

                <div>Unit Price : £${Number(product.price).toFixed(2)}</div>

                <div><strong>Total : £${(product.qty*product.price).toFixed(2)}</strong></div>

            </div>

        </div>

        `;

    });

    document.getElementById("bundleDrawerBody").innerHTML=`

<div class="bundleCard">

<h6>Customer Information</h6>

<div class="bundleRow"><span>Name</span><span>${order.first_name} ${order.last_name}</span></div>

<div class="bundleRow"><span>Email</span><span>${order.email}</span></div>

<div class="bundleRow"><span>Phone</span><span>${order.phone}</span></div>

<div class="bundleRow"><span>Company</span><span>${order.company}</span></div>

</div>

<div class="bundleCard">

<h6>Shipping Address</h6>

<p>

${order.address_1}<br>

${order.city}, ${order.state}<br>

${order.country} ${order.postcode}

</p>

</div>

<div class="bundleCard">

<h6>Order Summary</h6>

<div class="bundleRow"><span>Items</span><strong>${order.item_count}</strong></div>

<div class="bundleRow"><span>Subtotal</span><strong>£${Number(order.subtotal).toFixed(2)}</strong></div>

<div class="bundleRow"><span>Discount</span><strong>${order.discount_percentage}%</strong></div>

<div class="bundleRow"><span>Discount Amount</span><strong>£${Number(order.discount_amount).toFixed(2)}</strong></div>

<div class="bundleRow"><span>Total</span><strong>£${Number(order.total).toFixed(2)}</strong></div>

<div class="bundleRow"><span>Payment</span><strong>${order.payment_status?'Paid':'Pending'}</strong></div>

<div class="bundleRow"><span>Status</span><strong>${order.order_status}</strong></div>

</div>

<div class="bundleCard">

<h6>Products (${order.products.length})</h6>

${products}

</div>

<div class="bundleCard">

<h6>Customer Notes</h6>

${order.notes || 'No notes'}

</div>

`;

    $("#bundleDrawer").addClass("open");
    $("#bundleDrawerOverlay").addClass("show");
}


$("#closeBundleDrawer,#bundleDrawerOverlay").click(function(){

    $("#bundleDrawer").removeClass("open");

    $("#bundleDrawerOverlay").removeClass("show");

});
</script>