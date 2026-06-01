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

                    </div>

                </div>

                <!-- ORDERS -->
                <div class="tab-content hideX9" id="orders">

                    <div class="userTitleX9">Orders</div>

                    <div class="userEmptyX9">
                        <i class="fas fa-box-open"></i>
                        <h4>No Orders Yet</h4>
                        <p>Your order history will appear here.</p>
                    </div>

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

</main>

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
</script>

@endsection