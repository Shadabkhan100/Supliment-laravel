<!-- PRODUCT CATEGORIES START -->
<div class="categories-section pt-80 pb-40"
     style="background: url('images/home-bg.png') center center / cover no-repeat; width: 100vw; height: auto;
     padding: clamp(48px, 4.167vw, 180px) 0px 0px;">

    <div class="container-fluid">

        <div class="row row-gap-4"
             id="categoryContainer">

            <!-- LOADED VIA API -->

        </div>

    </div>

</div>
<!-- PRODUCT CATEGORIES END -->

<!-- =========================
     SCRIPT SECTION
========================= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function () {
    loadCategories();
});

function loadCategories()
{
    $.ajax({

        url: '/api/categories',
        type: 'GET',

        success: function (res) {

            let categories = res.data || [];

            let html = '';

            if(categories.length === 0)
            {
                $('#categoryContainer').html(`
                    <div class="col-12 text-center text-muted">
                        No categories found
                    </div>
                `);
                return;
            }

            categories.forEach(category => {

                html += `
                    <div class="col-lg-2 col-md-4 col-sm-6 col-6">

                        <a href="/shop?category=${category.id}"
                           class="category-block">

                            <div class="image-box mb-16">

                                <img src="${category.image || '/images/default.png'}"
                                     alt="${category.name || ''}">

                            </div>

                            <div class="text-box">

                                <p style="color:white" class="subtitle"
                                   style="margin-top: -20px;">

                                    ${category.products_count ?? 0}+ Items

                                </p>

                            </div>

                        </a>

                    </div>
                `;

            });

            $('#categoryContainer').html(html);

        },

        error: function (xhr) {

            console.log('API Error:', xhr.responseText);

            $('#categoryContainer').html(`
                <div class="col-12 text-center text-danger">
                    Failed to load categories
                </div>
            `);

        }

    });

}

</script>