@extends('layout.Main')

@section('content')
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<style>
.auth-btn:disabled {
    opacity: .7;
    cursor: not-allowed;
}

.auth-btn i {
    margin-right: 8px;
}
.auth-wrapper{
    min-height: 100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background: radial-gradient(circle at top, #111, #000);
    padding:40px 15px;
}

.auth-box{
    width:100%;
    max-width:420px;
    background:#0f0f0f;
    border:1px solid rgba(255,255,255,0.08);
    border-radius:16px;
    padding:30px;
    box-shadow:0 10px 40px rgba(0,0,0,0.6);
    animation: fadeIn 0.6s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

.auth-title{
    text-align:center;
    color:#fff;
    font-size:22px;
    font-weight:600;
    margin-bottom:20px;
    letter-spacing:1px;
}

.toggle-buttons{
    display:flex;
    gap:10px;
    margin-bottom:20px;
}

.toggle-buttons button{
    flex:1;
    padding:10px;
    border:none;
    cursor:pointer;
    border-radius:8px;
    background:#1c1c1c;
    color:#aaa;
    transition:0.3s;
}

.toggle-buttons button.active{
    background:#9eef0b;
    color:#fff;
}

.input-group{
    margin-bottom:15px;
}

.input-group input{
    width:100%;
    padding:12px;
    border-radius:8px;
    border:1px solid rgba(255,255,255,0.1);
    background:#141414;
    color:#fff;
    outline:none;
}

.input-group input:focus{
    border-color:#9eef0b;
}

.auth-btn{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#9eef0b;
    color:#fff;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

.auth-btn:hover{
    background:#ff6a1a;
}

.hr-line{
    display:flex;
    align-items:center;
    text-align:center;
    margin:20px 0;
    color:#666;
    font-size:12px;
}

.hr-line::before,
.hr-line::after{
    content:"";
    flex:1;
    height:1px;
    background:rgba(255,255,255,0.1);
    margin:0 10px;
}

.hidden{
    display:none;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<div class="auth-wrapper">
<!-- GLOBAL LOADER -->
<div id="globalLoader" style="
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.6);
    z-index:9999;
    align-items:center;
    justify-content:center;
">
    <div style="
        width:50px;
        height:50px;
        border:4px solid #fff;
        border-top:4px solid #9eef0b;
        border-radius:50%;
        animation:spin 1s linear infinite;
    "></div>
</div>


    <div class="auth-box">

        <div class="auth-title">SLIMZA ACCOUNT</div>

        <div class="toggle-buttons">
            <button id="loginTab" class="active">Login</button>
            <button id="signupTab">Sign Up</button>
        </div>

       <form id="loginForm">
   

    <div class="input-group">
        <input type="email"
               id="login_email"
               name="email"
               placeholder="Email Address"
               required>
    </div>

    <div class="input-group">
        <input type="password"
               id="login_password"
               name="password"
               placeholder="Password"
               required>
    </div>

    <button type="submit" class="auth-btn" id="loginBtn">
    Login
</button>
 <button type="button"
        class="auth-btn"
        style="margin-top:10px; background:#1c1c1c; color:#aaa;"
        onclick="continueAsGuest()">
    Continue as Guest
</button>
</form>
        {{-- Divider --}}
        <div class="hr-line">OR</div>

        {{-- SIGNUP FORM --}}
        <form id="signupForm" class="hidden">
            <div class="input-group">
                <input type="text" id="name" placeholder="Full Name" required>
            </div>
            <div class="input-group">
                <input type="email" id="email" placeholder="Email Address" required>
            </div>

            <div class="input-group">
                <input type="number" id="phone" placeholder="Phone Number" required>
            </div>

          <!-- Password -->
<div class="input-group password-group">
    <input
        type="password"
        id="password"
        class="form-control"
        placeholder="Password"
        required>

    <span class="password-toggle" data-target="password">
        <i class="fa fa-eye"></i>
    </span>
</div>

<!-- Confirm Password -->
<div class="input-group password-group">
    <input
        type="password"
        id="password_confirmation"
        class="form-control"
        placeholder="Confirm Password"
        required>

    <span class="password-toggle" data-target="password_confirmation">
        <i class="fa fa-eye"></i>
    </span>
</div>
         
        <button type="submit" class="auth-btn" id="signupBtn">
    <span id="btnText">Create Account</span>
    <span id="btnPercent" style="margin-left:6px;">0%</span>
</button>
        </form>

    </div>

</div>

<script>

async function continueAsGuest()
{
    try {
        const response = await fetch('/api/ensure-guest-id', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok && data.guest_id) {

            // store guest id in cookie (1 year expiry)
            document.cookie = `guest_id=${data.guest_id}; path=/; max-age=${60 * 60 * 24 * 365}`;

            // redirect to shop
            window.location.href = "/profile/guest-profile";

        } else {
            alert(data.message || "Failed to continue as guest");
        }

    } catch (error) {
        console.error(error);
        alert("Something went wrong. Please try again.");
    }
}

function showLoader() {
    document.getElementById("globalLoader").style.display = "flex";
}

function hideLoader() {
    document.getElementById("globalLoader").style.display = "none";
}

// TAB SWITCH
const loginTab = document.getElementById('loginTab');
const signupTab = document.getElementById('signupTab');
const loginForm = document.getElementById('loginForm');
const signupForm = document.getElementById('signupForm');

loginTab.onclick = () => {
    loginTab.classList.add('active');
    signupTab.classList.remove('active');
    loginForm.classList.remove('hidden');
    signupForm.classList.add('hidden');
};

signupTab.onclick = () => {
    signupTab.classList.add('active');
    loginTab.classList.remove('active');
    signupForm.classList.remove('hidden');
    loginForm.classList.add('hidden');
};


async function getUserLocation() {

    return new Promise((resolve) => {

        if (!navigator.geolocation) {
            resolve(null);
            return;
        }

        navigator.geolocation.getCurrentPosition(
            async (position) => {

                try {

                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    const response = await fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`
                    );

                    const data = await response.json();

                    resolve({
                        latitude: lat,
                        longitude: lon,
                        location: data.display_name || null
                    });

                } catch (e) {

                    resolve(null);
                }
            },
            () => resolve(null)
        );
    });
}












// SIGNUP API
signupForm.addEventListener("submit", async (e) => {

    e.preventDefault();

    const btn = document.getElementById("signupBtn");
    const btnText = document.getElementById("btnText");
    const btnPercent = document.getElementById("btnPercent");

    const originalText = btnText.innerText;

    btn.disabled = true;
    btnText.innerText = "Creating Account";
    btnPercent.innerText = "0%";

    showLoader();

    // =========================
    // FAKE PROGRESS ANIMATION
    // =========================
    let progress = 0;

    const progressInterval = setInterval(() => {

        if (progress < 90) {
            progress += Math.floor(Math.random() * 10) + 1; // smooth random increment
            if (progress > 90) progress = 90;
            btnPercent.innerText = progress + "%";
        }

    }, 200);

    try {

        const res = await fetch("/signup-user", {
            method: "POST",
            headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                   "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                name: document.getElementById("name").value,
                email: document.getElementById("email").value,
                phone: document.getElementById("phone").value,
                password: document.getElementById("password").value,
                password_confirmation: document.getElementById("password_confirmation").value
            })
        });

        const data = await res.json();
       console.log(data);
        clearInterval(progressInterval);
        btnPercent.innerText = "100%";

        if (!res.ok) {

            btn.disabled = false;
            btnText.innerText = originalText;
            btnPercent.innerText = "0%";

            Swal.fire({
                icon: "error",
                title: "Error",
                text: data.message || "Signup failed"
            });

            return;
        }

        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "success",
            title: data.message,
            showConfirmButton: false,
            timer: 2500
        });

        setTimeout(() => {
            window.location.href = data.redirect || "/";
        }, 800);

    } catch (err) {
        console.log(err);
        clearInterval(progressInterval);

        Swal.fire({
            icon: "error",
            title: "Network Error",
            text: "Please try again"
        });

        btn.disabled = false;
        btnText.innerText = originalText;
        btnPercent.innerText = "0%";

    } finally {

        hideLoader();
    }
});







document.querySelectorAll('.password-toggle').forEach(toggle => {

    toggle.addEventListener('click', function () {

        const input = document.getElementById(this.dataset.target);
        const icon = this.querySelector('i');

        if (input.type === 'password') {

            input.type = 'text';

            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');

        } else {

            input.type = 'password';

            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');

        }

    });

});





const loginBtn = document.getElementById("loginBtn");

loginForm.addEventListener("submit", async function (e) {

    e.preventDefault();

    const originalText = loginBtn.innerHTML;

    loginBtn.disabled = true;
    loginBtn.innerHTML = `
        <i class="fas fa-spinner fa-spin"></i>
        Loading...
    `;

    try {

        const formData = new FormData(loginForm);

        // append location fields if they exist
        formData.append("latitude", selectedLat ?? "");
        formData.append("longitude", selectedLng ?? "");
        formData.append(
            "location",
            document.getElementById("selectedCoords")?.innerText || ""
        );

        const response = await fetch(loginForm.action, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {

            loginBtn.innerHTML = `
                <i class="fas fa-check"></i>
                Success
            `;

            setTimeout(() => {
                window.location.href = data.redirect;
            }, 300);

        } else {

            alert(data.message || "Login failed.");

            loginBtn.disabled = false;
            loginBtn.innerHTML = originalText;
        }

    } catch (error) {

        console.error(error);

        alert("Something went wrong. Please try again.");

        loginBtn.disabled = false;
        loginBtn.innerHTML = originalText;
    }

});

</script>
@include("modules.subscribe-us")
@endsection