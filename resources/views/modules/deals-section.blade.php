<style>
    .deal-section {
        background: black;
    }

    .deal-img-card {
        width: 100%;
        position: relative;
        cursor: pointer;
        border-radius: 14px;
        overflow: hidden;
        transition: 0.3s ease;
        border: 2px solid transparent;
    }

    .deal-img-card img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
        transition: 0.3s ease;
        border-radius: 14px;
    }

    .deal-img-card:hover {
        transform: translateY(-5px);
    }

    .deal-img-card.active {
        border: 2px solid #22c55e;
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.2);
    }

    .deal-loader {
        text-align: center;
        padding: 30px;
    }

    /* Prevent horizontal scroll */
    body {
        overflow-x: hidden;
    }

    /* Mobile */
    @media (max-width: 767px) {
        .deal-col {
            width: 100%;
        }

        .deal-img-card {
            max-width: 100%;
        }
    }

    /* Tablet */
    @media (min-width: 768px) and (max-width: 991px) {
        .deal-col {
            width: 50%;
        }
    }

    /* Laptop/Desktop */
    @media (min-width: 992px) {
        .deal-col {
            width: 33.333%;
        }
    }
</style>

<div class="container-fluid">
    <section class="deal-section py-40">

        <h2 class="fw-600 mb-8" style="color:#9eef0b;">
            Our Latest Deals
        </h2>

        <p class="mb-24" style="color: #bab4b4;">
            A thoughtfully curated wellbeing collection crafted to elevate daily rituals.
        </p>

        <div class="container-fluid p-0">

            <div class="row g-3 justify-content-center" id="dealContainer">

                <!-- Loader -->
                <div class="col-12 deal-loader" id="dealLoader">
                    <div class="spinner-border text-success"></div>
                </div>

            </div>

        </div>

    </section>
</div>

<script>
const DEAL_API = "/api/deals";

$(document).ready(function () {
    loadDeals();
});

function loadDeals() {

    $("#dealLoader").show();

    $.ajax({
        url: DEAL_API,
        type: "GET",

        success: function (res) {

            let html = "";

            res.data.forEach((deal) => {

                let slug = deal.title
                    ? deal.title.toLowerCase().replace(/\s+/g, '-')
                    : deal.id;

                html += `
                    <div class="deal-col mb-3">

                        <div class="deal-img-card"
                             onclick="goToDeal('${slug}', ${deal.id}, this)">

                            <img src="${deal.image ?? 'https://via.placeholder.com/400x220'}">

                        </div>

                    </div>
                `;
            });

            $("#dealContainer").html(html);
            $("#dealLoader").hide();
        },

        error: function () {
            $("#dealLoader").html("<p>Failed to load deals</p>");
        }
    });
}

function goToDeal(slug, id, el) {

    $(".deal-img-card").removeClass("active");

    $(el).addClass("active");

    window.location.href = `/find-product/${slug}/${id}`;
}
</script>