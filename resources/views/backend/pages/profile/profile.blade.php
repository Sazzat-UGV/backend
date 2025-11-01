@extends('backend.layouts.app')
@section('title')
    Profile
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
        'parent_page' => 'My Profile',
        'page_name' => 'Profile',
    ])
    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary-subtle">
                    <div class="row">
                        <div class="col-12">
                            <img src="{{ asset('uploads/cover_photo') }}/{{ Auth::user()->cover_photo }}" alt="Cover Photo"
                                class="img-fluid w-100" style="height: 100px; object-fit: cover;">
                        </div>
                    </div>

                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4" style="width: 100px; height: 100px;">
                                <img src="{{ asset('uploads/profile_photo') }}/{{ Auth::user()->profile_photo }}"
                                    alt="Profile Photo" class="img-thumbnail rounded-circle"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4">

                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="font-size-17">{{ Auth::user()->first_name }}
                                            {{ Auth::user()->last_name ?? '' }}</h5>
                                        <p class="text-muted mb-0">{{ Auth::user()->role->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Personal Information</h4>

                    <p class="text-muted mb-4">{{ Auth::user()->bio ?? '' }}</p>
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Full Name :</th>
                                    <td>{{ Auth::user()->first_name }} {{ Auth::user()->last_name ?? '' }}</td>
                                </tr>
                                @if (Auth::user()->phone)
                                    <tr>
                                        <th scope="row">Mobile :</th>
                                        <td>{{ Auth::user()->phone }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th scope="row">E-mail :</th>
                                    <td>{{ Auth::user()->email }}</td>
                                </tr>
                                @if (Auth::user()->date_of_birth)
                                    <tr>
                                        <th scope="row">Date of Birth :</th>
                                        <td>{{ Auth::user()->date_of_birth }}</td>
                                    </tr>
                                @endif
                                @if (Auth::user()->postal_code)
                                    <tr>
                                        <th scope="row">Postal Code :</th>
                                        <td>{{ Auth::user()->postal_code }}</td>
                                    </tr>
                                @endif
                                @if (Auth::user()->city)
                                    <tr>
                                        <th scope="row">City :</th>
                                        <td>{{ Auth::user()->city }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit Profile</h4>
                    <form action="{{ route('admin.edit_profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-6 mb-4">
                                <label class="form-label">First Name<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('first_name')
                                                is-invalid
                                            @enderror"
                                    type="text" placeholder="First Name" name="first_name"
                                    value="{{ old('first_name', Auth::user()->first_name) }}">
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6 mb-4">
                                <label class="form-label">Last Name<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('last_name')
                                                is-invalid
                                            @enderror"
                                    type="text" placeholder="Last Name" name="last_name"
                                    value="{{ old('last_name', Auth::user()->last_name) }}">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Email<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('email')
                                                is-invalid
                                            @enderror"
                                    type="email" placeholder="Email" name="email"
                                    value="{{ old('email', Auth::user()->email) }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-8 mb-4">
                                <label class="form-label">Address<span class="text-danger">*</span></label>
                                <textarea
                                    class="form-control @error('address')
                                                is-invalid
                                            @enderror"
                                    cols="30" rows="2" name="address" placeholder="Address">{{ old('address', Auth::user()->address) }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Phone<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('phone')
                                                is-invalid
                                            @enderror"
                                    type="text" placeholder="Phone" name="phone"
                                    value="{{ old('phone', Auth::user()->phone) }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Date of Birth</label>
                                <input
                                    class="form-control @error('date_of_birth')
                                    is-invalid
                                @enderror"
                                    type="date" placeholder="Date of Birth" name="date_of_birth"
                                    value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}">
                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Postal Code</label>
                                <input
                                    class="form-control @error('postal_code')
                                    is-invalid
                                @enderror"
                                    type="text" placeholder="Postal Code" name="postal_code"
                                    value="{{ old('postal_code', Auth::user()->postal_code) }}">
                                @error('postal_code')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Role <span style="font-size: 12px" class="text-warning">(You
                                        can't
                                        change
                                        role)</strong></label>
                                <input class="form-control" type="text" placeholder="Role"
                                    value="{{ Auth::user()->role->name }}" disabled>
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Country</label>
                                <input
                                    class="form-control @error('country')
                                    is-invalid
                                @enderror"
                                    type="text" placeholder="Country" name="country"
                                    value="{{ old('country', Auth::user()->country) }}">
                                @error('country')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">City</label>
                                <input
                                    class="form-control @error('city')
                                    is-invalid
                                @enderror"
                                    type="text" placeholder="City" name="city"
                                    value="{{ old('city', Auth::user()->city) }}">
                                @error('city')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Bio</label>
                                <textarea
                                    class="form-control @error('bio')
                                                is-invalid
                                            @enderror"
                                    cols="30" rows="4" name="bio" placeholder="Bio">{{ old('bio', Auth::user()->bio) }}</textarea>
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
                                    data-default-file="{{ asset('uploads/profile_photo') }}/{{ Auth::user()->profile_photo }}">
                                @error('profile_photo')
                                    <span class="text-danger" style="font-size: 11px"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Cover Photo</label>
                                <input
                                    class="form-control dropify @error('cover_photo')
                                    is-invalid
                                @enderror"
                                    type="file"
                                    data-default-file="{{ asset('uploads/cover_photo') }}/{{ Auth::user()->cover_photo }}"
                                    name="cover_photo">
                                @error('cover_photo')
                                    <span class="text-danger" style="font-size: 11px"
                                        role="alert"><strong>{{ $message }}</strong></span>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.dropify').dropify();
    </script>
@endpush
