@extends('backend.layouts.app')
@section('title')
    Users
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
        'parent_page' => 'Users',
        'page_name' => 'User List',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-user')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.user.create') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New User</a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <form action="{{ route('admin.user.index') }}" method="GET">
                        <div class="row d-flex justify-content-between">
                            <div class="col-auto mb-4">
                                <div class="dropdown mt-4 mt-sm-0">
                                    <a href="#" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="mdi mdi-file-export font-size-14"></i> Export
                                    </a>
                                    <div class="dropdown-menu" style="">
                                        <li><a class="dropdown-item"
                                                href="{{ route('admin.exportPDF', ['search' => request('search')]) }}"><i
                                                    class="mdi mdi-file-pdf-outline font-size-16"></i> Export as PDF</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('admin.exportExcel', ['search' => request('search')]) }}"><i
                                                    class="mdi mdi-file-excel-outline font-size-16"></i> Export as Excel</a>
                                        </li>
                                    </div>
                                </div>

                            </div>
                            <div class="col-auto mb-4 d-flex">
                                <input class="form-control me-2" type="text" placeholder="Search" name="search"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <i class="bx bx-search font-size-16 align-middle"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <table id="datatabl" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Created At</th>
                                <th>Photo</th>
                                <th>Full Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                @if (Auth::user()->haspermission('edit-user') ||
                                        Auth::user()->haspermission('read-user') ||
                                        Auth::user()->haspermission('delete-user'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                    <td><img src="{{ asset('uploads/profile_photo') }}/{{ $user->profile_photo }}"
                                            alt="User Photo" class="rounded-circle avatar-sm"></td>
                                    <td class="wrap">{{ $user->first_name }} {{ $user->last_name ?? '' }}</td>
                                    <td>{{ $user->role->name }}</td>
                                    <td class="wrap">{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td class="wrap">{{ $user->address }}</td>
                                    @if (Auth::user()->haspermission('edit-user') ||
                                            Auth::user()->haspermission('read-user') ||
                                            Auth::user()->haspermission('delete-user'))
                                        <td>
                                            @can('edit-user')
                                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                                    class="btn btn-warning position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-edit" style="font-size: 16px"></i>
                                                    </span>
                                                </a>
                                            @endcan
                                            @can('read-user')
                                                <a href="{{ route('admin.user.show', $user->id) }}"
                                                    class="btn btn-info position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-show" style="font-size: 16px"></i>
                                                    </span>
                                                </a>
                                            @endcan
                                            @can('delete-user')
                                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
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
                    {{ $users->links('vendor.pagination.admin_dashboard') }}
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
