<section class="feature-products p-40">
  <div class="container-fluid">

    <h2 class="fw-600 mb-4 mt-4" style="color:#9eef0b;">
      You May Like
    </h2>

    <div class="row g-4" id="youMayLikeContainer">
      <!-- PRODUCTS LOAD HERE -->
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


(function () {

  async function loadYouMayLike() {

    try {

      const res = await fetch('/api/get-all-product');
      const json = await res.json();

      
      const container = document.getElementById('youMayLikeContainer');

      if (!container) return;

      if (!json || !Array.isArray(json.data)) return;

       

      container.innerHTML = '';

     const currentDealId = @json(isset($deal) ? $deal->id : 6);
      



      const filteredProducts = json.data.filter(product =>
    Number(product.deal_id) !== Number(currentDealId)
);

const randomProducts = filteredProducts
    .sort(() => 0.5 - Math.random())
    .slice(0, 8);


      randomProducts.forEach(product => {

        // FILTER SAME DEAL PRODUCTS
        if (Number(product.deal_id) === Number(currentDealId)) return;

        const mainImage = product.main_image || '';

       const discountLabel = product.old_price
        ? `-${Math.round(((product.old_price - product.price) / product.old_price) * 100)}%`
        : '';

      /* ✅ FIXED: moved inside loop + currency applied */
      const oldPriceHTML = product.old_price
        ? `<span class="h6 text-decoration-line-through dark-gray">
              ${formatPrice(product.old_price)}
           </span>`
        : '';


        container.insertAdjacentHTML('beforeend', `
          <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">

            <div class="product-block">

              <div class="image-box mb-16">
                <img src="${mainImage}" alt="${product.name}" />

                ${discountLabel ? `<div class="sale-label subtitle">${discountLabel}</div>` : ''}

                <div class="shopping-btns">

                  <a href="#" data-bs-toggle="modal" data-bs-target="#productQuickView">
                    <i class="fa-regular fa-eye"></i>
                  </a>

                  <a href="javascript:;">
                    <i class="fa-light fa-heart"></i>
                  </a>

                
                </div>
              </div>

              <div class="content-box">

                <p class="eyebrow mb-12">
                  ${product.category_name ?? 'Product'}
                </p>

                <a href="/product-details/${encodeURIComponent(product.name)}/${product.id}"
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
   class="open-quick-view"
   data-bs-toggle="modal"
   data-bs-target="#productQuickView"
   data-product='${encodeURIComponent(JSON.stringify(product))}'>

   <i class="fa-regular fa-eye"></i>
</a>

                </div>

              </div>

            </div>

          </div>
        `);

      });

    } catch (err) {
      console.error("You May Like Error:", err);
    }

  }

  document.addEventListener("DOMContentLoaded", loadYouMayLike);

})();
</script>