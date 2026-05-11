<!-- FEATURE PRODUCTS START -->
<section class="feature-products py-40">
  <div class="container-fluid">

    <h2 class="fw-600 mb-8" style="color:#9eef0b;">Product Range</h2>

    <p class="mb-24" style="color: #bab4b4;">
      A curated wellbeing collection designed to elevate everyday rituals.
      Combining purposeful ingredients with a modern, refined approach,
      each product is created to restore, rebalance and inspire.
    </p>

    <div class="d-flex align-items-start justify-content-between flex-lg-row flex-column pb-40">

      <ul class="tabs list-unstyled">
        <li class="tab-link active" data-tab="1">Cleanse & Reset</li>
        <li class="tab-link" data-tab="2">Daily Energy</li>
        <li class="tab-link" data-tab="3">Peak Performance</li>
        <li class="tab-link" data-tab="4">Radiance & Beauty</li>
        <li class="tab-link" data-tab="5">Total Wellness</li>
        <li class="tab-link" data-tab="6">Restore & Renew</li>
      </ul>

      <a href="shop-grid-sidebar.html" class="cus-btn-arrow">
        See All Products
        <div class="icon">
          <i class="fa-light fa-chevron-right"></i>
        </div>
      </a>

    </div>

    <div class="content-wrapper">

      <div id="tab-1" class="tab-content active">

        <div class="slider-container">

          <div class="slider-arrows d-sm-flex d-none">

            <a href="javascript:;" class="sm-btn light arrow-btn btn-prev">
              <i class="fa-light fa-chevron-left"></i>
            </a>

            <a href="javascript:;" class="sm-btn light arrow-btn btn-next">
              <i class="fa-light fa-chevron-right"></i>
            </a>

          </div>

          <!-- IMPORTANT -->
          <div class="product-slider" id="productContainer">

            <!-- PRODUCTS WILL LOAD HERE -->

          </div>

        </div>

      </div>

    </div>

  </div>
</section>
<!-- FEATURE PRODUCTS END -->

<script>
async function loadProducts() {

  try {

    const response = await fetch('/api/get-all-product');
    const json = await response.json();

    const container = document.getElementById('productContainer');

    container.innerHTML = '';

    json.data.forEach(product => {

      const mainImage = product.main_image || '';

      const discountLabel = product.old_price
        ? `-${Math.round(((product.old_price - product.price) / product.old_price) * 100)}%`
        : '';

      const oldPriceHTML = product.old_price
        ? `<span class="h6 text-decoration-line-through dark-gray">$${product.old_price}</span>`
        : '';

      const productHTML = `

        <div class="product-block">

          <div class="image-box mb-16">

            <img src="${mainImage}" alt="${product.name}" />

            ${discountLabel
              ? `<div class="sale-label subtitle">${discountLabel}</div>`
              : ''
            }

            <div class="shopping-btns">

              <a href="#"
                 data-bs-toggle="modal"
                 data-bs-target="#productQuickView">

                <i class="fa-regular fa-eye"></i>

              </a>

              <a href="javascript:;">
                <i class="fa-light fa-heart"></i>
              </a>

              <a href="#"
                 data-bs-toggle="modal"
                 data-bs-target="#comparepopup">

                <svg xmlns="http://www.w3.org/2000/svg"
                     width="20"
                     height="20"
                     viewBox="0 0 20 20"
                     fill="none">

                  <path
                    d="M16.2238 20C16.0216 20 15.8197 19.922 15.6667 19.7665C15.3642 19.4588 15.3683 18.9642 15.676 18.6617L18.3019 16.0796"
                    fill="#141516">
                  </path>

                </svg>

              </a>

            </div>

          </div>

          <div class="content-box">

            <p class="eyebrow mb-12">
              ${product.category_name ?? 'Product'}
            </p>

            <a href="product-detail/${product.name}/${product.id}"
               class="product-title h6 fw-500 mb-12">

              ${product.name}

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

                ${oldPriceHTML}

                $${product.price}

              </h5>

              <a href="#"
                 class="sm-btn light"
                 data-bs-toggle="modal"
                 data-bs-target="#productQuickView">

                <svg xmlns="http://www.w3.org/2000/svg"
                     width="20"
                     height="20"
                     viewBox="0 0 20 20"
                     fill="none">

                  <path
                    d="M18.6356 17.8959C18.1471 14.4776 16.9554 6.13472"
                    class="fill-black">
                  </path>

                </svg>

              </a>

            </div>

          </div>

        </div>

      `;

      container.innerHTML += productHTML;

    });

    // REINITIALIZE SLIDER
    if ($('.product-slider').hasClass('slick-initialized')) {
      $('.product-slider').slick('unslick');
    }

    $('.product-slider').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      arrows: true,
      dots: false,
      infinite: true,
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 3
          }
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 1
          }
        }
      ]
    });

  } catch (error) {

    console.error('Error loading products:', error);

  }

}

loadProducts();
</script>