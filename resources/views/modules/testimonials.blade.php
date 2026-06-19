<!-- TESTIMONIALS START -->

<style>
.testimonials-block {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.testimonial-text {
    min-height: 90px;
}
</style>

<section class="testimonial-section py-40">
  <div class="container-fluid">

    <div class="d-flex align-content-end justify-content-between flex-sm-row flex-column gap-sm-0 gap-24 mb-48">
      <div>
        <h2 class="fw-600 black mb-12" style="color:#9eef0b;">Testimonials</h2>
        <p style="color:white;">
          Hear from our satisfied customers who’ve transformed their journey with us.
        </p>
      </div>
    </div>

    <div class="slider-container">

      <!-- DYNAMIC SLIDER -->
      <div class="testimonials-slider" id="testimonialsSlider"></div>

      <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
        <span class="slider__label sr-only"></span>
      </div>

    </div>
  </div>
</section>

<!-- JS DEPENDENCIES -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/path/slick.min.js"></script>

<script>
const API_URL = "/api/testimonials";

/* =========================
   LOAD TESTIMONIALS
========================= */
function loadTestimonials() {

    $("#testimonialsSlider").html("");

    $.get(API_URL, function (data) {

        data.forEach(item => {

            let fullMessage = item.message ?? '';

            let shortMessage = fullMessage.length > 120
                ? fullMessage.substring(0, 120) + '...'
                : fullMessage;

            let stars = "";
            for (let i = 0; i < (item.rating ?? 5); i++) {
                stars += `<i class="fa-solid fa-star-sharp color-quant"></i>`;
            }

            let html = `
                <div class="testimonials-block d-flex flex-column gap-32 bg-lightest-gray p-24 br-12">

                    <div class="d-flex flex-column gap-16">

                        <div class="d-flex" style="justify-content: center;">
                            ${stars}
                        </div>

                        <p class="dark-gray testimonial-text" style="text-align:center">
                            <span class="short-text">${shortMessage}</span>
                            <span class="full-text" style="display:none;">${fullMessage}</span>

                            ${fullMessage.length > 120 ? `
                                <a href="javascript:void(0)" class="read-more"> Learn more</a>
                            ` : ''}
                        </p>

                    </div>

                    <hr class="qv-divider">

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex gap-16" style="margin: auto;">
                            <div class="d-flex flex-column black">
                                <h6 class="mb-8">${item.name}</h6>
                                <p>${item.role ?? 'Customer'}</p>
                            </div>
                        </div>
                    </div>

                </div>
            `;

            $("#testimonialsSlider").append(html);
        });

        /* =========================
           INIT / REINIT SLICK SAFELY
        ========================= */

        const $slider = $('.testimonials-slider');

        if ($slider.hasClass('slick-initialized')) {
            $slider.slick('unslick');
        }

        $slider.slick({
            dots: false,
            arrows: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,

            autoplay: true,
            autoplaySpeed: 2500,
            speed: 700,
            pauseOnHover: false,
            pauseOnFocus: false,

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

        $slider.slick('slickPlay');
    });
}

/* INIT */
$(document).ready(function () {
    loadTestimonials();
});

/* =========================
   READ MORE TOGGLE
========================= */
$(document).on('click', '.read-more', function () {

    let parent = $(this).closest('.testimonial-text');

    let shortText = parent.find('.short-text');
    let fullText = parent.find('.full-text');

    if (fullText.is(':visible')) {
        fullText.hide();
        shortText.show();
        $(this).text(' Learn more');
    } else {
        fullText.show();
        shortText.hide();
        $(this).text(' Show less');
    }

    $('.testimonials-slider').slick('setPosition');
});
</script>

<!-- TESTIMONIALS END -->