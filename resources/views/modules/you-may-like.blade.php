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
window.currentCurrency = "{{ session('currency', 'USD') }}";
console.log(currentCurrency);
function formatPrice(price) {

  const currency = window.currentCurrency || window.currencyConfig.default || "USD";

  const config = window.currencyConfig?.currencies?.[currency];

  if (!config) {
    console.warn("Currency not found:", currency);
    return `$ ${price}`;
  }

  const converted = price * config.rate;

  return `${config.symbol} ${converted.toFixed(2)}`;
}


(function () {

  async function loadYouMayLike() {

    try {

      const res = await fetch('/api/get-all-product');
      const json = await res.json();

      console.log("You May Like API:", json);

      const container = document.getElementById('youMayLikeContainer');

      if (!container) return;

      if (!json || !Array.isArray(json.data)) return;

       

      container.innerHTML = '';

      const currentDealId = @json($deal->id);
      



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

                  <a href="#" data-bs-toggle="modal" data-bs-target="#comparepopup">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="20" height="20" viewBox="0 0 20 20" fill="none">
                       <path
                                d="M16.2238 20C16.0216 20 15.8197 19.922 15.6667 19.7665C15.3642 19.4588 15.3683 18.9642 15.676 18.6617L18.3019 16.0796C18.448 15.9333 18.5284 15.7393 18.5284 15.5331C18.5284 15.3275 18.4485 15.1341 18.3033 14.988L15.679 12.435C14.9636 11.6854 16.0002 10.6208 16.7685 11.315L19.397 13.8721C19.3993 13.8743 19.4016 13.8765 19.4038 13.8788C19.8469 14.3206 20.0909 14.9081 20.0909 15.5332C20.0909 16.1582 19.8468 16.7457 19.4038 17.1875C19.4025 17.1887 19.4012 17.19 19.3999 17.1913L16.7715 19.7759C16.6194 19.9254 16.4215 20 16.2238 20ZM16.2238 16.25H4.77844C2.19375 16.25 0.0909424 14.1472 0.0909424 11.5625V9.57032C0.129341 8.53485 1.6154 8.53563 1.65344 9.57032V11.5625C1.65344 13.2856 3.05532 14.6875 4.77844 14.6875H16.2238C17.2592 14.7259 17.2584 16.212 16.2238 16.25ZM19.3097 11.2109C18.8782 11.2109 18.5284 10.8612 18.5284 10.4297V8.43751C18.5284 6.71438 17.1266 5.31251 15.4034 5.31251H3.95813C2.92266 5.27411 2.92344 3.78806 3.95813 3.75001H15.4034C17.9881 3.75001 20.0909 5.85282 20.0909 8.43751V10.4297C20.0909 10.8612 19.7412 11.2109 19.3097 11.2109ZM3.95805 8.90626C3.76172 8.90626 3.5652 8.83274 3.41336 8.68497L0.784849 6.1279C0.782544 6.12567 0.780278 6.12345 0.778052 6.12118C0.334966 5.67942 0.0909424 5.09192 0.0909424 4.46688C0.0909424 3.84184 0.334966 3.25431 0.778052 2.81259C0.779341 2.8113 0.780591 2.81005 0.78188 2.8088L3.4104 0.224188C3.71805 -0.0783121 4.2127 -0.0741715 4.5152 0.233485C4.8177 0.541141 4.81356 1.03579 4.5059 1.33829L1.87997 3.9204C1.58047 4.20829 1.57985 4.72337 1.87856 5.012L4.5029 7.56501C4.81215 7.86587 4.81895 8.36048 4.51809 8.66977C4.36501 8.82716 4.16157 8.90626 3.95805 8.90626Z"
                                fill="#141516"
                              ></path>
                    </svg>
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