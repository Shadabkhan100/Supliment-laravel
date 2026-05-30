<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs Management</title>

    <!-- All CSS files -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-animation.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <style>
        body{
            background:#f8f8f8;
        }

        .blog-card-box{
            background:#fff;
            border-radius:16px;
            padding:24px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        .table img{
            width:70px;
            height:70px;
            object-fit:cover;
            border-radius:10px;
        }

        .action-btn{
            width:36px;
            height:36px;
            border:none;
            border-radius:8px;
            display:flex;
            align-items:center;
            justify-content:center;
            text-decoration:none;
        }

        .view-btn{
            background:#e8f3ff;
            color:#0d6efd;
        }

        .edit-btn{
            background:#fff4de;
            color:#ff9800;
        }

        .delete-btn{
            background:#ffe5e5;
            color:#dc3545;
        }

        .modal-lg{
            max-width:900px;
        }

        textarea{
            min-height:140px;
        }



        .modal-content {
            border-radius: 16px;
            border: none;
        }

        .modal-body {
            max-height: 75vh;
            overflow-y: auto; background:white;

        }




  .preview-box {
            width: 160px;
            position: relative;
            display: none;
            margin-top: 10px;
        }

        .preview-box img {
            width: 160px;
            height: 160px;
            object-fit: cover;
            border-radius: 14px;
            border: 2px solid #ddd;
        }

    </style>
</head>
<body>

<div class="container py-5">

    <div class="blog-card-box">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

            <div class="w-50">
                <input
                    type="text"
                    id="searchBlog"
                    class="form-control"
                    placeholder="Search blogs by title, author, description..."
                >
            </div>

            <button
                class="btn btn-dark px-4"
                data-bs-toggle="modal"
                data-bs-target="#blogModal"
                onclick="openCreateModal()"
            >
                Add Blog
            </button>

        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publish Date</th>
                        <th>Status</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>

                <tbody id="blogsTableBody">

                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- BLOG MODAL -->
<div class="modal fade" id="blogModal" tabindex="-1" style="background-color:white;height:100vh">


    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Blog</h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>
            </div>

            <form id="blogForm">

                <div class="modal-body">

                    <input type="hidden" id="blog_id">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Blog Title</label>

                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                required
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Author Name</label>

                            <input
                                type="text"
                                class="form-control"
                                id="author"
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Publish Date</label>

                            <input
                                type="date"
                                class="form-control"
                                id="publish_date"
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>

                            <select class="form-control" id="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Short Description</label>

                            <textarea
                                class="form-control"
                                id="short_description"
                            ></textarea>
                        </div>

                       <div class="col-12 mb-3">
    <label class="form-label">Description</label>

    <textarea
        class="form-control"
        id="description"
        name="description"
    ></textarea>
</div>
<div class="col-12 mb-3">

    <label class="form-label fw-bold mb-2">
        Blog Image
    </label>

    <div class="custom-upload-wrapper">

        <input
            type="file"
            id="image"
            accept="image/*"
            hidden>

        <label for="image" class="custom-upload-box">

            <i class="fa fa-cloud-upload"></i>

            <span>
                Click to Upload Image
            </span>

        </label>

    </div>

</div>
                      
                    </div>

                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>

                    <button
                        type="submit"
                        class="btn btn-dark"
                    >
                        Save Blog
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Jquery Js -->
<script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('js/slickAnimation.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
ClassicEditor
    .create(document.querySelector('#description'), {
        toolbar: [
            'heading',
            '|',
            'bold',
            'italic',
            'link',
            'bulletedList',
            'numberedList',
            '|',
            'blockQuote',
            'insertTable',
            'imageUpload',
            'undo',
            'redo'
        ]
    })
    .catch(error => {
        console.error(error);
    });
</script>
<script>

    let allBlogs = [];

    fetchBlogs();

    // FETCH BLOGS
    function fetchBlogs()
    {
        $.ajax({
            url: '/api/blogs',
            type: 'GET',

            success: function(response)
            {
                allBlogs = response.data;
                renderBlogs(allBlogs);
            }
        });
    }

    // RENDER BLOGS
    function renderBlogs(blogs)
    {
        let html = '';

        blogs.forEach((blog, index) => {

            html += `
                <tr>

                    <td>${index + 1}</td>

                    <td>
                        ${
                            blog.image
                            ?
                            `<img src="${blog.image}" />`
                            :
                            `No Image`
                        }
                    </td>

                    <td>${blog.title ?? ''}</td>

                    <td>${blog.author ?? '-'}</td>

                    <td>${blog.publish_date ?? '-'}</td>

                    <td>
                        ${
                            blog.status == 1
                            ?
                            `<span class="badge bg-success">Active</span>`
                            :
                            `<span class="badge bg-danger">Inactive</span>`
                        }
                    </td>

                    <td>

                        <div class="d-flex gap-2">

                            <a
                                href="/blogs/view-blogs/name/${blog.id}"
                                target="_blank"
                                class="action-btn view-btn"
                            >
                                <i class="fa-light fa-eye"></i>
                            </a>

                            <button
                                class="action-btn edit-btn"
                                onclick="editBlog(${blog.id})"
                            >
                                <i class="fa-light fa-pen"></i>
                            </button>

                            <button
                                class="action-btn delete-btn"
                                onclick="deleteBlog(${blog.id})"
                            >
                                <i class="fa-light fa-trash"></i>
                            </button>

                        </div>

                    </td>

                </tr>
            `;
        });

        $('#blogsTableBody').html(html);
    }

    // SEARCH BLOGS
    $('#searchBlog').on('keyup', function(){

        let keyword = $(this).val().toLowerCase();

        let filteredBlogs = allBlogs.filter(blog => {

            return (
                (blog.title && blog.title.toLowerCase().includes(keyword)) ||
                (blog.author && blog.author.toLowerCase().includes(keyword)) ||
                (blog.short_description && blog.short_description.toLowerCase().includes(keyword)) ||
                (blog.description && blog.description.toLowerCase().includes(keyword))
            );
        });

        renderBlogs(filteredBlogs);
    });

    // OPEN CREATE MODAL
    function openCreateModal()
    {
        $('#modalTitle').text('Add Blog');

        $('#blogForm')[0].reset();

        $('#blog_id').val('');
    }

    // SAVE BLOG
    $('#blogForm').submit(function(e){

        e.preventDefault();

        let blogId = $('#blog_id').val();

        let formData = new FormData();

        formData.append('title', $('#title').val());
        formData.append('author', $('#author').val());
        formData.append('publish_date', $('#publish_date').val());
        formData.append('status', $('#status').val());
        formData.append('short_description', $('#short_description').val());
        formData.append('description', $('#description').val());

        if($('#image')[0].files[0]){
            formData.append('image', $('#image')[0].files[0]);
        }

        let url = '/api/blogs/create-blogs';

        if(blogId){
            url = '/api/blogs/update-blogs/' + blogId;
        }

        $.ajax({

            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            success: function(response){

                $('#blogModal').modal('hide');

                fetchBlogs();

                alert(response.message);
            },

            error: function(error){

                console.log(error);

                alert('Something went wrong');
            }
        });
    });

    // EDIT BLOG
    function editBlog(id)
    {
        $.ajax({

            url: '/api/blogs/get-blogs/' + id,
            type: 'GET',

            success: function(response){

                let blog = response.data;

                $('#modalTitle').text('Edit Blog');

                $('#blog_id').val(blog.id);

                $('#title').val(blog.title);
                $('#author').val(blog.author);
                $('#publish_date').val(blog.publish_date);
                $('#status').val(blog.status);
                $('#short_description').val(blog.short_description);
                $('#description').val(blog.description);

                $('#blogModal').modal('show');
            }
        });
    }

    // DELETE BLOG
    function deleteBlog(id)
    {
        if(confirm('Are you sure you want to delete this blog?'))
        {
            $.ajax({

                url: '/api/blogs/delete-blogs/' + id,
                type: 'DELETE',

                success: function(response){

                    fetchBlogs();

                    alert(response.message);
                }
            });
        }
    }

</script>

</body>
</html>