@extends('admin.main')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Overview')

@section('content')

<!-- CARDS -->

<div class="row g-4">
<div class="col-lg-4 col-md-6">
    <div class="dashboard-card">
        <div class="icon bg-blue">
            <i class="fa fa-shopping-cart"></i>
        </div>

        <h2>{{ number_format($products->count()) }}</h2>
        <p>Total Products</p>
    </div>
</div>

<div class="col-lg-4 col-md-6">
    <div class="dashboard-card">
        <div class="icon bg-green">
            <i class="fa fa-users"></i>
        </div>

        <h2>{{ number_format($users->count()) }}</h2>

        <p>Total Customers</p>
    </div>
</div>

<div class="col-lg-4 col-md-6">
    <div class="dashboard-card">
        <div class="icon bg-orange">
            <i class="fa fa-shopping-bag"></i>
        </div>

        <h2>{{ number_format($guestOrders->count()) }}</h2>

        <p>Total Orders</p>
    </div>
</div>

<div class="col-lg-4 col-md-6">
    <div class="dashboard-card">
        <div class="icon bg-success">
            <i class="fa fa-dollar"></i>
        </div>

        <h2>£{{ number_format($totalPaid, 2) }}</h2>
        <p>Total Paid Amount</p>
    </div>
</div>

<div class="col-lg-4 col-md-6">
    <div class="dashboard-card">
        <div class="icon bg-red">
            <i class="fa fa-dollar"></i>
        </div>

        <h2>£{{ number_format($totalFailed, 2) }}</h2>
        <p>Total Failed Amount</p>
    </div>
</div>

</div>

<!-- GRAPH -->

<div class="graph-box">
<div class="d-flex justify-content-between align-items-center">
    <h4>Sales Analytics</h4>
    <button class="btn btn-primary">View Report</button>
</div>

<div class="row g-4 mt-3">

    <!-- Left Side -->
    <div class="col-lg-8">

        <div class="card shadow border-0 rounded-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-0">Business Analytics</h4>
                        <small class="text-muted">Store Performance Overview</small>
                    </div>

                    <span class="badge bg-success px-3 py-2">
                        Live Statistics
                    </span>
                </div>

                <div class="row text-center">

                    <div class="col-md-3 mb-4">
                        <h2 class="fw-bold text-primary">
                            {{ $products->count() }}
                        </h2>
                        <small>Total Products</small>

                        <div class="progress mt-2" style="height:6px;">
                            <div class="progress-bar bg-primary" style="width:100%"></div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <h2 class="fw-bold text-success">
                            {{ $guestOrders->where('payment_status',1)->count() }}
                        </h2>

                        <small>Paid Orders</small>

                        <div class="progress mt-2" style="height:6px;">
                            <div class="progress-bar bg-success" style="width:85%"></div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">

                        <h2 class="fw-bold text-danger">
                            {{ $guestOrders->where('payment_status',0)->count() }}
                        </h2>

                        <small>Failed Payments</small>

                        <div class="progress mt-2" style="height:6px;">
                            <div class="progress-bar bg-danger" style="width:40%"></div>
                        </div>

                    </div>

                    <div class="col-md-3 mb-4">

                        <h2 class="fw-bold text-warning">

                            {{ number_format($products->sum('stock')) }}

                        </h2>

                        <small>Total Stock</small>

                        <div class="progress mt-2" style="height:6px;">
                            <div class="progress-bar bg-warning" style="width:70%"></div>
                        </div>

                    </div>

                </div>

                <hr>

                <div class="row">

                    <div class="col-md-6">

                     <h6 class="mb-3 mt-3">
    Payment Success Rate
</h6>

@php
    $total = max($guestOrders->count(), 1);

    $paid = $guestOrders->where('payment_status', 1)->count();
    $failed = $guestOrders->where('payment_status', 0)->count();

    $shipped = $guestOrders->filter(function($order){
        return strtolower($order->order_status) == 'shipped';
    })->count();

    $delivered = $guestOrders->filter(function($order){
        return strtolower($order->order_status) == 'delivered';
    })->count();

    $pending = $guestOrders->filter(function($order){
        return strtolower($order->order_status) == 'pending';
    })->count();

    $success = ($paid / $total) * 100;
    $failedRate = ($failed / $total) * 100;
    $shippedRate = ($shipped / $total) * 100;
    $deliveredRate = ($delivered / $total) * 100;
    $pendingRate = ($pending / $total) * 100;
@endphp

<!-- Paid -->
<h6 class="mb-2">Payment Success</h6>
<div class="progress mb-3" style="height:16px;">
    <div class="progress-bar bg-success" style="width:{{ $success }}%">
        {{ number_format($success,1) }}%
    </div>
</div>

