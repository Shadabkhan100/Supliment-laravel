@extends('layout.Main')

@section('content')

<style>
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

</style>

<div class="auth-wrapper">

    <div class="auth-box">

        <div class="auth-title">SLIMZA ACCOUNT</div>

        <div class="toggle-buttons">
            <button id="loginTab" class="active">Login</button>
            <button id="signupTab">Sign Up</button>
        </div>

        {{-- LOGIN FORM --}}
        <form method="POST" action="/login">
    @csrf

    <div class="input-group">
        <input type="email" name="email" placeholder="Email Address" required>
    </div>

    <div class="input-group">
        <input type="password" name="password" placeholder="Password" required>
    </div>

    <button type="submit" class="auth-btn">Login</button>
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

            <div class="input-group">
                <input type="password" id="password" placeholder="Password" required>
            </div>

            <div class="input-group">
                <input type="password" id="password_confirmation" placeholder="Confirm Password" required>
            </div>

            <button type="submit" class="auth-btn">Create Account</button>
        </form>

    </div>

</div>

<script>
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

// LOGIN API
loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const res = await fetch("/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            email: document.getElementById("login_email").value,
            password: document.getElementById("login_password").value
        })
    });

    const data = await res.json();
    alert(data.message || "Login response received");
});

// SIGNUP API
signupForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const res = await fetch("/api/signup-user", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
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
    alert(data.message || "Signup response received");
});
</script>
@include("modules.subscribe-us")
@endsection