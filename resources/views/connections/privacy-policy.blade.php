@extends('layout.Main')

@section('content')

<main class="main-wrapper">

    <!-- FULL WIDTH IMAGE HERO (NO TITLE ABOVE) -->
    <section style="margin:0; padding:0px;">
        <img src="images/home/privacy.png"
             alt="Privacy Policy"
             style="width:100%; height:auto; display:block;">
    </section>

    <!-- CONTENT SECTION START -->
    <section class="faq-section py-40">
        <div class="container">

            <!-- INTRO BLOCK -->
            <div class="mb-40 text-center">
                <h2 class="fw-600 mb-12" style="color:#9eef0b;">
                    Your Privacy Matters
                </h2>
                <p style="color:#bab4b4; max-width:800px; margin:auto;">
                    We are committed to protecting your personal data and ensuring complete transparency in how your information is collected, used, and secured.
                </p>
            </div>

            <!-- GRID SECTION -->
            <div class="row">

                <!-- 1. DATA CONTROL -->
                <div class="col-md-6 mb-24">
                    <div class="p-3 h-100" style="background:#111; border-radius:12px;">
                        <h5 style="color:#9eef0b;">
                            <i class="fa fa-user-shield"></i> Your Data Control
                        </h5>
                        <p style="color:#bab4b4; margin-bottom:0;">
                            You have full rights over your personal data including access, updates, and deletion requests anytime.
                        </p>
                    </div>
                </div>

                <!-- 2. SECURITY -->
                <div class="col-md-6 mb-24">
                    <div class="p-3 h-100" style="background:#111; border-radius:12px;">
                        <h5 style="color:#9eef0b;">
                            <i class="fa fa-lock"></i> Secure Protection
                        </h5>
                        <p style="color:#bab4b4; margin-bottom:0;">
                            All data is stored using secure systems with encryption and strict access control measures.
                        </p>
                    </div>
                </div>

                <!-- 3. TRANSPARENCY -->
                <div class="col-md-6 mb-24">
                    <div class="p-3 h-100" style="background:#111; border-radius:12px;">
                        <h5 style="color:#9eef0b;">
                            <i class="fa fa-eye"></i> Transparency Policy
                        </h5>
                        <p style="color:#bab4b4; margin-bottom:0;">
                            We clearly define how your data is collected and used to improve your shopping experience.
                        </p>
                    </div>
                </div>

                <!-- 4. COOKIES -->
                <div class="col-md-6 mb-24">
                    <div class="p-3 h-100" style="background:#111; border-radius:12px;">
                        <h5 style="color:#9eef0b;">
                            <i class="fa fa-cookie-bite"></i> Cookies & Tracking
                        </h5>
                        <p style="color:#bab4b4; margin-bottom:0;">
                            Cookies help us improve website performance, analytics, and user experience.
                        </p>
                    </div>
                </div>

                <!-- 5. NO SHARING -->
                <div class="col-md-12 mb-24">
                    <div class="p-3" style="background:#0d0d0d; border-left:4px solid #9eef0b; border-radius:10px;">
                        <h5 style="color:#9eef0b;">
                            <i class="fa fa-ban"></i> No Data Selling or Sharing
                        </h5>
                        <p style="color:#bab4b4; margin-bottom:0;">
                            We do not sell, rent, or share your personal information with third parties without your consent under any circumstances.
                        </p>
                    </div>
                </div>

            </div>

            <!-- FOOT NOTE -->
            <div class="mt-32 text-center">
                <p style="color:#bab4b4;">
                    We regularly update our privacy practices to ensure full compliance with global data protection standards.
                </p>
            </div>

        </div>
    </section>

</main>

@endsection