@extends('layout.Main')

@section('content')

<main class="main-wrapper">

    <!-- TITLE -->
    <section class="title-banner">
        <div class="container">
            <h2 class="white fw-600 text-center">Blog</h2>
        </div>
    </section>

    <!-- BLOG SECTION -->
    <div class="blog-section py-40">
        <div class="container-fluid">

            <!-- TOP BAR -->
            <div class="row row-gap-3 align-items-center justify-content-between mb-24">

                <div class="col-xl-4 col-lg-5 col-md-5">
                    <div class="d-flex align-items-center gap-16">

                        <a href="javascript:;" class="visual-box shop-filter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none">
                                <path d="M19.8812 1.2635L19.8812 1.26346C19.8327 1.16071..." fill="#141516"></path>
                            </svg>
                            <span class="fw-600">Filters</span>
                        </a>

                        <p class="black d-lg-block d-none">
                            Showing <span id="showingCount">00</span> Results
                        </p>

                    </div>
                </div>

                <!-- SEARCH -->
                <div class="col-xl-3 col-lg-5 col-md-6">
                    <form class="newsletter-form" onsubmit="return false;">
                        <input type="text" id="searchInput" class="form-control search-input" placeholder="Search Here...">
                    </form>
                </div>

            </div>

            <!-- LOADER -->
            <div id="progressLoader" class="mb-24">
                <div style="height:4px;background:#ddd;border-radius:10px;overflow:hidden;">
                    <div id="progressBar" style="height:100%;width:0%;background:#9eef0b;"></div>
                </div>
            </div>

            <!-- BLOG GRID -->
            <div class="row row-gap-4" id="blogsWrapper"></div>

            <!-- PAGINATION -->
            <div class="pagination mt-48 text-center">
                <ul id="border-pagination" style="display:flex;gap:10px;list-style:none;justify-content:center;"></ul>
            </div>

        </div>
    </div>

</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

let allBlogs = [];
let filteredBlogs = [];
let currentPage = 1;
const perPage = 5;

/* INIT */
$(document).ready(function () {
    fetchBlogs();
});

/* FETCH */
function fetchBlogs()
{
    showLoader(30);

    $.ajax({
        url: '/api/blogs',
        type: 'GET',

        success: function (res)
        {
            showLoader(100);

            setTimeout(() => {

                allBlogs = res.data || [];
                filteredBlogs = allBlogs;

                render();

                $('#progressLoader').hide();

            }, 300);
        },

        error: function ()
        {
            $('#progressBar').css('background', 'red');
        }
    });
}

/* LOADER */
function showLoader(p)
{
    $('#progressLoader').show();
    $('#progressBar').css('width', p + '%');
}

/* RENDER MAIN */
function render()
{
    renderBlogs();
    renderPagination();
}

/* RENDER BLOGS (5 PER PAGE) */
function renderBlogs()
{
    let start = (currentPage - 1) * perPage;
    let end = start + perPage;

    let blogs = filteredBlogs.slice(start, end);

    let container = $('#blogsWrapper');
    container.html('');

    $('#showingCount').text(filteredBlogs.length);

    if (!blogs.length)
    {
        container.html(`<div class="col-12 text-center">No blogs found</div>`);
        return;
    }

    blogs.forEach(blog => {

        container.append(`
            <div class="col-xl-3 col-lg-4 col-sm-6">

                <div class="blog-card main d-flex flex-column gap-16 bg-lightest-gray br-16">

                    <a href="/blog-details/${blog.title}/${blog.id}" class="card-image">
                        <img src="${blog.image}" alt="${blog.title}">
                    </a>

                    <div class="d-flex flex-column gap-32">

                        <div class="d-flex flex-column gap-16 black">

                            <div class="create-by">
                                <p class="fw-500">${formatDate(blog.publish_date)}</p>
                                <div class="dot"></div>
                                <p class="dark-gray">By ${blog.author ?? 'Admin'}</p>
                            </div>

                            <a href="/blog-details/${blog.title}/${blog.id}" class="h6">
                                ${blog.title}
                            </a>

                        </div>

                        <a href="/blog-details/${blog.title}/${blog.id}" class="text-16 medium black card-btn">
                            Read More
                        </a>

                    </div>

                </div>

            </div>
        `);

    });
}

/* PAGINATION */
function renderPagination()
{
    let totalPages = Math.ceil(filteredBlogs.length / perPage);
    let pagination = $('#border-pagination');
    pagination.html('');

    if (totalPages <= 1) return;

    // PREV
    pagination.append(`
        <li><a href="javascript:;" onclick="changePage(${currentPage - 1})">‹</a></li>
    `);

    // PAGES
    for (let i = 1; i <= totalPages; i++)
    {
        pagination.append(`
            <li>
                <a href="javascript:;"
                   class="${i === currentPage ? 'active' : ''}"
                   onclick="changePage(${i})">
                   ${i}
                </a>
            </li>
        `);
    }

    // NEXT
    pagination.append(`
        <li><a href="javascript:;" onclick="changePage(${currentPage + 1})">›</a></li>
    `);
}

/* CHANGE PAGE */
function changePage(page)
{
    let totalPages = Math.ceil(filteredBlogs.length / perPage);

    if (page < 1 || page > totalPages) return;

    currentPage = page;

    renderBlogs();
    renderPagination();

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* SEARCH */
$('#searchInput').on('keyup', function () {

    let value = $(this).val().toLowerCase();

    filteredBlogs = allBlogs.filter(b => {

        return (
            (b.title || '').toLowerCase().includes(value) ||
            (b.short_description || '').toLowerCase().includes(value) ||
            (b.description || '').toLowerCase().includes(value)
        );

    });

    currentPage = 1;

    render();
});

/* DATE */
function formatDate(date)
{
    if (!date) return '';

    return new Date(date).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
}

</script>

@endsection