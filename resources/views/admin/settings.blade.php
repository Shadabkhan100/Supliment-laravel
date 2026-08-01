@if(Auth::check() && Auth::user()->status === 'admin')

@extends('admin.main')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')

<div class="page-card">
   <style>


.drawer-panel{

    position:fixed;
    top:0;
    right:-100%;
    width:650px;
    max-width:100%;
    height:100vh;
    background:#f8fafc;
    display:flex;
    flex-direction:column;
    transition:.35s ease;
    z-index:999999;
    box-shadow:-15px 0 40px rgba(0,0,0,.15);

}

.drawer-panel.show{

    right:0;

}

.drawer-header{

    flex-shrink:0;

}

.drawer-content{

    flex:1;
    overflow:hidden;

    display:flex;
    flex-direction:column;

}
.drawer-title{

    display:flex;

    align-items:center;

    gap:15px;

}

.drawer-icon{

    width:50px;

    height:50px;

    border-radius:12px;

    background:#2563eb;

    color:#fff;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:22px;

}

.drawer-icon.admin{

    background:#16a34a;

}

.drawer-title h4{

    margin:0;

    font-size:20px;

    font-weight:700;

}

.drawer-title small{

    color:#888;

}

.drawer-close{

    width:42px;

    height:42px;

    border-radius:10px;

    border:none;

    background:#f3f4f6;

    transition:.25s;

}

.drawer-close:hover{

    background:#ef4444;

    color:#fff;

}

.drawer-overlay{

    opacity:0;

    visibility:hidden;

    transition:.35s;

}

.drawer-overlay.show{

    opacity:1;

    visibility:visible;

}
.setting-card{

    background:#fff;

    border-radius:18px;

    padding:25px;

    display:flex;

    align-items:center;

    gap:20px;

    cursor:pointer;

    transition:.3s;

    border:1px solid #e8e8e8;

    box-shadow:0 10px 30px rgba(0,0,0,.05);

}

.setting-card:hover{

    transform:translateY(-5px);

    box-shadow:0 18px 40px rgba(0,0,0,.12);

}

.setting-icon{

    width:70px;

    height:70px;

    border-radius:16px;

    background:#2563eb;

    color:#fff;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:28px;

}

.admin-icon{

    background:#16a34a;

}

.setting-content{

    flex:1;

}

.setting-content h4{

    font-weight:700;

    margin-bottom:8px;

}

.setting-content p{

    color:#666;

    margin:0;

}

.setting-arrow{

    font-size:30px;

    color:#bbb;

}

.drawer-overlay{

    position:fixed;

    inset:0;

    background:rgba(0,0,0,.45);

    display:none;

    z-index:9998;

}

.drawer-panel{

    position:fixed;
    top:0;
    right:-100%;
    width:650px;
    max-width:100%;
    height:100vh;
    background:#f8fafc;
    z-index:999999;
    transition:.35s ease;

    display:flex;
    flex-direction:column;

    box-shadow:-15px 0 40px rgba(0,0,0,.15);

}

.drawer-panel.show{

    right:0;

}

.drawer-header{

       padding: 10px 20px;
    justify-content: space-between;
    display: flex;
}


@keyframes drawerOpen{

from{

transform:translateX(60px);

opacity:.5;

}

to{

transform:translateX(0);

opacity:1;

}

}

.drawer-body{

    flex:1;

    overflow-y:auto;

    overflow-x:hidden;

    padding:25px;

    background:#f8fafc;

}

.drawer-footer{

    flex-shrink:0;

    background:#fff;

    border-top:1px solid #eee;

    padding:18px 25px;

    text-align:right;

}

.drawer-close{

    border:none;

    background:none;

    font-size:24px;

    cursor:pointer;

}

.drawer-body{

    padding:25px;

    overflow:auto;

    flex:1;

}

.drawer-card{

    background:#fff;

    border-radius:15px;

    padding:25px;

    border:1px solid #eee;

    box-shadow:0 8px 20px rgba(0,0,0,.05);

}



</style>

    <div class="row g-4">

        <!-- Website Information -->
        <div class="col-lg-6">

            <div class="setting-card" onclick="openDrawer('websiteDrawer')">

                <div class="setting-icon">
                    <i class="fa fa-globe"></i>
                </div>

                <div class="setting-content">

                    <h4>Manage Website Information</h4>

                    <p>
                        Update website title, logo, favicon, SEO information,
                        promotion text and general website settings.
                    </p>

                </div>

                <div class="setting-arrow">
                    <i class="fa fa-angle-right"></i>
                </div>

            </div>

        </div>

        <!-- Admin -->
        <div class="col-lg-6">

            <div class="setting-card" onclick="openDrawer('adminDrawer')">

                <div class="setting-icon admin-icon">
                    <i class="fa fa-user-shield"></i>
                </div>

                <div class="setting-content">

                    <h4>Manage Admin</h4>

                    <p>
                        Manage administrator information and account settings.
                    </p>

                </div>

                <div class="setting-arrow">
                    <i class="fa fa-angle-right"></i>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- Overlay -->

