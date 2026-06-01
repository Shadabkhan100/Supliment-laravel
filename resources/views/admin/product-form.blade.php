<!doctype html>
<html>
<head>

    <title>Add Product</title>
     <link rel="stylesheet"
          href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('css/product-management.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <style>

        body{
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #f4f6f9;
    padding: 40px;
    color: #333;
}

/* FORM WRAPPER */
form{
    max-width: 850px;
    margin: auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 18px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.08);
}

/* TITLE */
h2{
    text-align: center;
    margin-bottom: 25px;
    font-weight: 700;
}

/* INPUTS */
input,
textarea,
select{
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 10px;
    font-size: 14px;
    transition: 0.2s ease-in-out;
    outline: none;
    background: #fff;
}

input:focus,
textarea:focus,
select:focus{
    border-color: #111;
    box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
}

/* TEXTAREA */
textarea{
    min-height: 100px;
    resize: vertical;
}

/* BUTTON */
button{
    padding: 10px 18px;
    border: none;
    border-radius: 10px;
    background: #111;
    color: #fff;
    cursor: pointer;
    font-weight: 600;
    transition: 0.2s;
}

button:hover{
    background: #333;
}

/* SECTION HEADINGS */
h4{
    margin-top: 25px;
    margin-bottom: 10px;
    font-weight: 600;
}

/* IMAGE PREVIEW */
.preview-image{
    width: 140px;
    height: 140px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #ddd;
    margin-top: 10px;
    display: block;
}

/* GALLERY */
.gallery-item{
    display: inline-block;
    position: relative;
    margin: 8px;
}

.remove-btn{
    position: absolute;
    top: 5px;
    right: 5px;
    background: #e11d48;
    color: #fff;
    border: none;
    cursor: pointer;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    font-size: 12px;
}

/* WEIGHTS TAG */
.weight-tag{
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #111;
    color: #fff;
    padding: 6px 12px;
    border-radius: 25px;
    margin: 5px;
    font-size: 13px;
}

.weight-tag button{
    width: 18px;
    height: 18px;
    padding: 0;
    font-size: 12px;
    line-height: 18px;
    border-radius: 50%;
    background: #e11d48;
}

/* LAYOUT SPACING */
hr{
    margin: 25px 0;
    border: none;
    border-top: 1px solid #eee;
}

    </style>

</head>

<body>

<h2>Create Product</h2>

<form id="productForm">

    @csrf

    <!-- BASIC -->
    <input type="text" name="name" placeholder="Name"><br>
<input type="text" name="name" placeholder="Name"><br>

<select name="category_id" id="category_id">

    <option value="">
        Select Category
    </option>

    @foreach($categories as $category)

        <option value="{{ $category->id }}">
            {{ $category->name }}
        </option>

    @endforeach

</select>

<br><br>

<select name="deal_id" id="deal_id">

    <option value="">
        Select deal
    </option>

    @foreach($deals as $deal)

        <option value="{{ $deal->id }}">
            {{ $deal->title }}
        </option>

    @endforeach

</select>

<br><br>


    <input type="text" name="sku" placeholder="SKU"><br>

    <input type="number" name="price" placeholder="Price"><br>

    <input type="number" name="old_price" placeholder="Old Price"><br>

    <input type="number" name="stock" placeholder="Stock"><br>

  <textarea name="description" id="description"></textarea><br>

    <!-- WEIGHTS -->
    <h4>Weights</h4>

    <input type="text" id="weightInput" placeholder="250g">

    <button type="button" id="addWeight">
        Add Weight
    </button>

    <div id="weightList"></div>

    <hr>
     <h4>Tags</h4>

<select id="tagSelect">
    <option value="">Select Tag</option>
</select>

<div id="tagList"></div>

<hr>
    <!-- MAIN IMAGE -->
    <h4>Main Image</h4>

    <input type="file"
           id="main_image"
           accept="image/*">

    <br><br>

    <img id="mainPreview"
         class="preview-image"
         style="display:none;">

    <hr>

    <!-- GALLERY -->
    <h4>Gallery Images</h4>

    <input type="file"
           id="gallery_images"
           accept="image/*"
           multiple>

    <br><br>

    <div id="galleryPreview"></div>
  
    <hr>
   

<h4>Pack Options</h4>

<div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">

    <input type="number" id="packInput" placeholder="No. of Packs" style="width:150px;">
    <input type="number" id="priceInput" placeholder="Price" style="width:150px;">
    <input type="text" id="durationInput" placeholder="Duration (e.g. 15 days)" style="width:200px;">

    <input type="file"
           id="optionImageInput"
           accept="image/*"
           style="width:200px;">

    <button type="button" id="addPackOption">
        Add Option
    </button>

</div>

<div id="packOptionList"></div>

<hr>





    <button type="submit">
        Submit Product
    </button>

</form>




<script>

const SUPABASE_URL = "{{ $supabaseUrl }}";
const SUPABASE_KEY = "{{ $supabaseKey }}";
const SUPABASE_BUCKET = "{{ $supabaseBucket }}";

 

let editorInstance;
let tags = [];
let packOptions = [];
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
const availableTags = [
    "Cleanse & Reset",
    "Daily Energy",
    "Peak Performance",
    "Radiance & Beauty",
    "Mind & Focus",
    "Total Wellness",
    "Restore & Renew"
];

availableTags.forEach(tag => {
    $('#tagSelect').append(`<option value="${tag}">${tag}</option>`);
});

$('#tagSelect').on('change', function () {

    let value = $(this).val();

    if (!value) return;

    if (!tags.includes(value)) {
        tags.push(value);
    }

    $(this).val('');

    renderTags();
});


