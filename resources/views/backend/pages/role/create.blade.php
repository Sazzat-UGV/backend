@extends('backend.layouts.app')
@section('title')
    Create Role
@endsection
@push('style')
@endpush
@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Roles',
        'page_name' => 'Add New Role',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('browse-role')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="">
                                    <a href="{{ route('admin.role.index') }}"
                                        class="btn btn-secondary btn-rounded waves-effect waves-light addContact-modal mb-2">
                                        <i class="mdi mdi-arrow-left me-1"></i> Back to Roles
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <form action="{{ route('admin.role.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 {{ Auth::user()->role->id == 1 ? 'col-md-5':'col-md-6' }} mb-4">
                                <label class="form-label">Role Name<span class="text-danger">*</span></label>
                                <input class="form-control @error('role_name') is-invalid @enderror" type="text"
                                    placeholder="Enter name" name="role_name"
                                    value="{{ old('role_name', $role->name ?? '') }}">
                                @error('role_name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 {{ Auth::user()->role->id == 1 ? 'col-md-5':'col-md-6' }} mb-4">
                                <label class="form-label">Role Note</label>
                                <input class="form-control @error('role_note') is-invalid @enderror" type="text"
                                    placeholder="Enter note" name="role_note"
                                    value="{{ old('role_note', $role->note ?? '') }}">
                                @error('role_note')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            @if (Auth::user()->role->id == 1)
                                <div class="col-12 col-md-2 mb-4">
                                    <label for="status" class="form-label">Status <strong class="text-warning"
                                            style="font-size: 11px">(Default Active)</strong></label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status">
                                        <option value="1"
                                            {{ old('status', $role->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0"
                                            {{ old('status', $role->status ?? 1) == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="mt-4 mb-2">
                                    <strong class="@error('permissions') is-invalid @enderror">
                                        Manage Permissions for Role<span class="text-danger">*</span>
                                    </strong>
                                    @error('permissions')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="select-all-global">
                                    <label class="form-check-label" for="select-all-global">Select All Permissions</label>
                                </div>

                                <div class="mt-5">
                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
                                        @foreach ($modules as $module)
                                            <div class="col mb-4">
                                                <h5 class="text-warning" style="font-weight: 600">Module:
                                                    {{ $module->name }}</h5>
                                                <!-- Individual Select All for Module -->
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input select-all-module" type="checkbox"
                                                        id="select-all-{{ $module->id }}">
                                                    <label class="form-check-label "
                                                        style="font-size: 13px; font-weight: 800"
                                                        for="select-all-{{ $module->id }}">
                                                        Select All
                                                    </label>
                                                </div>

                                                @foreach ($module->permissions as $permission)
                                                    <div class="form-check mb-3">
                                                        <input
                                                            class="form-check-input permission-checkbox permission-checkbox-{{ $module->id }}"
                                                            type="checkbox" id="permission-{{ $permission->id }}"
                                                            name="permissions[]" value="{{ $permission->id }}"
                                                            {{ in_array($permission->id, old('permissions', $role_permissions ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="permission-{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success rounded-pill px-4">Save</button>
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
            $('#select-all-global').on('click', function() {
                var isChecked = $(this).is(':checked');
                $('.permission-checkbox').each(function() {
                    this.checked = isChecked;
                });

                $('.select-all-module').each(function() {
                    this.checked = isChecked;
                });
            });

            $('.select-all-module').on('click', function() {
                var moduleId = $(this).attr('id').split('-')[2];
                var isChecked = $(this).is(':checked');

                $('.permission-checkbox-' + moduleId).each(function() {
                    this.checked = isChecked;
                });

                checkGlobalSelectAll();
            });

            $('.permission-checkbox').on('change', function() {
                checkGlobalSelectAll();
            });

            function checkGlobalSelectAll() {
                var allChecked = $('.permission-checkbox').length === $('.permission-checkbox:checked').length;
                $('#select-all-global').prop('checked', allChecked);
            }
        });
    </script>
@endpush
