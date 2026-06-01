<!doctype html>
<html>
<head>

    <title>Edit Product</title>

    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <style>
.pack-card {
    position: relative;
    display: flex;
    gap: 12px;
    align-items: center;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 10px;
}

.pack-remove {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: none;
    background: #dc3545;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
}
        .tag-chip,
        .weight-chip{
            background:#111;
            color:#fff;
            padding:6px 12px;
            border-radius:20px;
            display:inline-flex;
            align-items:center;
            gap:8px;
            margin:4px;
            font-size:14px;
        }

        .tag-chip button,
        .weight-chip button{
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

<!-- CATEGORY -->
<div class="mb-3">
    <label class="form-label">Category</label>

    <select id="categorySelect" class="form-select">
        <option value="">Loading categories...</option>
    </select>
</div>
<!-- DEAL -->
<div class="mb-3">
    <label class="form-label">Deal</label>

    <select id="dealSelect" class="form-select">
        <option value="">Loading deals...</option>
    </select>
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

            <div id="tagError"
                 class="text-danger small mb-2">
            </div>

            <div id="tagBox"></div>

        </div>

        <!-- WEIGHTS -->
        <div class="mb-3">

            <label class="form-label">
                Weights
            </label>

            <div class="d-flex gap-2 mb-3">

                <input type="text"
                       id="weightInput"
                       class="form-control"
                       placeholder="Enter weight">

                <button type="button"
                        id="addWeightBtn"
                        class="btn btn-dark">
                    Add
                </button>

            </div>

            <div id="weightBox"></div>

        </div>
<!-- PACK OPTIONS -->
<div class="mb-3">

    <label class="form-label">
        Pack Options
    </label>

    <div class="row g-2 mb-3">

        <div class="col-md-3">
            <input type="number"
                   id="packInput"
                   class="form-control"
                   placeholder="Packs">
        </div>

        <div class="col-md-3">
            <input type="number"
                   id="packPriceInput"
                   class="form-control"
                   placeholder="Price">
        </div>

        <div class="col-md-4">
            <input type="text"
                   id="packDurationInput"
                   class="form-control"
                   placeholder="Duration (e.g. 15 days)">
        </div>

       <input type="file"
           id="optionImageInput"
           accept="image/*"
           style="width:200px;">

        <div class="col-md-2">
            <button type="button"
                    id="addPackOption"
                    class="btn btn-dark w-100">
                Add
            </button>
        </div>

    </div>

    <div id="packBox"></div>

</div>
        <!-- SUBMIT -->
        <button type="submit"
                class="btn btn-primary w-100">
            Update Product
        </button>

    </form>

</div>




<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="/js/bootstrap.min.js"></script>

<script>
const SUPABASE_URL = "https://dulladbjjuutgcgyliou.supabase.co";
const SUPABASE_KEY = "sb_publishable_LvoiRePLm78hYnz56-Iw6A_yWqVt_vs";
const SUPABASE_BUCKET = "slimza-images";

let optionImageFile = null;



async function uploadToSupabase(file)
{
    if (!file) {
        console.error("No file provided");
        return null;
    }

    const fileName = `options/${Date.now()}_${file.name}`;

    const url = `${SUPABASE_URL}/storage/v1/object/${SUPABASE_BUCKET}/${fileName}`;

    try {
        const res = await fetch(url, {
            method: "POST", // ✅ Supabase browser-safe method
            headers: {
                apikey: SUPABASE_KEY,
                Authorization: `Bearer ${SUPABASE_KEY}`
            },
            body: file
        });

        const text = await res.text();
        console.log("Supabase raw response:", text);

        if (!res.ok) {
            console.error("Upload failed:", text);
            return null;
        }

        return `${SUPABASE_URL}/storage/v1/object/public/${SUPABASE_BUCKET}/${fileName}`;
    }
    catch (err) {
        console.error("Upload error:", err);
        return null;
    }
}



$('#optionImageInput').on('change', function (e) {
    optionImageFile = e.target.files[0] || null;

    
   
});


$(document).ready(function () {

/* =========================
   CONSTANT TAGS
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
   SAFE INIT DATA (IMPORTANT FIX)
========================= */

// ensure arrays ALWAYS
let selectedTags = Array.isArray(@json($product['tags'] ?? []))
    ? @json($product['tags'] ?? [])
    : [];

let selectedWeights = Array.isArray(@json($product['weights'] ?? []))
    ? @json($product['weights'] ?? [])
    : [];

let galleryImages = Array.isArray(@json($product['gallery_images'] ?? []))
    ? @json($product['gallery_images'] ?? [])
    : [];
let selectedOptions = Array.isArray(@json($product['options'] ?? []))
    ? @json($product['options'] ?? [])
    : [];

function renderOptions()
{
    $('#packBox').html('');

    selectedOptions.forEach((opt, i) => {

        $('#packBox').append(`
            <div class="position-relative d-flex align-items-center gap-3 p-2 mb-2 border rounded">

                ${opt.image ? `
                    <img src="${opt.image}"
                         style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
                ` : ''}

                <div>
                    <div><b>Packs:</b> ${opt.pack}</div>
                    <div><b>Price:</b> ${opt.price}</div>
                    <div><b>Duration:</b> ${opt.duration}</div>
                </div>

                <!-- DELETE BUTTON -->
                <button type="button"
                        onclick="removeOption(${i})"
                        style="
                            position:absolute;
                            top:6px;
                            right:6px;
                            width:24px;
                            height:24px;
                            border:none;
                            border-radius:50%;
                            background:#dc3545;
                            color:#fff;
                            font-weight:bold;
                            line-height:1;
                        ">
                    ×
                </button>

            </div>
        `);

    });
}
window.removeOption = function (index)
{
    selectedOptions.splice(index, 1);
    renderOptions();
};
$('#addPackOption').click(async function () {

    let pack = $('#packInput').val().trim();
    let price = $('#packPriceInput').val()?.trim();
let duration = $('#packDurationInput').val()?.trim();

    if (!pack || !price || !duration) return;

    let imageUrl = null;

    if (optionImageFile) {
        imageUrl = await uploadToSupabase(optionImageFile);
    }

    selectedOptions.push({
        pack: parseInt(pack),
        price: parseFloat(price),
        duration: duration,
        image: imageUrl
    });

    $('#packInput').val('');
    $('#priceInput').val('');
    $('#durationInput').val('');
    $('#optionImageInput').val('');

    optionImageFile = null;

    renderOptions();
});
/* =========================
   CATEGORY + DEAL STATE
========================= */

let selectedCategoryId = "{{ $product['category_id'] ?? '' }}";
let selectedDealId = "{{ $product['deal_id'] ?? '' }}";

/* =========================
   LOAD CATEGORIES
========================= */

function loadCategories(selectedId = null)
{
    $.ajax({
        url: '/api/categories',
        type: 'GET',

        success: function (res) {

            let categories = res?.data?.data ?? res?.data ?? [];

            let select = $('#categorySelect');
            select.html('<option value="">Select Category</option>');

            categories.forEach(cat => {
                select.append(`
                    <option value="${cat.id}">
                        ${cat.name}
                    </option>
                `);
            });

            if (selectedId) {
                select.val(selectedId);
            }
        },

        error: function (err) {
            console.log('CATEGORY ERROR:', err.responseText);
        }
    });
}

/* =========================
   LOAD DEALS
========================= */

function loadDeals(selectedId = null)
{
    $.ajax({
        url: '/api/deals',
        type: 'GET',

        success: function (res) {
console.log(res.data);

            let deals = res.data ?? res.data ?? [];

            let select = $('#dealSelect');
            select.html('<option value="">Select Deal</option>');

            deals.forEach(deal => {
                select.append(`
                    <option value="${deal.id}">
                        ${deal.title}
                    </option>
                `);
            });

            if (selectedId) {
                select.val(selectedId);
            }
        },

        error: function (err) {
            console.log('DEAL ERROR:', err.responseText);
        }
    });
}

/* =========================
   TAG DROPDOWN
========================= */

function initTagDropdown()
{
    let select = $('#tagSelect');
    select.html('<option value="">Select Tag</option>');

    availableTags.forEach(tag => {
        select.append(`<option value="${tag}">${tag}</option>`);
    });
}

/* =========================
   RENDER TAGS
========================= */

function renderTags()
{
    $('#tagBox').html('');

    selectedTags.forEach((tag, index) => {
        $('#tagBox').append(`
            <span class="tag-chip">
                ${tag}
                <button type="button" onclick="removeTag(${index})">×</button>
            </span>
        `);
    });
}

/* =========================
   REMOVE TAG
========================= */

window.removeTag = function (index)
{
    selectedTags.splice(index, 1);
    renderTags();
};

/* =========================
   ADD TAG
========================= */

$('#tagSelect').on('change', function () {

    let value = $(this).val();

    if (!value) return;

    if (selectedTags.includes(value)) {
        $('#tagError').text('Tag already added');
        return;
    }

    selectedTags.push(value);
    renderTags();

    $(this).val('');
});

/* =========================
   WEIGHTS (FIXED AS ARRAY SYSTEM)
========================= */

function renderWeights()
{
    $('#weightBox').html('');

    selectedWeights.forEach((w, i) => {
        $('#weightBox').append(`
            <span class="weight-chip">
                ${w}
                <button type="button" onclick="removeWeight(${i})">×</button>
            </span>
        `);
    });
}

window.removeWeight = function (index)
{
    selectedWeights.splice(index, 1);
    renderWeights();
};

$('#addWeightBtn').on('click', function () {

    let val = $('#weightInput').val().trim();

    if (!val) return;

    if (selectedWeights.includes(val)) {
        alert('Already added');
        return;
    }

    selectedWeights.push(val);
    renderWeights();

    $('#weightInput').val('');
});

/* =========================
   GALLERY
========================= */

function renderGalleryImages()
{
    $('#galleryBox').html('');

    galleryImages.forEach((img, i) => {
        $('#galleryBox').append(`
            <div class="gallery-item">
                <img src="${img}">
                <button type="button"
                        class="remove-gallery-btn"
                        onclick="removeGalleryImage(${i})">×</button>
            </div>
        `);
    });
}

window.removeGalleryImage = function (index)
{
    galleryImages.splice(index, 1);
    renderGalleryImages();
};

/* =========================
   CATEGORY CHANGE
========================= */

$('#categorySelect').on('change', function () {
    selectedCategoryId = $(this).val();
});

/* =========================
   DEAL CHANGE
========================= */

$('#dealSelect').on('change', function () {
    selectedDealId = $(this).val();
});

/* =========================
   MAIN IMAGE PREVIEW
========================= */

$('#mainImageInput').on('change', function (e) {

    let file = e.target.files[0];
    if (!file) return;

    let reader = new FileReader();

    reader.onload = function (event) {
        $('#mainPreview').attr('src', event.target.result);
    };

    reader.readAsDataURL(file);
});

/* =========================
   INIT PAGE (IMPORTANT ORDER FIX)
========================= */

initTagDropdown();
renderTags();
renderWeights();
renderGalleryImages();
renderOptions();
loadCategories(selectedCategoryId);
loadDeals(selectedDealId);

/* =========================
   SUBMIT
========================= */

$('#editForm').on('submit', function (e) {

    e.preventDefault();

    let formData = new FormData(this);

    formData.append('category_id', selectedCategoryId);
    formData.append('deal_id', selectedDealId);

    selectedOptions.forEach((item, index) => {
    formData.append(`options[${index}][pack]`, item.pack);
    formData.append(`options[${index}][price]`, item.price);
    formData.append(`options[${index}][duration]`, item.duration);
    formData.append(`options[${index}][image]`, item.image);
});
    selectedTags.forEach(tag => {
        formData.append('tags[]', tag);
    });

    // =========================
    // SEND WEIGHTS AS ARRAY
    // =========================
    selectedWeights.forEach(weight => {
        formData.append('weights[]', weight);
    });
    formData.append('existing_gallery_images', JSON.stringify(galleryImages));

    $.ajax({
        url: '/api/update-product/{{ $product["id"] }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,

        success: function (res) {
            alert(res.message || 'Updated');
            window.location.href = '/admin/add-product';
        },

        error: function (xhr) {
            console.log(xhr.responseText);
            alert('Update failed');
        }
    });

    return false;
});

});
</script></body>
</html>