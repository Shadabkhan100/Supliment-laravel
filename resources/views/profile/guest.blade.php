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
.userSideX9{ padding:26px; }

.userAvatarX9{
    width:92px;height:92px;border-radius:50%;
    background:linear-gradient(135deg,#9eef0b,#7ad900);
    color:#000;display:flex;align-items:center;justify-content:center;
    font-size:30px;font-weight:800;margin:auto;
}

.userNameX9{color:#fff;font-size:18px;font-weight:700;margin-top:14px;text-align:center;}
.userEmailX9{color:#a3a3a3;font-size:13px;text-align:center;}

/* ================= MENU ================= */
.userMenuX9{
    margin-top:25px;display:flex;flex-direction:column;gap:8px;
}

.userMenuItemX9{
    display:flex;align-items:center;gap:12px;
    padding:13px 14px;border-radius:12px;
    background:transparent;color:#e5e5e5;
    border:1px solid transparent;
    cursor:pointer;transition:0.25s ease;
    font-size:14px;text-decoration:none;
}

.userMenuItemX9 i{width:18px;color:#9eef0b;}

.userMenuItemX9:hover{
    background:rgba(158,239,11,0.08);
    transform:translateX(6px);
    color:#9eef0b;
}

.userMenuItemX9.active{
    background:#9eef0b;color:#000;font-weight:700;
}

/* ================= CONTENT ================= */
.userContentX9{padding:30px;min-height:650px;}
.userTitleX9{color:#fff;font-size:26px;font-weight:800;margin-bottom:25px;}

/* ================= STATS ================= */
.userStatX9{
    background:rgba(255,255,255,0.03);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:16px;padding:22px;
}

.userStatNumX9{font-size:32px;font-weight:800;color:#9eef0b;}
.userStatTextX9{color:#bdbdbd;font-size:13px;}

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
        <div class="userAvatarX9">
            {{ strtoupper(substr($user->name,0,1)) }}
        </div>
        <div class="userNameX9">{{ $user->name }}</div>
        <div class="userEmailX9">{{ $user->email }}</div>
    </div>

    <div class="userMenuX9">
        <div class="userMenuItemX9 active tab-btn" data-tab="dashboard">
            <i class="fas fa-chart-line"></i> Dashboard
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

        <a class="userMenuItemX9 text-danger" href="{{ url('/login') }}">
            <i class="fas fa-sign-out-alt"></i> Register
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

</div>

<!-- ORDERS -->
<div class="tab-content hideX9" id="orders">

<div class="userTitleX9">My Orders</div>

<div class="ordersGridX9" id="ordersGrid"></div>

</div>

<!-- SETTINGS -->
<div class="tab-content hideX9" id="settings">
<div class="userTitleX9">Settings</div>

<div class="userStatX9">
<button class="userBtnX9">Change Password</button>
</div>

</div>

</div>
</div>

</div>
</div>
<!-- ================= ORDER MODAL ================= -->
<div id="orderModalX9" class="orderModalX9">

    <div class="orderModalHeaderX9">
        <h4>Order Details</h4>
        <button id="closeOrderModalX9">×</button>
    </div>

    <div class="orderModalBodyX9" id="orderModalBodyX9"></div>

</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {

const tabs = document.querySelectorAll('.tab-btn');
const sections = document.querySelectorAll('.tab-content');

tabs.forEach(tab=>{
tab.addEventListener('click',function(){
tabs.forEach(t=>t.classList.remove('active'));
this.classList.add('active');

let target=this.dataset.tab;
sections.forEach(sec=>{
sec.classList.toggle('hideX9',sec.id!==target);
});
});
});

const orders = @json($orders ?? []);

window.guestOrders = orders;

updateStats(orders);
renderOrders(orders);

// ================= STATS =================
function updateStats(data){
    
    document.getElementById('totalOrders').innerText = data.length;

    document.getElementById('shippedOrders').innerText =
        data.filter(o => o.order_status === 'Shipped').length;

    document.getElementById('deliveredOrders').innerText =
        data.filter(o => o.order_status === 'Delivered').length;
}

// ================= ORDERS =================
function renderOrders(data){
    console.log(data);

    const grid = document.getElementById('ordersGrid');
    grid.innerHTML = '';

    if (!data || !data.length) {
        grid.innerHTML = `<div class="userEmptyX9">No orders found</div>`;
        return;
    }

    data.forEach(o => {

        const opt = (o.product_option && !Array.isArray(o.product_option))
            ? o.product_option
            : {};

        // ✅ FINAL SOURCE OF TRUTH = backend product object
        const product = o.product || {};

        const image = opt.image || product.image || '/images/placeholder.jpg';
        const price = opt.price || product.price || '-';
        const name  = product.name || 'Product';

        const encodedOrder = encodeURIComponent(JSON.stringify(o));

        grid.innerHTML += `
<div class="orderCardX9" style="position:relative;">

    <div
        style="
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
        data-order="${encodedOrder}"
    >
        <i class="fas fa-eye"></i>
    </div>

    <img
        src="${image}"
        class="orderImgX9"
        onerror="this.src='/images/placeholder.jpg'"
    >

    <div class="orderInfoX9">

        <div class="orderTitleX9">
            ${name}
        </div>

        <div class="orderMetaX9">
            Order #${o.order_id}
        </div>

        <div class="orderMetaX9">
            ${o.city || ''} - ${o.address1 || ''}
        </div>

        <div class="orderPriceX9">
         <span class="orderBadgeX9 ${
        o.payment_status ? 'badge-delivered' : 'badge-processing'
    }"
    style="
        font-size:10px;
        background:${o.payment_status ? '#22c55e' : '#ef4444'};
        color:#fff;
    ">
        ${o.payment_status ? 'Paid' : 'Pending'}  ₹ ${price}
    </span>
        </div>

        <span class="orderBadgeX9 ${
            o.order_status === 'Shipped' ? 'badge-shipped' :
            o.order_status === 'Delivered' ? 'badge-delivered' :
            'badge-processing'
        }"
        style="
            position:absolute;
            bottom:10px;
            right:10px;
            font-size:10px;
        ">
            ${o.order_status || 'Pending'}
        </span>

    </div>

</div>
        `;
    });
}
});

document.addEventListener("click", function(e){

    const btn = e.target.closest(".orderViewBtnX9");
    if(!btn) return;

    const order = JSON.parse(decodeURIComponent(btn.dataset.order));

    openOrderModal(order);
});

function openOrderModal(o){

    const opt = (o.product_option && !Array.isArray(o.product_option))
    ? o.product_option
    : {};
  const image = (opt.image)
    ? opt.image
    : o.product?.image || o.product_image || '/images/placeholder.png';
const price = (opt.price)
    ? opt.price
    : o.product?.price || o.product_price || '-';
  const name  = o.product.name || 'Product';
    document.getElementById("orderModalBodyX9").innerHTML = `
        
        <!-- TOP PRODUCT ROW -->
        <div style="
            display:flex;
            gap:12px;
            background:rgba(255,255,255,0.04);
            padding:12px;
            border-radius:12px;
            align-items:center;
            margin-bottom:12px;
        ">

            <!-- SMALL IMAGE -->
            <img src="${image}"
                style="
                    width:70px;
                    height:70px;
                    object-fit:cover;
                    border-radius:10px;
                    flex-shrink:0;
                ">

            <!-- INFO -->
            <div style="flex:1;">

                <div style="font-size:14px;font-weight:700;color:#fff;">
                    ${name}
                </div>

                <div style="font-size:12px;color:#aaa;margin-top:3px;">
                    Order #${o.order_id} • ${o.city || '-'}
                </div>

                <div style="margin-top:6px;font-size:14px;color:#9eef0b;font-weight:700;">
                     ${opt.price || o.product_price || '-'}
                </div>

            </div>

            <!-- STATUS -->
            <div style="
                font-size:11px;
                padding:4px 8px;
                border-radius:8px;
                background:${
                    o.order_status === 'Shipped' ? '#3b82f6' :
                    o.order_status === 'Delivered' ? '#22c55e' :
                    '#ffb020'
                };
                color:#000;
                font-weight:700;
                white-space:nowrap;
            ">
                ${o.order_status || 'Pending'}
            </div>

        </div>

        <!-- DETAILS ROW -->
        <div style="
            background:rgba(255,255,255,0.04);
            padding:12px;
            border-radius:12px;
        ">

            <div style="margin-bottom:8px;color:#aaa;font-size:12px;">
                Customer Info
            </div>

            <div style="font-size:13px;color:#fff;margin-bottom:6px;">
                📞 ${o.phone || '-'}
            </div>

            <div style="font-size:13px;color:#fff;margin-bottom:6px;">
                📍 ${o.address1 || '-'}
            </div>

            <div style="font-size:13px;color:#fff;">
                🌍 ${o.country || '-'}
            </div>
            <div style="font-size:13px;color:#fff;">
                🌍 ${o.created_at ? new Date(o.created_at).toLocaleDateString('en-GB', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
}) : '-'}
            </div>

        </div>

    `;

    document.getElementById("orderModalX9").classList.add("active");
}

document.getElementById("closeOrderModalX9").addEventListener("click", function(){
    document.getElementById("orderModalX9").classList.remove("active");
});
</script>


@endsection

