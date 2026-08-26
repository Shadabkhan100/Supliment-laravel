<!-- FEATURE PRODUCTS START -->

<style>
.add-to-wishlist.active {
    background-color: #a4fd0c !important;
}

.add-to-wishlist.active i {
    color: #000 !important;
}


</style>
<section class="feature-products p-40">
  <div class="container-fluid">

    <h2 class="fw-600 mb-8" style="color:#9eef0b;">Product Range</h2>

    <p class="mb-24" style="color: #bab4b4;">
      A curated wellbeing collection designed to elevate everyday rituals.
      Combining purposeful ingredients with a modern, refined approach,
      each product is created to restore, rebalance and inspire.
    </p>

   @include("modules.searchTags")

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


<script>
window.currencyConfig = @json(config('currency'));
window.currentCurrency = "{{ session('currency', 'GBP') }}";

function formatPrice(price) {

  const currency = window.currentCurrency || window.currencyConfig.default || "GBP";

  const config = window.currencyConfig?.currencies?.[currency];

  if (!config) {
    console.warn("Currency not found:", currency);
    return `£ ${price}`;
  }

  const converted = price * config.rate;

  return `${config.symbol} ${converted.toFixed(2)}`;
}

async function loadProducts() {

  try {

    const response = await fetch('/api/get-all-product');
    const json = await response.json();

    const container = document.getElementById('productContainer');

    container.innerHTML = '';

    json.data.forEach(product => {

      const mainImage = product.main_image || '';
        const wishlist = JSON.parse(
          localStorage.getItem('wishlist') || '[]'
      );

      // Check if this product is already in wishlist
      const isInWishlist = wishlist.some(
          item => Number(item.id) === Number(product.id)
      );
      const discountLabel = product.old_price
        ? `-${Math.round(((product.old_price - product.price) / product.old_price) * 100)}%`
        : '';

      /* ✅ FIXED: moved inside loop + currency applied */
      const oldPriceHTML = product.old_price
        ? `<span class="h6 text-decoration-line-through dark-gray">
              ${formatPrice(product.old_price)}
           </span>`
        : '';

      const productHTML = `

        <div class="product-block">

          <div class="image-box mb-16">

           <a href="/product-details/${product.name
  .toLowerCase()
  .replace(/[^a-z0-9\s-]/g, '')
  .replace(/\s+/g, '-')
  .replace(/\s+/g, '-')
  .replace(/-+/g, '-')
  .trim()}/${product.id}">

  <img src="${mainImage}" alt="${product.name}" />

</a>

            ${discountLabel
              ? `<div class="sale-label subtitle">${discountLabel}</div>`
              : ''
            }

            <div class="shopping-btns">

             <a href="/product-details/${product.name
      .toLowerCase()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-')
      .trim()}/${product.id}"
             >

              <i class="fa-regular fa-eye"></i>
             </a>

   <a href="javascript:;" 
   class="add-to-wishlist ${isInWishlist ? 'active' : ''}"
   data-product='${encodeURIComponent(JSON.stringify(product))}'
   style="${isInWishlist ? 'background-color:#a4fd0c !important;' : ''}">
   
    <i class="${isInWishlist ? 'fa-solid' : 'fa-light'} fa-heart"
       style="${isInWishlist ? 'color:#000 !important;' : ''}">
    </i>

</a>

             
            </div>

          </div>

          <div class="content-box">

            <p class="eyebrow mb-12">
              ${product.category_name ?? 'Product'}
            </p>

          <a href="/product-details/${product.name
      .toLowerCase()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-')
      .trim()}/${product.id}"
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

                ${formatPrice(product.price)}

              </h5>



              <a href="#"
                 class="open-quick-view sm-btn light"
                 data-bs-toggle="modal"
                 data-bs-target="#productQuickView"
 data-product='${encodeURIComponent(JSON.stringify(product))}'
>

                <svg xmlns="http://www.w3.org/2000/svg"
                     width="20"
                     height="20"
                     viewBox="0 0 20 20"
                     fill="none">

                  <path
                    d="M18.6356 17.8959C18.1471 14.4776 16.9554 6.13472 16.9554 6.13472C16.9141 5.84569 16.6666 5.63102 16.3746 5.63102H13.8194V3.70419C13.6313 -1.23661 6.54869 -1.23285 6.36241 3.70419V5.63102H3.80728C3.51533 5.63102 3.26784 5.84569 3.22654 6.13472C3.22654 6.13472 2.03482 14.4776 1.5463 17.8959C1.47062 18.4253 1.62823 18.9606 1.97862 19.3644C2.32901 19.7684 2.83657 20 3.37121 20H16.8107C17.3453 20 17.8528 19.7683 18.2033 19.3644C18.5536 18.9606 18.7113 18.4254 18.6356 17.8959ZM7.53575 3.70419C7.66462 0.318209 12.5184 0.320751 12.6461 3.70419V5.63102H7.53575V3.70419ZM17.317 18.5956C17.1896 18.7425 17.005 18.8267 16.8107 18.8267H3.37121C3.17683 18.8267 2.99231 18.7425 2.86489 18.5956C2.73755 18.4488 2.68029 18.2543 2.70779 18.0619C3.12415 15.1487 4.05121 8.65872 4.3161 6.80432H6.36245V8.10277C6.39132 8.88031 7.50716 8.87973 7.53575 8.10277V6.80432H12.6461V8.10277C12.675 8.88031 13.7908 8.87973 13.8194 8.10277V6.80432H15.8658C16.1307 8.65872 17.0578 15.1487 17.4741 18.0619C17.5016 18.2543 17.4443 18.4488 17.317 18.5956Z"
                                class="fill-black"

                  </path>


                </svg>

              </a>

            </div>

          </div>

        </div>

      `;

      container.innerHTML += productHTML;

    });

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
        { breakpoint: 1200, settings: { slidesToShow: 3 } },
        { breakpoint: 992, settings: { slidesToShow: 2 } },
        { breakpoint: 576, settings: { slidesToShow: 1 } }
      ]
    });

  } catch (error) {
    console.error('Error loading products:', error);
  }

}

