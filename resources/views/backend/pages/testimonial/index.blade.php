@extends('backend.layouts.app')
@section('title')
    Testimonials
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
        'parent_page' => 'Testimonials',
        'page_name' => 'Testimonial List',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-testimonial')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.testimonial.create') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New Testimonial</a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <table id="" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Comment</th>
                                <th>Rating</th>
                                <th>Status</th>
                                @if (Auth::user()->haspermission('edit-testimonial') || Auth::user()->haspermission('delete-testimonial'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($testimonials as $index => $testimonial)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td><img src="{{ asset('uploads/testimonial') }}/{{ $testimonial->photo }}"
                                            alt="User Photo" class="rounded img-fluid;" style="max-width: 100px">
                                    </td>
                                    <td class="">{{ $testimonial->name }}</td>
                                    <td class="wrap">{{ $testimonial->designation }}</td>
                                    <td class="wrap">{{ $testimonial->comment }}</td>
                                    <td>
                                        @for ($i=0;$i<$testimonial->rating;$i++)
                                        <span class="mdi mdi-star text-primary fs-5"></span>
                                        @endfor
                                    </td>
                                    <td>
                                        @if ($testimonial->status == 1)
                                            <span class="badge rounded-pill badge-soft-success px-2"
                                                style="font-size: 13px">Active</span>
                                        @else
                                            <span class="badge rounded-pill badge-soft-danger px-2"
                                                style="font-size: 13px">Inactive</span>
                                        @endif
                                    </td>
                                    @if (Auth::user()->haspermission('edit-testimonial') || Auth::user()->haspermission('delete-testimonial'))
                                        <td class="d-flex gap-1">
                                            @can('edit-testimonial')
                                                <a href="{{ route('admin.testimonial.edit', $testimonial->id) }}"
                                                    class="btn btn-warning position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-edit" style="font-size: 16px"></i>
                                                    </span>
                                                </a>
                                            @endcan
                                            @can('delete-testimonial')
                                                <form action="{{ route('admin.testimonial.destroy', $testimonial->id) }}"
                                                    method="POST"
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
                    {{ $testimonials->links('vendor.pagination.admin_dashboard') }}
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
