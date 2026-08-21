@extends('admin.main')

@section('title', 'Product Management')

@section('page-title', 'Product Management')
@section('content')
 
<div class="container py-5">

    <div class="page-card">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">

           

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

let allProducts = [];
let currentPage = 1;
const productsPerPage = 8;


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

                currentPage = 1;

                renderProducts(allProducts);

            },

            error: function (err) {

                console.log(
                    "LOAD ERROR =>",
                    err.responseText
                );

            }

        });

    }


    // =========================
    // RENDER TABLE
    // =========================

    function renderProducts(products) {

        let html = "";


        // =========================
        // CALCULATE PAGINATION
        // =========================

        const totalProducts = products.length;

        const totalPages = Math.ceil(
            totalProducts / productsPerPage
        );


        // If current page becomes invalid
        if (currentPage > totalPages && totalPages > 0) {

            currentPage = totalPages;

        }


        // =========================
        // GET CURRENT PAGE PRODUCTS
        // =========================

        const startIndex =
            (currentPage - 1) * productsPerPage;

        const endIndex =
            startIndex + productsPerPage;

        const currentProducts =
            products.slice(startIndex, endIndex);


        // =========================
        // EMPTY STATE
        // =========================

        if (currentProducts.length === 0) {

            html = `
                <tr>

                    <td colspan="9"
                        class="text-center py-4 text-muted">

                        No products found.

                    </td>

                </tr>
            `;

            $("#productTableBody").html(html);

            renderPagination(totalPages);

            return;

        }


        // =========================
        // RENDER PRODUCTS
        // =========================

        currentProducts.forEach((p, i) => {

            html += `

                <tr>

                    <td>
                        ${startIndex + i + 1}
                    </td>


                    <td>

                        <img
                            src="${p.main_image}"
                            width="60"
                            height="60"
                            style="object-fit:cover;"
                            class="rounded"
                        >

                    </td>


                    <td>

                        <div class="fw-bold">
                            ${p.name}
                        </div>

                        <small>
                            SKU: ${p.sku}
                        </small>

                    </td>


                    <td>

                        ${p.category?.name ?? 'N/A'}

                    </td>


                    <td>

                        SAR ${p.price}

                    </td>


                    <td>

                        ${
                            p.stock > 0

                            ?

                            `<span class="text-success">
                                In Stock (${p.stock})
                            </span>`

                            :

                            `<span class="text-danger">
                                Out of Stock
                            </span>`
                        }

                    </td>


                    <td>

                        ${p.weights?.length ?? 0}

                    </td>


                    <td>

                        ${p.gallery_images?.length ?? 0}

                    </td>


                    <td>

                        <button
                            class="btn btn-info btn-sm">

                            View

                        </button>


                        <button
                            class="btn btn-warning btn-sm"
                            onclick="openEdit(${p.id})">

                            Edit

                        </button>


                        <button
                            class="btn btn-danger btn-sm"
                            onclick="deleteProduct(${p.id})">

                            Delete

                        </button>

                    </td>

                </tr>

            `;

        });


        $("#productTableBody").html(html);


        // =========================
        // RENDER PAGINATION
        // =========================

        renderPagination(totalPages);

    }


    // =========================
    // PAGINATION
    // =========================

    function renderPagination(totalPages) {

        let paginationHtml = "";


        // Remove old pagination
        $("#productPagination").remove();


        if (totalPages <= 1) {

            return;

        }


        paginationHtml = `

            <div
                id="productPagination"
                class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3"
            >

                <div class="text-muted small">

                    Showing
                    <strong>
                        ${((currentPage - 1) * productsPerPage) + 1}
                    </strong>

                    -
                    <strong>
                        ${Math.min(
                            currentPage * productsPerPage,
                            allProducts.length
                        )}
                    </strong>

                    of
                    <strong>
                        ${allProducts.length}
                    </strong>

                    products

                </div>


                <nav>

                    <ul class="pagination mb-0">


                        <!-- PREVIOUS -->

                        <li
                            class="page-item ${
                                currentPage === 1
                                    ? 'disabled'
                                    : ''
                            }"
                        >

                            <button
                                class="page-link"
                                onclick="changeProductPage(${currentPage - 1})"
                                ${
                                    currentPage === 1
                                        ? 'disabled'
                                        : ''
                                }
                            >

                                Previous

                            </button>

                        </li>


                        <!-- PAGE NUMBERS -->

                        ${generatePageNumbers(totalPages)}


                        <!-- NEXT -->

                        <li
                            class="page-item ${
                                currentPage === totalPages
                                    ? 'disabled'
                                    : ''
                            }"
                        >

                            <button
                                class="page-link"
                                onclick="changeProductPage(${currentPage + 1})"
                                ${
                                    currentPage === totalPages
                                        ? 'disabled'
                                        : ''
                                }
                            >

                                Next

                            </button>

                        </li>

                    </ul>

                </nav>

            </div>

        `;


        $(".table-responsive").after(
            paginationHtml
        );

    }


    // =========================
    // GENERATE PAGE NUMBERS
    // =========================

    function generatePageNumbers(totalPages) {

        let html = "";


        for (let i = 1; i <= totalPages; i++) {

            html += `

                <li
                    class="page-item ${
                        i === currentPage
                            ? 'active'
                            : ''
                    }"
                >

                    <button
                        class="page-link"
                        onclick="changeProductPage(${i})"
                    >

                        ${i}

                    </button>

                </li>

            `;

        }


        return html;

    }


    // =========================
    // CHANGE PAGE
    // =========================

    window.changeProductPage = function (page) {

        const totalPages = Math.ceil(
            getFilteredProducts().length /
            productsPerPage
        );


        if (page < 1 || page > totalPages) {

            return;

        }


        currentPage = page;

        renderProducts(
            getFilteredProducts()
        );


        // Scroll back to table
        $("html, body").animate({

            scrollTop:
                $(".table-responsive").offset().top - 100

        }, 300);

    };


    // =========================
    // GET FILTERED PRODUCTS
    // =========================

    function getFilteredProducts() {

        const value =
            $("#searchProduct")
                .val()
                .toLowerCase()
                .trim();


        if (!value) {

            return allProducts;

        }


        return allProducts.filter(p => {

            return (

                (p.name ?? "")
                    .toLowerCase()
                    .includes(value)

                ||

                (p.sku ?? "")
                    .toLowerCase()
                    .includes(value)

                ||

                (p.category?.name ?? "")
                    .toLowerCase()
                    .includes(value)

            );

        });

    }


    // =========================
    // EDIT
    // =========================

    window.openEdit = function (id) {

        window.location.href =
            "/admin/products/" +
            id +
            "/edit";

    };


    // =========================
    // DELETE PRODUCT
    // =========================

    window.deleteProduct = function (id) {

        if (
            !confirm(
                "Are you sure you want to delete this product?"
            )
        ) {

            return;

        }


        $.ajax({

            url:
                "/api/delete-product/" +
                id,

            type: "DELETE",

            data: {

                _token:
                    "{{ csrf_token() }}"

            },

            success: function (res) {

                alert(
                    "Deleted successfully"
                );

                loadProducts();

            },

            error: function (err) {

                console.log(
                    "DELETE ERROR =>",
                    err.responseText
                );

            }

        });

    };


    // =========================
    // SEARCH
    // =========================

    $("#searchProduct").on(
        "keyup",
        function () {

            currentPage = 1;

            const filteredProducts =
                getFilteredProducts();

            renderProducts(
                filteredProducts
            );

        }
    );


    // =========================
    // INIT
    // =========================

    loadProducts();

});

</script>

@endsection