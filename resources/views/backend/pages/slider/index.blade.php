@extends('backend.layouts.app')
@section('title')
    Sliders
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
        'parent_page' => 'Sliders',
        'page_name' => 'Slider List',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-slider')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.slider.create') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New Slider</a>
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
                                <th>Description</th>
                                @if (Auth::user()->haspermission('edit-slider') || Auth::user()->haspermission('delete-slider'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sliders as $index => $slider)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $slider->created_at->format('d-m-Y') }}</td>
                                    <td><img src="{{ asset('uploads/slider') }}/{{ $slider->image }}" alt="User Photo"
                                            class="rounded img-fluid max-width: 100%;" style="height:auto"></td>
                                    <td class="wrap">{{ $slider->title }}</td>
                                    <td class="wrap">{{ $slider->description }}</td>
                                    @if (Auth::user()->haspermission('edit-slider') || Auth::user()->haspermission('delete-slider'))
                                        <td class="d-flex gap-1">
                                                @can('edit-slider')
                                                    <a href="{{ route('admin.slider.edit', $slider->id) }}"
                                                        class="btn btn-warning position-relative p-0 avatar-xs rounded editModule-btn">
                                                        <span class="avatar-title bg-transparent">
                                                            <i class="bx bx-edit" style="font-size: 16px"></i>
                                                        </span>
                                                    </a>
                                                @endcan
                                            @can('delete-slider')
                                                <form action="{{ route('admin.slider.destroy', $slider->id) }}" method="POST"
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
                    {{ $sliders->links('vendor.pagination.admin_dashboard') }}
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
