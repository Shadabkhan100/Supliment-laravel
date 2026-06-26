@extends('layout.Main')

@section('content')

<div class="container" style="max-width:600px; margin-top:80px; text-align:center;">

    <div class="card p-4 shadow-lg">

        <h3 id="titleText" style="margin-bottom:20px;">
            Processing your payment...
        </h3>

        {{-- Progress Bar --}}
        <div class="progress" style="height:20px; border-radius:10px; overflow:hidden;">
            <div id="progressBar"
                 class="progress-bar progress-bar-striped progress-bar-animated"
                 role="progressbar"
                 style="width: 0%;">
            </div>
        </div>

        {{-- Percentage --}}
        <h4 id="percentText" style="margin-top:15px;">0%</h4>

        {{-- Subtitle --}}
        <p id="subText" style="margin-top:10px; color:gray;">
            Please wait while we confirm your payment...
        </p>

        {{-- Loader --}}
        <div id="loader" style="margin-top:20px;">
            <div class="spinner-border text-primary" role="status"></div>
        </div>

        {{-- Success Section --}}
        <div id="successBox" style="display:none; margin-top:20px;">
            <h4 style="color:green;">✔ Your order has been placed</h4>

            <p>
                Thank you for choosing <b>Slimza</b> for your dietary and supplement needs.
            </p>

            <a id="trackBtn"
               href="#"
               class="btn btn-success mt-3">
               Track Your Order
            </a>
        </div>

    </div>
</div>




@includes("modules.you-may-like")
<script>
document.addEventListener("DOMContentLoaded", function () {

    let progress = 0;

    const bar = document.getElementById("progressBar");
    const percentText = document.getElementById("percentText");
    const loader = document.getElementById("loader");
    const successBox = document.getElementById("successBox");
    const subText = document.getElementById("subText");
    const titleText = document.getElementById("titleText");
    const trackBtn = document.getElementById("trackBtn");

    // dynamic route based on login
    const isAuth = @json(auth()->check());

    const profileUrl = isAuth
        ? "/profile"
        : "/profile/guest-profile";

    trackBtn.href = profileUrl;

    function updateProgress(value) {
        bar.style.width = value + "%";
        percentText.innerText = value + "%";
    }

    let interval = setInterval(() => {

        progress += Math.floor(Math.random() * 12) + 5;

        if (progress >= 90) {
            progress = 100; // stop at 90 until backend done
            clearInterval(interval);
        }

        updateProgress(progress);

    }, 400);

    // simulate backend final confirmation delay
    setTimeout(() => {

        // complete progress
        progress = 100;
        updateProgress(progress);

        loader.style.display = "none";
        titleText.innerText = "Payment Completed Successfully";
        subText.innerText = "Your order is now confirmed and being processed.";

        successBox.style.display = "block";

    }, 2500);

});
</script>

@endsection