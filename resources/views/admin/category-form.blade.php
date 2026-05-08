<!doctype html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Category Management</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- JQuery -->
    <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>

    <style>

        body{
            background:#f4f6f9;
            font-family:Arial,sans-serif;
        }

        .page-card{
            background:#fff;
            border-radius:20px;
            padding:30px;
            box-shadow:0 10px 30px rgba(0,0,0,0.06);
        }

        .table img{
            width:60px;
            height:60px;
            object-fit:cover;
            border-radius:12px;
        }

        .form-box{
            display:none;
            background:#fafafa;
            border:1px solid #eee;
            border-radius:20px;
            padding:25px;
            margin-top:20px;
        }

        .btn-action{
            min-width:80px;
        }

        .preview-image{
            width:120px;
            height:120px;
            object-fit:cover;
            border-radius:16px;
            border:1px solid #ddd;
            margin-top:15px;
            display:none;
        }

        .table thead{
            background:#111;
            color:#fff;
        }

        .pagination .page-link{
            color:#111;
        }

        .pagination .active .page-link{
            background:#111;
            border-color:#111;
        }

    </style>

</head>

<body>

<div class="container py-5">

    <div class="page-card">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="fw-bold mb-1">
                    Category Management
                </h2>

                <p class="text-muted mb-0">
                    Manage all categories and products
                </p>
            </div>

            <button class="btn btn-dark px-4"
                    id="toggleCategoryForm">

                + Add Category

            </button>

        </div>

        <!-- FORM -->
        <div class="form-box" id="categoryFormBox">

            <form id="categoryForm"
                  enctype="multipart/form-data">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">
                            Category Name
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Enter category name">

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">
                            Category Image
                        </label>

                        <input type="file"
                               name="image"
                               id="categoryImage"
                               class="form-control"
                               accept="image/*">

                        <img src=""
                             id="imagePreview"
                             class="preview-image">

                    </div>

                </div>

                <button type="submit"
                        class="btn btn-dark px-5">

                    Save Category

                </button>

            </form>

        </div>

        <!-- TABLE -->
        <div class="table-responsive mt-5">

            <table class="table align-middle table-bordered">

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Category Name</th>
                        <th>Total Products</th>
                        <th width="280">Actions</th>
                    </tr>

                </thead>

                <tbody id="categoryTableBody">

                    <!-- DYNAMIC DATA -->

                </tbody>

            </table>

        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-center mt-4">

            <nav>

                <ul class="pagination" id="pagination">

                    <!-- PAGINATION -->

                </ul>

            </nav>

        </div>

    </div>

</div>

<!-- Bootstrap -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script>

    let categories = [];

    let currentPage = 1;

    let perPage = 10;

    /* =========================
       TOGGLE FORM
    ========================== */

    $('#toggleCategoryForm').click(function(){

        $('#categoryFormBox').slideToggle();

    });

    /* =========================
       IMAGE PREVIEW
    ========================== */

    $('#categoryImage').change(function(e){

        let file = e.target.files[0];

        if(file)
        {
            $('#imagePreview')
                .show()
                .attr('src', URL.createObjectURL(file));
        }

    });

    /* =========================
       FORM SUBMIT
    ========================== */

    $('#categoryForm').submit(function(e){

        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({

            url:'/api/create-category',

            type:'POST',

            data:formData,

            processData:false,

            contentType:false,

            success:function(res){

                alert('Category Created Successfully');

                $('#categoryForm')[0].reset();

                $('#imagePreview').hide();

                loadCategories();

            },

            error:function(err){

                console.log(err.responseJSON);

                alert('Error');

            }

        });

    });

    /* =========================
       LOAD CATEGORIES
    ========================== */

    function loadCategories(page = 1)
    {

        $.ajax({

            url:'/api/categories?page=' + page,

            type:'GET',

            success:function(res){

                categories = res.data;

                renderTable(categories);

                renderPagination(res.data);

            }

        });

    }

    /* =========================
       RENDER TABLE
    ========================== */

    function renderTable(data)
    {

        $('#categoryTableBody').html('');

        data.forEach((category,index)=>{

            $('#categoryTableBody').append(`

                <tr>

                    <td>${index + 1}</td>

                    <td>
                        <img src="${category.image}">
                    </td>

                    <td>
                        ${category.name}
                    </td>

                    <td>
                        ${category.products_count}
                    </td>

                    <td>

                        <button class="btn btn-info btn-sm btn-action">
                            View
                        </button>

                        <button class="btn btn-warning btn-sm btn-action">
                            Edit
                        </button>

                        <button class="btn btn-danger btn-sm btn-action"
                                onclick="deleteCategory(${category.id})">

                            Delete

                        </button>

                    </td>

                </tr>

            `);

        });

    }

    /* =========================
       PAGINATION
    ========================== */

    function renderPagination(data)
    {

        $('#pagination').html('');

        for(let i = 1; i <= data.last_page; i++)
        {

            $('#pagination').append(`

                <li class="page-item ${i == data.current_page ? 'active' : ''}">

                    <a class="page-link"
                       href="#"
                       onclick="loadCategories(${i})">

                        ${i}

                    </a>

                </li>

            `);

        }

    }

    /* =========================
       DELETE CATEGORY
    ========================== */

    function deleteCategory(id)
    {

        if(!confirm('Delete this category?'))
        {
            return;
        }

        $.ajax({

            url:'/api/delete-category/' + id,

            type:'DELETE',

            data:{
                _token:'{{ csrf_token() }}'
            },

            success:function(res){

                alert('Deleted Successfully');

                loadCategories();

            }

        });

    }

    /* =========================
       INITIAL LOAD
    ========================== */

    loadCategories();

</script>

</body>
</html>