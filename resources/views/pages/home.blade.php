@extends('layout.Main')

@section('content')
   
 <main class="main-wrapper">
  @include("modules.home-hero-banner")
  @include("modules.home-product-categories")
  @include("modules.deals-section")
  @include("modules.home-feature-products")
  @include("modules.newest-product")
  @include("modules.benefits-section")
@include("modules.sale-banner")
@include("modules.testimonials")
@include("modules.blog-section")
@include("modules.brand-slider")
 

 </main>

@endsection