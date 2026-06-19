@extends('layout.Main')

@section('content')
<style>
.banner-slide {
  position: relative;
}

.banner-slide img {
  width: 100%;
  height: clamp(180px, 40vw, 500px);
  object-fit: cover;
  display: block;
}

/* Dark overlay */
.banner-slide::after {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.75);
  z-index: 1;
}

/* Content */
.banner-content {
  text-align: center;
  position: absolute;
  top: 50%;
  left: 8%;
  transform: translateY(-50%);
  z-index: 2;
  color: #fff;
  max-width: 600px;
}

.banner-content h2 {
  font-size: clamp(28px, 4vw, 60px);
  font-weight: 700;
  margin-bottom: 15px;
  color: #9eef0b;
}

.banner-content p {
  font-size: clamp(14px, 1.3vw, 18px);
  line-height: 1.6;
  margin-bottom: 0;
  color: #f1f1f1;
}

@media (max-width: 768px) {
  .banner-content {
    left: 20px;
    right: 20px;
    max-width: 100%;
  }

  .banner-content h2 {
    font-size: 26px;
  }

  .banner-content p {
    font-size: 14px;
  }
}
</style>
<div class="banner-slider" id="bannerSlider"></div>
<div class="container py-4 px-3">


  <div class="row row-gap-3" id="productGrid">

    @foreach($products as $product)

    <div class="col-xl-3 col-lg-4 col-sm-6">
      <div class="product-block">

        <div class="image-box mb-16">

          <img src="{{ $product['main_image'] }}" alt="{{ $product['name'] }}" />

          @if(!empty($product['old_price']) && $product['old_price'] > $product['price'])
          <div class="sale-label subtitle">
            -{{ round((($product['old_price'] - $product['price']) / $product['old_price']) * 100) }}%
          </div>
          @endif

          <div class="shopping-btns">

            <a href="javascript:;" class="open-quick-view" data-bs-toggle="modal" data-bs-target="#productQuickView"
              data-product='@json($product)'>

              <i class="fa-regular fa-eye"></i>
            </a>

            <a href="javascript:;">
              <i class="fa-light fa-heart"></i>
            </a>


          </div>

        </div>

        <div class="content-box">

          <p class="eyebrow mb-12">
            {{ $product['category_name'] ?? 'Uncategorized' }}
          </p>

          <a href="/product-details/{{ strtolower(preg_replace('/-+/', '-', preg_replace('/[^a-z0-9\s-]/', '', preg_replace('/\s+/', '-', trim($product['name']))))) }}/{{ $product['id'] }}"
            class="product-title h6 fw-500 mb-12">
            {{ $product['name'] }}
          </a>

          <div class="d-flex align-items-center gap-8 mb-16">
            <p class="caption">
              <i class="fa-solid fa-star-sharp color-quant"></i>
              <i class="fa-solid fa-star-sharp color-quant"></i>
              <i class="fa-solid fa-star-sharp color-quant"></i>
              <i class="fa-solid fa-star-sharp color-quant"></i>
              <i class="fa-solid fa-star-sharp color-quant"></i>
            </p>
          </div>

          <div class="d-flex align-items-center justify-content-between">

            <h5 class="black">

              @if(!empty($product['old_price']) && $product['old_price'] > $product['price'])
              <span class="old-price h6 text-decoration-line-through dark-gray">
                {{ $product['old_price'] }}
              </span>
              @endif

              <span class="main-price">
                {{ $product['price'] }}
              </span>

            </h5>
         <a href="javascript:;"
   class="open-quick-view sm-btn light"
   data-bs-toggle="modal"
   data-bs-target="#productQuickView"
   data-product='{{ urlencode(json_encode($product)) }}'>

   <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
      <path
        d="M18.6356 17.8959C18.1471 14.4776 16.9554 6.13472 16.9554 6.13472C16.9141 5.84569 16.6666 5.63102 16.3746 5.63102H13.8194V3.70419C13.6313 -1.23661 6.54869 -1.23285 6.36241 3.70419V5.63102H3.80728C3.51533 5.63102 3.26784 5.84569 3.22654 6.13472C3.22654 6.13472 2.03482 14.4776 1.5463 17.8959C1.47062 18.4253 1.62823 18.9606 1.97862 19.3644C2.32901 19.7684 2.83657 20 3.37121 20H16.8107C17.3453 20 17.8528 19.7683 18.2033 19.3644C18.5536 18.9606 18.7113 18.4254 18.6356 17.8959Z
        M7.53575 3.70419C7.66462 0.318209 12.5184 0.320751 12.6461 3.70419V5.63102H7.53575V3.70419ZM17.317 18.5956C17.1896 18.7425 17.005 18.8267 16.8107 18.8267H3.37121C3.17683 18.8267 2.99231 18.7425 2.86489 18.5956C2.73755 18.4488 2.68029 18.2543 2.70779 18.0619C3.12415 15.1487 4.05121 8.65872 4.3161 6.80432H6.36245V8.10277C6.39132 8.88031 7.50716 8.87973 7.53575 8.10277V6.80432H12.6461V8.10277C12.675 8.88031 13.7908 8.87973 13.8194 8.10277V6.80432H15.8658C16.1307 8.65872 17.0578 15.1487 17.4741 18.0619C17.5016 18.2543 17.4443 18.4488 17.317 18.5956Z"
        class="fill-black">
      </path>
   </svg>

