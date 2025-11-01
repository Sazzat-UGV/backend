@extends('backend.layouts.app')
@section('title')
    Modules
@endsection
@push('style')
@endpush
@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Modules',
        'page_name' => 'Module List',
    ])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-module')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#newModuleModal"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New Module</button>
                                </div>
                            </div>
                        </div>
                    @endcan

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Module Name</th>
                                <th>Module Slug</th>
                                <th>Status</th>
                                @if (Auth::user()->haspermission('edit-module') || Auth::user()->haspermission('delete-module'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modules as $index => $module)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $module->name }}</td>
                                    <td>{{ $module->slug }}</td>
                                    <td>
                                        @if ($module->status == 1)
                                            <span class="badge rounded-pill badge-soft-success px-2"
                                                style="font-size: 13px">Active</span>
                                        @else
                                            <span class="badge rounded-pill badge-soft-danger px-2"
                                                style="font-size: 13px">Inactive</span>
                                        @endif
                                    </td>
                                    @if (Auth::user()->haspermission('edit-module') || Auth::user()->haspermission('delete-module'))
                                        <td>
                                            @can('edit-module')
                                                <button type="button"
                                                    class="btn btn-warning position-relative p-0 avatar-xs rounded editModule-btn"
                                                    data-bs-toggle="modal" data-bs-target="#editModuleModal"
                                                    data-id="{{ $module->id }}" data-name="{{ $module->name }}"
                                                    data-status="{{ $module->status }}">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-edit" style="font-size: 16px"></i>
                                                    </span>
                                                </button>
                                            @endcan
                                            @can('delete-module')
                                                <form action="{{ route('admin.module.destroy', $module->id) }}" method="POST"
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

    <!-- Add module Modal -->
    <div class="modal fade" id="newModuleModal" tabindex="-1" aria-labelledby="newModuleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newModuleModalLabel">Add Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="moduleAddForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="module_name" class="form-label">Module Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="module_name" class="form-control" name="module_name"
                                        placeholder="Enter name" />
                                    <span class="text-danger" style="font-size: 11px"><strong
                                            class="error-module_name"></strong></span>
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
                                    <button type="submit" id="addModule-btn" class="btn btn-success">Add Module</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit module Modal -->
    <div class="modal fade" id="editModuleModal" tabindex="-1" aria-labelledby="editModuleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModuleModalLabel">Edit Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="moduleEditForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="module_name" class="form-label">Module Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="module_name" class="form-control" name="module_name"
                                        placeholder="Enter name" />
                                    <span class="text-danger" style="font-size: 11px"><strong
                                            class="error-edit-module_name"></strong></span>
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
                                    <button type="submit" id="editModule-btn" class="btn btn-success">Update
                                        Module</button>
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

            // Add modal submit handler
            $(document).on('submit', '#moduleAddForm', function(e) {
                e.preventDefault();
                $('.error-module_name').text('');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.module.store') }}',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#newModuleModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.module_name) {
                                $('.error-module_name').text(errors.module_name[0]);
                            }
                        }
                    }
                });
            });

            // Edit modal handler
            $(document).on('click', '.editModule-btn', function() {
                var moduleId = $(this).data('id');
                var moduleName = $(this).data('name');
                var moduleStatus = $(this).data('status');

                $('#editModuleModal input[name="module_name"]').val(moduleName);
                $('#editModuleModal select[name="status"]').val(moduleStatus);
                $('#editModuleModal form').attr('action', '/admin/modules/' + moduleId);
            });

            // Edit form submit handler
            $(document).on('submit', '#moduleEditForm', function(e) {
                e.preventDefault();
                $('.error-edit-module_name').text('');

                var moduleId = $('#editModuleModal form').attr('action').split('/').pop();

                $.ajax({
                    type: 'PUT',
                    url: '{{ route('admin.module.update', '') }}' + '/' + moduleId,
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#editModuleModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.module_name) {
                                $('.error-edit-module_name').text(errors.module_name[0]);
                            }
                        }
                    }
                });
            });

            // Delete confirmation handler
            $(document).on('click', '.show_confirm', function(event) {
                let form = $(this).closest('form');
                event.preventDefault();

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
