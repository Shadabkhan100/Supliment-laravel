<!doctype html>
<html>
<head>
    <title>Edit Product</title>

    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <style>

        .tag-chip {
            background:#111;
            color:#fff;
            padding:6px 12px;
            border-radius:20px;
            display:inline-flex;
            align-items:center;
            gap:8px;
            margin:4px;
        }

        .tag-chip button {
            background:none;
            border:none;
            color:#fff;
            font-weight:bold;
            cursor:pointer;
            padding:0;
            line-height:1;
        }

        .gallery-item{
            position:relative;
        }

        .gallery-item img{
            width:90px;
            height:90px;
            object-fit:cover;
            border-radius:8px;
        }

        .remove-gallery-btn{
            position:absolute;
            top:-6px;
            right:-6px;
            width:22px;
            height:22px;
            border:none;
            border-radius:50%;
            background:red;
            color:#fff;
            font-weight:bold;
            cursor:pointer;
        }

    </style>
</head>

<body>

<div class="container py-5">

    <h2 class="mb-4">
        Edit Product
    </h2>

    <form id="editForm" enctype="multipart/form-data">

        @csrf

        <input type="hidden"
               name="id"
               value="{{ $product['id'] }}">

        <!-- NAME -->
        <div class="mb-3">

            <label class="form-label">
                Name
            </label>

            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ $product['name'] }}">

        </div>

        <!-- SKU -->
        <div class="mb-3">

            <label class="form-label">
                SKU
            </label>

            <input type="text"
                   name="sku"
                   class="form-control"
                   value="{{ $product['sku'] }}">

        </div>

        <!-- PRICE -->
        <div class="mb-3">

            <label class="form-label">
                Price
            </label>

            <input type="text"
                   name="price"
                   class="form-control"
                   value="{{ $product['price'] }}">

        </div>

        <!-- OLD PRICE -->
        <div class="mb-3">

            <label class="form-label">
                Old Price
            </label>

            <input type="text"
                   name="old_price"
                   class="form-control"
                   value="{{ $product['old_price'] }}">

        </div>

        <!-- STOCK -->
        <div class="mb-3">

            <label class="form-label">
                Stock
            </label>

            <input type="text"
                   name="stock"
                   class="form-control"
                   value="{{ $product['stock'] }}">

        </div>

        <!-- DESCRIPTION -->
        <div class="mb-3">

            <label class="form-label">
                Description
            </label>

            <textarea name="description"
                      class="form-control"
                      rows="8">{{ $product['description'] }}</textarea>

        </div>

        <!-- MAIN IMAGE -->
        <div class="mb-3">

            <label class="form-label">
                Main Image
            </label>

            <div class="mb-2">

                <img id="mainPreview"
                     src="{{ $product['main_image'] }}"
                     style="width:140px;height:140px;object-fit:cover;border-radius:10px;">

            </div>

            <input type="file"
                   name="main_image"
                   id="mainImageInput"
                   class="form-control">

        </div>

        <!-- GALLERY -->
        <div class="mb-3">

            <label class="form-label">
                Gallery Images
            </label>

            <div id="galleryBox"
                 class="d-flex flex-wrap gap-2 mb-3">

                @foreach($product['gallery_images'] as $index => $img)

                    <div class="gallery-item">

                        <img src="{{ $img }}">

                        <button type="button"
                                class="remove-gallery-btn"
                                onclick="removeGalleryImage({{ $index }})">
                            ×
                        </button>

                    </div>

                @endforeach

            </div>

            <input type="file"
                   name="gallery_images[]"
                   id="galleryInput"
                   multiple
                   class="form-control">

        </div>

        <!-- TAGS -->
        <div class="mb-3">

            <label class="form-label">
                Tags
            </label>

            <select id="tagSelect"
                    class="form-select mb-3">

                <option value="">
                    Select Tag
                </option>

            </select>

            <div id="tagBox"></div>

        </div>

        <!-- WEIGHTS -->
        <div class="mb-3">

            <label class="form-label">
                Weights
            </label>

            <input type="text"
                   id="weightsInput"
                   class="form-control"
                   value="{{ implode(',', $product['weights']) }}">

        </div>

        <!-- SUBMIT -->
        <button class="btn btn-primary w-100">
            Update Product
        </button>

    </form>

