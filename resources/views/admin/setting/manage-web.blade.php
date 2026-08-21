<style>

.drawer-panel{

    position:fixed;
    top:0;
    right:-100%;
    width:650px;
    max-width:100%;
    height:100vh;
    background:#f8fafc;
    display:flex;
    flex-direction:column;
    transition:.35s;
    z-index:999999;
    box-shadow:-15px 0 40px rgba(0,0,0,.15);

}

.drawer-panel.show{

    right:0;

}

.drawer-header{

    flex-shrink:0;

}

.drawer-form{

    display:flex;
    flex-direction:column;
    height:100%;
    overflow:hidden;

}

.drawer-body{

    flex:1;
    overflow-y:auto;
    overflow-x:hidden;
    padding:25px;

}

.drawer-card{

    background:#fff;
    border-radius:15px;
    padding:25px;
    box-shadow:0 8px 25px rgba(0,0,0,.05);

}

.drawer-card label{

    margin-bottom:8px;
    font-size:14px;
    font-weight:600;

}

.drawer-card .form-control{

    height:50px;
    border-radius:10px;

}

.drawer-card textarea.form-control{

    min-height:120px;
    resize:vertical;

}

.drawer-footer{

    flex-shrink:0;
    background:#fff;
    border-top:1px solid #e9ecef;
    padding:18px 25px;
    text-align:right;

}

.drawer-footer .btn{

    min-width:200px;
    border-radius:10px;

}

</style>


<form
    id="websiteSettingForm"
    action="{{ url('admin/web-setting/add') }}"
    method="POST"
    enctype="multipart/form-data"
    class="drawer-form">
    @csrf

    <div class="drawer-body">

        <div class="drawer-card">

            <h5 class="mb-4">
                <i class="fa fa-cogs text-primary me-2"></i>
                Website Settings
            </h5>

            <div class="row">

                <!-- Website Title -->

                <div class="col-12 mb-4">

                    <label>Website Title</label>

                   <input style="color:black;"
    type="text"
    id="website_title"
    name="website_title"
    class="form-control"
    placeholder="Enter Website Title"
    value="{{ old('website_title', $setting->website_title ?? '') }}">

                </div>

                <!-- Meta Description -->

                <div class="col-12 mb-4">

                    <label>Meta Description</label>

                   <textarea style="color:black;"

    id="meta_description"
    name="meta_description"
    class="form-control"
    placeholder="Enter Meta Description">{{ old('meta_description', $setting->meta_description ?? '') }}</textarea>

                </div>

                <!-- Promotion Text -->

                <div class="col-12 mb-4">

                    <label>Promotion Text</label>

                  <input style="color:black;"

    type="text"
    id="promotion_text"
    name="promotion_text"
    class="form-control"
    placeholder="Summer Sale | Up to 50% OFF"
    value="{{ old('promotion_text', $setting->promotion_text ?? '') }}">

                </div>

                <!-- Support Email -->

                <div class="col-12 mb-4">

                    <label>Support Email</label>

                   <input style="color:black;"

    type="email"
    id="support_email"
    name="support_email"
    class="form-control"
    placeholder="support@example.com"
    value="{{ old('support_email', $setting->support_email ?? '') }}">

                </div>

                <!-- Canonical URL -->

                <div class="col-12 mb-4">

                    <label>Canonical URL</label>

                   <input style="color:black;"

    type="url"
    id="canonical_url"
    name="canonical_url"
    class="form-control"
    placeholder="https://slimza.com"
    value="{{ old('canonical_url', $setting->canonical_url ?? '') }}">

                </div>

                <!-- Logo -->

                <div class="col-12 mb-4">

                    <label>Website Logo</label>

<input style="display:block;"
    type="file"
    id="logo"
    name="logo"
    class="form-control"
    accept="image/*">

