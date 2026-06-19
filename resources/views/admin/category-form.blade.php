@extends('admin.main')

@section('title', 'Category Management')
@section('page-title', 'Category Management')

@section('content')

<style>
.modal-content{
    background:#fff !important;
    border-radius:16px;
    border:none;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
}

.modal-header{
    border-bottom:1px solid #eee;
    padding:18px 22px;
}

.modal-header h5{
    font-weight:600;
    margin:0;
    color:#111827;
}

.modal-body{
    padding:22px;
    background:#fff;
}

.preview-image{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:12px;
    margin-top:10px;
    display:none;
    border:1px solid #ddd;
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

.table thead{
    background:#111;
    color:#fff;
}
</style>

<div class="container py-5">

    <div class="page-card">

        <!-- HEADER -->
        <div class="d-flex justify-content-between mb-4">

            <div>
                <h3>Category Management</h3>
                <p class="text-muted">Manage categories</p>
            </div>

            <button class="btn btn-dark" onclick="openAddModal()">
                + Add Category
            </button>

        </div>

        <!-- TABLE -->
        <table class="table table-bordered align-middle">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Products</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="categoryTableBody"></tbody>

        </table>

    </div>

</div>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 id="modalTitle">Add Category</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="categoryForm" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" id="category_id">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" id="edit_name" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Image</label>
                        <input style="display:block" type="file" id="edit_image" name="image" class="form-control">
                        <img id="edit_preview" class="preview-image">
                    </div>

                    <button class="btn btn-dark w-100" id="submitBtn">
                        Save
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script>
let modal;

$(document).ready(function () {

    modal = new bootstrap.Modal(document.getElementById('categoryModal'));

    loadCategories();
});

/* ================= LOAD ================= */
function loadCategories()
{
    $.get('/api/categories', function(res){

        let data = res.data;

        $('#categoryTableBody').html('');

        data.forEach((c,i)=>{

            $('#categoryTableBody').append(`
                <tr>
                    <td>${i+1}</td>
                    <td><img src="${c.image}"></td>
                    <td>${c.name}</td>
                    <td>${c.products_count}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick='editCategory(${JSON.stringify(c)})'>Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteCategory(${c.id})">Delete</button>
                    </td>
                </tr>
            `);
        });

    });
}

/* ================= ADD MODAL ================= */
function openAddModal()
{
    $('#categoryForm')[0].reset();
    $('#category_id').val('');
    $('#edit_preview').hide();
    $('#modalTitle').text('Add Category');
    $('#submitBtn').text('Save');

    modal.show();
}

/* ================= EDIT ================= */
function editCategory(c)
{
    $('#category_id').val(c.id);
    $('#edit_name').val(c.name);

    $('#modalTitle').text('Edit Category');
    $('#submitBtn').text('Update');

    if(c.image){
        $('#edit_preview').show().attr('src', c.image);
    }

    modal.show();
}

/* ================= IMAGE PREVIEW ================= */
$(document).on('change', '#edit_image', function(e){

    let file = e.target.files[0];

    if(file){
        let reader = new FileReader();

        reader.onload = function(e){
            $('#edit_preview')
                .attr('src', e.target.result)
                .show();
        };

        reader.readAsDataURL(file);
    }
});

/* ================= SUBMIT ================= */
$('#categoryForm').submit(function(e){

    e.preventDefault();

    let formData = new FormData(this);
    let id = $('#category_id').val();

    let url = id
        ? `/api/edit-category/${id}`
        : `/api/create-category`;

    $.ajax({
        url:url,
        type:'POST',
        data:formData,
        processData:false,
        contentType:false,

        success:function(){
            modal.hide();
            loadCategories();
        },

        error:function(err){
            console.log(err.responseJSON);
            alert("Something went wrong");
        }
    });

});

/* ================= DELETE ================= */
function deleteCategory(id)
{
    if(!confirm('Delete?')) return;

    $.ajax({
        url:'/api/delete-category/'+id,
        type:'DELETE',
        data:{_token:'{{ csrf_token() }}'},
        success:function(){
            loadCategories();
        }
    });
}

</script>




@endsection