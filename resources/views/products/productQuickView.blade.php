

<!-- Modal -->
<div class="modal fade" id="productQuickView" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="shop-detail">
                    <div class="detail-wrapper">

                        <div class="row">

                            <!-- IMAGE SECTION -->
                            <div class="col-lg-6">

                                <!-- MAIN IMAGE -->
                                <div class="quick-image-box">
                                    <img id="qv-main-image" src="" alt="">
                                </div>

                                <!-- GALLERY SLIDER (FIXED) -->
                                <div id="qv-gallery" class="qv-gallery-slider mt-3"></div>

                            </div>

                            <!-- CONTENT SECTION -->
                            <div class="col-lg-6">

                                <div class="product-text-container bg-white br-20">

                                    <div class="close-content text-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <p class="eyebrow mb-12" id="qv-category"></p>

                                    <h3 class="black fw-700 mb-16" id="qv-name"></h3>

                                    <div class="d-flex align-items-center flex-wrap gap-16 mb-16">
                                        <h6 class="color-quant">
                                            ★★★★<span class="light-gray">★</span>
                                            <span class="text-16 fw-400 dark-black">(02 Reviews)</span>
                                        </h6>
                                    </div>

                                    <div class="d-flex align-items-center gap-16 mb-16">
                                        <h6 class="dark-gray text-decoration-line-through" id="qv-old-price"></h6>
                                        <h5 class="black" id="qv-price"></h5>
                                    </div>

                                    <p class="quick-view-text mb-16" id="qv-description"></p>

                                    <div class="hr-line bg-sept mb-24"></div>

                                    <div class="function-bar mb-16">

                                        <p class="subtitle font-primary fw-500 black mb-8">Quantity:</p>

                                        <div class="quantity quantity-wrap mb-24">
                                            <div class="input-area quantity-wrap">
                                                <input class="decrement" type="button" value="-">
                                                <input type="text" name="quantity" value="1" maxlength="2" size="1" class="number">
                                                <input class="increment" type="button" value="+">
                                            </div>
                                        </div>

                                        <p class="black font-primary fw-500 mb-24">
                                            SKU:
                                            <span class="dark-gray font-sec" id="qv-sku"></span>
                                        </p>

                                        <div class="cart-btn">
                                            <a href="#" class="cus-btn-2">ADD TO CART</a>
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
</div>
<!-- Modal -->