</div>

<script src="/js/jquery.min.js"></script>

<script>

/* =========================
   TAG OPTIONS
========================= */

const availableTags = [
    "Cleanse & Reset",
    "Daily Energy",
    "Peak Performance",
    "Radiance & Beauty",
    "Mind & Focus",
    "Total Wellness",
    "Restore & Renew"
];

/* =========================
   EXISTING PRODUCT TAGS
========================= */

let selectedTags = @json($product['tags'] ?? []);

/* =========================
   EXISTING GALLERY
========================= */

let galleryImages = @json($product['gallery_images'] ?? []);

/* =========================
   INIT TAG DROPDOWN
========================= */

function initTagDropdown()
{
    $('#tagSelect').html(`
        <option value="">
            Select Tag
        </option>
    `);

    availableTags.forEach(tag => {

        $('#tagSelect').append(`
            <option value="${tag}">
                ${tag}
            </option>
        `);

    });
}

/* =========================
   RENDER TAGS
========================= */

function renderTags()
{
    $('#tagBox').html('');

    selectedTags.forEach((tag,index)=>{

        $('#tagBox').append(`
            <span class="tag-chip">
                ${tag}

                <button type="button"
                        onclick="removeTag(${index})">
                    ×
                </button>
            </span>
        `);

    });
}

/* =========================
   ADD TAG
========================= */

$('#tagSelect').on('change', function(){

    let value = $(this).val();

    if(!value)
    {
        return;
    }

    if(selectedTags.includes(value))
    {
        $(this).val('');
        return;
    }

    selectedTags.push(value);

    renderTags();

    $(this).val('');

});

/* =========================
   REMOVE TAG
========================= */

function removeTag(index)
{
    selectedTags.splice(index,1);

    renderTags();
}

/* =========================
   REMOVE GALLERY IMAGE
========================= */

function removeGalleryImage(index)
{
    galleryImages.splice(index,1);

    renderGalleryImages();
}

/* =========================
   RENDER GALLERY
========================= */

function renderGalleryImages()
{
    $('#galleryBox').html('');

    galleryImages.forEach((img,index)=>{

        $('#galleryBox').append(`
            <div class="gallery-item">

                <img src="${img}">

                <button type="button"
                        class="remove-gallery-btn"
                        onclick="removeGalleryImage(${index})">
                    ×
                </button>

            </div>
        `);

    });
}

/* =========================
   MAIN IMAGE PREVIEW
========================= */

$('#mainImageInput').on('change', function(e){

    let file = e.target.files[0];

    if(!file)
    {
        return;
    }

    let reader = new FileReader();

    reader.onload = function(event){

        $('#mainPreview').attr('src', event.target.result);

    };

    reader.readAsDataURL(file);

});

/* =========================
   INIT PAGE
========================= */

$(document).ready(function(){

    initTagDropdown();

    renderTags();

    renderGalleryImages();

});

/* =========================
   SUBMIT
========================= */

$('#editForm').on('submit', function(e){

    e.preventDefault();

    let formData = new FormData(this);

    formData.append(
        'tags',
        JSON.stringify(selectedTags)
    );

    formData.append(
        'weights',
        JSON.stringify(
            $('#weightsInput')
                .val()
                .split(',')
                .map(x => x.trim())
                .filter(x => x !== '')
        )
    );

    formData.append(
        'existing_gallery_images',
        JSON.stringify(galleryImages)
    );

    $.ajax({

        url:'/update-product/{{ $product["id"] }}',

        type:'POST',

        data:formData,

        processData:false,

        contentType:false,

        beforeSend:function(){

            $('button[type="submit"]')
                .text('Updating...')
                .prop('disabled', true);

        },

        success:function(res){

            alert(res.message);

            window.location.href='/products';

        },

        complete:function(){

            $('button[type="submit"]')
                .text('Update Product')
                .prop('disabled', false);

        }

    });

});

</script>

</body>
</html>