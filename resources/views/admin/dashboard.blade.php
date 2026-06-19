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

        <h2>1,250</h2>
        <p>Total Products</p>
    </div>
</div>

<div class="col-lg-4 col-md-6">
    <div class="dashboard-card">
        <div class="icon bg-green">
            <i class="fa fa-users"></i>
        </div>

        <h2>8,420</h2>
        <p>Total Customers</p>
    </div>
</div>

<div class="col-lg-4 col-md-6">
    <div class="dashboard-card">
        <div class="icon bg-orange">
            <i class="fa fa-shopping-bag"></i>
        </div>

        <h2>950</h2>
        <p>Total Orders</p>
    </div>
</div>

<div class="col-lg-4 col-md-6">
    <div class="dashboard-card">
        <div class="icon bg-red">
            <i class="fa fa-dollar"></i>
        </div>

        <h2>$12,540</h2>
        <p>Total Revenue</p>
    </div>
</div>


</div>

<!-- GRAPH -->

<div class="graph-box">
<div class="d-flex justify-content-between align-items-center">
    <h4>Sales Analytics</h4>
    <button class="btn btn-primary">View Report</button>
</div>

<div class="graph">

    <div class="bar" style="height:70%;">
        <span>Jan</span>
    </div>

    <div class="bar" style="height:45%;">
        <span>Feb</span>
    </div>

    <div class="bar" style="height:85%;">
        <span>Mar</span>
    </div>

    <div class="bar" style="height:60%;">
        <span>Apr</span>
    </div>

    <div class="bar" style="height:90%;">
        <span>May</span>
    </div>

    <div class="bar" style="height:75%;">
        <span>Jun</span>
    </div>

</div>
```

</div>

<!-- TABLE -->

<div class="table-box">

```
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Recent Orders</h4>
    <button class="btn btn-dark">View All</button>
</div>

<div class="table-responsive">

    <table class="table align-middle">

        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Amount</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td>#1025</td>
                <td>Ahmed Khan</td>
                <td>
                    <span class="badge bg-success">Completed</span>
                </td>
                <td>$250</td>
            </tr>

            <tr>
                <td>#1026</td>
                <td>John Smith</td>
                <td>
                    <span class="badge bg-warning">Pending</span>
                </td>
                <td>$120</td>
            </tr>

            <tr>
                <td>#1027</td>
                <td>Sarah Ali</td>
                <td>
                    <span class="badge bg-danger">Cancelled</span>
                </td>
                <td>$80</td>
            </tr>

        </tbody>

    </table>

</div>
```

</div>

@endsection
