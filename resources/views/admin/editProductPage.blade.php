<!doctype html>
<html>

<head>

  <title>Edit Product</title>

  <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>

.back-btn{
    position:fixed;
    top:45px;
    left:25px; /* change to left:25px if you want left side */
    width:55px;
    height:55px;
    border-radius:50%;
    background:#111827;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    font-size:20px;
    box-shadow:0 5px 15px rgba(0,0,0,.2);
    z-index:9999;
    transition:.3s;
}

.back-btn:hover{
    background:#2563eb;
    color:#fff;
    transform:translateY(-3px);
}
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
  .weight-chip {
    background: #111;
    color: #fff;
    padding: 6px 12px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin: 4px;
    font-size: 14px;
  }

  .tag-chip button,
  .weight-chip button {
    background: none;
    border: none;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    padding: 0;
    line-height: 1;
  }

  .gallery-item {
    position: relative;
  }

  .gallery-item img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 8px;
  }

  .remove-gallery-btn {
    position: absolute;
    top: -6px;
    right: -6px;
    width: 22px;
    height: 22px;
    border: none;
    border-radius: 50%;
    background: red;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
  }
  </style>

</head>

<body>

  <div class="container py-5">
<a href="{{ url('/admin/add-product') }}" class="back-btn">
   <svg style="color:white;font-weight:bold;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chevron-compact-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M9.224 1.553a.5.5 0 0 1 .223.67L6.56 8l2.888 5.776a.5.5 0 1 1-.894.448l-3-6a.5.5 0 0 1 0-.448l3-6a.5.5 0 0 1 .67-.223"/>
</svg>
</a>
    <h2 class="mb-4">
      Edit Product
    </h2>

    <form id="editForm" enctype="multipart/form-data">

      @csrf

      <input type="hidden" name="id" value="{{ $product['id'] }}">

      <!-- NAME -->
      <div class="mb-3">

        <label class="form-label">
          Name
        </label>

        <input type="text" name="name" class="form-control" value="{{ $product['name'] }}">

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

        <input type="text" name="sku" class="form-control" value="{{ $product['sku'] }}">

      </div>

      <!-- PRICE -->
      <div class="mb-3">

        <label class="form-label">
          Price
        </label>

        <input type="text" name="price" class="form-control" value="{{ $product['price'] }}">

      </div>

      <!-- OLD PRICE -->
      <div class="mb-3">

        <label class="form-label">
          Old Price
        </label>

        <input type="text" name="old_price" class="form-control" value="{{ $product['old_price'] }}">

      </div>

      <!-- STOCK -->
      <div class="mb-3">

        <label class="form-label">
          Stock
        </label>

        <input type="text" name="stock" class="form-control" value="{{ $product['stock'] }}">

      </div>

      <!-- DESCRIPTION -->
      <div class="mb-3">

        <label class="form-label">
          Description
        </label>

        <textarea name="description" class="form-control" rows="8">{{ $product['description'] }}</textarea>

      </div>

      <!-- MAIN IMAGE -->
      <div class="mb-3">

        <label class="form-label">
          Main Image
        </label>

        <div class="mb-2">

          <img id="mainPreview" src="{{ $product['main_image'] }}"
            style="width:140px;height:140px;object-fit:cover;border-radius:10px;">

        </div>

        <input type="file" name="main_image" id="mainImageInput" class="form-control">

      </div>

      <!-- GALLERY -->
      <div class="mb-3">

        <label class="form-label">
          Gallery Images
        </label>

        <div id="galleryBox" class="d-flex flex-wrap gap-2 mb-3">
        </div>

        <input type="file" name="gallery_images[]" id="galleryInput" multiple class="form-control">

      </div>

      <!-- TAGS -->
      <div class="mb-3">

        <label class="form-label">
          Tags
        </label>

        <select id="tagSelect" class="form-select mb-3">

          <option value="">
            Select Tag
          </option>

        </select>

        <div id="tagError" class="text-danger small mb-2">
        </div>

        <div id="tagBox"></div>

      </div>

      <!-- WEIGHTS -->
      <div class="mb-3">

        <label class="form-label">
          Weights
        </label>

        <div class="d-flex gap-2 mb-3">

          <input type="text" id="weightInput" class="form-control" placeholder="Enter weight">

          <button type="button" id="addWeightBtn" class="btn btn-dark">
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
            <input type="number" id="packInput" class="form-control" placeholder="Packs">
          </div>

          <div class="col-md-3">
            <input type="number" id="packPriceInput" class="form-control" placeholder="Price">
          </div>

          <div class="col-md-4">
            <input type="text" id="packDurationInput" class="form-control" placeholder="Duration (e.g. 15 days)">
          </div>
         <input type="hidden" id="editIndex" value="">
          <div class="col-md-3">
             <input type="file" id="optionImageInput" class="form-control" accept="image/*">

          <div id="imagePreview" class="mt-2 d-none">
             <img id="previewImg"
                  src=""
                    style="width:80px;height:80px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">
            </div>
            </div>

        <div class="d-flex justify-content-end gap-2 mt-3">

    <button type="button" id="cancelEdit" class="btn btn-outline-secondary d-none">
        <span class="material-icons align-middle me-1" style="font-size:18px;">
            close
        </span>
        Cancel
    </button>

    <button type="button" id="addPackOption" class="btn btn-dark">
        <span class="material-icons align-middle me-1" style="font-size:18px;">
            add
        </span>
        Add
    </button>

