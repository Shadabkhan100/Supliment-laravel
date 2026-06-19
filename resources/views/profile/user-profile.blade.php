@extends('layout.Main')

@section('content')

<style>
/* ================= ROOT WRAPPER ================= */
.userProfileWrapX9{
    padding:40px 0;
    background:transparent;
}

/* ================= GLASS PANEL ================= */
.userGlassX9{
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(255,255,255,0.08);
    backdrop-filter:blur(14px);
    border-radius:22px;
    overflow:hidden;
}

/* ================= SIDEBAR ================= */
.userSideX9{
    padding:26px;
}

.userAvatarX9{
    width:92px;
    height:92px;
    border-radius:50%;
    background:linear-gradient(135deg,#9eef0b,#7ad900);
    color:#000;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:30px;
    font-weight:800;
    margin:auto;
}

.userNameX9{
    color:#fff;
    font-size:18px;
    font-weight:700;
    margin-top:14px;
    text-align:center;
}

.userEmailX9{
    color:#a3a3a3;
    font-size:13px;
    text-align:center;
}

/* ================= MENU ================= */
.userMenuX9{
    margin-top:25px;
    display:flex;
    flex-direction:column;
    gap:8px;
}

.userMenuItemX9{
    display:flex;
    align-items:center;
    gap:12px;
    padding:13px 14px;
    border-radius:12px;
    background:transparent;
    color:#e5e5e5;
    border:1px solid transparent;
    cursor:pointer;
    transition:0.25s ease;
    font-size:14px;
    text-decoration:none;
}

.userMenuItemX9 i{
    width:18px;
    color:#9eef0b;
}

.userMenuItemX9:hover{
    background:rgba(158,239,11,0.08);
    transform:translateX(6px);
    color:#9eef0b;
}

.userMenuItemX9.active{
    background:#9eef0b;
    color:#000;
    font-weight:700;
}

.userMenuItemX9.active i{
    color:#000;
}

/* ================= CONTENT ================= */
.userContentX9{
    padding:30px;
    min-height:650px;
}

/* ================= TITLE ================= */
.userTitleX9{
    color:#fff;
    font-size:26px;
    font-weight:800;
    margin-bottom:25px;
}

/* ================= CARDS ================= */
.userStatX9{
    background:rgba(255,255,255,0.03);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:16px;
    padding:22px;
    transition:0.25s;
}

.userStatX9:hover{
    transform:translateY(-5px);
    border-color:#9eef0b;
}

.userStatNumX9{
    font-size:32px;
    font-weight:800;
    color:#9eef0b;
}

.userStatTextX9{
    color:#bdbdbd;
    font-size:13px;
}

/* ================= INFO ================= */
.userInfoBoxX9{
    background:rgba(255,255,255,0.03);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:16px;
    padding:20px;
}

.userInfoRowX9{
    display:flex;
    justify-content:space-between;
    padding:14px 0;
    border-bottom:1px solid rgba(255,255,255,0.06);
}

.userInfoRowX9:last-child{
    border-bottom:none;
}

.userLabelX9{
    color:#9eef0b;
    font-weight:600;
}

.userValueX9{
    color:#fff;
}

/* ================= EMPTY ================= */
.userEmptyX9{
    text-align:center;
    padding:70px 20px;
}

.userEmptyX9 i{
    font-size:55px;
    color:#9eef0b;
    margin-bottom:12px;
}

.userEmptyX9 h4{
    color:#fff;
}

.userEmptyX9 p{
    color:#9ca3af;
}

/* ================= BUTTON ================= */
.userBtnX9{
    background:#9eef0b;
    color:#000;
    border:none;
    padding:10px 18px;
    border-radius:10px;
    font-weight:700;
    cursor:pointer;
}

/* ================= HIDE ================= */
.hideX9{
    display:none !important;
}


.profileDrawerX9{
    position:fixed;
    left:0;
    right:0;
    bottom:-100%;
    height:88vh;
    background:#0f1115;
    z-index:99999;
    transition:.4s ease;
    overflow-y:auto;
    padding:40px;
}

.profileDrawerX9.show{
    bottom:0;
}

.drawerOverlayX9{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.6);
    opacity:0;
    visibility:hidden;
    transition:.3s;
    z-index:99998;
}

