@extends('backend.layouts.app')
@section('title')
    Galleries
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
        'parent_page' => 'Galleries',
        'page_name' => 'Gallery List',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-gallery')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.gallery.create') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New Gallery</a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <table id="datatabl" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Created At</th>
                                <th>Photo</th>
                                <th>Title</th>
                                @if (Auth::user()->haspermission('edit-gallery') || Auth::user()->haspermission('delete-gallery'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($galleries as $index => $gallery)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $gallery->created_at->format('d-m-Y') }}</td>
                                    <td><img src="{{ asset('uploads/gallery') }}/{{ $gallery->photo }}" alt="Photo"
                                            class="rounded" style="max-width: 150px;max-height:150px"></td>
                                    <td class="wrap">{{ $gallery->title }}</td>
                                    @if (Auth::user()->haspermission('edit-gallery') || Auth::user()->haspermission('delete-gallery'))
                                        <td class="d-flex gap-1">
                                                @can('edit-gallery')
                                                    <a href="{{ route('admin.gallery.edit', $gallery->id) }}"
                                                        class="btn btn-warning position-relative p-0 avatar-xs rounded editModule-btn">
                                                        <span class="avatar-title bg-transparent">
                                                            <i class="bx bx-edit" style="font-size: 16px"></i>
                                                        </span>
                                                    </a>
                                                @endcan
                                            @can('delete-gallery')
                                                <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST"
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
                    {{ $galleries->links('vendor.pagination.admin_dashboard') }}
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
