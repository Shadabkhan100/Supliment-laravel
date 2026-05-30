@extends('layout.Main')

@section('content')
<!-- ERROR CONTAINER -->
            <section class="error-section">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-xl-5">
                            <div  class="error-text mb-48">
                                <h1 style="color:white">404</h1>
                            </div>
                            <h3 class="black2 fw-600 mb-16">Sorry, We Can’t Find That Page!</h3>
                            <p class="mb-32">It seems this page has moved or doesn’t exist. Head back to our homepage, or reach out if you need help!</p>
                            <a href="/" class="cus-btn-arrow m-auto">
                                Back to Home
                                <div class="icon">
                                    <i class="fa-thin fa-hand-point-left fa-rotate-90"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- ERROR CONTAINER -->

@endsection