</a>
          </div>

        </div>

      </div>
    </div>

    @endforeach
  </div>

  <!-- Loader -->
  <div id="loader" style="text-align:center; display:none; padding:20px;">
    Loading more products...
  </div>

</div>
</div>
<script>
window.currencyConfig = @json(config('currency'));
window.currentCurrency = "{{ session('currency', 'GBP') }}";

function formatPrice(price) {

  const currency = window.currentCurrency || window.currencyConfig.default || "GBP";
  const config = window.currencyConfig?.currencies?. [currency];
  if (!config) return price;

  const converted = price * config.rate;

  return `${config.symbol} ${converted.toFixed(2)}`;
}

document.addEventListener('DOMContentLoaded', function() {

  document.querySelectorAll('.main-price').forEach(el => {
    const value = parseFloat(el.innerText);
    if (!isNaN(value)) {
      el.innerText = formatPrice(value);
    }
  });

  document.querySelectorAll('.old-price').forEach(el => {
    const value = parseFloat(el.innerText);
    if (!isNaN(value)) {
      el.innerHTML = formatPrice(value);
    }
  });

});
</script>

<script>
let page = 2;
let loading = false;
const banners = [{
    image: "/images/shop/ban-1.jpeg",
    title: "Premium Wellness Supplements",
    description: "Support your daily health with carefully selected vitamins, minerals, and nutritional supplements."
  },
  {
    image: "/images/shop/ban-2.jpeg",
    title: "Achieve Your Fitness Goals",
    description: "Discover weight management, sports nutrition, and wellness products designed for an active lifestyle."
  },
  {
    image: "/images/shop/ban-3.jpg",
    title: "Achieve Your Fitness Goals",
    description: "Discover weight management, sports nutrition, and wellness products designed for an active lifestyle."
  }
];

function renderBanners() {

  const slider = document.getElementById("bannerSlider");

  let html = "";

  banners.forEach(banner => {
    html += `
            <div class="banner-slide">
                <img src="${banner.image}" alt="${banner.title}">
                
                <div class="banner-content">
                    <h2>${banner.title}</h2>
                    <p>${banner.description}</p>
                </div>
            </div>
        `;
  });

  slider.innerHTML = html;
}

function initBannerSlider() {

  $('#bannerSlider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000,
    dots: true,
    arrows: false,
    infinite: true,
    fade: true,
    cssEase: 'linear'
  });

}
document.addEventListener("DOMContentLoaded", function() {

  renderBanners();

  // wait for DOM paint then init slick
  setTimeout(() => {
    initBannerSlider();
  }, 100);

});

function loadProducts() {

  if (loading) return;

  loading = true;
  $("#loader").show();

  $.ajax({
    url: "/api/get-all-product?page=" + page,
    type: "GET",

    success: function(res) {

      let products = res.data;

      if (!products || products.length === 0) {
        $("#loader").hide();
        loading = false;
        return;
      }

      products.forEach(product => {

        let html = `
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="product-block">

                        <div class="image-box mb-16">
                            <img src="${product.main_image}" />
                        </div>

                        <div class="content-box">

                            <p class="eyebrow mb-12">
                                ${product.category_name ?? 'Uncategorized'}
                            </p>

                            <h6>${product.name}</h6>

                            <h5 class="black">
                                <span class="main-price">
                                    ${formatPrice(product.price)}
                                </span>
                            </h5>

                        </div>

                    </div>
                </div>
                `;

        $("#productGrid").append(html);
      });

      page++;
      loading = false;
      $("#loader").hide();
    },

    error: function() {
      loading = false;
      $("#loader").hide();
      alert("Failed to load products");
    }
  });
}

window.addEventListener("scroll", function() {

  if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 200) {
    loadProducts();
  }
});
</script>

@endsection