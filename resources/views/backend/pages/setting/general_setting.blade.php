@extends('backend.layouts.app')
@section('title')
    General Setting
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
    <link rel="stylesheet" href="https://unpkg.com/@yaireo/tagify/dist/tagify.css">
    <script src="https://unpkg.com/@yaireo/tagify"></script>
@endpush

@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Settings',
        'page_name' => 'General Setting',
    ])

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link mb-2  {{ request('stage') == 'site' ? ' active' : '' }}"
                                    id="site_information-tab" data-bs-toggle="pill" href="#site_information" role="tab"
                                    aria-controls="site_information" aria-selected="true">Site Information</a>
                                <a class="nav-link mb-2  {{ request('stage') == 'contact' ? ' active' : '' }}"
                                    id="contact_information-tab" data-bs-toggle="pill" href="#contact_information"
                                    role="tab" aria-controls="contact_information" aria-selected="false">Contact
                                    Information</a>
                                <a class="nav-link mb-2 {{ request('stage') == 'breadcrumb' ? 'active' : '' }}"
                                    id="breadcrumb-tab" data-bs-toggle="pill" href="#breadcrumb" role="tab"
                                    aria-controls="breadcrumb" aria-selected="false">Breadcrumb Image</a>
                                <a class="nav-link mb-2 {{ request('stage') == 'social' ? 'active' : '' }}"
                                    id="social_media-tab" data-bs-toggle="pill" href="#social_media" role="tab"
                                    aria-controls="social_media" aria-selected="false">Social Media Links</a>
                                <a class="nav-link mb-2 {{ request('stage') == 'map' ? 'active' : '' }}" id="map-tab"
                                    data-bs-toggle="pill" href="#map" role="tab" aria-controls="map"
                                    aria-selected="false">Map</a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                <div class="tab-pane fade  {{ request('stage') == 'site' ? 'show active' : '' }}"
                                    id="site_information" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <form action="{{ route('admin.general_setting_submit') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                <label class="form-label">Site Name</label>
                                                <input
                                                    class="form-control @error('site_name')
                                                     is-invalid
                                                @enderror"
                                                    type="text" placeholder="Enter site name" name="site_name"
                                                    value="{{ old('site_name', $setting->site_name) }}">
                                                @error('site_name')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 mb-4">
                                                <label class="form-label">Site Logo</label>
                                                <input
                                                    class="form-control dropify @error('site_logo')
                                                    is-invalid
                                                @enderror"
                                                    type="file"
                                                    data-default-file="{{ asset('uploads/settings') }}/{{ $setting->site_logo }}"
                                                    name="site_logo">
                                                @error('site_logo')
                                                    <span class="text-danger" style="font-size: 11px"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 mb-4">
                                                <label class="form-label">Site Favicon<span class="text-warning"
                                                        style="font-size: 10px">(Only support ".ico" file.)</span></label>
                                                <input
                                                    class="form-control dropify @error('site_favicon')
                                                is-invalid
                                                @enderror"
                                                    type="file"
                                                    data-default-file="{{ asset('uploads/settings') }}/{{ $setting->site_favicon }}"
                                                    name="site_favicon">
                                                @error('site_favicon')
                                                    <span class="text-danger" style="font-size: 11px"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>

                                            <div class="col-12  mb-4">
                                                <label class="form-label">Site Description</label>
                                                <textarea name="site_description"
                                                    class="form-control @error('site_description')
                                                     is-invalid
                                                @enderror"
                                                    cols="30" rows="4">{{ old('site_description', $setting->site_description) }}</textarea>
                                                @error('site_description')
                                                    <span class="text-danger" style="font-size: 11px"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="col-12 mb-4">
                                                <label class="form-label">Site Keywords</label>
                                                <input type="text" id="siteKeywords" name="site_keywords"
                                                    value="{{ old('site_keywords', $setting->site_keywords) }}"
                                                    class="form-control">
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-success rounded-pill px-4"
                                                    type="submit">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade  {{ request('stage') == 'contact' ? 'show active' : '' }}"
                                    id="contact_information" role="tabpanel" aria-labelledby="contact_information-tab">
                                    <form action="{{ route('admin.general_setting_submit') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                <label class="form-label">Email</label>
                                                <input
                                                    class="form-control @error('email')
                                                     is-invalid
                                                @enderror"
                                                    type="email" placeholder="Enter email" name="email"
                                                    value="{{ old('email', $setting->email) }}">
                                                @error('email')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="col-12  mb-4">
                                                <label class="form-label">Phone Number</label>
                                                <input
                                                    class="form-control @error('phone_number')
                                                     is-invalid
                                                @enderror"
                                                    type="text" placeholder="Enter phone number" name="phone_number"
                                                    value="{{ old('phone_number', $setting->phone_number) }}">
                                                @error('phone_number')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="col-12  mb-4">
                                                <label class="form-label">Physical Address</label>
                                                <textarea name="physical_address"
                                                    class="form-control @error('physical_address')
                                                     is-invalid
                                                @enderror"
                                                    cols="30" rows="3" placeholder="Enter physical address">{{ old('physical_address', $setting->physical_address) }}</textarea>
                                                @error('physical_address')
                                                    <span class="text-danger" style="font-size: 11px"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>

                                            <div class="col-12">
                                                <button class="btn btn-success rounded-pill px-4"
                                                    type="submit">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade {{ request('stage') == 'breadcrumb' ? 'show active' : '' }}"
                                    id="breadcrumb" role="tabpanel" aria-labelledby="breadcrumb-tab">
                                    <form action="{{ route('admin.general_setting_submit') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12  mb-4">
                                                <label class="form-label">Image</label>
                                                <input
                                                    class="form-control dropify @error('breadcrumb_image')
                                                    is-invalid
                                                @enderror"
                                                    type="file"
                                                    data-default-file="{{ asset('uploads/settings') }}/{{ $setting->breadcrumb_image }}"
                                                    name="breadcrumb_image">
                                                @error('breadcrumb_image')
                                                    <span class="text-danger" style="font-size: 11px"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>

                                            <div class="col-12">
                                                <button class="btn btn-success rounded-pill px-4"
                                                    type="submit">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade {{ request('stage') == 'social' ? 'show active' : '' }}"
                                    id="social_media" role="tabpanel" aria-labelledby="social_media-tab">
                                    <form action="{{ route('admin.general_setting_submit') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12  mb-4">
                                                <label class="form-label">Facebook URL</label>
                                                <input
                                                    class="form-control @error('facebook_url')
                                                     is-invalid
                                                @enderror"
                                                    type="text" placeholder="Enter facebook url" name="facebook_url"
                                                    value="{{ old('facebook_url', $setting->facebook_url) }}">
                                                @error('facebook_url')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="col-12  mb-4">
                                                <label class="form-label">Twitter URL</label>
                                                <input
                                                    class="form-control @error('twitter_url')
                                                     is-invalid
                                                @enderror"
                                                    type="text" placeholder="Enter twitter url" name="twitter_url"
                                                    value="{{ old('twitter_url', $setting->twitter_url) }}">
                                                @error('twitter_url')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="col-12  mb-4">
                                                <label class="form-label">Instagram URL</label>
                                                <input
                                                    class="form-control @error('instagram_url')
                                                     is-invalid
                                                @enderror"
                                                    type="text" placeholder="Enter instagram url" name="instagram_url"
                                                    value="{{ old('instagram_url', $setting->instagram_url) }}">
                                                @error('instagram_url')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="col-12  mb-4">
                                                <label class="form-label">YouTube URL</label>
                                                <input
                                                    class="form-control @error('youtube_url')
                                                     is-invalid
                                                @enderror"
                                                    type="text" placeholder="Enter youtube url" name="youtube_url"
                                                    value="{{ old('youtube_url', $setting->youtube_url) }}">
                                                @error('youtube_url')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="col-12  mb-4">
                                                <label class="form-label">LinkedIn URL</label>
                                                <input
                                                    class="form-control @error('linkedin_url')
                                                     is-invalid
                                                @enderror"
                                                    type="text" placeholder="Enter linkedin url" name="linkedin_url"
                                                    value="{{ old('linkedin_url', $setting->linkedin_url) }}">
                                                @error('linkedin_url')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>

                                            <div class="col-12">
                                                <button class="btn btn-success rounded-pill px-4"
                                                    type="submit">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade {{ request('stage') == 'map' ? 'show active' : '' }}"
                                    id="map" role="tabpanel" aria-labelledby="map-tab">
                                    <form action="{{ route('admin.general_setting_submit') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12  mb-4">
                                                <label class="form-label">Map<span class="text-danger">*</span></label>
                                                <textarea name="map" id="" cols="30" rows="5" placeholder="Enter ifream code"
                                                    class="form-control @error('map')
                                                is-invalid
                                           @enderror">{{ old('map', $setting->map) }}</textarea> @error('map')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-success rounded-pill px-4"
                                                    type="submit">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <script>
        var input = document.querySelector('#siteKeywords');
        var tagify = new Tagify(input);
    </script>
@endpush
