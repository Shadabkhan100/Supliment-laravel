@extends('admin.main')

@section('title', 'Comments')

@section('page-title', 'Users Feedbacks')

@section('content')

<style>
.delete-message-btn {
    position: absolute;
    top: 14px;
    right: 14px;

    width: 32px;
    height: 32px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: none;
    border-radius: 7px;

    background: #f8f8f8;
    color: #999;

    cursor: pointer;

    transition: all .2s ease;
}

.delete-message-btn:hover {
    background: #feecec;
    color: #dc3545;
}

.delete-message-btn i {
    font-size: 13px;
}
    .management-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    /* Search */
    .search-box {
        width: 100%;
        max-width: 350px;
        position: relative;
    }

    .search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 19px;
        color: #777;
        z-index: 2;
    }

    .search-box input {
        height: 44px;
        padding-left: 42px;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: none;
    }

    .search-box input:focus {
        border-color: #111;
        box-shadow: none;
    }

    /* Feedback Card */
    .feedback-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 14px;
        padding: 20px;
        height: 100%;
        transition: .2s ease;
    }

    .feedback-card:hover {
        border-color: #d2d2d2;
        box-shadow: 0 5px 18px rgba(0, 0, 0, .06);
        transform: translateY(-2px);
    }

    /* User */
    .feedback-user {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-placeholder {
        width: 46px;
        height: 46px;
        min-width: 46px;
        border-radius: 50%;
        background: #f1f1f1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-placeholder i {
        font-size: 25px;
        color: #777;
    }

    .user-details {
        min-width: 0;
    }

    .user-details h6 {
        margin: 0 0 3px;
        color: #222;
        font-size: 15px;
        font-weight: 600;
    }

    .user-details span {
        display: block;
        color: #888;
        font-size: 12px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Date */
    .feedback-date {
        margin-top: 15px;
        padding-top: 12px;
        border-top: 1px solid #eee;
        color: #999;
        font-size: 11px;
    }

    /* Message */
    .feedback-message {
        margin-top: 14px;
    }

    .message-text {
        margin: 0;
        color: #555;
        font-size: 14px;
        line-height: 1.7;

        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Expanded */
    .feedback-card.expanded .message-text {
        display: block;
        -webkit-line-clamp: unset;
        overflow: visible;
    }

    /* View More */
    .view-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        margin-top: 8px;
        padding: 0;
        border: none;
        background: transparent;
        color: #111;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .view-more-btn:hover {
        color: #555;
    }

    .view-more-btn i {
        font-size: 18px;
        transition: .2s ease;
    }

    .feedback-card.expanded .view-more-btn i {
        transform: rotate(180deg);
    }

    /* Empty */
    .empty-feedback {
        text-align: center;
        padding: 60px 20px;
        color: #777;
    }

    .empty-feedback i {
        display: block;
        font-size: 48px;
        color: #bbb;
        margin-bottom: 12px;
    }

    .empty-feedback h5 {
        margin-bottom: 5px;
        color: #444;
    }

    .empty-feedback p {
        margin: 0;
        font-size: 14px;
    }

</style>

<body>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>
                <h5 class="mb-1 fw-semibold">
                    Users Feedbacks
                </h5>

                <p class="text-muted small mb-0">
                    View and manage messages submitted by users.
                </p>
            </div>

            {{-- Search --}}
            <div class="search-box">

                <i class="fa fa-search"></i>

                <input
                    type="text"
                    id="feedbackSearch"
                    class="form-control"
                    placeholder="Search feedback..."
                >

            </div>

        </div>


        {{-- Feedback Cards --}}
        <div class="row g-4" id="feedbackContainer">

          @forelse($messages ?? [] as $message)

    <div
        class="col-xl-4 col-lg-6 col-md-6 feedback-item"
        id="message-card-{{ $message->id }}"
        data-search="{{ strtolower($message->name . ' ' . $message->email . ' ' . $message->message) }}"
    >

        <div class="feedback-card position-relative">

            {{-- Delete --}}
            <button
                type="button"
                class="delete-message-btn"
                onclick="deleteMessage({{ $message->id }}, this)"
                title="Delete Message"
            >
                <i class="fa fa-trash"></i>
            </button>


            {{-- User --}}
            <div class="feedback-user">

                <div class="user-placeholder">
                    <i class="fa fa-user"></i>
                </div>

                <div class="user-details">

                    <h6>
                        {{ $message->name }}
                    </h6>

                    <span>
                        {{ $message->email }}
                    </span>

                </div>

            </div>


            {{-- Date --}}
            <div class="feedback-date">

                <i class="fa fa-clock me-1"></i>

                {{ $message->created_at?->format('d M Y, h:i A') }}

            </div>


            {{-- Message --}}
            <div class="feedback-message">

                <p class="message-text">
                    {{ $message->message }}
                </p>

                @if(strlen($message->message) > 180)

                    <button
                        type="button"
                        class="view-more-btn"
                        onclick="toggleMessage(this, {{ $message->id }})"
                    >

                        <span class="view-text">
                            View More
                        </span>

                        <i class="fa fa-chevron-down"></i>

                    </button>

                @endif

            </div>

        </div>

    </div>

@empty



                <div class="col-12">

                    <div class="empty-feedback">

                        <i class="fa fa-comments"></i>

                        <h5>
                            No Feedback Found
                        </h5>

                        <p>
                            There are currently no user feedback messages.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>


        {{-- No Search Results --}}
        <div
            id="noSearchResults"
            class="empty-feedback d-none"
        >

            <i class="fa fa-search"></i>

            <h5>
                No Results Found
            </h5>

            <p>
                No feedback matches your search.
            </p>

        </div>

</body>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    /* ============================
       VIEW MORE / VIEW LESS
    ============================ */

    function toggleMessage(button) {

        const card = button.closest('.feedback-card');

        const viewText = button.querySelector('.view-text');

        const icon = button.querySelector('i');

        card.classList.toggle('expanded');

        if (card.classList.contains('expanded')) {

            viewText.textContent = 'View Less';

            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');

        } else {

            viewText.textContent = 'View More';

            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');

        }

    }


    /* ============================
       SEARCH
    ============================ */

    document
        .getElementById('feedbackSearch')
        .addEventListener('input', function () {

            const searchValue = this.value
                .toLowerCase()
                .trim();

            const items = document.querySelectorAll('.feedback-item');

            let visibleCount = 0;

            items.forEach(function (item) {

                const searchableText =
                    item.dataset.search || '';

                if (
                    searchableText.includes(searchValue)
                ) {

                    item.style.display = '';

                    visibleCount++;

                } else {

                    item.style.display = 'none';

                }

            });


            const noResults =
                document.getElementById('noSearchResults');


            if (
                visibleCount === 0 &&
                searchValue !== ''
            ) {

                noResults.classList.remove('d-none');

            } else {

                noResults.classList.add('d-none');

            }

        });





async function deleteMessage(messageId, button) {

    const result = await Swal.fire({
        title: 'Delete Message?',
        text: 'This message will be permanently deleted.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (!result.isConfirmed) {
        return;
    }

    button.disabled = true;

    try {

        const response = await fetch(
            `/user-contact/message-delete/${messageId}`,
            {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }
        );

        const data = await response.json();

        if (response.ok && data.success) {

            const card = document.getElementById(
                `message-card-${messageId}`
            );

            if (card) {
                card.remove();
            }

            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });

            // If there are no cards left, reload the page
            // so your "No Feedback Found" state appears.
            if (document.querySelectorAll('.feedback-item').length === 0) {
                setTimeout(() => {
                    location.reload();
                }, 1500);
            }

        } else {

            throw new Error(
                data.message || 'Unable to delete the message.'
            );

        }

    } catch (error) {

        console.error(error);

        button.disabled = false;

        Swal.fire({
            icon: 'error',
            title: 'Delete Failed',
            text: error.message || 'Something went wrong.'
        });
    }
}

</script>

@endsection