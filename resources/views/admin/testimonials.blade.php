<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
   
@extends('admin.main')

@section('title', 'Testimonials Manage')

@section('page-title', 'Testimonials Manage')
@section('content')

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

                <h5 class="mb-3" id="testimonialFormTitle">
    Add Testimonial
</h5>

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
const EDIT_URL = "/testimonials/edit";

let editTestimonialId = null;
let currentImage = null;


/* =========================
   LOAD TESTIMONIALS
========================= */

function loadTestimonials() {

    $("#tableLoader").show();
    $("#testimonialTable").html("");

    $.get(GET_URL, function (data) {

        $("#tableLoader").hide();

        data.forEach(item => {
            $("#testimonialTable").append(
                createTestimonialRow(item)
            );
        });

    }).fail(function (xhr) {

        $("#tableLoader").hide();

        console.log(xhr.responseText);

        $("#testimonialTable").html(`
            <tr>
                <td colspan="4" class="text-center text-danger">
                    Failed to load testimonials
                </td>
            </tr>
        `);

    });
}


/* =========================
   CREATE TABLE ROW
========================= */

function createTestimonialRow(item) {

    let img = item.image
        ? item.image
        : '/images/user-1.png';

    return `
        <tr data-testimonial-id="${item.id}">

            <td>
                <img src="${img}"
                     style="
                        width:40px;
                        height:40px;
                        border-radius:50%;
                        object-fit:cover;
                        margin-right:8px;
                     ">

                ${item.name}
            </td>

            <td>
                ${item.message}
            </td>

            <td>
                ${item.rating}
            </td>

            <td>

                <button
                    class="btn btn-warning btn-sm edit-testimonial-btn"
                    data-id="${item.id}">

                    <i class="fa fa-edit"></i>
                    Edit

                </button>

                <button
                    class="btn btn-danger btn-sm"
                    onclick="deleteTestimonial(${item.id})">

                    <i class="fa fa-trash"></i>
                    Delete

                </button>

            </td>

        </tr>
    `;
}


/* =========================
   ADD / EDIT MODE RESET
========================= */
function resetTestimonialForm() {

    editTestimonialId = null;
    currentImage = null;

    $("#testimonialForm")[0].reset();

    $("#submitBtn").text("Add Testimonial");

    $("#testimonialFormTitle").text("Add Testimonial");

    $("#currentImagePreview").remove();
}

/* =========================
   EDIT TESTIMONIAL
========================= */

$(document).on(
    "click",
    ".edit-testimonial-btn",
    function () {

        const id = $(this).data("id");

        editTestimonialId = id;

        $("#formLoader").show();

        /*
        Get the testimonial from existing API
        */

        $.get(GET_URL, function (data) {

            const testimonial = data.find(
                item => String(item.id) === String(id)
            );

            if (!testimonial) {

                $("#formLoader").hide();

                alert("Testimonial not found.");

                return;
            }


            /*
            Fill form
            */

            $("#name").val(
                testimonial.name || ""
            );

            $("#role").val(
                testimonial.role || "Customer"
            );

            $("#rating").val(
                testimonial.rating || 5
            );

            $("#message").val(
                testimonial.message || ""
            );


            /*
            Store existing image
            */

            currentImage =
                testimonial.image || null;


            /*
            Reset file input
            */

            $("#image").val("");


            /*
            Remove previous preview
            */

            $("#currentImagePreview").remove();


            /*
            Show existing image
            */

            if (currentImage) {

                $("#image").after(`

                    <div id="currentImagePreview"
                         style="margin-top:10px;">

                        <small style="
                            display:block;
                            color:#aaa;
                            margin-bottom:5px;
                        ">
                            Current Image
                        </small>

                        <img src="${currentImage}"
                             style="
                                width:90px;
                                height:90px;
                                border-radius:10px;
                                object-fit:cover;
                                border:2px solid #333;
                             ">

                        <div style="
                            color:#aaa;
                            font-size:12px;
                            margin-top:5px;
                        ">
                            Select a new image to replace it.
                        </div>

                    </div>

                `);

            }


            /*
            Change form to EDIT mode
            */

            $("#submitBtn")
                .text("Update Testimonial");

            $("#testimonialForm")
                .find("h5")
                .text("Edit Testimonial");


            $("#formLoader").hide();


            /*
            Scroll to form
            */

            $("html, body").animate({
                scrollTop: $("#testimonialForm").offset().top - 100
            }, 400);

        }).fail(function (xhr) {

            $("#formLoader").hide();

            console.log(xhr.responseText);

            alert(
                "Failed to load testimonial."
            );

        });

    }
);


/* =========================
   IMAGE PREVIEW
========================= */

