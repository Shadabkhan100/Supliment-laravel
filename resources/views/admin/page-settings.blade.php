<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Page Settings</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
</head>

<body class="bg-light">

<div class="container py-5">

    <h2 class="mb-4">Page Settings (Banners)</h2>

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
                <input type="file" class="form-control" id="home_banner">

                <img id="preview" style="width:150px;margin-top:10px;display:none;">
            </div>

            <button class="btn btn-dark">Save</button>

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

<script>

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
        url: "/api/page-settings/" + id,
        type: "DELETE",

        success: function(res) {
            alert(res.message ?? "Deleted");
            loadSettings();
        }
    });
}

// ================= SAVE =================
$("#settingForm").submit(function(e) {

    e.preventDefault();

    let formData = new FormData();

    formData.append("description", $("#description").val());

    if ($("#home_banner")[0].files[0]) {
        formData.append("home_banner", $("#home_banner")[0].files[0]);
    }

    let id = $("#setting_id").val();

    let url = "/api/page-settings";
    let type = "POST";

    // UPDATE MODE
    if (id) {
        url = "/api/page-settings/" + id;
        type = "POST"; // or PUT depending on backend
    }

    $.ajax({
        url: url,
        type: type,
        data: formData,
        processData: false,
        contentType: false,

        success: function(res) {

            alert(res.message);

            $("#settingForm")[0].reset();
            $("#preview").hide();

            loadSettings();
        }
    });

});

// ================= INIT =================
loadSettings();

</script>

</body>
</html>