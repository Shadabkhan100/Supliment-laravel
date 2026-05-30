{{-- resources/views/admin/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <style>
        body{
            background:#f5f7fb;
            font-family:Arial, Helvetica, sans-serif;
        }

        .admin-wrapper{
            display:flex;
            min-height:100vh;
        }

        /* SIDEBAR */
        .sidebar{
            width:280px;
            background:#111827;
            color:#fff;
            padding:25px 20px;
            position:fixed;
            left:0;
            top:0;
            bottom:0;
            overflow-y:auto;
            transition:.3s;
            z-index:999;
        }

        .sidebar .logo{
            font-size:28px;
            font-weight:700;
            margin-bottom:35px;
            text-align:center;
        }

        .sidebar ul{
            padding:0;
            margin:0;
            list-style:none;
        }

        .sidebar ul li{
            margin-bottom:10px;
        }

        .sidebar ul li a{
            color:#d1d5db;
            text-decoration:none;
            display:flex;
            align-items:center;
            gap:12px;
            padding:14px 18px;
            border-radius:12px;
            transition:.3s;
            font-size:15px;
            font-weight:500;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active{
            background:#2563eb;
            color:#fff;
        }

        /* MAIN */
        .main-content{
            margin-left:280px;
            width:100%;
            padding:30px;
        }

        .topbar{
            background:#fff;
            padding:18px 25px;
            border-radius:18px;
            margin-bottom:30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        .topbar h3{
            margin:0;
            font-size:26px;
            font-weight:700;
        }

        .admin-user{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .admin-user img{
            width:45px;
            height:45px;
            border-radius:50%;
            object-fit:cover;
        }

        /* CARDS */
        .dashboard-card{
            background:#fff;
            border-radius:20px;
            padding:25px;
            position:relative;
            overflow:hidden;
            box-shadow:0 3px 15px rgba(0,0,0,0.05);
            transition:.3s;
            height:100%;
        }

        .dashboard-card:hover{
            transform:translateY(-5px);
        }

        .dashboard-card .icon{
            width:60px;
            height:60px;
            border-radius:15px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:24px;
            color:#fff;
            margin-bottom:18px;
        }

        .bg-blue{ background:#2563eb; }
        .bg-green{ background:#10b981; }
        .bg-orange{ background:#f59e0b; }
        .bg-red{ background:#ef4444; }

        .dashboard-card h2{
            font-size:32px;
            font-weight:700;
            margin-bottom:5px;
        }

        .dashboard-card p{
            margin:0;
            color:#6b7280;
        }

        /* GRAPH */
        .graph-box{
            background:#fff;
            border-radius:20px;
            padding:25px;
            margin-top:30px;
            box-shadow:0 3px 15px rgba(0,0,0,0.05);
        }

        .graph{
            height:300px;
            display:flex;
            align-items:flex-end;
            gap:20px;
            margin-top:25px;
        }

        .bar{
            flex:1;
            border-radius:12px 12px 0 0;
            background:linear-gradient(to top,#2563eb,#60a5fa);
            position:relative;
        }

        .bar span{
            position:absolute;
            bottom:-30px;
            left:50%;
            transform:translateX(-50%);
            font-size:14px;
            color:#555;
        }

        /* TABLE */
        .table-box{
            background:#fff;
            padding:25px;
            border-radius:20px;
            margin-top:30px;
            box-shadow:0 3px 15px rgba(0,0,0,0.05);
        }

        .table thead{
            background:#f3f4f6;
        }

        .table th{
            border:none;
        }

        .table td{
            vertical-align:middle;
        }

        /* MOBILE */
        .menu-toggle{
            display:none;
            font-size:22px;
            cursor:pointer;
        }

        @media(max-width:991px){

            .sidebar{
                left:-100%;
            }

            .sidebar.active{
                left:0;
            }

            .main-content{
                margin-left:0;
            }

            .menu-toggle{
                display:block;
            }
        }
    </style>
</head>
<body>

<div class="admin-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">

        <div class="logo">
            ADMIN PANEL
        </div>

        <ul>
            <li>
                <a href="/admin/dashboard" class="active">
                    <i class="fa fa-dashboard"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="/admin/add-product">
                    <i class="fa fa-plus-circle"></i>
                    Add Product
                </a>
            </li>

            <li>
                <a href="/admin/add-category">
                    <i class="fa fa-list"></i>
                    Add Category
                </a>
            </li>

            <li>
                <a href="/admin/update-banner">
                    <i class="fa fa-image"></i>
                    Update Banner
                </a>
            </li>

            <li>
                <a href="/admin/future-products-management">
                    <i class="fa fa-cubes"></i>
                    Future Products
                </a>
            </li>

            <li>
                <a href="/admin/testimonialmanagement">
                    <i class="fa fa-comments"></i>
                    Testimonials
                </a>
            </li>

            <li>
                <a href="/admin/deals-management">
                    <i class="fa fa-tags"></i>
                    Deals Management
                </a>
            </li>

            <li>
                <a href="/admin/blogs-managements">
                    <i class="fa fa-pencil"></i>
                    Blogs Management
                </a>
            </li>
        </ul>

    </div>

    <!-- MAIN -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar">

            <div class="d-flex align-items-center gap-3">
                <div class="menu-toggle" id="menu-toggle">
                    <i class="fa fa-bars"></i>
                </div>

                <h3>Dashboard Overview</h3>
            </div>

            <div class="admin-user">
                <img src="https://i.pravatar.cc/100" alt="">
                <div>
                    <strong>Admin</strong>
                    <div class="text-muted small">Administrator</div>
                </div>
            </div>

        </div>

        <!-- CARDS -->
        <div class="row g-4">

            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">
                    <div class="icon bg-blue">
                        <i class="fa fa-shopping-cart"></i>
                    </div>

                    <h2>1,250</h2>
                    <p>Total Products</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">
                    <div class="icon bg-green">
                        <i class="fa fa-users"></i>
                    </div>

                    <h2>8,420</h2>
                    <p>Total Customers</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">
                    <div class="icon bg-orange">
                        <i class="fa fa-shopping-bag"></i>
                    </div>

                    <h2>950</h2>
                    <p>Total Orders</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
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

        </div>

        <!-- TABLE -->
        <div class="table-box">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Recent Orders</h4>

                <button class="btn btn-dark">
                    View All
                </button>
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
                                <span class="badge bg-success">
                                    Completed
                                </span>
                            </td>
                            <td>$250</td>
                        </tr>

                        <tr>
                            <td>#1026</td>
                            <td>John Smith</td>
                            <td>
                                <span class="badge bg-warning">
                                    Pending
                                </span>
                            </td>
                            <td>$120</td>
                        </tr>

                        <tr>
                            <td>#1027</td>
                            <td>Sarah Ali</td>
                            <td>
                                <span class="badge bg-danger">
                                    Cancelled
                                </span>
                            </td>
                            <td>$80</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!-- JS -->
<script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script>
    $('#menu-toggle').click(function(){
        $('#sidebar').toggleClass('active');
    });
</script>

</body>
</html>