.drawerOverlayX9.show{
    opacity:1;
    visibility:visible;
}

.drawerHeaderX9{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.drawerHeaderX9 h4{
    color:#fff;
    margin:0;
    font-size:28px;
    font-weight:800;
}

.drawerHeaderX9 button{
    border:none;
    background:none;
    color:#fff;
    font-size:24px;
}

.profileInputX9{
    background:#181c23 !important;
    border:1px solid rgba(255,255,255,.1) !important;
    color:#fff !important;
    min-height:52px;
}

.profileInputX9:focus{
    border-color:#9eef0b !important;
    box-shadow:none !important;
}

.drawerFooterX9{
    margin-top:35px;
}

.updateBtnX9{
    width:100%;
    height:55px;
    border:none;
    border-radius:12px;
    background:#9eef0b;
    color:#000;
    font-weight:800;
}

.updateBtnX9:disabled{
    opacity:.45;
    cursor:not-allowed;
}

.userAvatarWrapperX9{
    position:relative;
    width:92px;
    height:92px;
    margin:auto;
}

.userAvatarImgX9{
    width:92px;
    height:92px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #9eef0b;
}

.avatarEditBtnX9{
    position:absolute;
    bottom:0;
    right:-4px;
    width:30px;
    height:30px;
    border-radius:50%;
    background:#9eef0b;
    color:#000;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    font-size:12px;
}

.avatarSaveBtnX9{
    position:absolute;
    top:-8px;
    right:-8px;
    width:30px;
    height:30px;
    border:none;
    border-radius:50%;
    background:#28a745;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
}


/* ================= ORDERS ================= */
.ordersGridX9{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
    gap:16px;margin-top:20px;
}

.orderCardX9{
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:16px;
    padding:14px;
    display:flex;
    gap:12px;
    transition:0.25s;
}

.orderCardX9:hover{
    transform:translateY(-4px);
    border-color:#9eef0b;
}

.orderImgX9{
    width:70px;height:70px;border-radius:12px;
    object-fit:cover;background:#222;
}

.orderTitleX9{font-size:14px;font-weight:700;color:#fff;}
.orderMetaX9{font-size:12px;color:#aaa;margin-top:3px;}
.orderPriceX9{margin-top:6px;color:#9eef0b;font-weight:700;}

.orderBadgeX9{
    display:inline-block;
    padding:3px 8px;
    border-radius:8px;
    font-size:11px;
    margin-top:6px;
}

.badge-processing{background:#ffb020;color:#000;}
.badge-shipped{background:#3b82f6;color:#fff;}
.badge-delivered{background:#22c55e;color:#000;}

/* ================= HIDE ================= */
.hideX9{display:none!important;}

.userEmptyX9{
    text-align:center;padding:70px 20px;color:#fff;
}

/* ================= BOTTOM SHEET MODAL ================= */
.orderModalX9{
    position:fixed;
    left:0;
    right:0;
    bottom:0;
    height:85vh;
    background:rgba(10,10,10,0.98);
    border-top-left-radius:18px;
    border-top-right-radius:18px;
    z-index:99999;

    transform:translateY(100%);
    transition:0.3s ease;

    display:flex;
    flex-direction:column;
}

.orderModalX9.active{
    transform:translateY(0);
}

.orderModalHeaderX9{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:16px 20px;
    border-bottom:1px solid rgba(255,255,255,0.08);
    color:#fff;
}

.orderModalHeaderX9 button{
    background:none;
    border:none;
    font-size:28px;
    color:#fff;
    cursor:pointer;
}

.orderModalBodyX9{
    padding:20px;
    overflow:auto;
    color:#fff;
}

</style>

<main class="main-wrapper">

<div class="container userProfileWrapX9">

    <div class="row g-4">

        <!-- LEFT -->
        <div class="col-lg-3">

            <div class="userGlassX9 userSideX9">

                <div class="text-center">

                   <div class="userAvatarWrapperX9">

    @if(!empty($user->avatar))
        <img
            id="profilePreviewX9"
            src="{{ asset($user->avatar) }}"
            class="userAvatarImgX9">
    @else
        <div id="profilePreviewX9" class="userAvatarX9">
            {{ strtoupper(substr($user->name,0,1)) }}
        </div>
    @endif

    <label for="profilePhotoInputX9" class="avatarEditBtnX9">
        <i class="fas fa-pen"></i>
    </label>

    <button
        type="button"
        id="avatarSaveBtnX9"
        class="avatarSaveBtnX9"
        style="display:none;">
        <i class="fas fa-check"></i>
    </button>

    <input
        type="file"
        id="profilePhotoInputX9"
        accept="image/*"
        hidden>

</div>

                    <div class="userNameX9">
                        {{ $user->name }}
                    </div>

                    <div class="userEmailX9">
                        {{ $user->email }}
                    </div>

                </div>

                <div class="userMenuX9">

                    <div class="userMenuItemX9 active tab-btn" data-tab="dashboard">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </div>

                    <div class="userMenuItemX9 tab-btn" data-tab="personal">
                        <i class="fas fa-user"></i> Personal Info
                    </div>

                    <a class="userMenuItemX9" href="/cart">
                        <i class="fas fa-shopping-cart"></i> Cart Items
                    </a>

                    <div class="userMenuItemX9 tab-btn" data-tab="orders">
                        <i class="fas fa-box"></i> Orders
                    </div>

                    <div class="userMenuItemX9 tab-btn" data-tab="settings">
                        <i class="fas fa-cog"></i> Settings
                    </div>

                    <a class="userMenuItemX9 text-danger" href="{{ url('/logout') }}">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="col-lg-9">

            <div class="userGlassX9 userContentX9">

                <!-- DASHBOARD -->
                <div class="tab-content" id="dashboard">

                    <div class="userTitleX9">Dashboard</div>

                    <div class="row g-4">

                        <div class="col-md-4">
                            <div class="userStatX9">
                                <div class="userStatNumX9">{{ $cartItems->count() }}</div>
                                <div class="userStatTextX9">Cart Items</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="userStatX9">
                                <div class="userStatNumX9">Active</div>
                                <div class="userStatTextX9">Account Status</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="userStatX9">
                                <div class="userStatNumX9">
                                    {{ $user->created_at->format('Y') }}
                                </div>
                                <div class="userStatTextX9">Member Since</div>
                            </div>
                        </div>

                    </div>

  <div class="row g-4 my-3" id="orderCardsInfo">

<div class="col-md-4">
<div class="userStatX9">
<div class="userStatNumX9" id="totalOrders">0</div>
<div class="userStatTextX9">Total Orders</div>
</div>
</div>

<div class="col-md-4">
<div class="userStatX9">
<div class="userStatNumX9" id="shippedOrders">0</div>
<div class="userStatTextX9">Shipped Orders</div>
</div>
</div>

<div class="col-md-4">
<div class="userStatX9">
<div class="userStatNumX9" id="deliveredOrders">0</div>
<div class="userStatTextX9">Delivered Orders</div>
</div>

</div>
</div>


<div class="row g-4 my-4" id="analyticsBoxX9">

    <div class="col-md-6">
        <div class="userStatX9">
            <canvas id="orderStatusChartX9"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div class="userStatX9">
            <canvas id="orderTrendChartX9"></canvas>
        </div>
    </div>

</div>
                </div>

                <!-- PERSONAL -->
                <div class="tab-content hideX9" id="personal">

                    <div class="userTitleX9">Personal Information</div>

                    <div class="userInfoBoxX9">

                        <div class="userInfoRowX9">
                            <div class="userLabelX9">Name</div>
                            <div class="userValueX9">{{ $user->name }}</div>
                        </div>

                        <div class="userInfoRowX9">
                            <div class="userLabelX9">Email</div>
                            <div class="userValueX9">{{ $user->email }}</div>
                        </div>

                        <div class="userInfoRowX9">
                            <div class="userLabelX9">Phone</div>
                            <div class="userValueX9">{{ $user->phone ?? 'N/A' }}</div>
                        </div>

                        <div class="userInfoRowX9">
                            <div class="userLabelX9">Country</div>
                            <div class="userValueX9">{{ $user->country ?? 'N/A' }}</div>
                        </div>

                        <div class="userInfoRowX9">
                            <div class="userLabelX9">Address</div>
                            <div class="userValueX9">{{ $user->address ?? 'N/A' }}</div>
                        </div>
                      
                    <div class="userInfoRowX9">
    <div class="userLabelX9">Date Of Birth</div>
    <div class="userValueX9">
        {{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format('d M Y') : 'N/A' }}
    </div>
</div>
                        
                         <div class="userInfoRowX9">
                            <div class="userLabelX9">Member Since</div>
                            <div class="userValueX9">{{ $user->created_at->format('d M Y') ?? 'N/A' }}</div>
                        </div>


                    </div>
                    <div class="userMenuItemX9 tab-btn" data-tab="editProfile">
    <i class="fas fa-user-edit"></i> Update Profile
</div>
                </div>

                <!-- ORDERS -->
                <div class="row g-4 my-3" id="orderCardsInfo">


<!-- ORDERS -->
<div class="tab-content hideX9" id="orders">

<div class="userTitleX9">My Orders</div>

<div class="ordersGridX9" id="ordersGrid"></div>
</div>






                <!-- SETTINGS -->
                <div class="tab-content hideX9" id="settings">

                    <div class="userTitleX9">Settings</div>

                    <div class="userInfoBoxX9">

                        <button class="userBtnX9">Change Password</button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<!-- UPDATE PROFILE DRAWER -->
<div class="profileDrawerX9" id="profileDrawerX9">

    <div class="drawerHeaderX9">
        <h4>Update Profile</h4>
        <button type="button" id="closeDrawerX9">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <form id="updateProfileFormX9">

        @csrf

        <div class="row g-4">

            <div class="col-md-6">
                <label>Name</label>
                <input
                    type="text"
                    class="form-control profileInputX9"
                    name="name"
                    value="{{ $user->name }}">
            </div>

            <div class="col-md-6">
                <label>Phone</label>
                <input
                    type="text"
                    class="form-control profileInputX9"
                    name="phone"
                    value="{{ $user->phone }}">
            </div>

            <div class="col-md-6">
                <label>Country</label>
                <input
                    type="text"
                    class="form-control profileInputX9"
                    name="country"
                    value="{{ $user->country }}">
            </div>

            <div class="col-md-6">
                <label>Date Of Birth</label>
                <input
                    type="date"
                    class="form-control profileInputX9"
                    name="dob"
                    value="{{ $user->dob }}">
            </div>

            <div class="col-12">
                <label>Address</label>
                <textarea
                    class="form-control profileInputX9"
                    rows="4"
                    name="address">{{ $user->address }}</textarea>
            </div>

            <div class="col-md-6">
                <label>Email</label>
                <input
                    type="email"
                    class="form-control"
                    value="{{ $user->email }}"
                    disabled>
            </div>

            <div class="col-md-6">
                <label>Member Since</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ $user->created_at->format('d M Y') }}"
                    disabled>
            </div>

        </div>

        <div class="drawerFooterX9">
            <button
                type="submit"
                class="updateBtnX9"
                id="updateBtnX9"
                disabled>
                Update Information
            </button>
        </div>

    </form>

</div>

<div class="drawerOverlayX9" id="drawerOverlayX9"></div>
<!-- ================= ORDER MODAL ================= -->
<div id="orderModalX9" class="orderModalX9">

    <div class="orderModalHeaderX9">
        <h4>Order Details</h4>
        <button id="closeOrderModalX9">×</button>
    </div>

    <div class="orderModalBodyX9" id="orderModalBodyX9"></div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

document.addEventListener('DOMContentLoaded', function(){

    const tabs = document.querySelectorAll('.tab-btn');
    const sections = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {

        tab.addEventListener('click', function(){

            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            let target = this.dataset.tab;

            sections.forEach(sec => {
                if(sec.id === target){
                    sec.classList.remove('hideX9');
                }else{
                    sec.classList.add('hideX9');
                }
            });

        });

    });

});


const drawer = document.getElementById('profileDrawerX9');
const overlay = document.getElementById('drawerOverlayX9');

document.querySelector('[data-tab="editProfile"]')
.addEventListener('click', () => {

    drawer.classList.add('show');
    overlay.classList.add('show');

});

document.getElementById('closeDrawerX9')
.addEventListener('click', closeDrawer);

overlay.addEventListener('click', closeDrawer);
const orderInfoBox = document.getElementById('orderCardsInfo');
function closeDrawer(){
    drawer.classList.remove('show');
    overlay.classList.remove('show');
}

const form = document.getElementById('updateProfileFormX9');
const btn = document.getElementById('updateBtnX9');

const initialData = new FormData(form);

form.addEventListener('input', function(){

    let changed = false;

    for(let [key,value] of initialData.entries()){

        const field = form.querySelector(`[name="${key}"]`);

        if(field && field.value != value){
            changed = true;
            break;
        }
    }

    btn.disabled = !changed;
});

form.addEventListener('submit', function(e){

    e.preventDefault();

    btn.disabled = true;
    btn.innerHTML = 'Updating...';

    fetch('/api/update-profile/{{ $user->id }}', {

        method:'POST',

        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Accept':'application/json'
        },

        body:new FormData(form)

    })
    .then(res => res.json())
    .then(response => {

        btn.innerHTML = 'Profile Updated';

    })
    .catch(() => {

        btn.innerHTML = 'Update Information';
        btn.disabled = false;

    });

});


const photoInput = document.getElementById('profilePhotoInputX9');
const saveBtn = document.getElementById('avatarSaveBtnX9');

let selectedFile = null;

photoInput.addEventListener('change', function () {

    const file = this.files[0];

    if (!file) return;

    selectedFile = file;

    const reader = new FileReader();

    reader.onload = function (e) {

        const currentPreview =
            document.getElementById('profilePreviewX9');

        const img = document.createElement('img');

        img.src = e.target.result;
        img.id = 'profilePreviewX9';
        img.className = 'userAvatarImgX9';

        currentPreview.parentNode.replaceChild(
            img,
            currentPreview
        );

        saveBtn.style.display = 'flex';
    };

    reader.readAsDataURL(file);

});


saveBtn.addEventListener('click', function () {

    if (!selectedFile) return;

    const formData = new FormData();

    formData.append('avatar', selectedFile);

    fetch('/api/update-profile/{{ $user->id }}', {

        method: 'POST',

        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },

        body: formData

    })
    .then(res => res.json())
    .then(data => {

        saveBtn.innerHTML = '<i class="fas fa-check"></i>';

        setTimeout(() => {
            saveBtn.style.display = 'none';
        }, 1000);

    });

});


document.addEventListener('DOMContentLoaded', function () {

    const tabs = document.querySelectorAll('.tab-btn');
    const sections = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {

            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            let target = this.dataset.tab;

            sections.forEach(sec => {
                sec.classList.toggle('hideX9', sec.id !== target);
            });
 // ✅ HIDE when orders tab is active
    if (target === 'orders') {
        if (orderInfoBox) orderInfoBox.style.display = 'none';
    } else {
        if (orderInfoBox) orderInfoBox.style.display = 'flex';
    }
        });
    });

    const orders = @json($orders ?? []);

    window.guestOrders = orders;

    console.log("RAW ORDERS FROM BACKEND:", orders);

    updateStats(orders);
    renderOrders(orders);
buildAnalytics(orders);
    // ================= STATS =================
    function updateStats(data){

        document.getElementById('totalOrders').innerText = data.length;

        document.getElementById('shippedOrders').innerText =
            data.filter(item => item.order.order_status === 'Shipped').length;

        document.getElementById('deliveredOrders').innerText =
            data.filter(item => item.order.order_status === 'Delivered').length;
    }

    // ================= ORDERS =================
    function renderOrders(data){

        const grid = document.getElementById('ordersGrid');
        grid.innerHTML = '';

        if(!data.length){
            grid.innerHTML = `<div class="userEmptyX9">No orders found</div>`;
            return;
        }

        data.forEach(item => {

            const order = item.order;
            const product = item.product;
            const option = order.option;

            grid.innerHTML += `
            <div class="orderCardX9" style="position:relative;">

                <div style="
                    position:absolute;
                    top:10px;
                    right:10px;
                    width:30px;
                    height:30px;
                    border-radius:8px;
                    background:rgba(0,0,0,0.4);
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    cursor:pointer;
                    color:#9eef0b;
                    z-index:2;
                "
                class="orderViewBtnX9"
                data-order='${btoa(JSON.stringify(item))}'>

                    <i class="fas fa-eye"></i>
                </div>

                <img src="${option?.image || product?.main_image || ''}" class="orderImgX9">

                <div class="orderInfoX9">

                    <div class="orderTitleX9">
                        ${product?.name || 'Product'}
                    </div>

                    <div class="orderMetaX9">
                        Order #${order.id}
                    </div>

                    <div class="orderMetaX9">
                        ${order.user?.city || ''}
                    </div>

                    <div class="orderPriceX9">
                        ₹ ${option?.price || product?.price || '-'}
                    </div>

                    <span class="orderBadgeX9 ${
                        order.order_status === 'Shipped' ? 'badge-shipped' :
                        order.order_status === 'Delivered' ? 'badge-delivered' :
                        'badge-processing'
                    }"
                    style="position:absolute;bottom:10px;right:10px;font-size:10px;">
                        ${order.order_status || 'Pending'}
                    </span>

                </div>

            </div>`;
        });
    }

});


