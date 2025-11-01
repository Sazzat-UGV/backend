@extends('backend.layouts.app')
@section('title')
    Roles
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
        'parent_page' => 'Roles',
        'page_name' => 'Role List',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-role')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.role.create') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New Role</a>
                                </div>
                            </div>
                        </div>
                    @endcan

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Permissions</th>
                                <th>Note</th>
                                @if (Auth::user()->role->id == 1)
                                <th>Status</th>
                                @endif
                                @if (Auth::user()->haspermission('edit-role') || Auth::user()->haspermission('	delete-role'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $index => $role)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $role->name }}</td>
                                    <td class="wrap">
                                        @foreach ($role->permissions as $permission)
                                            <span class="badge bg-success"
                                                style="font-size: 12px; margin-top: 4px">{{ $permission->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="wrap">
                                        {{ $role->note }}
                                    </td>
                                    @if (Auth::user()->role->id == 1)
                                    <td>
                                        @if ($role->status == 1)
                                            <span class="badge rounded-pill badge-soft-success px-2"
                                                style="font-size: 13px">Active</span>
                                        @else
                                            <span class="badge rounded-pill badge-soft-danger px-2"
                                                style="font-size: 13px">Inactive</span>
                                        @endif
                                    </td>
                                        @endif
                                    @if (Auth::user()->haspermission('edit-role') || Auth::user()->haspermission('delete-role'))
                                        <td>
                                            @can('edit-role')
                                                <a href="{{ route('admin.role.edit', $role->id) }}"
                                                    class="btn btn-warning position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-edit" style="font-size: 16px"></i>
                                                    </span>
                                                </a>
                                            @endcan
                                            @if ($role->is_deletable && Auth::user()->haspermission('delete-role'))
                                                <form action="{{ route('admin.role.destroy', $role->id) }}" method="POST"
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
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
