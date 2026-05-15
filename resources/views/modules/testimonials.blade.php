<!-- TESTIMONIALS START -->
<section class="testimonial-section py-40">
  <div class="container-fluid">

    <div class="d-flex align-content-end justify-content-between flex-sm-row flex-column gap-sm-0 gap-24 mb-48">
      <div>
        <h2 class="fw-600 black mb-12" style="color:#9eef0b;">Testimonials</h2>
        <p style="color:white;">Hear from our satisfied customers who’ve transformed their journey with us.</p>
      </div>
    </div>

    <div class="slider-container">

      <!-- DYNAMIC SLIDER -->
      <div class="testimonials-slider" id="testimonialsSlider">
        <!-- JS will inject testimonials here -->
      </div>

      <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
        <span class="slider__label sr-only"></span>
      </div>

    </div>
  </div>
</section>

<script>

const API_URL = "/api/testimonials";

/* =========================
   LOAD TESTIMONIALS
========================= */
function loadTestimonials() {

    $("#testimonialsSlider").html("");

    $.get(API_URL, function (data) {

        data.forEach(item => {

            let img = item.image ? item.image : '/images/user-1.png';

            let stars = "";

            for (let i = 0; i < (item.rating ?? 5); i++) {
                stars += `<i class="fa-solid fa-star-sharp color-quant"></i>`;
            }

            let html = `
                <div class="testimonials-block d-flex flex-column gap-32 bg-lightest-gray p-24 br-12">

                    <div class="d-flex flex-column gap-16">

                        <div class="d-flex align-items-center">
                            ${stars}
                        </div>

                        <p class="dark-gray">
                            “${item.message}”
                        </p>

                    </div>

                    <div class="d-flex align-items-center justify-content-between">

                        <div class="d-flex align-items-center gap-16">

                            <img src="${img}" alt="user" class="user-image" />

                            <div class="d-flex flex-column black">
                                <h6 class="mb-8">${item.name}</h6>
                                <p>${item.role ?? 'Customer'}</p>
                            </div>

                        </div>

                        <img src="images/quote.png" alt="quote" />

                    </div>

                </div>
            `;

            $("#testimonialsSlider").append(html);
        });

        /* REINIT SLICK AFTER DATA LOAD */
        if ($('.testimonials-slider').hasClass('slick-initialized')) {
            $('.testimonials-slider').slick('unslick');
        }

        $('.testimonials-slider').slick({
            dots: false,
            arrows: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 992,
                    settings: { slidesToShow: 2 }
                },
                {
                    breakpoint: 576,
                    settings: { slidesToShow: 1 }
                }
            ]
        });

    });
}

/* INIT */
$(document).ready(function () {
    loadTestimonials();
});

</script>
<!-- TESTIMONIALS END -->