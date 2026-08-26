<!-- =========================================================
     Wishlist Drawer
========================================================= -->

<style>

    /* Overlay */
    .wishlist-drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        z-index: 99998;

        opacity: 0;
        visibility: hidden;

        transition:
            opacity 0.3s ease,
            visibility 0.3s ease;
    }

    .wishlist-drawer-overlay.active {
        opacity: 1;
        visibility: visible;
    }


    /* Drawer */
    .wishlist-drawer {
        position: fixed;
        top: 0;
        right: 0;

        width: 80vw;
        max-width: 1100px;
        height: 100vh;

        background: #ffffff;

        z-index: 99999;

        display: flex;
        flex-direction: column;

        transform: translateX(100%);

        transition: transform 0.35s cubic-bezier(.4, 0, .2, 1);

        box-shadow: -10px 0 40px rgba(0, 0, 0, 0.15);

        overflow: hidden;
    }

    .wishlist-drawer.active {
        transform: translateX(0);
    }


    /* Header */
    .wishlist-drawer-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 28px 35px;

        border-bottom: 1px solid #eeeeee;

        flex-shrink: 0;
    }

    .wishlist-drawer-heading {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: #171717;
    }

    .wishlist-drawer-subtitle {
        margin: 6px 0 0;
        font-size: 14px;
        color: #777777;
    }


    /* Close button */
    .wishlist-drawer-close {
        width: 42px;
        height: 42px;

        border: 1px solid #e5e5e5;
        border-radius: 50%;

        background: #ffffff;

        display: flex;
        align-items: center;
        justify-content: center;

        cursor: pointer;

        color: #222222;

        transition: all 0.2s ease;
    }

    .wishlist-drawer-close:hover {
        background: #171717;
        color: #ffffff;
        border-color: #171717;
    }


    /* Body */
    .wishlist-drawer-body {
        flex: 1;

        overflow-y: auto;

        padding: 30px 35px;
    }


    /* Wishlist item */
    .wishlist-item {
        display: flex;
        align-items: center;

        gap: 24px;

        padding: 20px 0;

        border-bottom: 1px solid #eeeeee;
    }

    .wishlist-item:first-child {
        padding-top: 0;
    }


    /* Product image */
    .wishlist-item-image {
        width: 110px;
        height: 110px;

        flex-shrink: 0;

        border-radius: 8px;

        overflow: hidden;

        background: #f7f7f7;
    }

    .wishlist-item-image img {
        width: 100%;
        height: 100%;

        object-fit: cover;

        display: block;
    }


    /* Product information */
    .wishlist-item-info {
        flex: 1;

        min-width: 0;
    }

    .wishlist-item-name {
        margin: 0;

        font-size: 18px;
        font-weight: 600;

        color: #1a1a1a;

        line-height: 1.4;
    }


    /* Actions */
    .wishlist-item-actions {
        display: flex;
        align-items: center;

        gap: 10px;

        flex-shrink: 0;
    }

    .wishlist-view-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-width: 125px;

        padding: 11px 18px;

        border-radius: 5px;

        background: #171717;
        color: #ffffff;

        font-size: 13px;
        font-weight: 600;

        text-decoration: none;

        transition: all 0.2s ease;
    }

    .wishlist-view-btn:hover {
        background: #9eef0b;
        color: #000000;
    }


    .wishlist-remove-btn {
        width: 42px;
        height: 42px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border: 1px solid #e5e5e5;
        border-radius: 5px;

        background: #ffffff;

        color: #555555;

        cursor: pointer;

        transition: all 0.2s ease;
    }

    .wishlist-remove-btn:hover {
        border-color: #dc3545;
        background: #dc3545;
        color: #ffffff;
    }


    /* Empty state */
    .wishlist-empty {
        min-height: 400px;

        display: flex;
        flex-direction: column;

        align-items: center;
        justify-content: center;

        text-align: center;

        padding: 40px;
    }

    .wishlist-empty-icon {
        width: 80px;
        height: 80px;

        border-radius: 50%;

        background: #f5f5f5;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 22px;
    }

    .wishlist-empty-icon i {
        font-size: 30px;
        color: #777777;
    }

    .wishlist-empty h3 {
        margin: 0 0 8px;

        font-size: 22px;
        font-weight: 700;

        color: #171717;
    }

    .wishlist-empty p {
        margin: 0;

        font-size: 14px;

        color: #777777;
    }


    /* Mobile */
    @media (max-width: 767px) {

        .wishlist-drawer {
            width: 100vw;
        }

        .wishlist-drawer-header {
            padding: 22px 20px;
        }

        .wishlist-drawer-heading {
            font-size: 22px;
        }

        .wishlist-drawer-body {
            padding: 20px;
        }

        .wishlist-item {
            gap: 14px;
            align-items: flex-start;
        }

        .wishlist-item-image {
            width: 80px;
            height: 80px;
        }

        .wishlist-item-name {
            font-size: 15px;
        }

        .wishlist-item-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .wishlist-view-btn {
            min-width: auto;
            padding: 9px 12px;
            font-size: 12px;
        }

        .wishlist-remove-btn {
            width: 100%;
            height: 36px;
        }
    }