<img
    id="logo_preview"
    src="{{ $setting->logo ?? '' }}"
    style="width:120px;height:120px;object-fit:cover;border-radius:10px;margin-top:15px;{{ empty($setting->logo) ? 'display:none;' : '' }}">

                </div>

                <!-- Favicon -->

                <div class="col-12 mb-4">

                   <label>Favicon</label>

<input style="display:block;"
    type="file"
    id="favicon"
    name="favicon"
    class="form-control"
    accept="image/*">

<img
    id="favicon_preview"
    src="{{ $setting->favicon ?? '' }}"
    style="width:70px;height:70px;object-fit:cover;border-radius:10px;margin-top:15px;{{ empty($setting->favicon) ? 'display:none;' : '' }}">

                </div>

                <!-- OG Image -->

                <div class="col-12 mb-4">

                   <label>Social Share (OG) Image</label>

<input style="display:block;"
    type="file"
    id="og_image"
    name="og_image"
    class="form-control"
    accept="image/*">

<img
    id="og_image_preview"
    src="{{ $setting->og_image ?? '' }}"
    style="width:180px;height:100px;object-fit:cover;border-radius:10px;margin-top:15px;{{ empty($setting->og_image) ? 'display:none;' : '' }}">

                </div>

            </div>

        </div>

    </div>

    <div class="drawer-footer">

        <button
            type="submit"
            class="btn btn-primary btn-lg">

            <i class="fa fa-save me-2"></i>

            Save Settings

        </button>

    </div>

</form>

<script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
<script>
console.log("Script Loaded");
function previewImage(input, preview){

    if(input.files && input.files[0]){

        const reader = new FileReader();

        reader.onload = function(e){

            $(preview)
                .attr('src', e.target.result)
                .show();

        };

        reader.readAsDataURL(input.files[0]);

    }

}

$('#logo').on('change', function(){

    previewImage(this, '#logo_preview');

});

$('#favicon').on('change', function(){

    previewImage(this, '#favicon_preview');

});

$('#og_image').on('change', function(){

    previewImage(this, '#og_image_preview');

});


/* ===============================
        AJAX FORM SUBMIT
================================ */

$(document).on('submit', '#websiteSettingForm', function(e){

    e.preventDefault();
    e.stopPropagation();

    var form = this;
    var formData = new FormData(form);

    var btn = $(form).find('button[type="submit"]');
    var oldText = btn.html();

    btn.prop('disabled', true);
    btn.html('<i class="fa fa-spinner fa-spin me-2"></i> Saving...');

    $.ajax({

        url: $(form).attr('action'),
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',

        success: function(response){

            console.log('================ AJAX SUCCESS ================');
            console.log('Full Response:', response);
            console.log('Message:', response.message);
            console.log('Status:', response.status);
            console.log('==============================================');

            btn.prop('disabled', false);
            btn.html(oldText);

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message
            });

        },

        error: function(xhr, status, error){

            console.error('================ AJAX ERROR ================');
            console.error('HTTP Status:', xhr.status);
            console.error('Status Text:', status);
            console.error('Error:', error);
            console.error('Response Text:', xhr.responseText);
            console.error('Response JSON:', xhr.responseJSON);
            console.error('Full XHR Object:', xhr);
            console.error('============================================');

            btn.prop('disabled', false);
            btn.html(oldText);

            let message = 'Something went wrong.';

            if (xhr.responseJSON) {

                console.error('Server Message:', xhr.responseJSON.message);
                console.error('Server Error:', xhr.responseJSON.error);
                console.error('Server File:', xhr.responseJSON.file);
                console.error('Server Line:', xhr.responseJSON.line);
                console.error('Server Errors:', xhr.responseJSON.errors);

                message = xhr.responseJSON.message ??
                          xhr.responseJSON.error ??
                          Object.values(xhr.responseJSON.errors ?? {})[0]?.[0] ??
                          message;
            }

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message
            });

        }

    });

    return false;

});

</script>