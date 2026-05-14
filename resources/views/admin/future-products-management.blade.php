<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Future Products Management</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}" />

    <!-- All CSS files -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-animation.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <style>

        body{
            background: #f5f7fb;
        }

        .page-wrapper{
            padding: 40px 0;
        }
/* FORCE WHITE MODAL */
.modal-content{
    background: #fff !important;
    border-radius: 20px;
    border: none !important;
    overflow: hidden;
}

.modal-header{
    background: #fff !important;
    border-bottom: 1px solid #f1f1f1;
}

.modal-body{
    background: #fff !important;
}

/* FORM INPUT */
.form-control{
    border-radius: 10px;
    height: 48px;
    background: #fff !important;
    border: 1px solid #dcdcdc;
    color: #111;
}

/* CUSTOM FILE INPUT */
.custom-upload-wrapper{
    width: 100%;
}

.custom-file-input{
    display: none;
}

.custom-upload-box{
    width: 100%;
    min-height: 180px;
    border: 2px dashed #d6d6d6;
    border-radius: 16px;
    background: #fafafa;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.3s ease;
    padding: 20px;
    text-align: center;
}

.custom-upload-box:hover{
    border-color: #9eef0b;
    background: #f8ffea;
}

.custom-upload-box i{
    font-size: 48px;
    color: #111;
    margin-bottom: 10px;
}

.custom-upload-box span{
    font-size: 15px;
    font-weight: 600;
    color: #444;
}
   

        .top-bar{
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }

        .table-card{
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }

        .btn-main{
            background: #9eef0b;
            border: none;
            color: #000;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
        }

        .btn-main:hover{
            background: #85d900;
        }

        .search-box{
            border-radius: 10px;
            height: 48px;
        }

        .product-img{
            width: 70px;
            height: 70px;
            border-radius: 12px;
            object-fit: cover;
        }

        .status-active{
            background: #dcfce7;
            color: #166534;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-expired{
            background: #fee2e2;
            color: #991b1b;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .table td{
            vertical-align: middle;
        }

        .action-btn{
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: none;
            margin-right: 5px;
        }

        .loader-wrapper{
            position: fixed;
            inset: 0;
            background: rgba(255,255,255,0.8);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(3px);
        }

        .loader{
            width: 60px;
            height: 60px;
            border: 5px solid #ddd;
            border-top-color: #9eef0b;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin{
            to{
                transform: rotate(360deg);
            }
        }

        .modal-content{
            border-radius: 20px;
            border: none;
        }

        .form-control{
            border-radius: 10px;
            height: 48px;
        }

        textarea.form-control{
            height: auto;
        }

    </style>

</head>

<body>

<div class="loader-wrapper" id="globalLoader">
    <div class="loader"></div>
</div>

<div class="container page-wrapper">

    <!-- TOP BAR -->
    <div class="top-bar">

        <div class="row align-items-center">

            <div class="col-md-6 mb-3 mb-md-0">

                <button class="btn btn-main"
                        data-bs-toggle="modal"
                        data-bs-target="#addProductModal">

                    <i class="fa fa-plus"></i>
                    Add Product

                </button>

            </div>

            <div class="col-md-6">

                <input type="text"
                       class="form-control search-box"
                       id="searchInput"
                       placeholder="Search products...">

            </div>

        </div>

    </div>

    <!-- TABLE -->
    <div class="table-card">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Validity</th>
                    <th>Remaining Days</th>
                    <th>Status</th>
                    <th width="180">Actions</th>
                </tr>

                </thead>

                <tbody id="productTable">

                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="spinner-border text-success"></div>
                    </td>
                </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- ADD MODAL -->
<div class="modal fade" id="addProductModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header border-0">

                <h4 class="fw-bold">Add Future Product</h4>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <form id="productForm">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="mb-2">Product Title</label>

                            <input type="text"
                                   class="form-control"
                                   name="title"
                                   required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="mb-2">Validity Date</label>

                            <input type="date"
                                   class="form-control"
                                   name="validity">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="mb-2">Status</label>

                            <select class="form-control"
                                    name="status">

                                <option value="1">Active</option>
                                <option value="0">Inactive</option>

                            </select>

                        </div>
