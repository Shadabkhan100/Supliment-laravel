<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Deals Management</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-animation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
            background: #f5f7fb;
            font-family: sans-serif;
        }
.custom-upload-wrapper {
    width: 100%;
}

.custom-upload-box {
    width: 100%;
    min-height: 160px;
    border: 2px dashed #cfcfcf;
    border-radius: 14px;
    background: #fafafa;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.3s;
    gap: 10px;
}

.custom-upload-box:hover {
    border-color: #111;
    background: #f1f1f1;
}

.custom-upload-box i {
    font-size: 42px;
    color: #111;
}

.custom-upload-box span {
    font-size: 15px;
    font-weight: 600;
    color: #444;
}
        .management-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .table img {
            width: 75px;
            height: 75px;
            object-fit: cover;
            border-radius: 10px;
        }

        .action-btn {
            border: none;
            background: transparent;
            font-size: 18px;
            margin-right: 10px;
            cursor: pointer;
            transition: .2s;
        }

        .action-btn:hover {
            transform: scale(1.15);
        }

        .loader-wrapper {
            position: fixed;
            inset: 0;
            background: rgba(255,255,255,0.7);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .search-box {
            max-width: 300px;
        }

        .table thead {
            background: #111;
            color: #fff;
        }

        .badge-status {
            padding: 7px 14px;
            border-radius: 30px;
            font-size: 12px;
        }

        .active-status {
            background: #d1fae5;
            color: #065f46;
        }

        .inactive-status {
            background: #fee2e2;
            color: #991b1b;
        }

        .modal-content {
            border-radius: 16px;
            border: none;
        }

        .modal-body {
            max-height: 75vh;
            overflow-y: auto;
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

        .remove-image-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%;
            background: red;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        .empty-data {
            text-align: center;
            padding: 30px;
            color: #777;
        }
    </style>

</head>

<body>

    <!-- Loader -->
    <div class="loader-wrapper" id="loader">
        <div class="spinner-border text-dark"></div>
    </div>

    <div class="container py-5">

        <div class="management-card">

            <!-- Top -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                <!-- Search -->
                <div class="search-box">
                    <input
                        type="text"
                        class="form-control"
                        id="searchInput"
                        placeholder="Search deals...">
                </div>

                <!-- Add Button -->
                <button
                    class="btn btn-dark px-4"
                    id="addDealBtn"
                    data-bs-toggle="modal"
                    data-bs-target="#dealModal">

                    <i class="fa fa-plus"></i>
                    Add Deal

                </button>

            </div>

            <!-- Table -->
            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th width="140">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="dealTableBody">

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- Modal -->
<div class="modal fade" id="dealModal" tabindex="-1" style="background-color:white;height:100vh">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="modalTitle">
                        Add Deal
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <form id="dealForm">

                        <input type="hidden" id="dealId">

                        <div class="row">

                            <!-- Title -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Title
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="title"
                                    required>

                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Status
                                </label>

                                <select class="form-control" id="is_active">

                                    <option value="1">
                                        Active
                                    </option>

                                    <option value="0">
                                        Inactive
                                    </option>

                                </select>

                            </div>

                            <!-- Start Date -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Start Date
                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="start_date">

                            </div>

                            <!-- End Date -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    End Date
                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="end_date">

                            </div>

                            <!-- Description -->
                            <div class="col-12 mb-3">

                                <label class="form-label">
                                    Description
                                </label>

                                <textarea
                                    class="form-control"
                                    rows="4"
                                    id="description"></textarea>

                            </div>

                   <!-- Upload -->
<div class="col-12 mb-3">

    <label class="form-label fw-bold mb-2">
        Deal Image
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

                            <!-- Preview -->
                            <div class="col-12">

                                <div class="preview-box" id="previewWrapper">

                                    <img
                                        src=""
                                        id="previewImage">

                                    <button
                                        type="button"
                                        class="remove-image-btn"
                                        id="removeImage">

                                        <i class="fa fa-times"></i>

                                    </button>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Close

                    </button>

                    <button
                        class="btn btn-dark"
                        id="saveDealBtn">

                        Save Deal

                    </button>

                </div>

            </div>

        </div>


 </div>

    <!-- View Modal -->

    <div class="modal fade" id="viewModal" tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Deal Details
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body" id="viewContent">

                </div>

            </div>

        </div>

    </div>

    <!-- JS -->
    <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('js/slickAnimation.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>

        const API_URL = "/api/deals";

        let uploadedImage = null;

        // INIT
        $(document).ready(function () {

            fetchDeals();

            // SEARCH
            $("#searchInput").on("keyup", function () {

                let value = $(this).val().toLowerCase();

                $("#dealTableBody tr").filter(function () {

                    $(this).toggle(
                        $(this).text().toLowerCase().indexOf(value) > -1
                    );

                });

            });

        });

        // LOADER
        function showLoader() {
            $("#loader").css("display", "flex");
        }

        function hideLoader() {
            $("#loader").hide();
        }

        // FETCH DEALS
        function fetchDeals() {

            showLoader();

            $.ajax({

                url: API_URL,
                type: "GET",

                success: function (response) {

                    let rows = '';

                    if(response.data.length === 0){

                        rows = `
                            <tr>
                                <td colspan="8" class="empty-data">
                                    No Deals Found
                                </td>
                            </tr>
                        `;

                    }

                    response.data.forEach((deal, index) => {

                        rows += `
                            <tr>

                                <td>${index + 1}</td>

                                <td>
                                    <img src="${deal.image ?? 'https://via.placeholder.com/70'}">
                                </td>

                                <td>${deal.title ?? ''}</td>

                                <td>${deal.description ?? ''}</td>

                                <td>${deal.start_date ?? '-'}</td>

                                <td>${deal.end_date ?? '-'}</td>

                                <td>

                                    ${
                                        deal.is_active == 1
                                        ?
                                        `<span class="badge-status active-status">Active</span>`
                                        :
                                        `<span class="badge-status inactive-status">Inactive</span>`
                                    }

                                </td>

                                <td>

                                    <button
                                        class="action-btn text-info"
                                        onclick="viewDeal(${deal.id})">

                                        <i class="fa fa-eye"></i>

                                    </button>

                                    <button
                                        class="action-btn text-primary"
                                        onclick='editDeal(${JSON.stringify(deal)})'>

                                        <i class="fa fa-edit"></i>

                                    </button>

                                    <button
                                        class="action-btn text-danger"
                                        onclick="deleteDeal(${deal.id})">

                                        <i class="fa fa-trash"></i>

                                    </button>

                                </td>

                            </tr>
                        `;

                    });

                    $("#dealTableBody").html(rows);

                    hideLoader();

                },

                error: function () {

                    hideLoader();

                    alert("Failed to fetch deals");

                }

            });

        }

        // IMAGE PREVIEW
        $(document).on("change", "#image", function (e) {

            const file = e.target.files[0];

            if (!file) return;

            uploadedImage = file;

            const imageURL = URL.createObjectURL(file);

            $("#previewImage").attr("src", imageURL);

            $("#previewWrapper").show();

        });

        // REMOVE IMAGE
        $("#removeImage").click(function () {

            uploadedImage = null;

            $("#image").val('');

            $("#previewImage").attr("src", "");

            $("#previewWrapper").hide();

        });

        // ADD DEAL
        $("#addDealBtn").click(function () {

            $("#modalTitle").text("Add Deal");

            $("#dealForm")[0].reset();

            $("#dealId").val('');

            uploadedImage = null;

            $("#previewImage").attr("src", "");

            $("#previewWrapper").hide();

        });

        // SAVE DEAL
        $("#saveDealBtn").click(function () {

            showLoader();

            let formData = new FormData();

            formData.append("title", $("#title").val());
            formData.append("description", $("#description").val());
            formData.append("start_date", $("#start_date").val());
            formData.append("end_date", $("#end_date").val());
            formData.append("is_active", $("#is_active").val());

            if (uploadedImage) {

                formData.append("image", uploadedImage);

            }

            let id = $("#dealId").val();

            let url = id
                ? `${API_URL}/update/${id}`
                : `${API_URL}/create-deal`;

            $.ajax({

                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function () {

                    hideLoader();

                    $("#dealModal").modal('hide');

                    fetchDeals();

                },

                error: function (xhr) {

                    hideLoader();

                    console.log(xhr.responseText);

                    alert("Something went wrong");

                }

            });

        });

        // EDIT DEAL
        function editDeal(deal) {

            $("#modalTitle").text("Edit Deal");

            $("#dealId").val(deal.id);

            $("#title").val(deal.title);

            $("#description").val(deal.description);

            $("#start_date").val(deal.start_date);

            $("#end_date").val(deal.end_date);

            $("#is_active").val(deal.is_active);

            uploadedImage = null;

            if (deal.image) {

                $("#previewImage").attr("src", deal.image);

                $("#previewWrapper").show();

            } else {

                $("#previewWrapper").hide();

            }

            new bootstrap.Modal(document.getElementById('dealModal')).show();

        }

        // VIEW DEAL
        function viewDeal(id) {

            showLoader();

            $.ajax({

                url: `${API_URL}/${id}`,
                type: "GET",

                success: function (response) {

                    let deal = response.data;

                    $("#viewContent").html(`

                        <div class="row g-4">

                            <div class="col-md-5">

                                <img
                                    src="${deal.image}"
                                    class="img-fluid rounded">

                            </div>

                            <div class="col-md-7">

                                <h3>${deal.title}</h3>

                                <p>${deal.description ?? ''}</p>

                                <p>
                                    <strong>Start:</strong>
                                    ${deal.start_date ?? '-'}
                                </p>

                                <p>
                                    <strong>End:</strong>
                                    ${deal.end_date ?? '-'}
                                </p>

                                <p>
                                    <strong>Status:</strong>

                                    ${
                                        deal.is_active == 1
                                        ? 'Active'
                                        : 'Inactive'
                                    }

                                </p>

                            </div>

                        </div>

                    `);

                    hideLoader();

                    new bootstrap.Modal(document.getElementById('viewModal')).show();

                },

                error: function () {

                    hideLoader();

                    alert("Failed to fetch deal");

                }

            });

        }

        // DELETE
        function deleteDeal(id) {

            if (!confirm("Are you sure you want to delete this deal?")) {
                return;
            }

            showLoader();

            $.ajax({

                url: `${API_URL}/${id}`,
                type: "DELETE",

                success: function () {

                    fetchDeals();

                },

                error: function () {

                    hideLoader();

                    alert("Failed to delete");

                }

            });

        }

    </script>

</body>

</html>
