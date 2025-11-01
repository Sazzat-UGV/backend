@extends('backend.layouts.app')
@section('title')
    Edit User
@endsection
@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"
        integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 20px;
        }
    </style>
@endpush
@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Users',
        'page_name' => 'Edit User',
    ])
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('browse-user')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="">
                                    <a href="{{ route('admin.user.index') }}"
                                        class="btn btn-secondary btn-rounded waves-effect waves-light addContact-modal mb-2">
                                        <i class="mdi mdi-arrow-left me-1"></i> Back to Users
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 col-md-5 mb-4">
                                <label class="form-label">First Name<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('first_name')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter first name" name="first_name"
                                    value="{{ old('first_name', $user->first_name) }}">
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-5 mb-4">
                                <label class="form-label">Last Name<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('last_name')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter last name" name="last_name"
                                    value="{{ old('last_name', $user->last_name) }}">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-2 mb-4">
                                <label for="role_id" class="form-label">Role<span class="text-danger">*</span></label>
                                <select
                                    class="form-select @error('role_id')
                                            is-invalid
                                        @enderror"
                                    name="role_id">
                                    <option>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            @if ($role->id == $user->role_id) selected
                                            @elseif (old('role_id') == $role->id)
                                            selected @endif>
                                            {{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Email<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('email')
                                            is-invalid
                                        @enderror"
                                    type="email" placeholder="Enter email" name="email"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Password</label>
                                <input
                                    class="form-control @error('password')
                                            is-invalid
                                        @enderror"
                                    type="password" placeholder="Enter password" name="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Address<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('address')
                                            is-invalid
                                        @enderror"
                                    type="text" name="address" value="{{ old('address', $user->address) }}"
                                    placeholder="Enter address">
                                @error('address')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3 mb-4">
                                <label class="form-label">Phone<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('phone')
                                            is-invalid
                                        @enderror"
                                    type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                    placeholder="Enter phone">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3 mb-4">
                                <label class="form-label">Status</label>
                                <select
                                    class="form-select @error('status')
                                        is-invalid
                                    @enderror"
                                    name="status">
                                    <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3 mb-4">
                                <label class="form-label">Date of Birth</label>
                                <input
                                    class="form-control @error('date_of_birth')
                                            is-invalid
                                        @enderror"
                                    type="date" name="date_of_birth"
                                    value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3 mb-4">
                                <label class="form-label">Postal Code</label>
                                <input
                                    class="form-control @error('postal_code')
                                            is-invalid
                                        @enderror"
                                    type="text" name="postal_code"
                                    value="{{ old('postal_code', $user->postal_code) }}" placeholder="Enter postal code">
                                @error('postal_code')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3 mb-4">
                                <label class="form-label">Country</label>
                                <input
                                    class="form-control @error('country')
                                            is-invalid
                                        @enderror"
                                    type="text" name="country" value="{{ old('country', $user->country) }}"
                                    placeholder="Enter country">
                                @error('country')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3 mb-4">
                                <label class="form-label">City</label>
                                <input
                                    class="form-control @error('city')
                                            is-invalid
                                        @enderror"
                                    type="text" name="city" value="{{ old('city', $user->city) }}"
                                    placeholder="Enter city">
                                @error('city')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Bio</label>
                                <textarea name="bio" id="" cols="30" rows="9"
                                    class="form-control @error('bio')
                                            is-invalid
                                        @enderror"
                                    placeholder="Enter bio">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Profile Photo</label>
                                <input
                                    class="form-control dropify @error('profile_photo')
                                    is-invalid
                                @enderror"
                                    type="file" name="profile_photo"
                                    data-default-file="{{ asset('uploads/profile_photo') }}/{{ $user->profile_photo }}">
                                @error('profile_photo')
                                    <span class="text-danger" style="font-size: 11px"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-success rounded-pill px-4" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.dropify').dropify();
    </script>
@endpush
