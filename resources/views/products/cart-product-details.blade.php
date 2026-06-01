<div id="cartProductView" style="margin:top:30px;">
 

    <div class="text-center text-muted py-5">
        Loading product details...
    </div>
</div>

<script>
const modalEl = document.getElementById('productModal');

modalEl.addEventListener('shown.bs.modal', async function () {

    const id = window.__cartItemId;

    if (!id) return;

    // SHOW LOADER IMMEDIATELY
    document.getElementById('cartProductView').innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-success" role="status"></div>
            <div class="mt-3 text-light">
                Loading product details...
            </div>
        </div>
    `;

    try {

        const res = await fetch(`/api/cart-item/${id}`);
        const data = await res.json();

        const product = data.product;
        const deal = data.deal;

document.getElementById('cartProductView').innerHTML = `

    ${deal && deal.image ? `
        <div class="mb-4">
            <img
                src="${deal.image}"
                class="img-fluid rounded-4 w-100"
                style="max-height:220px;object-fit:cover;"
            >
        </div>
    ` : ''}

    <div class="row">

        <div class="col-md-5">

            <img
                src="${product.main_image}"
                class="img-fluid rounded-4 border"
            >

            ${
                product.gallery_images?.length
                ? `
                    <div class="d-flex gap-2 mt-3 flex-wrap">
                        ${product.gallery_images.map(img => `
                            <img
                                src="${img}"
                                style="
                                    width:70px;
                                    height:70px;
                                    object-fit:cover;
                                    border-radius:10px;
                                "
                            >
                        `).join('')}
                    </div>
                `
                : ''
            }

        </div>

        <div class="col-md-7 text-start">

            <h3 class="fw-bold text-white mb-1">
                ${product.name ?? ''}
            </h3>

            <div class="text-secondary mb-2">
                Category ID: ${product.category_id ?? '-'}
            </div>

            <div class="mb-3">

                <span class="badge bg-success">
                    Qty: ${data.qty}
                </span>

                <span class="badge bg-dark ms-2">
                    SKU: ${product.sku ?? '-'}
                </span>

            </div>

            <div class="mb-3">

                <span class="fs-3 fw-bold text-warning">
                    £${product.price}
                </span>

                ${
                    product.old_price
                    ? `
                        <span class="text-decoration-line-through text-secondary ms-2">
                            £${product.old_price}
                        </span>
                    `
                    : ''
                }

            </div>

            <div class="mb-4">

                <h6 class="text-success mb-2">
                    Description
                </h6>

                <div style="
                    max-height:220px;
                    overflow:auto;
                    line-height:1.8;
                ">
                    ${product.description ?? ''}
                </div>

            </div>

        </div>

    </div>
${
    data.option
    ? `
    <div class="mt-4">

        <h5 class="mb-3 text-success">
            Selected Buying Option
        </h5>

        <div class="border rounded-4 p-3">

            ${
                data.option.image
                ? `
                    <img
                        src="${data.option.image}"
                        class="img-fluid rounded mb-3"
                        style="height:150px;object-fit:cover;width:100%;"
                    >
                `
                : ''
            }

            <h5 class="fw-bold">
                ${data.option.pack} Pack
            </h5>

            <div class="text-warning fw-bold fs-4">
                £${data.option.price}
            </div>

            <div class="text-secondary">
                Duration: ${data.option.duration} Days
            </div>

            <div class="mt-2">
                Quantity Selected: ${data.qty}
            </div>

        </div>

    </div>
    `
    : ''
}
    ${
        product.tags?.length
        ? `
        <div class="mt-4">

            <h5 class="text-success mb-3">
                Tags
            </h5>

            ${product.tags.map(tag => `
                <span class="badge bg-secondary me-2 mb-2">
                    ${tag}
                </span>
            `).join('')}

        </div>
        `
        : ''
    }

    ${
        deal && deal.id
        ? `
        <div class="mt-4 border border-success rounded-4 p-3">

            <h5 class="text-success mb-3">
                Deal Information
            </h5>

            <div class="fw-bold">
                ${deal.title}
            </div>

            <p class="mt-2 mb-3">
                ${deal.description ?? ''}
            </p>

            <div class="row">

                <div class="col-6">
                    <small class="text-secondary">Start Date</small>
                    <div>${deal.start_date}</div>
                </div>

                <div class="col-6">
                    <small class="text-secondary">End Date</small>
                    <div>${deal.end_date}</div>
                </div>

            </div>

            <div class="mt-3">
                <small class="text-secondary">
                    Created:
                </small>
                ${new Date(deal.created_at).toLocaleDateString()}
            </div>

        </div>
        `
        : ''
    }

`;

    } catch (error) {

        document.getElementById('cartProductView').innerHTML = `
            <div class="text-center text-danger py-5">
                Failed to load product details.
            </div>
        `;

        console.error(error);
    }

});
</script>