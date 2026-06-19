<style>
.option-box {
    border: 1px solid #000;   /* black border */
    border-radius: 10px;
    transition: 0.2s ease;
    margin-bottom: 10px;      /* spacing between items */
    background: #fff;
}

.option-box:hover {
    border-color: #333;
}

/* SELECTED STATE */
.option-box.option-selected {
    border: 2px solid #9eef0b !important;
    box-shadow: 0 0 10px rgba(158, 239, 11, 0.25);
    transform: scale(1.01);
}
/* ================= MODAL BOTTOM SHEET ================= */
#productQuickView .modal-dialog {
    position: fixed;
    bottom: 0;
    margin: 0;
    width: 100%;
    max-width: 100%;
    transform: translateY(100%);
    transition: transform 0.35s ease-in-out;
}

#productQuickView.show .modal-dialog {
    transform: translateY(0);
}

#productQuickView .modal-content {
    border-radius: 18px 18px 0 0;
    border: none;
    overflow: hidden;
    min-height: 85vh;
    animation: fadeUp 0.35s ease-in-out;
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ================= CLOSE BUTTON ================= */
#productQuickView .btn-close {
    position: absolute;
    top: 44px;
    right: 15px;
    z-index: 20;
    background-color: #fff;
    border-radius: 50%;
    padding: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.15);
}

/* ================= IMAGE WRAPPER ================= */
.quick-image-box {
    background-color: #fafafa;
    text-align: center;
    height: 370px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0px;
    overflow: hidden;
}

#qv-main-image {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}

/* ================= GALLERY WRAPPER ================= */
.qv-gallery-wrapper {
    position: relative;
    z-index: 99;    margin-top: -28px;
    background-color: white;
    padding: 0px 20px;
}

/* ================= GALLERY ================= */
#qv-gallery {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: 10px;
    background: #0b0b0b;
    border-radius: 12px;
}

/* scrollbar */
#qv-gallery::-webkit-scrollbar {
    height: 4px;
}

#qv-gallery::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.25);
    border-radius: 10px;
}

/* thumbnails */
#qv-gallery img {
    width: 70px;
    height: 70px;
    min-width: 70px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid rgba(255,255,255,0.15);
    cursor: pointer;
    transition: 0.25s ease;
    flex-shrink: 0;
}

#qv-gallery img:hover {
    transform: scale(1.06);
    border-color: #fff;
}

/* ================= ARROWS ================= */
.qv-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    background: rgba(0,0,0,0.65);
    border: 1px solid rgba(255,255,255,0.25);
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: 0.2s;
}

.qv-arrow:hover {
    background: #000;
    border-color: #fff;
}

.qv-arrow.left {
    left: 8px;
}

.qv-arrow.right {
    right: 8px;
}

/* ================= CONTENT ================= */
.qv-close-btn{
    position: absolute;
    top: 12px;
    right: 12px;

    width: 34px;
    height: 34px;

    background: #000;
    border: none;

    border-radius: 50%;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;
    padding: 0;
}
</style>


<!-- MODAL -->
<div class="modal fade" id="productQuickView" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body" style="padding:0px">
                <div class="shop-detail">
                    <div class="detail-wrapper">
                        <div class="row">
                            <!-- IMAGE SECTION -->
                            <div class="col-lg-6" style="    margin-top: 37px;">
                                <!-- CLOSE BUTTON -->
                            <div class="col-lg-6" style="margin-top: 37px; position: relative;">

    <button type="button" data-bs-dismiss="modal" class="qv-close-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#fff" viewBox="0 0 16 16">
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
        </svg>
    </button>

