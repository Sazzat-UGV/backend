@extends('backend.layouts.app')
@section('title')
    Blog Categories
@endsection
@push('style')
@endpush
@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Categories',
        'page_name' => 'Blog Category List',
    ])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-blog-category')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#newCategoryModal"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New Category</button>
                                </div>
                            </div>
                        </div>
                    @endcan

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Category Slug</th>
                                <th>Status</th>
                                @if (Auth::user()->haspermission('edit-blog-category') || Auth::user()->haspermission('delete-blog-category'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $index => $category)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        @if ($category->status == 1)
                                            <span class="badge rounded-pill badge-soft-success px-2"
                                                style="font-size: 13px">Active</span>
                                        @else
                                            <span class="badge rounded-pill badge-soft-danger px-2"
                                                style="font-size: 13px">Inactive</span>
                                        @endif
                                    </td>
                                    @if (Auth::user()->haspermission('edit-blog-category') || Auth::user()->haspermission('delete-blog-category'))
                                        <td>
                                            @can('edit-blog-category')
                                                <button type="button"
                                                    class="btn btn-warning position-relative p-0 avatar-xs rounded editCategory-btn"
                                                    data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                                    data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                                    data-status="{{ $category->status }}">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-edit" style="font-size: 16px"></i>
                                                    </span>
                                                </button>
                                            @endcan
                                            @can('delete-blog-category')
                                                <form action="{{ route('admin.category.destroy', $category->id) }}"
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

    <!-- Add module Modal -->
    <div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newCategoryModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoryAddForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Category Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="category_name" class="form-control" name="category_name"
                                        placeholder="Enter name" />
                                    <span class="text-danger" style="font-size: 11px"><strong
                                            class="error_category_name"></strong></span>
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
                                    <button type="submit" id="addModule-btn" class="btn btn-success">Add Category</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit module Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoryEditForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Category Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="category_name" class="form-control" name="category_name"
                                        placeholder="Enter name" />
                                    <span class="text-danger" style="font-size: 11px"><strong
                                            class="error-edit-category_name"></strong></span>
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
                                    <button type="submit" id="editCategory-btn" class="btn btn-success">Update
                                        Category</button>
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
            $(document).on('submit', '#categoryAddForm', function(e) {
                e.preventDefault();
                $('.error_category_name').text('');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.category.store') }}',
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
                            if (errors.category_name) {
                                $('.error_category_name').text(errors.category_name[0]);
                            }
                        }
                    }
                });
            });

            // Edit modal handler
            $(document).on('click', '.editCategory-btn', function() {
                var categoryId = $(this).data('id');
                var categoryName = $(this).data('name');
                var categoryStatus = $(this).data('status');

                $('#editCategoryModal input[name="category_name"]').val(categoryName);
                $('#editCategoryModal select[name="status"]').val(categoryStatus);
                $('#editCategoryModal form').attr('action', '/admin/categories/' + categoryId);
            });

            // Edit form submit handler
            $(document).on('submit', '#categoryEditForm', function(e) {
                e.preventDefault();
                $('.error-edit-category_name').text('');

                var categoryId = $('#editCategoryModal form').attr('action').split('/').pop();

                $.ajax({
                    type: 'PUT',
                    url: '{{ route('admin.category.update', '') }}' + '/' + categoryId,
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#editCategoryModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.category_name) {
                                $('.error-edit-category_name').text(errors.category_name[0]);
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