<div id="drawerOverlay" class="drawer-overlay"></div>

<!-- Website Drawer -->

<div id="websiteDrawer" class="drawer-panel">

    <!-- Header -->

    <div class="drawer-header">

        <div class="drawer-title">

            <div class="drawer-icon">
                <i class="fa fa-globe"></i>
            </div>

            <div>

                <h4>Website Information</h4>

                <small>Manage the website information</small>

            </div>

        </div>

        <button class="drawer-close" onclick="closeDrawer()">
            <i class="fa fa-times"></i>
        </button>

    </div>

    <!-- Body -->

    <div class="drawer-content">

        @include('admin.setting.manage-web')

    </div>

</div>

<!-- Admin Drawer -->

<div id="adminDrawer" class="drawer-panel">

   <div class="drawer-header">

    <div class="drawer-title">

        <div class="drawer-icon admin">

            <i class="fa fa-user-shield"></i>

        </div>

        <div>

            <h4>Admin Manager</h4>

            <small>Manage administrator information</small>

        </div>
      


    </div>

    <button class="drawer-close" onclick="closeDrawer()">
        <i class="fa fa-times"></i>
    </button>

</div>
  <div class="drawer-content">

        @include('admin.setting.add-admin')

    </div>
</div>




<div class="admin-card" style="margin-top:40px;">

    <div class="admin-header">

        <h4 class="mb-0">
            <i class="fa fa-user-shield text-primary"></i>
            Administrator Management
        </h4>

        <form method="GET">

            <div class="input-group admin-search">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Search Admin...">

                <button class="btn btn-primary">
                    <i class="fa fa-search"></i>
                </button>

            </div>

        </form>

    </div>

    <div class="table-responsive admin-table">

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Admin</th>

                    <th>Email</th>

                    <th>Rank</th>

                    <th>Created</th>

                    <th width="130">Action</th>

                </tr>

            </thead>

            <tbody>

            @forelse($admins as $admin)

                <tr>

                    <td>

                        {{ $admins->firstItem()+$loop->index }}

                    </td>

                    <td>

                        <div class="d-flex align-items-center">

                            <div class="table-avatar">

                                {{ strtoupper(substr($admin->name,0,1)) }}

                            </div>

                            <div class="ms-3">

                                <strong>{{ $admin->name }}</strong>

                            </div>

                        </div>

                    </td>

                    <td>

                        {{ $admin->email }}

                    </td>

                    <td>

                        @if($admin->status=="admin")

                            <span class="rank-admin">

                                Admin

                            </span>

                        @else

                            <span class="rank-sub">

                                Sub Admin

                            </span>

                        @endif

                    </td>

                    <td>

                        {{ $admin->created_at->format('d M Y') }}

                    </td>

                    <td>

            @if(Auth::id() != $admin->id)
    <a href="{{ url('delete/admin/'.$admin->id) }}"
       class="btn btn-sm btn-danger"
       onclick="return confirm('Are you sure you want to delete this administrator?');">

        <i class="fa fa-trash"></i>

    </a>
@endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center py-5">

                        <i class="fa fa-users fa-3x text-secondary mb-3"></i>

                        <br>

                        No administrators found.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-3">

        {{ $admins->links('pagination::bootstrap-5') }}

    </div>

</div>
<script>

let currentDrawer = null;

function openDrawer(id){

    closeDrawer();

    currentDrawer=document.getElementById(id);

    currentDrawer.classList.add('show');

    document.getElementById('drawerOverlay').classList.add('show');

    document.body.style.overflow='hidden';

}

function closeDrawer(){

    document.querySelectorAll('.drawer-panel').forEach(function(drawer){

        drawer.classList.remove('show');

    });

    document.getElementById('drawerOverlay').classList.remove('show');

    document.body.style.overflow='';

}

document.getElementById('drawerOverlay').addEventListener('click',closeDrawer);

document.addEventListener('keydown',function(e){

    if(e.key==="Escape"){

        closeDrawer();

    }

});


</script>


@endsection
@endif