$("#image").on("change", function () {

    const file = this.files[0];

    /*
    Remove old preview
    */

    $("#newImagePreview").remove();


    if (!file) {
        return;
    }


    /*
    Show selected image
    */

    const reader = new FileReader();

    reader.onload = function (e) {

        $("#image").after(`

            <div id="newImagePreview"
                 style="margin-top:10px;">

                <small style="
                    display:block;
                    color:#9eef0b;
                    margin-bottom:5px;
                ">
                    New Image
                </small>

                <img src="${e.target.result}"
                     style="
                        width:90px;
                        height:90px;
                        border-radius:10px;
                        object-fit:cover;
                        border:2px solid #9eef0b;
                     ">

            </div>

        `);

    };

    reader.readAsDataURL(file);

});


/* =========================
   ADD / UPDATE TESTIMONIAL
========================= */

$("#testimonialForm").submit(function (e) {

    e.preventDefault();


    $("#submitBtn").prop(
        "disabled",
        true
    );

    $("#formLoader").show();


    let formData = new FormData();


    formData.append(
        "name",
        $("#name").val()
    );

    formData.append(
        "role",
        $("#role").val()
    );

    formData.append(
        "rating",
        $("#rating").val()
    );

    formData.append(
        "message",
        $("#message").val()
    );


    /*
    New image
    */

    let imageFile =
        $("#image")[0].files[0];

    if (imageFile) {

        formData.append(
            "image",
            imageFile
        );

    }


    /*
    Existing image
    */

    if (currentImage) {

        formData.append(
            "current_image",
            currentImage
        );

    }


    /*
    =========================
    EDIT
    =========================
    */

    if (editTestimonialId) {

        $.ajax({

            url:
                EDIT_URL +
                "/" +
                editTestimonialId,

            method: "POST",

            data: formData,

            processData: false,

            contentType: false,

                headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
            success: function (res) {

                /*
                Get updated testimonial
                */

                const updated =
                    res.data ||
                    res.testimonial;


                if (updated) {

                    const row =
                        $(
                            `tr[data-testimonial-id="${editTestimonialId}"]`
                        );


                    row.replaceWith(
                        createTestimonialRow(
                            updated
                        )
                    );

                } else {

                    loadTestimonials();

                }


                $("#formLoader").hide();

                $("#submitBtn")
                    .prop("disabled", false);


                resetTestimonialForm();


                alert(
                    res.message ||
                    "Testimonial updated successfully."
                );

            },


            error: function (xhr) {

                $("#formLoader").hide();

                $("#submitBtn")
                    .prop("disabled", false);

                console.log(
                    xhr.responseText
                );

                alert(
                    xhr.responseJSON?.message ||
                    "Failed to update testimonial."
                );

            }

        });


        return;
    }


    /*
    =========================
    ADD
    =========================
    */

    $.ajax({

        url: POST_URL,

        method: "POST",

        data: formData,

        processData: false,

        contentType: false,


        success: function (res) {

            const newTestimonial =
                res.data ||
                res.testimonial;


            if (newTestimonial) {

                /*
                Remove "No testimonials"
                */

                $("#testimonialTable")
                    .find("td[colspan='4']")
                    .closest("tr")
                    .remove();


                /*
                Add new row instantly
                */

                $("#testimonialTable")
                    .prepend(
                        createTestimonialRow(
                            newTestimonial
                        )
                    );

            } else {

                loadTestimonials();

            }


            $("#formLoader").hide();

            $("#submitBtn")
                .prop("disabled", false);


            resetTestimonialForm();


            alert(
                res.message ||
                "Testimonial added successfully."
            );

        },


        error: function (xhr) {

            $("#formLoader").hide();

            $("#submitBtn")
                .prop("disabled", false);

            console.log(
                xhr.responseText
            );

            alert(
                xhr.responseJSON?.message ||
                "Error saving testimonial."
            );

        }

    });

});


/* =========================
   DELETE TESTIMONIAL
========================= */

function deleteTestimonial(id) {

    if (!confirm(
        "Are you sure you want to delete this testimonial?"
    )) {
        return;
    }


    $.ajax({

        url:
            DELETE_URL +
            "/" +
            id,

        method: "DELETE",


        success: function () {

            $(
                `tr[data-testimonial-id="${id}"]`
            ).remove();


            /*
            Show empty message
            */

            if (
                $("#testimonialTable tr").length === 0
            ) {

                $("#testimonialTable").html(`

                    <tr>

                        <td colspan="4"
                            class="text-center py-4">

                            No testimonials found

                        </td>

                    </tr>

                `);

            }

        },


        error: function (xhr) {

            console.log(
                xhr.responseText
            );

            alert(
                "Delete failed."
            );

        }

    });

}


/* =========================
   SEARCH
========================= */

$("#search").on("keyup", function () {

    let value =
        $(this)
        .val()
        .toLowerCase();


    $("#testimonialTable tr")
        .filter(function () {

            $(this).toggle(
                $(this)
                .text()
                .toLowerCase()
                .indexOf(value) > -1
            );

        });

});


/* =========================
   INIT
========================= */

loadTestimonials();

</script>

@endsection