</div>
        </div>

        <div id="packBox" class="row g-3"></div>

      </div>



      <h4>Halal Certification</h4>
      <input type="file" id="halal_certification" accept="image/*">
      <br><br>
      <img id="halalPreview" class="preview-image" style="display:none;">
      <hr>
      <h4>Shipping Info</h4>
      <textarea name="shipping_info" id="shipping_info"
        class="form-control">{{ $product['shipping_info'] ?? '' }}</textarea>
      <h4>Supplement Facts</h4>
      <textarea name="supplement_facts" id="supplement_facts"
        class="form-control">{{ $product['supplement_facts'] ?? '' }}</textarea>
      <h4>How to Use</h4>
      <textarea name="how_to_use" id="how_to_use" class="form-control">{{ $product['how_to_use'] ?? '' }}</textarea>

    <h4>Ingredients</h4>
      <textarea name="ingredients" id="ingredients" class="form-control">{{ $product['ingredients'] ?? '' }}</textarea>


      <!-- SUBMIT -->
      <button type="submit" class="btn btn-primary w-100">
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
  let halalFile = null;
  let newGalleryFiles = [];
  $('#halal_certification').on('change', function(e) {

    let file = e.target.files[0];
    if (!file) return;

    halalFile = file;

    let reader = new FileReader();

    reader.onload = function(event) {
      $('#halalPreview')
        .show()
        .attr('src', event.target.result);
    };

    reader.readAsDataURL(file);
  });


  @if(!empty($product['halal_certification']))
  $('#halalPreview')
    .show()
    .attr('src', "{{ $product['halal_certification'] }}");
  @endif


  async function uploadToSupabase(file) {
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
    } catch (err) {
      console.error("Upload error:", err);
      return null;
    }
  }



  $('#optionImageInput').on('change', function(e) {
    optionImageFile = e.target.files[0] || null;



  });

 let selectedOptions = Array.isArray(@json($product['options'] ?? [])) ?
      @json($product['options'] ?? []) : [];
  $(document).ready(function() {

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
    let selectedTags = Array.isArray(@json($product['tags'] ?? [])) ?
      @json($product['tags'] ?? []) : [];

    let selectedWeights = Array.isArray(@json($product['weights'] ?? [])) ?
      @json($product['weights'] ?? []) : [];

    let galleryImages = Array.isArray(@json($product['gallery_images'] ?? [])) ?
      @json($product['gallery_images'] ?? []) : [];
   

    function renderOptions() {
      $('#packBox').html('');

    selectedOptions.forEach((opt, i) => {

    $('#packBox').append(`
        <div class="col-12 col-md-6">
            <div class="position-relative d-flex align-items-center gap-3 p-2 border rounded h-100">

                ${opt.image ? `
                    <img src="${opt.image}"
                         style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
                ` : ''}

                <div>
                    <div><b>Packs:</b> ${opt.pack}</div>
                    <div><b>Price:</b> ${opt.price}</div>
                    <div><b>Duration:</b> ${opt.duration}</div>
                </div>

                <button
                    type="button"
                    onclick="editPack(${i})"
                    style="
                        position:absolute;
                        top:6px;
                        right:36px;
                        width:24px;
                        height:24px;
                        border:none;
                        border-radius:50%;
                        background:#0d6efd;
                        color:#fff;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        cursor:pointer;
                    ">
                    <span class="material-icons" style="font-size:16px;">edit</span>
                </button>

                <button
                    type="button"
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
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        cursor:pointer;
                    ">
                    <span class="material-icons" style="font-size:16px;">delete</span>
                </button>

            </div>
        </div>
    `);

});
    }




window.removeOption = function(index) {

    if (!confirm('Are you sure you want to delete this pack?')) {
        return;
    }

    const productId = {{ $product['id'] }};

    $.ajax({

        url: `/product/pack/delete/${productId}/${index}`,
        type: 'POST',

        data: {
            _token: '{{ csrf_token() }}'
        },

        beforeSend: function () {

            $('button').prop('disabled', true);

        },

        success: function(res){

            selectedOptions.splice(index, 1);

            renderOptions();

            alert(res.message || '✅ Pack deleted successfully.');

        },

        error: function(xhr){

            alert(xhr.responseJSON?.message || '❌ Failed to delete pack.');

        },

        complete: function(){

            $('button').prop('disabled', false);

        }

    });

};

$('#addPackOption').click(async function () {

    const productId = {{ $product['id'] }};
    const index = $('#editIndex').val();
    console.log(productId);
     console.log(index);

    const pack = $('#packInput').val().trim();
    const price = $('#packPriceInput').val().trim();
    const duration = $('#packDurationInput').val().trim();

    if (!pack || !price || !duration) {
        alert('Please fill in Pack, Price and Duration.');
        return;
    }

    // ==========================================
    // ADD NEW PACK
    // ==========================================
if (index === '' || index === undefined || index === null) {

    let imageUrl = null;

    if (optionImageFile) {
        imageUrl = await uploadToSupabase(optionImageFile);
    }

    const formData = new FormData();

    formData.append('_token', '{{ csrf_token() }}');
    formData.append('pack', pack);
    formData.append('price', price);
    formData.append('duration', duration);
    formData.append('image', imageUrl); // Send the Supabase URL

    $.ajax({

        url: `/product/pack/add/${productId}`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,

        beforeSend: function () {

            $('#addPackOption')
                .prop('disabled', true)
                .html(`
                    <span class="spinner-border spinner-border-sm me-1"></span>
                    Saving...
                `);

        },

        success: function (res) {

            // Add to local array
            selectedOptions.push({
                pack: parseInt(pack),
                price: parseFloat(price),
                duration: duration,
                image: imageUrl
            });

            renderOptions();

            // Clear form
            $('#packInput').val('');
            $('#packPriceInput').val('');
            $('#packDurationInput').val('');
            $('#optionImageInput').val('');
            $('#previewImg').attr('src', '');
            $('#imagePreview').addClass('d-none');

            optionImageFile = null;

            alert(res.message || '✅ Pack added successfully.');

        },

        error: function (xhr) {

            alert(xhr.responseJSON?.message || '❌ Failed to add pack.');

        },

        complete: function () {

            $('#addPackOption')
                .prop('disabled', false)
                .html(`
                    <span class="material-icons align-middle me-1" style="font-size:18px;">add</span>
                    Add
                `);

        }

    });

    return;
}

    // ==========================================
    // UPDATE PACK
    // ==========================================

    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('pack', pack);
    formData.append('price', price);
    formData.append('duration', duration);

    if ($('#optionImageInput')[0].files.length) {
        formData.append('image', $('#optionImageInput')[0].files[0]);
    }

    $.ajax({

        url: `/product/pack/update/${productId}/${index}`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,

        beforeSend: function () {

            $('#addPackOption')
                .prop('disabled', true)
                .html(`
                    <span class="spinner-border spinner-border-sm me-1"></span>
                    Updating...
                `);

        },

        success: function (res) {

            // Update local array
            selectedOptions[index].pack = parseInt(pack);
            selectedOptions[index].price = parseFloat(price);
            selectedOptions[index].duration = duration;

            if (res.image) {
                selectedOptions[index].image = res.image;
            }

            renderOptions();

            // Reset edit mode
            $('#cancelEdit').trigger('click');

            alert(res.message || '✅ Pack updated successfully.');

        },

        error: function (xhr) {

            alert(xhr.responseJSON?.message || '❌ Failed to update pack.');

        },

        complete: function () {

            $('#addPackOption')
                .prop('disabled', false)
                .html(`
                    <span class="material-icons align-middle me-1" style="font-size:18px;">add</span>
                    Add
                `);

        }

    });

}); 








    function loadDeals(selectedId = null) {
      $.ajax({
        url: '/api/deals',
        type: 'GET',

        success: function(res) {
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

        error: function(err) {
          console.log('DEAL ERROR:', err.responseText);
        }
      });
    }

    /* =========================
       TAG DROPDOWN
    ========================= */

    function initTagDropdown() {
      let select = $('#tagSelect');
      select.html('<option value="">Select Tag</option>');

      availableTags.forEach(tag => {
        select.append(`<option value="${tag}">${tag}</option>`);
      });
    }

    /* =========================
       RENDER TAGS
    ========================= */

    function renderTags() {
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

    window.removeTag = function(index) {
      selectedTags.splice(index, 1);
      renderTags();
    };

    /* =========================
       ADD TAG
    ========================= */

    $('#tagSelect').on('change', function() {

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

    function renderWeights() {
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

    window.removeWeight = function(index) {
      selectedWeights.splice(index, 1);
      renderWeights();
    };

    $('#addWeightBtn').on('click', function() {

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

    $('#galleryInput').on('change', function(e) {
      const files = Array.from(e.target.files);

      files.forEach(file => {
        newGalleryFiles.push(file);
      });

      // CLEAR INPUT so same file can be reselected if needed
      $(this).val('');

      renderGalleryImages();
    });

    function renderGalleryImages() {
      $('#galleryBox').html('');

      // EXISTING IMAGES (from DB)
      galleryImages.forEach((img, i) => {
        $('#galleryBox').append(`
      <div class="gallery-item">
        <img src="${img}">
        <button type="button" class="remove-gallery-btn" onclick="removeExistingImage(${i})">×</button>
      </div>
    `);
      });
      window.removeNewImage = function(index) {
        newGalleryFiles.splice(index, 1);
        renderGalleryImages();
      };
      // NEW IMAGES (instant preview)
      newGalleryFiles.forEach((file, i) => {
        const url = URL.createObjectURL(file);

        $('#galleryBox').append(`
      <div class="gallery-item">
        <img src="${url}">
        <button type="button" class="remove-gallery-btn" onclick="removeNewImage(${i})">×</button>
      </div>
    `);
      });
    }
    window.removeExistingImage = function(index) {
      galleryImages.splice(index, 1);
      renderGalleryImages();
    };
    window.removeGalleryImage = function(index) {
      galleryImages.splice(index, 1);
      renderGalleryImages();
    };

    /* =========================
       CATEGORY CHANGE
    ========================= */

    $('#categorySelect').on('change', function() {
      selectedCategoryId = $(this).val();
    });

    /* =========================
       DEAL CHANGE
    ========================= */

    $('#dealSelect').on('change', function() {
      selectedDealId = $(this).val();
    });

    /* =========================
       MAIN IMAGE PREVIEW
    ========================= */

    $('#mainImageInput').on('change', function(e) {

      let file = e.target.files[0];
      if (!file) return;

      let reader = new FileReader();

      reader.onload = function(event) {
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

    $('#editForm').on('submit', async function(e) {

      e.preventDefault();

      let formData = new FormData(this);

      formData.append('category_id', selectedCategoryId);
      formData.append('deal_id', selectedDealId);
      formData.append('shipping_info', $('#shipping_info').val());
      formData.append('supplement_facts', $('#supplement_facts').val());
      formData.append('how_to_use', $('#how_to_use').val());
       formData.append('ingredients', $('#ingredients').val());

       
      if (halalFile) {
        formData.append('halal_certification', halalFile);
      }
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
      // UPLOAD NEW IMAGES FIRST
      let uploadedNewGallery = [];

      for (let file of newGalleryFiles) {
        let url = await uploadToSupabase(file);
        if (url) uploadedNewGallery.push(url);
      }

      // MERGE FINAL LIST
      let finalGallery = [
        ...galleryImages, // existing DB images
        ...uploadedNewGallery
      ];

      // SEND TO BACKEND
      function getPath(url) {
        return url.split('/storage/v1/object/public/slimza-images/')[1];
      }

      let finalGalleryPaths = [
        ...galleryImages.map(getPath),
        ...uploadedNewGallery.map(getPath)
      ];

      formData.append(
        'existing_gallery_images',
        JSON.stringify(finalGalleryPaths)
      );


      $.ajax({
        url: '/api/update-product/{{ $product["id"] }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,

        success: function(res) {
          alert(res.message || 'Updated');
          window.location.href = '/admin/add-product';
          halalFile = null;
        },

        error: function(xhr) {
          console.log(xhr.responseText);
          alert('Update failed');
        }
      });

      return false;
    });

  });





function editPack(index){
        console.log("Edit clicked:", index);

    $('#editIndex').val(index);

    console.log("Hidden value:", $('#editIndex').val());
    const pack = selectedOptions[index];

    $('#packInput').val(pack.pack);
    $('#packPriceInput').val(pack.price);
    $('#packDurationInput').val(pack.duration);

    $('#editIndex').val(index);

    if(pack.image){

        $('#previewImg').attr('src', pack.image);
        $('#imagePreview').removeClass('d-none');

    }else{

        $('#imagePreview').addClass('d-none');

    }

    $('#addPackOption').text('Update');
    $('#cancelEdit').removeClass('d-none');

}


$('#cancelEdit').click(function(){

    $('#editIndex').val('');

    $('#packInput').val('');
    $('#packPriceInput').val('');
    $('#packDurationInput').val('');

    $('#optionImageInput').val('');

    $('#previewImg').attr('src','');
    $('#imagePreview').addClass('d-none');

    $('#addPackOption').text('Add');
    $('#cancelEdit').addClass('d-none');

});

$('#optionImageInput').on('change', function () {

    const file = this.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function(e){

        $('#previewImg').attr('src', e.target.result);
        $('#imagePreview').removeClass('d-none');

    };

    reader.readAsDataURL(file);

});



 </script>
</body>

</html>