</div>

                                <!-- MAIN IMAGE -->
                                <div class="quick-image-box">
                                    <img id="qv-main-image" src="" alt="">
                                </div>
                                <!-- GALLERY -->
                                <div class="qv-gallery-wrapper">
                                    <div class="qv-arrow left" onclick="scrollQvGallery(-1)">‹</div>
                                    <div id="qv-gallery"></div>
                                    <div class="qv-arrow right" onclick="scrollQvGallery(1)">›</div>
                                </div>

                            </div>
                            <!-- CONTENT SECTION -->
                            <div class="col-lg-6" style="margin-top: 37px">

                                <div class="product-text-container bg-white br-20" style="padding-top:54px">

                                    <p class="eyebrow mb-12" id="qv-category"></p>

                                    <h3 class="black fw-700 mb-16" id="qv-name"></h3>

                                    <div class="d-flex align-items-center flex-wrap gap-16 mb-16">
                                        <h6 class="color-quant">
                                            ★★★★<span class="light-gray">★</span>
                                            <span class="text-16 fw-400 dark-black">(02 Reviews)</span>
                                        </h6>
                                    </div>
  
                                    <div id="qv-buying-options"></div>

                                    <div class="d-flex align-items-center gap-16 mb-16">
                                        <h6 class="dark-gray text-decoration-line-through" id="qv-old-price"></h6>
                                        <h5 class="black" id="qv-price"></h5>
                                    </div>

                                    <p class="quick-view-text mb-16" id="qv-description"></p>

                                    <div class="hr-line bg-sept mb-24"></div>

                                    <p class="subtitle fw-500 mb-8">Quantity:</p>

                                    <div class="quantity mb-24">
                                        <div class="input-area">
                                            <input class="decrement" type="button" value="-">
                                            <input type="text" name="quantity" value="1" maxlength="2" size="1" class="number">
                                            <input class="increment" type="button" value="+">
                                        </div>
                                    </div>

                                    <p class="black fw-500 mb-24">
                                        SKU:
                                        <span class="dark-gray" id="qv-sku"></span>
                                    </p>

                                   <div style="    padding: 1px 20px;width: 100%;flex-direction: row;display: flex;justify-content: space-between;">
                                      <a href="#" class="add-to-cart cus-btn-2" id="qv-add-to-cart">
                                         <i class="fas fa-shopping-cart me-2"></i>
                                             Add To Cart
                                       </a>

                                       <a href="#" class="cus-btn-2" id="qv-order-now">
                                        <i class="fas fa-bolt me-2"></i>
                                           Order Now
                                        </a>
                                   </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>




function renderQuickViewOptions(product) {

    const container = document.getElementById("qv-buying-options");

    if (!container) return;

    container.innerHTML = "";

    if (!product.options || !product.options.length) {
        container.innerHTML = "<p>No options available</p>";
        return;
    }

    product.options.forEach((opt) => {

    container.insertAdjacentHTML("beforeend", `
        <div class="col-md-12">
            <div class="d-flex border rounded p-3 align-items-center gap-3 option-box"
                 data-option='${JSON.stringify(opt)}'
                 data-base-price="${opt.price}"
                 style="cursor:pointer;">

                <!-- IMAGE -->
                <div style="width:80px;height:80px;flex-shrink:0;overflow:hidden;border-radius:10px;background:#f5f5f5;display:flex;align-items:center;justify-content:center;">
                    <img src="${opt.image || '/placeholder.png'}"
                         style="width:100%;height:100%;object-fit:cover;">
                </div>

                <!-- CONTENT -->
                <div class="flex-grow-1">
                    <div class="fw-bold">${opt.pack} x Pack</div>

                    <div class="mt-1">
                        <span class="badge bg-light text-dark border per-pouch">
                            per pouch
                        </span>
                    </div>

                    <div class="small mt-2" style="color:white;">
                        ${opt.duration || ''} Days
                    </div>
                </div>

                <!-- PRICE -->
                <div class="d-flex flex-column" style="margin-top: 44px">
                    <div class="fw-bold price-box">
                        £${parseFloat(opt.price).toFixed(2)}
                    </div>

                    <div class="option-badge">
                        🎁 Get Free ${opt.pack} Pack
                    </div>
                </div>

            </div>
        </div>
    `);
});

    bindQuickViewOptions();
}

function bindQuickViewOptions() {

    const boxes = document.querySelectorAll("#qv-buying-options .option-box");

    boxes.forEach(box => {

        box.addEventListener("click", function () {

            boxes.forEach(x =>
                x.classList.remove("option-selected")
            );

            this.classList.add("option-selected");

            const opt = JSON.parse(this.dataset.option || '{}');

            window.selectedOption = opt;

            // ✅ UPDATE MAIN PRICE
            const priceEl = document.getElementById("qv-price");

            if (priceEl && opt.price) {
                priceEl.innerText = `£${parseFloat(opt.price).toFixed(2)}`;
            }

            console.log("Selected option:", opt);
        });

    });

    if (boxes.length) {
        boxes[0].click(); // default select first option
    }
}
function scrollQvGallery(direction) {
    const container = document.getElementById("qv-gallery");
    const scrollAmount = 120;

    container.scrollBy({
        left: direction * scrollAmount,
        behavior: "smooth"
    });
}



document.addEventListener("click", function (e) {

    const btn = e.target.closest(".open-quick-view");
    if (!btn) return;

    const encoded = btn.dataset.product;
    const product = JSON.parse(decodeURIComponent(encoded));

    window.currentQuickViewProduct = product;
    window.selectedProductId = product.id;

    renderQuickViewOptions(product);
});



const quickViewEl = document.getElementById("productQuickView");

if (quickViewEl) {
    const modalInstance = bootstrap.Modal.getOrCreateInstance(quickViewEl);
    modalInstance.hide();
}
</script>