</style>


<!-- Overlay -->
<div id="wishlist-drawer-overlay"
     class="wishlist-drawer-overlay">
</div>


<!-- Wishlist Drawer -->
<aside id="wishlist-drawer"
       class="wishlist-drawer"
       aria-hidden="true">

    <!-- Header -->
    <div class="wishlist-drawer-header">

        <div>
            <h2 class="wishlist-drawer-heading">
                Your Wishlist
            </h2>

            <p class="wishlist-drawer-subtitle">
                Your saved favorites, all in one place.
            </p>
        </div>

        <button type="button"
                id="close-wishlist-drawer"
                class="wishlist-drawer-close"
                aria-label="Close wishlist">

            <i class="fa-light fa-xmark"></i>

        </button>

    </div>


    <!-- Body -->
    <div id="wishlist-drawer-body"
         class="wishlist-drawer-body">

        <!-- Products will be inserted here -->

    </div>

</aside>


<script>

(function () {

    'use strict';


    /* =========================================================
       Elements
    ========================================================= */

    const openButton =
        document.getElementById('open-wishlist-modal');

    const closeButton =
        document.getElementById('close-wishlist-drawer');

    const drawer =
        document.getElementById('wishlist-drawer');

    const overlay =
        document.getElementById('wishlist-drawer-overlay');

    const drawerBody =
        document.getElementById('wishlist-drawer-body');


    if (!openButton || !drawer || !overlay || !drawerBody) {
        return;
    }


    /* =========================================================
       Get Wishlist
    ========================================================= */

    function getWishlist() {

        try {

            const wishlist =
                JSON.parse(
                    localStorage.getItem('wishlist') || '[]'
                );

            return Array.isArray(wishlist)
                ? wishlist
                : [];

        } catch (error) {

            console.error(
                'Unable to read wishlist:',
                error
            );

            return [];
        }
    }


    /* =========================================================
       Save Wishlist
    ========================================================= */

    function saveWishlist(wishlist) {

        localStorage.setItem(
            'wishlist',
            JSON.stringify(wishlist)
        );

        updateWishlistCount();

        window.dispatchEvent(
            new CustomEvent('wishlistUpdated')
        );
    }


    /* =========================================================
       Update Header Count
    ========================================================= */

    function updateWishlistCount() {

        const countElement =
            document.getElementById('wishlist-count');

        if (!countElement) {
            return;
        }

        const wishlist = getWishlist();

        countElement.textContent =
            wishlist.length;
    }


    /* =========================================================
       Product Image
    ========================================================= */

    function getProductImage(product) {

        /*
         * Supports the common image properties used
         * by the Slimza product API.
         */

        let image =
            product.main_image ||
            product.image ||
            product.thumbnail ||
            product.product_image ||
            '';


        if (!image) {
            return "{{ asset('images/placeholder.png') }}";
        }


        /*
         * If Supabase/storage URL is already complete,
         * keep it unchanged.
         */

        if (
            image.startsWith('http://') ||
            image.startsWith('https://') ||
            image.startsWith('/')
        ) {
            return image;
        }


        return image;
    }


    /* =========================================================
       Product URL
    ========================================================= */

    function getProductUrl(product) {

        const name =
            product.name || 'product';

        const id =
            product.id;


        const slug =
            name
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');


        return `/product-details/${slug}/${id}`;
    }


    /* =========================================================
       Render Wishlist
    ========================================================= */

    function renderWishlist() {

        const wishlist =
            getWishlist();


        if (!wishlist.length) {

            drawerBody.innerHTML = `

                <div class="wishlist-empty">

                    <div class="wishlist-empty-icon">
                        <i class="fa-light fa-heart"></i>
                    </div>

                    <h3>
                        Your Wishlist Is Empty
                    </h3>

                    <p>
                        Save products you love and
                        find them here whenever you're ready.
                    </p>

                </div>

            `;

            return;
        }


        drawerBody.innerHTML =
            wishlist.map(function (product) {

                const productId =
                    Number(product.id);

                const productName =
                    product.name || 'Unnamed Product';

                const productImage =
                    getProductImage(product);

                const productUrl =
                    getProductUrl(product);


                return `

                    <div class="wishlist-item"
                         data-product-id="${productId}">

                        <div class="wishlist-item-image">

                            <img
                                src="${productImage}"
                                alt="${escapeHtml(productName)}"
                                loading="lazy"
                            >

                        </div>


                        <div class="wishlist-item-info">

                            <h3 class="wishlist-item-name">
                                ${escapeHtml(productName)}
                            </h3>

                        </div>


                        <div class="wishlist-item-actions">

                            <a href="${productUrl}"
                               class="wishlist-view-btn">

                                View Details

                            </a>


                            <button
                                type="button"
                                class="wishlist-remove-btn"
                                data-product-id="${productId}"
                                aria-label="Remove ${escapeHtml(productName)}">

                                <i class="fa-light fa-trash-can"></i>

                            </button>

                        </div>

                    </div>

                `;

            }).join('');
    }


    /* =========================================================
       Escape HTML
    ========================================================= */

    function escapeHtml(value) {

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }


    /* =========================================================
       Open Drawer
    ========================================================= */

    function openWishlist() {

        renderWishlist();

        drawer.classList.add('active');

        overlay.classList.add('active');

        drawer.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.style.overflow = 'hidden';
    }


    /* =========================================================
       Close Drawer
    ========================================================= */

    function closeWishlist() {

        drawer.classList.remove('active');

        overlay.classList.remove('active');

        drawer.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow = '';
    }


    /* =========================================================
       Open
    ========================================================= */

    openButton.addEventListener(
        'click',
        function (event) {

            event.preventDefault();

            openWishlist();

        }
    );


    /* =========================================================
       Close
    ========================================================= */

    closeButton.addEventListener(
        'click',
        closeWishlist
    );


    overlay.addEventListener(
        'click',
        closeWishlist
    );


    /* =========================================================
       ESC Key
    ========================================================= */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                drawer.classList.contains('active')
            ) {

                closeWishlist();

            }

        }
    );


    /* =========================================================
       Remove Product
    ========================================================= */

    drawerBody.addEventListener(
        'click',
        function (event) {

            const removeButton =
                event.target.closest(
                    '.wishlist-remove-btn'
                );


            if (!removeButton) {
                return;
            }


            const productId =
                Number(
                    removeButton.dataset.productId
                );


            let wishlist =
                getWishlist();


            wishlist =
                wishlist.filter(function (product) {

                    return Number(product.id) !== productId;

                });


            saveWishlist(wishlist);


            /*
             * Re-render immediately so the
             * product disappears without reload.
             */

            renderWishlist();

        }
    );


    /* =========================================================
       Wishlist Updates From Other Components
    ========================================================= */

    window.addEventListener(
        'wishlistUpdated',
        function () {

            updateWishlistCount();

            /*
             * If drawer is currently open,
             * refresh its contents immediately.
             */

            if (
                drawer.classList.contains('active')
            ) {

                renderWishlist();

            }

        }
    );


    /* =========================================================
       Initial Count
    ========================================================= */

    updateWishlistCount();


})();

</script>