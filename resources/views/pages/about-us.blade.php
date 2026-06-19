@extends('layout.Main')

@section('content')

<main class="main-wrapper">
  <section class="title-banner">
    <div class="container">
      <h2 class="white fw-600 text-center">About us</h2>
    </div>
  </section>



  <!-- ABOUT SLIMZA CONTENT START -->
  <section class="about-section py-40">
    <div class="container">

      <div class="about-box p-32 bg-white rounded-16 shadow-sm">

        <h2 class="fw-600 black mb-16">
          Premium Health & Wellbeing Products at Slimza
        </h2>

        <p class="mb-16">
          At Slimza, we believe that living well should feel simple, empowering, and sustainable.
          Our mission is to provide premium-quality health and wellbeing products that support
          healthier lifestyles, increased confidence, and everyday vitality.
        </p>

        <p class="mb-24">
          Whether you are starting your wellness journey or maintaining a balanced lifestyle,
          Slimza is here to support you with trusted products you can rely on.
        </p>

        <h5 class="fw-600 black mb-12">Our Commitment to Quality</h5>

        <ul class="mb-24">
          <li>Premium-quality health and wellbeing products</li>
          <li>Carefully selected ingredients and formulations</li>
          <li>Customer-focused service and support</li>
          <li>Dedication to wellness and healthy living</li>
          <li>Products designed for modern lifestyles</li>
        </ul>

        <h5 class="fw-600 black mb-12">Why Choose Slimza?</h5>

        <ul class="mb-24">
          <li>Trusted premium wellness products</li>
          <li>Focus on customer satisfaction</li>
          <li>Modern approach to health and wellbeing</li>
          <li>Reliable service and fast support</li>
          <li>Passion for helping customers feel their best</li>
        </ul>

        <div class="p-24 rounded-12" style="background:#f9fff0; border-left:4px solid #9eef0b;">
          <h6 class="fw-600 black mb-8">Supporting Your Wellness Journey</h6>
          <p class="mb-0">
            Health and wellbeing are ongoing journeys. Slimza helps you make positive lifestyle choices
            through premium wellness solutions and trusted support.
          </p>
        </div>

      </div>

    </div>
  </section>
  <!-- ABOUT SLIMZA CONTENT END -->

  @include('modules.benefits-section')
</main>

@endsection