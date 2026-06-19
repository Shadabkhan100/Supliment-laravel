<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
   
@extends('admin.main')

@section('title', 'Page Settings')

@section('page-title', 'Page Settings')
@section('content')
 
<div class="container py-5">

    <!-- FORM -->
    <div class="card p-3 mb-4">

        <form id="settingForm" enctype="multipart/form-data">

            <input type="hidden" id="setting_id">

            <div class="mb-3">
                <label>Description</label>
                <textarea class="form-control" id="description"></textarea>
            </div>

            <div class="mb-3">
                <label>Home Banner</label>
                <input style="display:block" type="file" class="form-control" id="home_banner">

                <img id="preview" style="width:150px;margin-top:10px;display:none;">
            </div>

            <button type="submit" class="btn btn-dark" id="saveBtn">
    Save Banner
</button>

        </form>

    </div>

    <!-- TABLE -->
    <div class="card p-3">

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Banner</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="tableData"></tbody>

        </table>

    </div>

</div>
 <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
loadSettings();
// ================= LOAD DATA =================
function loadSettings() {

    $.ajax({
        url: "/api/page-settings",
        type: "GET",

        success: function(res) {

            let data = res.data;

            let html = "";

            // ✅ IMPORTANT: NOW DATA IS ARRAY
            if (Array.isArray(data)) {

                data.forEach(item => {

                    html += `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.description ?? ''}</td>
                        <td>
                            ${item.home_banner ? `<img src="${item.home_banner}" width="80">` : ''}
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick='edit(${JSON.stringify(item)})'>Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteSetting(${item.id})">Delete</button>
                        </td>
                    </tr>
                    `;
                });

            }

            $("#tableData").html(html);
        }
    });
}

// ================= EDIT =================
function edit(data) {

    $("#setting_id").val(data.id);
    $("#description").val(data.description);

    if (data.home_banner) {
        $("#preview").show().attr("src", data.home_banner);
    }
}

// ================= DELETE =================
function deleteSetting(id) {

    if (!confirm("Delete this banner?")) return;

    $.ajax({
        url: "/api/page-settings/delete-banner/" + id,
        type: "DELETE",
        success: function(res) {
            alert(res.message ?? "Deleted successfully");
            loadSettings();
        },
        error: function(xhr) {
            alert(xhr.responseJSON?.message ?? "Delete failed");
        }
    });
}

// ================= SAVE =================
$("#settingForm").submit(function(e) {

    e.preventDefault();

    let id = $("#setting_id").val();

    let formData = new FormData();

    formData.append("description", $("#description").val());

    if ($("#home_banner")[0].files[0]) {
        formData.append("home_banner", $("#home_banner")[0].files[0]);
    }

    let url = "/api/page-settings";
    let type = "POST";

    // EDIT MODE
    if (id) {
        url = "/api/banner/edit/" + id;
        type = "POST";
    }

    $.ajax({
        url: url,
        type: type,
        data: formData,
        processData: false,
        contentType: false,

        beforeSend: function() {
            $("#saveBtn")
                .prop("disabled", true)
                .text("Please Wait...");
        },

        success: function(res) {

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: res.message || 'Operation completed successfully'
            });

            $("#settingForm")[0].reset();

            $("#setting_id").val('');

            $("#preview").hide();

            $("#currentImageName").remove();

            $("#saveBtn")
                .prop("disabled", false)
                .text("Save Banner");

            loadSettings();
        },

        error: function(xhr) {

            $("#saveBtn")
                .prop("disabled", false)
                .text(id ? "Update Banner" : "Save Banner");

            let message = "Something went wrong.";

            // Laravel validation errors
            if (xhr.responseJSON?.errors) {

                message = '';

                $.each(xhr.responseJSON.errors, function(key, value) {
                    message += value[0] + "<br>";
                });

            }
            // Custom backend error
            else if (xhr.responseJSON?.message) {

                message = xhr.responseJSON.message;
            }

            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: message
            });
        }
    });

});

$("#home_banner").change(function () {

    let file = this.files[0];

    if (!file) return;

    let reader = new FileReader();

    reader.onload = function(e) {

        $("#preview")
            .attr("src", e.target.result)
            .show();
    };

    reader.readAsDataURL(file);

    if ($("#currentImageName").length === 0) {
        $("#preview").after(
            `<div id="currentImageName" class="mt-2 text-muted"></div>`
        );
    }

    $("#currentImageName").html(
        `<strong>Selected Image:</strong> ${file.name}`
    );
});

// ================= INIT =================

function edit(data) {

    $("#setting_id").val(data.id);
    $("#description").val(data.description || '');

    if (data.home_banner) {

        $("#preview")
            .show()
            .attr("src", data.home_banner);

        // Show current image name below preview
        let fileName = data.home_banner.split('/').pop();

        if ($("#currentImageName").length === 0) {
            $("#preview").after(
                `<div id="currentImageName" class="mt-2 text-muted"></div>`
            );
        }

        $("#currentImageName").html(
            `<strong>Current Image:</strong> ${fileName}`
        );
    }

    // Change button text
    $("#saveBtn").text("Update Banner");
}
</script>

@endsection