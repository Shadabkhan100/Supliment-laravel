<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Testimonials Admin</title>

    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-animation.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <style>


    #testimonialForm input,
    #testimonialForm textarea {
        color: #fff !important;
        background-color: #111 !important;
        border: 1px solid #333;
    }

    #testimonialForm input::placeholder,
    #testimonialForm textarea::placeholder {
        color: #aaa !important;
    }

    #testimonialForm input:focus,
    #testimonialForm textarea:focus {
        color: #fff !important;
        background-color: #111 !important;
        border-color: #9eef0b !important;
        box-shadow: none !important;
    }

        body { background: black; color: white; }

        .card-box {
            background: #111;
            border-radius: 12px;
            padding: 20px;
        }

        .loader {
            display: none;
            text-align: center;
            padding: 20px;
            color: #9eef0b;
        }

        .btn-green {
            background: #9eef0b;
            border: none;
            color: black;
        }

        .btn-green:hover {
            background: #86d10a;
        }

        table {
            color: white;
        }

        .table-dark {
            background: #111;
        }
    </style>
</head>

<body>

<div class="container py-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 style="color:#9eef0b;">Testimonials Manager</h3>

        <!-- SEARCH -->
        <input type="text" id="search" class="form-control w-25"
               placeholder="Search testimonials...">
    </div>

    <div class="row">

        <!-- FORM -->
        <div class="col-md-4">
            <div class="card-box">

                <h5 class="mb-3">Add Testimonial</h5>

                <form id="testimonialForm">
<input type="file" id="image" class="form-control mb-3"
       accept="image/*"
       style="display:block !important; opacity:1 !important;">
                    <input type="text" id="name" class="form-control mb-2"
                           placeholder="Name" required>

                    <input type="text" id="role" class="form-control mb-2"
                           placeholder="Role (Customer)" value="Customer">

                    <input type="number" id="rating" class="form-control mb-2"
                           placeholder="Rating (1-5)" min="1" max="5" value="5">

                    <textarea id="message" class="form-control mb-2"
                              placeholder="Review" required></textarea>

                    <!-- IMAGE UPLOAD -->
                   

                    <button class="btn btn-green w-100" type="submit" id="submitBtn">
                        Add Testimonial
                    </button>

                </form>

                <div class="loader" id="formLoader">Saving...</div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="col-md-8">
            <div class="card-box">

                <h5 class="mb-3">All Testimonials</h5>

                <div class="loader" id="tableLoader">Loading testimonials...</div>

                <table class="table table-dark table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Message</th>
                            <th>Rating</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="testimonialTable"></tbody>

                </table>

            </div>
        </div>

    </div>
</div>

<script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script>

const GET_URL = "/api/testimonials";
const POST_URL = "/api/create-testimonials";
const DELETE_URL = "/api/testimonials";

/* =========================
   LOAD TESTIMONIALS
========================= */
function loadTestimonials() {
    $("#tableLoader").show();
    $("#testimonialTable").html("");

    $.get(GET_URL, function (data) {

        $("#tableLoader").hide();

        data.forEach(item => {

            let img = item.image
                ? item.image
                : '/images/user-1.png';

            $("#testimonialTable").append(`
                <tr>
                    <td>
                        <img src="${img}"
                             style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:8px;">
                        ${item.name}
                    </td>
                    <td>${item.message}</td>
                    <td>${item.rating}</td>
                    <td>
                        <button class="btn btn-danger btn-sm"
                                onclick="deleteTestimonial(${item.id})">
                            Delete
                        </button>
                    </td>
                </tr>
            `);
        });
    });
}

/* =========================
   ADD TESTIMONIAL (UPLOAD)
========================= */
$("#testimonialForm").submit(function (e) {
    e.preventDefault();

    $("#submitBtn").prop("disabled", true);
    $("#formLoader").show();

    let formData = new FormData();
    formData.append("name", $("#name").val());
    formData.append("role", $("#role").val());
    formData.append("rating", $("#rating").val());
    formData.append("message", $("#message").val());

    let imageFile = $("#image")[0].files[0];
    if (imageFile) {
        formData.append("image", imageFile);
    }

    $.ajax({
        url: POST_URL,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,

        success: function (res) {

            $("#testimonialForm")[0].reset();

            loadTestimonials();

            $("#submitBtn").prop("disabled", false);
            $("#formLoader").hide();

            alert(res.message || "Testimonial added successfully");
        },

        error: function (xhr) {

            console.log(xhr.responseText);

            alert("Error saving testimonial");

            $("#submitBtn").prop("disabled", false);
            $("#formLoader").hide();
        }
    });
});

/* =========================
   DELETE TESTIMONIAL
========================= */
function deleteTestimonial(id) {

    if (!confirm("Are you sure?")) return;

    $.ajax({
        url: DELETE_URL + "/" + id,
        method: "DELETE",
        success: function () {
            loadTestimonials();
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            alert("Delete failed");
        }
    });
}

/* =========================
   SEARCH FILTER
========================= */
$("#search").on("keyup", function () {

    let value = $(this).val().toLowerCase();

    $("#testimonialTable tr").filter(function () {
        $(this).toggle(
            $(this).text().toLowerCase().indexOf(value) > -1
        );
    });
});

/* INIT */
loadTestimonials();

</script></body>
</html>