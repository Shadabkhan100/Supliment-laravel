<!-- BLOGS SECTION START -->
<section class="blog-section pt-40">
  <div class="container-fluid">

    <div
      class="d-flex align-items-center justify-content-between flex-sm-row flex-column gap-sm-0 gap-24 mb-48"
    >
      <div>
        <h2 class="fw-600 black mb-12">Our Recent Blogs</h2>
        <p>
          Catch up on the latest insights, tips, and trends from our recent blogs.
        </p>
      </div>

      <a href="/blogs" class="cus-btn-arrow">
        See More Blogs
        <div class="icon">
          <i class="fa-light fa-chevron-right"></i>
        </div>
      </a>
    </div>

    <!-- LOADER -->
    <div id="blogLoader" class="text-center py-5">
      <div class="spinner-border text-dark" role="status"></div>
    </div>

    <!-- BLOGS CONTENT -->
    <div class="row row-gap-4 d-none" id="blogsContainer">

      <!-- LEFT SIDE MAIN BLOG -->
      <div class="col-xl-6" id="mainBlogContainer"></div>

      <!-- RIGHT SIDE SMALL BLOGS -->
      <div class="col-xl-6">
        <div class="row row-gap-4" id="smallBlogsContainer"></div>
      </div>

    </div>

  </div>
</section>
<!-- BLOGS SECTION END -->

<script>

  $(document).ready(function () {

    fetchBlogs();

  });

  function fetchBlogs()
  {
    $('#blogLoader').removeClass('d-none');
    $('#blogsContainer').addClass('d-none');

    $.ajax({

      url: '/api/blogs',
      type: 'GET',

      success: function (response)
      {
        let blogs = response.data;

        $('#blogLoader').addClass('d-none');
        $('#blogsContainer').removeClass('d-none');

        renderBlogs(blogs);
      },

      error: function ()
      {
        $('#blogLoader').html(`
          <p class="text-danger">
            Failed to load blogs.
          </p>
        `);
      }
    });
  }

  function renderBlogs(blogs)
  {
    if (!blogs || blogs.length === 0) {

      $('#blogsContainer').html(`
        <div class="col-12 text-center">
          <p>No blogs found.</p>
        </div>
      `);

      return;
    }

    // MAIN BLOG
    let mainBlog = blogs[0];

    let mainBlogHtml = `
      <div class="blog-card main d-flex flex-column gap-16 bg-lightest-gray br-16">

        <a href="/blogs/view-blogs/name/${mainBlog.id}" class="card-image">

          <img
            src="${mainBlog.image ?? 'images/1_1.png'}"
            alt="${mainBlog.title}"
          />

        </a>

        <div class="d-flex flex-column gap-32">

          <div class="d-flex flex-column gap-16 black">

            <div class="create-by">

              <p class="fw-500">
                ${formatDate(mainBlog.publish_date)}
              </p>

              <div class="dot"></div>

              <p class="dark-gray">
                By ${mainBlog.author ?? 'Admin'}
              </p>

            </div>

            <a
              href="/blogs/view-blogs/name/${mainBlog.id}"
              class="h4"
            >
              ${mainBlog.title ?? ''}
            </a>

            <p>
              ${truncateText(mainBlog.short_description ?? mainBlog.description ?? '', 180)}
            </p>

          </div>

          <a
            href="/blogs/view-blogs/name/${mainBlog.id}"
            class="text-16 medium black card-btn"
          >
            Read More
          </a>

        </div>

      </div>
    `;

    $('#mainBlogContainer').html(mainBlogHtml);

    // SMALL BLOGS
    let smallBlogsHtml = '';

    blogs.slice(1, 5).forEach(blog => {

      smallBlogsHtml += `
        <div class="col-lg-6">

          <div class="blog-card main d-flex flex-column gap-16 bg-lightest-gray br-16">

            <a
              href="/blogs/view-blogs/name/${blog.id}"
              class="card-image"
            >

              <img
                src="${blog.image ?? 'images/2_1.png'}"
                alt="${blog.title}"
              />

            </a>

            <div class="d-flex flex-column gap-32">

              <div class="d-flex flex-column gap-16 black">

                <div class="create-by">

                  <p class="fw-500">
                    ${formatDate(blog.publish_date)}
                  </p>

                  <div class="dot"></div>

                  <p class="dark-gray">
                    By ${blog.author ?? 'Admin'}
                  </p>

                </div>

                <a
                  href="/blogs/view-blogs/name/${blog.id}"
                  class="h6"
                >
                  ${truncateText(blog.title ?? '', 60)}
                </a>

              </div>

              <a
                href="/blogs/view-blogs/name/${blog.id}"
                class="text-16 medium black card-btn"
              >
                Read More
              </a>

            </div>

          </div>

        </div>
      `;
    });

    $('#smallBlogsContainer').html(smallBlogsHtml);
  }

  function truncateText(text, limit)
  {
    if (!text) return '';

    return text.length > limit
      ? text.substring(0, limit) + '...'
      : text;
  }

  function formatDate(dateString)
  {
    if (!dateString) return '';

    let date = new Date(dateString);

    return date.toLocaleDateString('en-GB', {
      day: '2-digit',
      month: 'short',
      year: 'numeric'
    });
  }

</script>