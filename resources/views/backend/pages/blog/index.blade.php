@extends('backend.layouts.app')
@section('title')
    Blogs
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
        'page_name' => 'Blog List',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-blog')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.blog.create') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New Blog</a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <table id="" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Title</th>
                                <th>Short Description</th>
                                @if (Auth::user()->haspermission('edit-blog') ||
                                        Auth::user()->haspermission('show-blog') ||
                                        Auth::user()->haspermission('browse-comment') ||
                                        Auth::user()->haspermission('delete-blog'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($blogs as $index => $blog)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td><img src="{{ asset('uploads/blog') }}/{{ $blog->photo }}" alt="User Photo"
                                            class="rounded img-fluid;" style="max-width: 100px">
                                    </td>
                                    <td class="">{{ $blog->title }}</td>
                                    <td class="wrap">{{ $blog->short_description }}</td>
                                    @if (Auth::user()->haspermission('edit-blog') || Auth::user()->haspermission('delete-blog'))
                                        <td class="d-flex gap-1">
                                            @can('edit-blog')
                                                <a href="{{ route('admin.blog.edit', $blog->id) }}"
                                                    class="btn btn-warning position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-edit" style="font-size: 16px"></i>
                                                    </span>
                                                </a>
                                            @endcan
                                            @can('read-blog')
                                                <a href="{{ route('admin.blog.show', $blog->id) }}"
                                                    class="btn btn-info position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-show" style="font-size: 16px"></i>
                                                    </span>
                                                </a>
                                            @endcan
                                            @can('delete-blog')
                                                <form action="{{ route('admin.blog.destroy', $blog->id) }}" method="POST"
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
                                            @can('browse-comment')
                                                @if ($blog->comments_count > 0)
                                                    <a href="{{ route('admin.browseComment', $blog->id) }}"
                                                        class="btn btn-success position-relative p-0 avatar-xs rounded editModule-btn">
                                                        <i class="bx bx-comment mt-2" style="font-size: 16px"></i>
                                                        <span
                                                            class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger">
                                                            {{ $blog->comments_count < 99 ? $blog->comments_count : '99+' }}
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
                    {{ $blogs->links('vendor.pagination.admin_dashboard') }}
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
