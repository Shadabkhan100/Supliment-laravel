  <!-- NEWEST PRODUCTS START -->


<div class="coming-soon-wrapper" style:"margin:auto 20px">
    <img src="{{ asset('images/home/coming-soon.png') }}" alt="Coming Soon">
</div>

<!-- NEWEST PRODUCTS START -->

<section class="newest-section py-40">

    <div class="container-fluid">

        <!-- Loader -->
        <div class="text-center" id="newestLoader">
            <div class="spinner-border text-light"></div>
        </div>

        <!-- IMAGE GRID -->
        <div class="row g-3 justify-content-center" id="newestProducts"></div>

    </div>

</section>

<style>

.newest-section{
    background: black;
    min-height: 300px;
}

/* IMAGE CARD */
.future-img-card{
    width: 100%;
    max-width: 280px;
    border-radius: 14px;
    overflow: hidden;
    cursor: pointer;
    transition: 0.3s ease;
    margin: auto;
}

.future-img-card img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    border-radius: 14px;
}

.future-img-card:hover{
    transform: scale(1.03);
}

/* RESPONSIVE ALIGNMENT */
@media (max-width: 768px){
    .future-img-card{
        max-width: 100%;
    }
}

</style>

<script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>

<script>

const FUTURE_API = "http://127.0.0.1:8000/api/get-future-products";

$(document).ready(function () {
    loadNewestProducts();
});

function loadNewestProducts(){

    $("#newestLoader").show();

    $.ajax({
        url: FUTURE_API,
        type: "GET",

        success: function(res){

            let html = "";

            if(res.data && res.data.length > 0){

               res.data.forEach((item) => {

    html += `
        <div class="col-6 d-flex justify-content-center">

            <div class="future-img-card">

                <img src="${item.image}" alt="future product">

            </div>

        </div>
    `;
});

            } else {

                html = `
                    <div class="col-12 text-center text-white">
                        No products available
                    </div>
                `;
            }

            $("#newestProducts").html(html);
            $("#newestLoader").hide();
        },

        error: function(){

            $("#newestLoader").hide();

            $("#newestProducts").html(`
                <div class="col-12 text-center text-danger">
                    Failed to load products
                </div>
            `);
        }
    });

}

</script>

<!-- NEWEST PRODUCTS END -->