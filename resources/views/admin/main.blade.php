<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
       <link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @yield('styles')
</head>
 <style>
     

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

<body>

<div class="admin-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">

        <div class="logo">
            ADMIN PANEL
        </div>

        <ul>
            <li>
                <a href="{{ url('/admin') }}">
                    <i class="fa fa-dashboard"></i>
                    Dashboard
                </a>
            </li>
            <li>
    <a href="{{ url('/admin/orders') }}">
        <i class="fa fa-shopping-cart"></i>
        Orders
    </a>
</li>

<li>
    <a href="{{ url('/admin/bundle-orders') }}">
        <i class="fa-solid fa-box-open"></i>
        Bundle Orders
    </a>
</li>



@if(Auth::check() && Auth::user()->status === 'admin')

<li>
    <a href="{{ url('/admin/users') }}">
        <i class="fa fa-users"></i>
        Users
    </a>
</li>
@endif
      <li>
                <a href="{{ url('/admin/add-product') }}">
                    <i class="fa fa-plus-circle"></i>
                    Add Product
                </a>
            </li>

            <li>
                <a href="{{ url('/admin/add-category') }}">
                    <i class="fa fa-list"></i>
                    Add Category
                </a>
            </li>

            <li>
                <a href="{{ url('/admin/update-banner') }}">
                    <i class="fa fa-image"></i>
                    Update Banner
                </a>
            </li>

            <li>
                <a href="{{ url('/admin/future-products-management') }}">
                    <i class="fa fa-cubes"></i>
                    Future Products
                </a>
            </li>

            <li>
                <a href="{{ url('/admin/testimonialmanagement') }}">
                    <i class="fa fa-comments"></i>
                    Testimonials
                </a>
            </li>

            <li>
                <a href="{{ url('/admin/deals-management') }}">
                    <i class="fa fa-tags"></i>
                    Deals Management
                </a>
            </li>

            <li>
                <a href="{{ url('/admin/blogs-managements') }}">
                    <i class="fa fa-pencil"></i>
                    Blogs Management
                </a>
            </li>

@if(Auth::check() && Auth::user()->status === 'admin')
<li>
    <a href="{{ url('/admin/settings') }}">
        <i class="fa fa-cog"></i>
        Settings
    </a>
</li>
@endif

<li>
    <a href="{{ url('/logout') }}">
        <i class="fa fa-sign-out"></i>
        Logout
    </a>
</li>
        </ul>

    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar">

            <div class="d-flex align-items-center gap-3">
                <div class="menu-toggle" id="menu-toggle">
                    <i class="fa fa-bars"></i>
                </div>

                <h3>@yield('page-title')</h3>
               
            </div>

            <div class="admin-user">
                <img src="https://i.pravatar.cc/100" alt="">
                <div>
                    <strong>{{ Auth::user()->name ?? 'Admin' }}</strong>
                    <div class="text-muted small">{{ Auth::user()->status ?? 'Admin' }}</div>
                </div>
            </div>

        </div>

        @yield('content')

    </div>

</div>

<script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<script>
    $('#menu-toggle').click(function(){
        $('#sidebar').toggleClass('active');
    });
</script>

@yield('scripts')

</body>
</html>