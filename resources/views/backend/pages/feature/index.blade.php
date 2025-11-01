@extends('backend.layouts.app')
@section('title')
    Features
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
        'parent_page' => 'Features',
        'page_name' => 'Feature List',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-feature')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.feature.create') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New Feature</a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <table id="datatabl" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Created At</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Text</th>
                                <th>Status</th>
                                @if (Auth::user()->haspermission('edit-feature') || Auth::user()->haspermission('delete-feature'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($features as $index => $feature)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $feature->created_at->format('d-m-Y') }}</td>
                                    <td><img src="{{ asset('uploads/feature') }}/{{ $feature->icon }}" alt="User Photo"
                                            class="rounded img-fluid max-width: 100%;" style="height:auto"></td>
                                    <td class="wrap">{{ $feature->title }}</td>
                                    <td class="wrap">{{ $feature->text }}</td>
                                    <td>
                                        @if ($feature->status == 1)
                                    <span class="badge rounded-pill badge-soft-success px-2"
                                        style="font-size: 13px">Active</span>
                                @else
                                    <span class="badge rounded-pill badge-soft-danger px-2"
                                        style="font-size: 13px">Inactive</span>
                                @endif
                                    </td>
                                    @if (Auth::user()->haspermission('edit-feature') || Auth::user()->haspermission('delete-feature'))
                                        <td class="d-flex gap-1">
                                            @can('edit-feature')
                                                <a href="{{ route('admin.feature.edit', $feature->id) }}"
                                                    class="btn btn-warning position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-edit" style="font-size: 16px"></i>
                                                    </span>
                                                </a>
                                            @endcan
                                            @can('delete-feature')
                                                <form action="{{ route('admin.feature.destroy', $feature->id) }}" method="POST"
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
                    {{ $features->links('vendor.pagination.admin_dashboard') }}
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
