<!doctype html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Product Management</title>

    <link rel="stylesheet"
          href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('css/product-management.css') }}">

    <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>

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

<script>

    let allProducts = [];

    /* =========================
       LOAD PRODUCTS
    ========================== */

    function loadProducts()
    {

        $.ajax({

            url:'/api/get-all-product',

            type:'GET',

            success:function(res){

                allProducts = res.data;

                renderProducts(allProducts);

            }

        });

    }

    /* =========================
       RENDER PRODUCTS
    ========================== */

    function renderProducts(products)
    {

        $('#productTableBody').html('');

        products.forEach((product,index)=>{

            $('#productTableBody').append(`

                <tr>

                    <td>${index + 1}</td>

                    <td>

                        <img src="${product.main_image}">

                    </td>

                    <td>

                        <div class="fw-bold">
                            ${product.name}
                        </div>

                        <div class="text-muted small">
                            SKU : ${product.sku}
                        </div>

                    </td>

                    <td>

                        ${product.category?.name ?? 'N/A'}

                    </td>

                    <td>

                        SAR ${product.price}

                    </td>

                    <td>

                        ${
                            product.stock > 0
                            ?
                            `<span class="badge-stock in-stock">
                                In Stock (${product.stock})
                             </span>`
                            :
                            `<span class="badge-stock out-stock">
                                Out Of Stock
                             </span>`
                        }

                    </td>

                    <td>

                        ${product.weights?.length ?? 0}

                    </td>

                    <td>

                        ${product.gallery_images?.length ?? 0}

                    </td>

                    <td>

                        <button class="btn btn-info btn-sm btn-action">

                            View

                        </button>

                        <button class="btn btn-warning btn-sm btn-action">

                            Edit

                        </button>

                        <button class="btn btn-secondary btn-sm btn-action">

                            Suspend

                        </button>

                        <button class="btn btn-danger btn-sm btn-action"
                                onclick="deleteProduct(${product.id})">

                            Delete

                        </button>

                    </td>

                </tr>

            `);

        });

    }

    /* =========================
       SEARCH PRODUCT
    ========================== */

    $('#searchProduct').on('keyup', function(){

        let value = $(this).val().toLowerCase();

        let filtered = allProducts.filter(product => {

            return product.name.toLowerCase().includes(value)
                || product.sku.toLowerCase().includes(value);

        });

        renderProducts(filtered);

    });

    /* =========================
       DELETE PRODUCT
    ========================== */

    function deleteProduct(id)
    {

        if(!confirm('Delete this product?'))
        {
            return;
        }

        $.ajax({

            url:'/api/delete-product/' + id,

            type:'DELETE',

            data:{
                _token:'{{ csrf_token() }}'
            },

            success:function(res){

                alert('Product Deleted Successfully');

                loadProducts();

            }

        });

    }

    /* =========================
       INITIAL LOAD
    ========================== */

    loadProducts();

</script>

</body>
</html>