@extends('backend.layouts.app')
@section('title')
    Volunteers
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
        'parent_page' => 'Volunteers',
        'page_name' => 'Volunteer List',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-volunteer')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.volunteer.create') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New Volunteer</a>
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
                                <th>Title</th>
                                <th>Social Media</th>
                                @if (Auth::user()->haspermission('edit-volunteer') || Auth::user()->haspermission('delete-volunteer'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($volunteers as $index => $volunteer)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td><img src="{{ asset('uploads/volunteer') }}/{{ $volunteer->photo }}" alt="User Photo"
                                            class="rounded img-fluid;" style="max-width: 100px">
                                    </td>
                                    <td class="">{{ $volunteer->name }}</td>
                                    <td class="wrap">{{ $volunteer->title }}</td>
                                    <td class="wrap">
                                        @if ($volunteer->facebook)
                                            <a href="{{ $volunteer->facebook }}"> <i class="mdi mdi-facebook"
                                                    style="font-size: 30px"></i></a>
                                        @endif
                                        @if ($volunteer->twitter)
                                            <a href="{{ $volunteer->twitter }}"> <i class="mdi mdi-twitter"
                                                    style="font-size: 30px"></i></a>
                                        @endif
                                        @if ($volunteer->instagram)
                                            <a href="{{ $volunteer->instagram }}"> <i class="mdi mdi-instagram"
                                                    style="font-size: 30px"></i></a>
                                        @endif
                                        @if ($volunteer->linkedin)
                                            <a href="{{ $volunteer->linkedin }}"> <i class="mdi mdi-linkedin"
                                                    style="font-size: 30px"></i></a>
                                        @endif
                                    </td>

                                    @if (Auth::user()->haspermission('edit-volunteer') || Auth::user()->haspermission('delete-volunteer'))
                                        <td class="d-flex gap-1">
                                            @can('edit-volunteer')
                                                <a href="{{ route('admin.volunteer.edit', $volunteer->id) }}"
                                                    class="btn btn-warning position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-edit" style="font-size: 16px"></i>
                                                    </span>
                                                </a>
                                            @endcan
                                            @can('delete-volunteer')
                                                <form action="{{ route('admin.volunteer.destroy', $volunteer->id) }}"
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
                    {{ $volunteers->links('vendor.pagination.admin_dashboard') }}
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
