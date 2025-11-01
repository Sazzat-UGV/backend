@extends('backend.layouts.app')
@section('title')
    Permissions
@endsection
@push('style')
@endpush
@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Permissions',
        'page_name' => 'Permission List',
    ])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-permission')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#newPermissionModal"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New Permission</button>
                                </div>
                            </div>
                        </div>
                    @endcan

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Module Name</th>
                                <th>Permission Name</th>
                                <th>Permission Slug</th>
                                @if (Auth::user()->role->id == 1)
                                    <th>Status</th>
                                @endif
                                @if (Auth::user()->haspermission('edit-permission') || Auth::user()->haspermission('delete-permission'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $index => $permission)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $permission->module->name }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->slug }}</td>
                                    @if (Auth::user()->role->id == 1)
                                        <td>
                                            @if ($permission->status == 1)
                                                <span class="badge rounded-pill badge-soft-success px-2"
                                                    style="font-size: 13px">Active</span>
                                            @else
                                                <span class="badge rounded-pill badge-soft-danger px-2"
                                                    style="font-size: 13px">Inactive</span>
                                            @endif
                                        </td>
                                    @endif
                                    @if (Auth::user()->haspermission('edit-permission') || Auth::user()->haspermission('delete-permission'))
                                        <td>
                                            @can('edit-permission')
                                                <button type="button"
                                                    class="btn btn-warning position-relative p-0 avatar-xs rounded editModule-btn"
                                                    data-bs-toggle="modal" data-bs-target="#editPermissionModal"
                                                    data-id="{{ $permission->id }}" data-name="{{ $permission->name }}"
                                                    data-module-id="{{ $permission->module_id }}"
                                                    data-status="{{ $permission->status }}">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-edit" style="font-size: 16px"></i>
                                                    </span>
                                                </button>
                                            @endcan
                                            @can('delete-permission')
                                                <form action="{{ route('admin.permission.destroy', $permission->id) }}"
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add permission Modal -->
    <div class="modal fade" id="newPermissionModal" tabindex="-1" aria-labelledby="newPermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newPermissionModalLabel">Add Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="permissionAddForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Module Name<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select" name="module_id">
                                        <option value="">Select Module</option>
                                        @foreach ($modules as $module)
                                            <option value="{{ $module->id }}">{{ $module->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" style="font-size: 11px"><strong
                                            class="error-module_id"></strong></span> <!-- Error for module -->
                                </div>
                                <div class="mb-3">
                                    <label for="permission_name" class="form-label">Permission Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="permission_name" class="form-control" name="permission_name"
                                        placeholder="Enter name" />
                                    <span class="text-danger" style="font-size: 11px"><strong
                                            class="error-permission_name"></strong></span>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="button" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" id="addPermission-btn" class="btn btn-success">Add
                                        Permisssion</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Permission Modal -->
    <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPermissionModalLabel">Edit Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="permissionEditForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="module_id" class="form-label">Module Name<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select" name="module_id" id="edit_module_id">
                                        <option value="">Select Module</option>
                                        @foreach ($modules as $module)
                                            <option value="{{ $module->id }}">{{ $module->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" style="font-size: 11px"><strong
                                            class="error-edit-module_id"></strong></span>
                                </div>
                                <div class="mb-3">
                                    <label for="permission_name" class="form-label">Permission Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="edit_permission_name" class="form-control"
                                        name="permission_name" placeholder="Enter name" />
                                    <span class="text-danger" style="font-size: 11px"><strong
                                            class="error-edit-permission_name"></strong></span>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="button" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" id="editPermission-btn" class="btn btn-success">Update
                                        Permission</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();

            // Add permission modal submission
            $(document).on('submit', '#permissionAddForm', function(e) {
                e.preventDefault();

                $('.error-permission_name').text('');
                $('.error-module_id').text('');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.permission.store') }}',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#newPermissionModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.permission_name) {
                                $('.error-permission_name').text(errors.permission_name[0]);
                            }
                            if (errors.module_id) {
                                $('.error-module_id').text(errors.module_id[0]);
                            }
                        }
                    }
                });
            });

            // Edit button click event
            $(document).on('click', '.editModule-btn', function() {
                var permissionId = $(this).data('id');
                var permissionName = $(this).data('name');
                var permissionStatus = $(this).data('status');
                var moduleId = $(this).data('module-id');
                $('#edit_permission_name').val(permissionName);
                $('#edit_module_id').val(moduleId);
                $('#editPermissionModal select[name="status"]').val(permissionStatus);
                $('#permissionEditForm').attr('action', '/admin/permissions/' + permissionId);
            });

            // Edit permission form submission
            $(document).on('submit', '#permissionEditForm', function(e) {
                e.preventDefault();

                var permissionId = $('#permissionEditForm').attr('action').split('/').pop();
                $('.error-edit-permission_name').text('');
                $('.error-edit-module_id').text('');

                $.ajax({
                    type: 'PUT',
                    url: '{{ route('admin.permission.update', '') }}' + '/' + permissionId,
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#editPermissionModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.permission_name) {
                                $('.error-edit-permission_name').text(errors.permission_name[
                                    0]);
                            }
                            if (errors.module_id) {
                                $('.error-edit-module_id').text(errors.module_id[0]);
                            }
                        }
                    }
                });
            });

            // Delete permission confirmation with SweetAlert
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
        });
    </script>
@endpush
