@extends('layout.Main')

@section('content')

<style>
/* =========================
   BLOG CONTENT DARK STYLE
   FIXED & OVERRIDE SAFE
========================= */

.blog-content {
    color: #eaeaea !important;
    line-height: 1.8;
    font-size: 16px;
}

/* Paragraph */
.blog-content p {
    color: #eaeaea !important;
    margin-bottom: 16px;
}

/* Headings */
.blog-content h1,
.blog-content h2,
.blog-content h3,
.blog-content h4,
.blog-content h5,
.blog-content h6 {
    color: #ffffff !important;
    font-weight: 700;
}

/* Heading sizes */
.blog-content h1 { font-size: 32px; margin: 24px 0 12px; }
.blog-content h2 { font-size: 26px; margin: 22px 0 10px; }
.blog-content h3 { font-size: 22px; margin: 20px 0 10px; }

/* Lists */
.blog-content ul,
.blog-content ol {
    padding-left: 20px;
    margin-bottom: 16px;
    color: #eaeaea !important;
}

.blog-content li {
    margin-bottom: 6px;
}

/* Blockquote / Quotes */
.blog-content blockquote {
    border-left: 4px solid #9eef0b;
    background: #1a1a1a;
    color: #d5d5d5 !important;
    padding: 12px 16px;
    margin: 20px 0;
    border-radius: 6px;
    font-style: italic;
}

/* Links */
.blog-content a {
    color: #9eef0b !important;
    text-decoration: none;
}

.blog-content a:hover {
    text-decoration: underline;
}

/* Images */
.blog-content img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 16px 0;
}
</style>
<section class="title-banner">
    <div class="container">

        <h2 class="white fw-600 text-center mb-24">
            {{ $blog->title }}
        </h2>

        <p class="white text-center">
            {{ \Carbon\Carbon::parse($blog->publish_date)->format('d M, Y') }}

            @if($blog->author)
                <span class="light-gray">
                    • By {{ $blog->author }}
                </span>
            @endif
        </p>

    </div>
</section>
<!-- TITLE BANNER END -->

<!-- Blog Detail Section Start -->
<div class="blog-detail-page py-40">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="blog-detail-wrapper">

                    <!-- SHORT DESCRIPTION -->
                    @if($blog->short_description)
                        <p class="mb-24">
                            {{ $blog->short_description }}
                        </p>
                    @endif

                    <!-- MAIN IMAGE -->
                    @if($blog->image)
                        <div class="main-image mb-24">
                            <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="w-100 br-10">
                        </div>
                    @endif

                    <!-- FULL DESCRIPTION (MARKDOWN HTML) -->
                    <div class="blog-content mb-24">
                        {!! $blog->description !!}
                    </div>

                    <!-- TAGS (STATIC OR FUTURE DB READY) -->
                    <div class="row row-gap-4 mb-24">
                        <div class="col-sm-6">
                            <img src="{{ asset('images/blog-detail-2.png') }}" class="w-100 br-10" alt="">
                        </div>
                        <div class="col-sm-6">
                            <img src="{{ asset('images/blog-detail-3.png') }}" class="w-100 br-10" alt="">
                        </div>
                    </div>

                   

                    <div class="hr-line bg-light-gray mb-24"></div>

                    <!-- SHARE + TAGS -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-24 mb-24">

                        <div class="blog-tags-wrapper">
                            <h6 class="black2 fw-600">Tags:</h6>

                            <a href="#" class="blog-tags black2">Wellness</a>
                            <a href="#" class="blog-tags black2">Tea</a>
                            <a href="#" class="blog-tags black2">Lifestyle</a>
                        </div>

                        <ul class="list-unstyled social-link mb-0 d-flex align-items-center gap-2">

                            <li><h6 class="black2 fw-600 mb-0">Share:</h6></li>

                            <li>
                                <a href="#" class="blog-icons">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="blog-icons">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="blog-icons">
                                    <i class="fab fa-x-twitter"></i>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="blog-icons">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>

                        </ul>
                    </div>

                    <div class="hr-line bg-dark-gray mb-64"></div>

                    <!-- COMMENTS -->
                    <div class="review-area p-16 bg-black br-15 mb-48">

                        <h2 class="mb-32 fw-700" style="color:#9eef0b">Comments</h2>

                        @forelse($comments as $comment)

                            <div class="review-block mb-24">

                                <div class="image-box">
                                    <img src="{{ $comment['author']['image'] ?? asset('images/default-user.png') }}" alt="">
                                </div>

                                <div class="text-box">

                                    <div class="mb-16">
                                        <h6 class="fw-600 black2 mb-8">
                                            {{ $comment['author']['name'] ?? 'Guest' }}
                                        </h6>

                                        <span class="subtitle fw-500">
                                            {{ $comment['created_at'] }}
                                        </span>
                                    </div>

                                    <p class="mb-24">
                                        {{ $comment['content'] }}
                                    </p>

                                    <a href="#" class="reply-btn fw-500">Reply</a>
                                </div>
                            </div>

                            <!-- REPLIES -->
                            @if(!empty($comment['replies']))
                                @foreach($comment['replies'] as $reply)

                                    <div class="review-block block-2 mb-32">

                                        <div class="image-box">
                                            <img src="{{ $reply['author']['image'] ?? asset('images/default-user.png') }}" alt="">
                                        </div>

                                        <div class="text-box">

                                            <div class="mb-16">
                                                <h6 class="fw-600 black2 mb-8">
                                                    {{ $reply['author']['name'] ?? 'Admin' }}
                                                </h6>

                                                <span class="subtitle fw-500">
                                                    {{ $reply['created_at'] }}
                                                </span>
                                            </div>

                                            <p class="mb-24">
                                                {{ $reply['content'] }}
                                            </p>

                                            <a href="#" class="reply-btn fw-500">Reply</a>
                                        </div>

                                    </div>

                                @endforeach
                            @endif

                        @empty
                            <p class="text-white">No comments yet.</p>
                        @endforelse

                    </div>

                    <!-- COMMENT FORM -->
                    <div class="comment-wrapper p-16 bg-black br-15">

                        <h2 class="mb-16 fw-700" style="color:#9eef0b">Leave a Comment</h2>

                        <form action="#" method="post" class="blog-form">
                            @csrf

                            <div class="row">

                                <div class="col-md-12">
                                    <textarea name="message" class="form-control mb-16" rows="5"
                                        placeholder="Write Your Comments..."></textarea>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control mb-16"
                                        placeholder="Your Name" required>
                                </div>

                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control mb-16"
                                        placeholder="Your Email" required>
                                </div>

                                <div class="col-md-12 mb-32">
                                    <input type="checkbox" id="remember" checked>
                                    <label for="remember">Remember my details for future comments.</label>
                                </div>

                                <div class="col-md-6">
                                    <button type="submit" class="cus-btn-arrow">
                                        Post Comment
                                        <span class="icon">
                                            <i class="fa fa-arrow-right"></i>
                                        </span>
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection