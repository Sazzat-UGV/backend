@extends('backend.layouts.app')
@section('title')
    Change Password
@endsection
@push('style')
@endpush

@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'My Profile',
        'page_name' => 'Change Password',
    ])
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.change_password') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label">Current Password<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('current_password')
                                                is-invalid
                                            @enderror"
                                    type="password" placeholder="Enter current password" name="current_password">
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">New Password<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('new_password')
                                                is-invalid
                                            @enderror"
                                    type="password" placeholder="Enter new password" name="new_password">
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Retype Password<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('retype_password')
                                                is-invalid
                                            @enderror"
                                    type="password" placeholder="Retype password" name="retype_password">
                                @error('retype_password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-success rounded-pill px-4" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