function renderTags()
{
    $('#tagList').html('');

    tags.forEach((tag, index) => {

        $('#tagList').append(`

            <div class="weight-tag">

                ${tag}

                <button type="button"
                        onclick="removeTag(${index})">
                    x
                </button>

            </div>

        `);

    });
}

function removeTag(index)
{
    tags.splice(index, 1);
    renderTags();
}


function renderOptions()
{
    $('#packOptionList').html('');

    packOptions.forEach((opt, i) => {

        $('#packOptionList').append(`

            <span class="weight-tag" style="display:flex;align-items:center;gap:10px;">

                ${opt.image ? `<img src="${opt.image}" style="width:40px;height:40px;border-radius:8px;object-fit:cover;">` : ''}

                <div>
                    <div>Packs: ${opt.pack}</div>
                    <div>Price: ${opt.price}</div>
                    <div>Duration: ${opt.duration}</div>
                </div>

                <button type="button" onclick="removePackOption(${i})">×</button>

            </span>

        `);

    });
}

/* =========================
   ADD PACK OPTION
========================== */

$('#addPackOption').click(async function () {

    let pack = $('#packInput').val().trim();
    let price = $('#priceInput').val().trim();
    let duration = $('#durationInput').val().trim();

    if (!pack || !price || !duration) return;

    let imageUrl = null;

    if (optionImageFile) {
        imageUrl = await uploadToSupabase(optionImageFile);
    }

    packOptions.push({
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
   RENDER CARDS
========================== */



/* =========================
   REMOVE
========================== */
function removePackOption(index)
{
    packOptions.splice(index, 1);
    renderOptions();
}
ClassicEditor
    .create(document.querySelector('#description'))
    .then(editor => {
        editorInstance = editor;
    })
    .catch(error => {
        console.error(error);
    });
    let weights = [];

    let galleryFiles = [];

    let mainImageFile = null;

    /* =========================
       WEIGHTS
    ========================== */

    $('#addWeight').click(function () {

        let val = $('#weightInput').val().trim();

        if (!val) return;

        weights.push(val);

        $('#weightInput').val('');

        renderWeights();

    });

    function renderWeights()
    {
        $('#weightList').html('');

        weights.forEach((w, i) => {

            $('#weightList').append(`
            
                <div class="weight-tag">

                    ${w}

                    <button type="button"
                            onclick="removeWeight(${i})">
                        x
                    </button>

                </div>

            `);

        });
    }

    function removeWeight(i)
    {
        weights.splice(i, 1);

        renderWeights();
    }

    /* =========================
       MAIN IMAGE
    ========================== */

    $('#main_image').on('change', function (e) {

        mainImageFile = e.target.files[0];

        if(mainImageFile)
        {
            $('#mainPreview')
                .show()
                .attr('src', URL.createObjectURL(mainImageFile));
        }

    });

    /* =========================
       GALLERY IMAGES
    ========================== */

    $('#gallery_images').on('change', function (e) {

        let files = Array.from(e.target.files);

        // ADD NEW FILES
        files.forEach(file => {

            galleryFiles.push(file);

        });

        renderGallery();

        // RESET INPUT
        $(this).val('');

    });

    function renderGallery()
    {
        $('#galleryPreview').html('');

        galleryFiles.forEach((file, index) => {

            let imageUrl = URL.createObjectURL(file);

            $('#galleryPreview').append(`

                <div class="gallery-item">

                    <button type="button"
                            class="remove-btn"
                            onclick="removeGalleryImage(${index})">

                        x

                    </button>

                    <img src="${imageUrl}"
                         class="preview-image">

                </div>

            `);

        });
    }

    function removeGalleryImage(index)
    {
        galleryFiles.splice(index, 1);

        renderGallery();
    }

    /* =========================
       SUBMIT FORM
    ========================== */

    $('#productForm').submit(function (e) {

        e.preventDefault();

        let formData = new FormData();

        // TEXT FIELDS
        formData.append('name', $('input[name="name"]').val());
        formData.append('category_id',$('#category_id').val());
        formData.append('deal_id',$('#deal_id').val());
        formData.append('sku', $('input[name="sku"]').val());
        formData.append('price', $('input[name="price"]').val());
        formData.append('old_price', $('input[name="old_price"]').val());
        formData.append('stock', $('input[name="stock"]').val());
        formData.append('description', editorInstance.getData());
        

        packOptions.forEach((item, index) => {

    formData.append(`options[${index}][pack]`, item.pack);
    formData.append(`options[${index}][price]`, item.price);
    formData.append(`options[${index}][duration]`, item.duration);
    formData.append(`options[${index}][image]`, item.image);


});
        // WEIGHTS ARRAY
        weights.forEach(weight => {
            formData.append('weights[]', weight);

        });
        tags.forEach(tag => {
    formData.append('tags[]', tag);
});
        // MAIN IMAGE
        if(mainImageFile)
        {
            formData.append('main_image', mainImageFile);
        }

        // GALLERY ARRAY
        galleryFiles.forEach(file => {

            formData.append('gallery_images[]', file);

        });

        $.ajax({

            url: "/api/create-product",

            type: "POST",

            data: formData,

            processData: false,

            contentType: false,

            success: function (res) {

                alert("Product Created Successfully");

                console.log(res);

            },

            error: function (err) {

    console.log(err.responseJSON);

    let message = "Something went wrong";

    // VALIDATION ERRORS
    if (err.responseJSON.errors) {

        message = Object.values(err.responseJSON.errors)
            .flat()
            .join('\n');

    }

    // NORMAL MESSAGE
    else if (err.responseJSON.message) {

        message = err.responseJSON.message;

    }

    alert(message);

}

        });

    });

</script>

</body>
</html>