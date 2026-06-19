@extends('admin.main')

@section('title', 'Orders Management')
@section('page-title', 'Orders Management')

@section('content')

<style>
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
        <a href="/admin/order/{{ $order['id'] }}" class="btn btn-primary btn-sm">View</a>
       <button class="btn btn-danger btn-sm"
        onclick="deleteOrder({{ $order['id'] }})">
    Delete
</button>
    </td>

</tr>

@endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection


@section('scripts')

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

$(document).ready(function(){

    /* STATUS UPDATE */
    $('.status-dropdown').change(function(){

        let orderId = $(this).data('id');
        let status = $(this).val();

        $.ajax({
            url:'/update-status/' + orderId,
            method:'POST',
            data:{
                _token:'{{ csrf_token() }}',
                status:status
            },
            success:function(){
                console.log('updated');
            }
        });

    });

    /* SEARCH */
    $('#searchInput').on('keyup', function(){

        let value = $(this).val().toLowerCase();

        $('#ordersTable tbody tr').filter(function(){

            $(this).toggle(
                $(this).text().toLowerCase().indexOf(value) > -1
            );

        });

    });

    /* STATUS FILTER */
    $('#statusFilter').change(function(){

        let status = $(this).val();

        $('#ordersTable tbody tr').each(function(){

            let rowStatus = $(this).data('status');

            if(status === '' || rowStatus === status){
                $(this).show();
            }else{
                $(this).hide();
            }

        });

    });

    /* PAYMENT FILTER */
    $('#paymentFilter').change(function(){

        let payment = $(this).val();

        $('#ordersTable tbody tr').each(function(){

            let rowPayment = $(this).data('payment');

            if(payment === '' || rowPayment === payment){
                $(this).show();
            }else{
                $(this).hide();
            }

        });

    });

});

</script>

@endsection