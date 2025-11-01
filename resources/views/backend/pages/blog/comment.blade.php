@extends('backend.layouts.app')
@section('title')
    Blog Comments
@endsection
@push('style')
    <style>
        .wrap {
            white-space: normal !important;
            word-wrap: break-word;
        }
    </style>
@endpush
@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Blogs',
        'page_name' => 'Comment List',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Comment</th>
                                @if (Auth::user()->haspermission('change-comment-status'))
                                    <th>Status</th>
                                @endif
                                @if (Auth::user()->haspermission('delete-comment') ||
                                        Auth::user()->haspermission('reply-comment') ||
                                        Auth::user()->haspermission('browse-reply'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($comments as $index => $comment)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td class="wrap">{{ $comment->name }}</td>
                                    <td class="wrap">{{ $comment->email }}</td>
                                    <td class="wrap">{{ $comment->comment }}</td>
                                    @if (Auth::user()->haspermission('change-comment-status'))
                                        <td class="">
                                            @if ($comment->status == 'Accept')
                                                <a href="{{ route('admin.commentStatus', $comment->id) }}"
                                                    class="btn btn-success btn-sm rounded-pill px-3"
                                                    style="font-size: 13px;">
                                                    Accept
                                                </a>
                                            @elseif($comment->status == 'Pending')
                                                <a href="{{ route('admin.commentStatus', $comment->id) }}"
                                                    class="btn btn-warning btn-sm rounded-pill px-3"
                                                    style="font-size: 13px;">
                                                    Pending
                                                </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if (Auth::user()->haspermission('delete-comment') ||
                                            Auth::user()->haspermission('reply-comment') ||
                                            Auth::user()->haspermission('browse-reply'))
                                        <td class="d-flex gap-1">

                                            @can('reply-comment')
                                                <a href="javascript(0)" data-bs-toggle="modal"
                                                    data-bs-target="#reply{{ $comment->id }}"
                                                    class="btn btn-warning position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <i class="bx bx-reply mt-2" style="font-size: 16px"></i>
                                                </a>
                                                <!-- Add permission Modal -->
                                                <div class="modal fade" id="reply{{ $comment->id }}" tabindex="-1"
                                                    aria-labelledby="replyLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="replyLabel">Give a reply</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.replyComment') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="comment_id"
                                                                        value="{{ $comment->id }}">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">

                                                                            <div class="mb-3">
                                                                                <label for="reply"
                                                                                    class="form-label">Reply<span
                                                                                        class="text-danger ">*</span></label>
                                                                                <textarea
                                                                                    class="form-control @error('reply')
                                                                                            is-invalid
                                                                                        @enderror"
                                                                                    name="reply" id="" cols="30" rows="5"></textarea>
                                                                                @error('reply')
                                                                                    <span class="invalid-feedback"
                                                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                                                @enderror
                                                                            </div>

                                                                        </div>

                                                                        <div class="col-lg-12">
                                                                            <div class="text-end">
                                                                                <button type="button"
                                                                                    class="btn btn-outline-secondary"
                                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-success">Submit</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan


                                            @can('delete-comment')
                                                <form action="{{ route('admin.deleteComment', $comment->id) }}" method="POST"
                                                    class="btn btn-danger position-relative p-0 avatar-xs rounded">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger position-relative p-0 avatar-xs rounded show_confirm">
                                                        <span class="avatar-title bg-transparent">
                                                            <i class="bx bx-trash" style="font-size: 16px"></i>
                                                        </span>
                                                    </button>
                                                </form>
                                            @endcan

                                            @can('browse-reply')
                                                @if ($comment->reply_count > 0)
                                                    <a href="{{ route('admin.browseReply', $comment->id) }}"
                                                        class="btn btn-success position-relative p-0 avatar-xs rounded editModule-btn">
                                                        <i class="bx bx-comment mt-2" style="font-size: 16px"></i>
                                                        <span
                                                            class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger">
                                                            {{ $comment->reply_count < 99 ? $comment->reply_count : '99+' }}
                                                        </span>
                                                    </a>
                                                @endif
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No data available in table</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $comments->links('vendor.pagination.admin_dashboard') }}
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection

@push('script')
    <script>
        $(document).on('click', '.show_confirm', function(event) {
            event.preventDefault();
            var form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