document.addEventListener("click", function(e){

    const btn = e.target.closest(".orderViewBtnX9");
    if(!btn) return;

    const item = JSON.parse(atob(btn.dataset.order));

    const order = item.order;
    const product = item.product;
    const option = order.option;

    document.getElementById("orderModalBodyX9").innerHTML = `
    
        <div style="
            display:flex;
            gap:12px;
            background:rgba(255,255,255,0.04);
            padding:12px;
            border-radius:12px;
            align-items:center;
            margin-bottom:12px;
        ">

            <img src="${option?.image || product?.main_image || ''}"
                style="width:70px;height:70px;object-fit:cover;border-radius:10px;">

            <div style="flex:1;">

                <div style="font-size:14px;font-weight:700;color:#fff;">
                    ${product?.name || 'Product'}
                </div>

                <div style="font-size:12px;color:#aaa;margin-top:3px;">
                    Order #${order.id} • ${order.user?.city || '-'}
                </div>

                <div style="margin-top:6px;font-size:14px;color:#9eef0b;font-weight:700;">
                    ₹ ${option?.price || product?.price || '-'}
                </div>

            </div>

            <div style="
                font-size:11px;
                padding:4px 8px;
                border-radius:8px;
                background:${
                    order.order_status === 'Shipped' ? '#3b82f6' :
                    order.order_status === 'Delivered' ? '#22c55e' :
                    '#ffb020'
                };
                color:#000;
                font-weight:700;
            ">
                ${order.order_status || 'Pending'}
            </div>

        </div>

        <div style="
            background:rgba(255,255,255,0.04);
            padding:12px;
            border-radius:12px;
        ">

            <div style="font-size:13px;color:#fff;">📞 ${order.user?.phone || '-'}</div>
            <div style="font-size:13px;color:#fff;">📍 ${order.user?.address1 || '-'}</div>
            <div style="font-size:13px;color:#fff;">🌍 ${order.user?.country || '-'}</div>

        </div>
    `;

    document.getElementById("orderModalX9").classList.add("active");
});


document.getElementById("closeOrderModalX9").addEventListener("click", function(){
    document.getElementById("orderModalX9").classList.remove("active");
});


function buildAnalytics(data){

    const shipped = data.filter(o => o.order.order_status === 'Shipped').length;
    const delivered = data.filter(o => o.order.order_status === 'Delivered').length;
    const pending = data.filter(o => o.order.order_status === 'Pending').length;
    const processing = data.filter(o => o.order.order_status === 'Processing').length;

    // ================= PIE / DOUGHNUT =================
    new Chart(document.getElementById('orderStatusChartX9'), {
        type: 'doughnut',
        data: {
            labels: ['Delivered', 'Shipped', 'Pending', 'Processing'],
            datasets: [{
                data: [delivered, shipped, pending, processing],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // ================= BAR CHART =================
    new Chart(document.getElementById('orderTrendChartX9'), {
        type: 'bar',
        data: {
            labels: ['Total Orders', 'Shipped', 'Delivered', 'Pending'],
            datasets: [{
                label: 'Orders Overview',
                data: [
                    data.length,
                    shipped,
                    delivered,
                    pending
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}
</script>
@endsection