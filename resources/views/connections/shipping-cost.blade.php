@extends('layout.Main')

@section('content')

<main class="main-wrapper">

    <section class="title-banner">
        <div class="container">
            <h2 class="white fw-600 text-center">Shipping Cost</h2>
        </div>
    </section>

    <!-- CONTENT SECTION START -->
    <section class="faq-section py-40">
        <div class="container">

            <!-- IMAGE SECTION -->
            <div class="mb-32 text-center">
                <img src="/images/home/shipping.png" 
                     alt="Shipping Information" 
                     style="max-width:100%; height:auto; border-radius:12px;">
            </div>

            <!-- INTRO -->
            <div class="mb-32">
                <h2 class="fw-600 mb-12" style="color:#9eef0b;">
                    Shipping Information
                </h2>
                <p style="color:#bab4b4;">
                    We provide reliable, fast, and secure shipping services to ensure your order reaches you safely.
                    Our delivery system is designed to be transparent, affordable, and customer-friendly.
                </p>
            </div>

            <!-- DETAILS -->
            <div class="row">

                <div class="col-md-6 mb-24">
                    <div class="p-3" style="background:#111; border-radius:10px;">
                        <h5 style="color:#9eef0b;">
                            <i class="fa fa-truck"></i> Delivery Time
                        </h5>
                        <p style="color:#bab4b4; margin-bottom:0;">
                            Orders are usually processed within 24–48 hours and delivered in 3–7 business days depending on your location.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 mb-24">
                    <div class="p-3" style="background:#111; border-radius:10px;">
                        <h5 style="color:#9eef0b;">
                            <i class="fa fa-globe"></i> Coverage
                        </h5>
                        <p style="color:#bab4b4; margin-bottom:0;">
                            We deliver across all major regions with secure courier partners ensuring safe handling.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 mb-24">
                    <div class="p-3" style="background:#111; border-radius:10px;">
                        <h5 style="color:#9eef0b;">
                            <i class="fa fa-credit-card"></i> Shipping Cost
                        </h5>
                        <p style="color:#bab4b4; margin-bottom:0;">
                            Shipping charges are calculated at checkout based on your location and order size. We aim to keep it affordable.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 mb-24">
                    <div class="p-3" style="background:#111; border-radius:10px;">
                        <h5 style="color:#9eef0b;">
                            <i class="fa fa-shield"></i> Safe Packaging
                        </h5>
                        <p style="color:#bab4b4; margin-bottom:0;">
                            Every product is securely packed to prevent damage during transit and ensure premium delivery condition.
                        </p>
                    </div>
                </div>

            </div>

            <!-- NOTE -->
            <div class="mt-32">
                <div class="p-3" style="background:#0d0d0d; border-left:4px solid #9eef0b;">
                    <p style="color:#bab4b4; margin-bottom:0;">
                        <strong style="color:#9eef0b;">Note:</strong> Delivery times may vary during peak seasons or public holidays.
                    </p>
                </div>
            </div>

        </div>
    </section>

</main>

@endsection