loadProducts();





document.addEventListener('click', function (e) {

    const wishlistBtn = e.target.closest('.add-to-wishlist');

    if (!wishlistBtn) return;

    e.preventDefault();
    e.stopPropagation();

    try {

        const product = JSON.parse(
            decodeURIComponent(wishlistBtn.dataset.product)
        );

        let wishlist = JSON.parse(
            localStorage.getItem('wishlist') || '[]'
        );

        const existingIndex = wishlist.findIndex(
            item => Number(item.id) === Number(product.id)
        );

        const icon = wishlistBtn.querySelector('i');

        // ==========================================
        // REMOVE FROM WISHLIST
        // ==========================================

        if (existingIndex !== -1) {

            wishlist.splice(existingIndex, 1);

           localStorage.setItem(
    'wishlist',
    JSON.stringify(wishlist)
);

window.dispatchEvent(
    new Event('wishlistUpdated')
);

wishlistBtn.classList.add('active');

            wishlistBtn.style.removeProperty('background-color');

            if (icon) {

                icon.classList.remove('fa-solid');
                icon.classList.add('fa-light');

                icon.style.removeProperty('color');

            }

            // Success message
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Removed from wishlist',
                text: product.name,
                showConfirmButton: false,
                timer: 2200,
                timerProgressBar: true
            });

            console.log(
                'Removed from wishlist:',
                product.name
            );

        }

        // ==========================================
        // ADD TO WISHLIST
        // ==========================================

        else {

            wishlist.push(product);

       localStorage.setItem(
    'wishlist',
    JSON.stringify(wishlist)
);

window.dispatchEvent(
    new Event('wishlistUpdated')
);

wishlistBtn.classList.remove('active');

            wishlistBtn.style.setProperty(
                'background-color',
                '#a4fd0c',
                'important'
            );

            if (icon) {

                icon.classList.remove('fa-light');
                icon.classList.add('fa-solid');

                icon.style.setProperty(
                    'color',
                    '#000',
                    'important'
                );

            }

            // Success message
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Added to wishlist',
                text: product.name,
                showConfirmButton: false,
                timer: 2200,
                timerProgressBar: true
            });

            console.log(
                'Added to wishlist:',
                product
            );

        }

    } catch (error) {

        console.error(
            'Error updating wishlist:',
            error
        );

        // Error message
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Something went wrong',
            text: 'We couldn’t update your wishlist. Please try again.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

    }

});



</script>