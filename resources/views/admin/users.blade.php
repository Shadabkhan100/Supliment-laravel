@extends('admin.main')

@section('title', 'Users')
@section('page-title', 'Users')

@section('content')

<style>
    .users-page {
        width: 100%;
    }

    .users-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .users-header h3 {
        margin: 0;
        font-size: 22px;
        font-weight: 600;
        color: #1f2937;
    }

    .users-header p {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .users-count {
        background: #f3f4f6;
        color: #374151;
        padding: 7px 13px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    .users-table-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .users-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }

    .users-table thead {
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }

    .users-table th {
        padding: 14px 18px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .04em;
        white-space: nowrap;
    }

    .users-table td {
        padding: 15px 18px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        font-size: 14px;
        color: #374151;
    }

    .users-table tbody tr {
        transition: background .15s ease;
    }

    .users-table tbody tr:hover {
        background: #fafafa;
    }

    .users-table tbody tr:last-child td {
        border-bottom: none;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #e5e7eb;
        background: #f3f4f6;
    }

    .user-name {
        font-weight: 600;
        color: #111827;
        margin-bottom: 3px;
    }

    .user-email {
        font-size: 12px;
        color: #6b7280;
    }

    .user-id {
        color: #9ca3af;
        font-size: 13px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        background: #ecfdf5;
        color: #047857;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10b981;
    }

    .date-text {
        color: #6b7280;
        font-size: 13px;
    }

    .delete-btn {
        width: 34px;
        height: 34px;
        border: 0;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #dc2626;
        background: #fef2f2;
        cursor: pointer;
        transition: all .2s ease;
    }

    .delete-btn:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    .delete-btn i {
        font-size: 15px;
    }

    .empty-users {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .empty-users i {
        font-size: 40px;
        color: #d1d5db;
        margin-bottom: 12px;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 18px;
        border-top: 1px solid #e5e7eb;
        gap: 15px;
        flex-wrap: wrap;
    }

    .pagination-info {
        color: #6b7280;
        font-size: 13px;
    }

    .pagination {
        margin: 0;
    }

    @media (max-width: 768px) {
        .users-header {
            align-items: flex-start;
        }

        .users-count {
            display: none;
        }

        .pagination-wrapper {
            justify-content: center;
        }

        .pagination-info {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="users-page">

    {{-- Header --}}
    <div class="users-header">
        <div>
            <h3>Users Management</h3>
            <p>View and manage registered users.</p>
        </div>

        <div class="users-count">
            {{ $users->total() }} {{ Str::plural('User', $users->total()) }}
        </div>
    </div>

    {{-- Users Table --}}
    <div class="users-table-card">

        <div class="users-table-wrapper">

            @if($users->count() > 0)

                <table class="users-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($users as $user)

                            @php
                                $supabaseBaseUrl = 'https://dulladbjjuutgcgyliou.supabase.co/storage/v1/object/public/slimza-images/';

                                $avatar = $user->avatar ?? null;

                                if ($avatar) {
                                    // If database stores the complete URL
                                    if (Str::startsWith($avatar, ['http://', 'https://'])) {
                                        $avatarUrl = $avatar;
                                    } else {
                                        // If database stores only the Supabase path
                                        $avatarUrl = $supabaseBaseUrl . ltrim($avatar, '/');
                                    }
                                } else {
                                    // Random-looking round profile image based on email
                                    $avatarUrl = 'https://i.pravatar.cc/100?u=' . urlencode($user->email ?? $user->id);
                                }
                            @endphp

                            <tr>

                                {{-- ID --}}
                                <td>
                                    <span class="user-id">
                                        #{{ $user->id }}
                                    </span>
                                </td>

                                {{-- User --}}
                                <td>
                                    <div class="user-info">

                                        <img
                                            src="{{ $avatarUrl }}"
                                            alt="{{ $user->name ?? 'User' }}"
                                            class="user-avatar"
                                            onerror="this.onerror=null;this.src='https://i.pravatar.cc/100?u={{ urlencode($user->id) }}';"
                                        >

                                        <div>
                                            <div class="user-name">
                                                {{ $user->name ?? 'Unknown User' }}
                                            </div>

                                            <div class="user-email">
                                                {{ $user->email }}
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                {{-- Phone --}}
                                <td>
                                    {{ $user->phone ?? '—' }}
                                </td>

                                {{-- Status --}}
                                <td>
                                    <span class="status-badge">
                                        <span class="status-dot"></span>
                                        Active
                                    </span>
                                </td>

                                {{-- Joined --}}
                                <td>
                                    <span class="date-text">
                                        {{ $user->created_at ? $user->created_at->format('d M Y') : '—' }}
                                    </span>
                                </td>

                                {{-- Delete --}}
                                <td style="text-align: center;">

                                    <form
                                        action="{{ route('admin.users.delete', $user->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');"
                                        style="display: inline;"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="delete-btn"
                                            title="Delete User"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="empty-users">
                    <i class="fas fa-users"></i>
                    <div>No users found.</div>
                </div>

            @endif

        </div>

        {{-- Pagination --}}
        @if($users->hasPages())

            <div class="pagination-wrapper">

                <div class="pagination-info">
                    Showing
                    <strong>{{ $users->firstItem() }}</strong>
                    to
                    <strong>{{ $users->lastItem() }}</strong>
                    of
                    <strong>{{ $users->total() }}</strong>
                    users
                </div>

                <div>
                    {{ $users->links() }}
                </div>

            </div>

        @endif

    </div>

</div>

@endsection