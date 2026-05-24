<!doctype html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Product Management</title>

    <link rel="stylesheet"
          href="css/bootstrap.min.css">

    <link rel="stylesheet"
          href="css/product-management.css">

    <script src="js/jquery-3.6.3.min.js"></script>

</head>

<body>

<div class="container py-5">

    <div class="page-card">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1">
                    Product Management
                </h2>

                <p class="text-muted mb-0">
                    Manage all products
                </p>

            </div>

            <button class="btn btn-dark px-4"
                    data-bs-toggle="modal"
                    data-bs-target="#productModal">

                + Add Product

            </button>

        </div>

        <!-- SEARCH -->
        <div class="mb-4">

            <input type="text"
                   id="searchProduct"
                   class="form-control search-box"
                   placeholder="Search product...">

        </div>

        <!-- TABLE -->
        <div class="table-responsive">

            <table class="table align-middle table-bordered">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Image</th>

                        <th>Name</th>

                        <th>Category</th>

                        <th>Price</th>

                        <th>Stock</th>

                        <th>Total Weight</th>

                        <th>Total Gallery</th>

                        <th width="350">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody id="productTableBody">

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- PRODUCT MODAL -->
<div class="modal fade"
     id="productModal"
     tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="fw-bold">
                    Add Product
                </h4>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">

                </button>

            </div>

            <div class="modal-body">

                @include('admin.product-form')

            </div>

        </div>

    </div>

</div>

<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
let allProducts = [];

$(document).ready(function () {

    console.log("Product list loaded ✅");

    // =========================
    // LOAD PRODUCTS
    // =========================
    function loadProducts() {

        $.ajax({
            url: "/api/get-all-product",
            type: "GET",

            success: function (res) {

                console.log("PRODUCT RESPONSE =>", res);

                allProducts = res.data ?? [];

                renderProducts(allProducts);
            },

            error: function (err) {
                console.log("LOAD ERROR =>", err.responseText);
            }
        });
    }

    // =========================
    // RENDER TABLE
    // =========================
    function renderProducts(products) {

        let html = "";

        products.forEach((p, i) => {

            html += `
                <tr>
                    <td>${i + 1}</td>

                    <td>
                        <img src="${p.main_image}" width="60" height="60" style="object-fit:cover;">
                    </td>

                    <td>
                        <div class="fw-bold">${p.name}</div>
                        <small>SKU: ${p.sku}</small>
                    </td>

                    <td>
                        ${p.category?.name ?? 'N/A'}
                    </td>

                    <td>
                        SAR ${p.price}
                    </td>

                    <td>
                        ${p.stock > 0
                            ? `<span class="text-success">In Stock (${p.stock})</span>`
                            : `<span class="text-danger">Out of Stock</span>`
                        }
                    </td>

                    <td>${p.weights?.length ?? 0}</td>
                    <td>${p.gallery_images?.length ?? 0}</td>

                    <td>

                        <button class="btn btn-info btn-sm">
                            View
                        </button>

                        <button class="btn btn-warning btn-sm"
                                onclick="openEdit(${p.id})">
                            Edit
                        </button>

                        <button class="btn btn-danger btn-sm"
                                onclick="deleteProduct(${p.id})">
                            Delete
                        </button>

                    </td>
                </tr>
            `;
        });

        $("#productTableBody").html(html);
    }

    // =========================
    // EDIT REDIRECT
    // =========================
    window.openEdit = function (id) {
        window.location.href = "/admin/products/" + id + "/edit";
    };

    // =========================
    // DELETE PRODUCT
    // =========================
    window.deleteProduct = function (id) {

        if (!confirm("Are you sure you want to delete this product?")) {
            return;
        }

        $.ajax({
            url: "/api/delete-product/" + id,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },

            success: function (res) {
                alert("Deleted successfully");
                loadProducts();
            },

            error: function (err) {
                console.log("DELETE ERROR =>", err.responseText);
            }
        });
    };

    // =========================
    // SEARCH
    // =========================
    $("#searchProduct").on("keyup", function () {

        let value = $(this).val().toLowerCase();

        let filtered = allProducts.filter(p => {
            return (p.name ?? "").toLowerCase().includes(value)
                || (p.sku ?? "").toLowerCase().includes(value);
        });

        renderProducts(filtered);
    });

    // INIT
    loadProducts();

});
</script></body>
</html>