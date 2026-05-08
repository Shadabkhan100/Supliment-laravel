<!doctype html>
<html>
<head>

    <title>Add Product</title>
     <link rel="stylesheet"
          href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('css/product-management.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

    <input type="text" name="sku" placeholder="SKU"><br>

    <input type="number" name="price" placeholder="Price"><br>

    <input type="number" name="old_price" placeholder="Old Price"><br>

    <input type="number" name="stock" placeholder="Stock"><br>

    <textarea name="description" placeholder="Description"></textarea><br>

    <!-- WEIGHTS -->
    <h4>Weights</h4>

    <input type="text" id="weightInput" placeholder="250g">

    <button type="button" id="addWeight">
        Add Weight
    </button>

    <div id="weightList"></div>

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

    <button type="submit">
        Submit Product
    </button>

</form>

<script>

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
        formData.append('sku', $('input[name="sku"]').val());
        formData.append('price', $('input[name="price"]').val());
        formData.append('old_price', $('input[name="old_price"]').val());
        formData.append('stock', $('input[name="stock"]').val());
        formData.append('description', $('textarea[name="description"]').val());
        // WEIGHTS ARRAY
        weights.forEach(weight => {

            formData.append('weights[]', weight);

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

                alert("Error Creating Product");

            }

        });

    });

</script>

</body>
</html>