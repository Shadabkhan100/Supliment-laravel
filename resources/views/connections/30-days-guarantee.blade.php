@extends('layout.Main')

@section('content')

<main class="main-wrapper">



    <!-- CONTENT SECTION START -->
    <section class="faq-section py-40">
        <div class="container">

            <!-- IMAGE -->
            <div class="mb-32 text-center">
                <img src="images/home/30-days.png"
                     alt="30 Days Guarantee"
                     style="max-width:100%; height:auto; border-radius:12px;">
            </div>

            <!-- INTRO -->
            <div class="mb-32">
                <h2 class="fw-600 mb-12" style="color:#9eef0b;">
                    Money Back Guarantee
                </h2>
                <p style="color:#bab4b4;">
                    Shop with confidence knowing your satisfaction is our priority.
                    We offer a simple and fair 30-day money-back guarantee on eligible purchases.
                </p>
            </div>

            <!-- DETAILS -->
            <div class="row">

                <div class="col-md-6 mb-24">
                    <div class="p-3" style="background:#111; border-radius:10px;">
                        <h5 style="color:#9eef0b;">
                            <i class="fa fa-shield"></i> Risk-Free Shopping
                        </h5>
                        <p style="color:#bab4b4; margin-bottom:0;">
                            Try our products with complete peace of mind. If you're not satisfied, you can request a refund.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 mb-24">
                    <div class="p-3" style="background:#111; border-radius:10px;">
                        <h5 style="color:#9eef0b;">
                            <i class="fa fa-calendar-check"></i> 30-Day Period
                        </h5>
                        <p style="color:#bab4b4; margin-bottom:0;">
                            The guarantee is valid for 30 days from the date you receive your order.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 mb-24">
                    <div class="p-3" style="background:#111; border-radius:10px;">
                        <h5 style="color:#9eef0b;">
                            <i class="fa fa-undo"></i> Easy Refund Process
                        </h5>
                        <p style="color:#bab4b4; margin-bottom:0;">
                            Simply contact our support team to initiate a quick and hassle-free refund request.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 mb-24">
                    <div class="p-3" style="background:#111; border-radius:10px;">
                        <h5 style="color:#9eef0b;">
                            <i class="fa fa-thumbs-up"></i> Customer First Policy
                        </h5>
                        <p style="color:#bab4b4; margin-bottom:0;">
                            We prioritize customer satisfaction and aim to resolve issues quickly and fairly.
                        </p>
                    </div>
                </div>

            </div>

            <!-- NOTE -->
            <div class="mt-32">
                <div class="p-3" style="background:#0d0d0d; border-left:4px solid #9eef0b;">
                    <p style="color:#bab4b4; margin-bottom:0;">
                        <strong style="color:#9eef0b;">Note:</strong> Refunds are processed after product verification and compliance with return conditions.
                    </p>
                </div>
            </div>

        </div>
    </section>

</main>

@endsection