<!-- Failed -->
<h6 class="mb-2">Failed Payments</h6>
<div class="progress mb-3" style="height:16px;">
    <div class="progress-bar bg-danger" style="width:{{ $failedRate }}%">
        {{ number_format($failedRate,1) }}%
    </div>
</div>

<!-- Shipped -->
<h6 class="mb-2">Shipped Orders</h6>
<div class="progress mb-3" style="height:16px;">
    <div class="progress-bar bg-info" style="width:{{ $shippedRate }}%">
        {{ number_format($shippedRate,1) }}%
    </div>
</div>


<!-- Pending -->
<h6 class="mb-2">Pending Orders</h6>
<div class="progress" style="height:16px;">
    <div class="progress-bar bg-warning text-dark" style="width:{{ $pendingRate }}%">
        {{ number_format($pendingRate,1) }}%
    </div>
</div>


                    </div>

                    <div class="col-md-6">

                        <canvas id="salesChart" height="180"></canvas>
<!-- Delivered -->
<h6 class="mb-2 mt-3">Delivered Orders</h6>
<div class="progress mb-3" style="height:16px;">
    <div class="progress-bar bg-primary" style="width:{{ $deliveredRate }}%">
        {{ number_format($deliveredRate,1) }}%
    </div>
</div>
                    </div>


                </div>

            </div>
        </div>

    </div>

    <!-- Right Side -->

    <div class="col-lg-4">

        <div class="card shadow border-0 rounded-4">

            <div class="card-body">

                <h5 class="fw-bold mb-4">
                    Order Summary
                </h5>

                <div class="d-flex justify-content-between mb-3">

                    <span>📦 Total Orders</span>

                    <strong>{{ $guestOrders->count() }}</strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>💳 Paid</span>

                    <strong class="text-success">
                        {{ $guestOrders->where('payment_status',1)->count() }}
                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>❌ Failed</span>

                    <strong class="text-danger">
                        {{ $guestOrders->where('payment_status',0)->count() }}
                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>👥 Subscribers</span>

                    <strong>
                        {{ $subscribers->count() }}
                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>📝 Blogs</span>

                    <strong>
                        {{ $blogs->count() }}
                    </strong>

                </div>

                <div class="d-flex justify-content-between">

                    <span>⭐ Testimonials</span>

                    <strong>
                        {{ $testimonials->count() }}
                    </strong>

                </div>

            </div>


        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('salesChart'),{

type:'line',

data:{

labels:['Jan','Feb','Mar','Apr','May','Jun'],

datasets:[{

label:'Orders',

data:[25,45,35,60,85,70],

borderColor:'#0d6efd',

backgroundColor:'rgba(13,110,253,.15)',

fill:true,

tension:.4

}]

},

options:{

plugins:{
legend:{
display:false
}
},

responsive:true,

scales:{
y:{
beginAtZero:true
}
}

}

});

</script>

</div>

<!-- TABLE -->

<div class="table-box">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Recent Orders</h4>

    <a href="" class="btn btn-dark btn-sm">
        View All
    </a>
</div>

<div class="table-responsive">

    <table class="table table-hover align-middle">

        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Payment</th>
                <th>Order Status</th>
                <th>Updated</th>
            </tr>
        </thead>

        <tbody>

        @forelse($recentOrders as $order)

            <tr>

                <td>
                    <strong>#{{ $order->id }}</strong>
                </td>

                <td>
                    {{ $order->name }}
                </td>

                <td>
                    {{ $order->email }}
                </td>

                <td>
                    {{ $order->phone }}
                </td>

                <td>

                    @if($order->payment_status == 1)

                        <span class="badge bg-success">
                            Paid
                        </span>

                    @else

                        <span class="badge bg-danger">
                            Failed
                        </span>

                    @endif

                </td>

                <td>

                    @php

                        $status = strtolower($order->order_status);

                    @endphp

                    @if($status=='pending')

                        <span class="badge bg-warning text-dark">
                            Pending
                        </span>

                    @elseif($status=='processing')

                        <span class="badge bg-info">
                            Processing
                        </span>

                    @elseif($status=='shipped')

                        <span class="badge bg-primary">
                            Shipped
                        </span>

                    @elseif($status=='delivered')

                        <span class="badge bg-success">
                            Delivered
                        </span>

                    @elseif($status=='cancelled')

                        <span class="badge bg-danger">
                            Cancelled
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            {{ ucfirst($order->order_status) }}
                        </span>

                    @endif

                </td>

                <td>
                    {{ $order->updated_at->diffForHumans() }}
                    <br>
                    <small class="text-muted">
                        {{ $order->updated_at->format('d M Y H:i') }}
                    </small>
                </td>

            </tr>

        @empty

            <tr>

                <td colspan="7" class="text-center text-muted py-4">
                    No recent orders found.
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>
</div>

@endsection