<div class="col-12 mb-3">

    <label class="form-label fw-bold mb-2">
        Deal Image
    </label>

    <div class="custom-upload-wrapper">

        <input type="file"
               id="image"
               class="custom-file-input"
               name="image"
               accept="image/*"
               required>

        <label for="image" class="custom-upload-box">

            <i class="fa fa-cloud-upload"></i>

            <span id="uploadText">
                Click to Upload Image
            </span>

        </label>

    </div>

</div>

                 
                       
                    </div>

                    <div class="text-end mt-3">

                        <button type="submit"
                                class="btn btn-main px-4">

                            Save Product

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('js/slickAnimation.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script>

    const API_URL = "/api/get-future-products";
    const STORE_API = "/api/future-products";
const DELETE_API = "/api/future-products";
$("#image").on("change", function () {

    let fileName = this.files[0]?.name;

    if(fileName){

        $("#uploadText").text(fileName);

    }else{

        $("#uploadText").text("Click to Upload Image");

    }

});
    $(document).ready(function () {

        loadProducts();

    });

    function showLoader(){
        $("#globalLoader").css("display","flex");
    }

    function hideLoader(){
        $("#globalLoader").hide();
    }

    function loadProducts(){

        showLoader();

        $.ajax({

            url: API_URL,
            type: "GET",

            success: function (res){

                let html = "";

                if(res.data.length === 0){

                    html = `
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                No products found
                            </td>
                        </tr>
                    `;

                }else{

                    res.data.forEach((item)=>{

                        let remainingDays = calculateRemainingDays(item.validity);

                        let statusBadge = remainingDays < 0
                            ? `<span class="status-expired">Expired</span>`
                            : `<span class="status-active">Active</span>`;

                        html += `
                            <tr>

                                <td>
                                    <img src="${item.image}"
                                         class="product-img">
                                </td>

                                <td>
                                    <strong>${item.title}</strong>
                                </td>

                                <td>
                                    ${item.validity ?? '-'}
                                </td>

                                <td>
                                    ${remainingDays >= 0
                                        ? remainingDays + ' Days'
                                        : 'Expired'}
                                </td>

                                <td>
                                    ${statusBadge}
                                </td>

                                <td>

                                    <button class="action-btn btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <button class="action-btn btn btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                   <button class="action-btn btn btn-danger"
                                        onclick="deleteProduct(${item.id}, this)">
                                    <i class="fa fa-trash"></i>
                                </button>
  

                                </td>

                            </tr>
                        `;

                    });

                }

                $("#productTable").html(html);

                hideLoader();

            },

            error:function (){

                hideLoader();

                $("#productTable").html(`
                    <tr>
                        <td colspan="6" class="text-center text-danger py-5">
                            Failed to load products
                        </td>
                    </tr>
                `);

            }

        });

    }

    function calculateRemainingDays(date){

        if(!date) return '-';

        const today = new Date();

        const validityDate = new Date(date);

        const diffTime = validityDate - today;

        return Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    }

    // SEARCH
    $("#searchInput").on("keyup", function() {

        let value = $(this).val().toLowerCase();

        $("#productTable tr").filter(function() {

            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

        });

    });

    // STORE PRODUCT
    $("#productForm").submit(function (e){

        e.preventDefault();

        showLoader();

        let formData = new FormData(this);

        $.ajax({

            url: STORE_API,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success:function (res){

                hideLoader();

                $("#addProductModal").modal('hide');

                $("#productForm")[0].reset();

                loadProducts();

            },

            error:function (err){

                hideLoader();

                alert("Something went wrong");

                console.log(err);

            }

        });

    });
  function deleteProduct(id, el){

        if(!confirm("Are you sure?")) return;

        showLoader();

        $.ajax({
            url: DELETE_API + "/" + id,
            type: "DELETE",

            success:function(){

                $(el).closest("tr").remove();
                hideLoader();

            },

            error:function(){
                hideLoader();
                alert("Delete failed");
            }
        });

    }
</script>

</body>
</html>   