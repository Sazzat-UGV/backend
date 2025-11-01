@extends('backend.layouts.app')
@section('title')
    Reply Comments
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
        'page_name' => 'Reply List',
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
                                <th>Reply</th>
                                <th>User Type</th>
                                @if (Auth::user()->haspermission('change-reply-status'))
                                    <th>Status</th>
                                @endif
                                @if (Auth::user()->haspermission('delete-reply'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($replies as $index => $reply)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td class="wrap">{{ $reply->name }}</td>
                                    <td class="wrap">{{ $reply->email }}</td>
                                    <td class="wrap">{{ $reply->comment }}</td>
                                    <td class="wrap">{{ $reply->user_type }}</td>
                                    @if (Auth::user()->haspermission('change-reply-status'))
                                        <td class="">
                                            @if ($reply->status == 'Accept')
                                                <a href="{{ route('admin.replyStatus', $reply->id) }}"
                                                    class="btn btn-success btn-sm rounded-pill px-3"
                                                    style="font-size: 13px;">
                                                    Accept
                                                </a>
                                            @elseif($reply->status == 'Pending')
                                                <a href="{{ route('admin.replyStatus', $reply->id) }}"
                                                    class="btn btn-warning btn-sm rounded-pill px-3"
                                                    style="font-size: 13px;">
                                                    Pending
                                                </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if (Auth::user()->haspermission('delete-reply'))
                                        <td class="d-flex gap-1">

                                            @can('delete-reply')
                                                <form action="{{ route('admin.deleteReply', $reply->id) }}" method="POST"
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
                    {{ $replies->links('vendor.pagination.admin_dashboard') }}
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
