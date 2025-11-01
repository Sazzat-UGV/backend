@extends('backend.layouts.app')
@section('title')
    Create Volunteer
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
        'parent_page' => 'Volunteers',
        'page_name' => 'Add New Volunteer',
    ])
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('browse-volunteer')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="">
                                    <a href="{{ route('admin.volunteer.index') }}"
                                        class="btn btn-secondary btn-rounded waves-effect waves-light addContact-modal mb-2">
                                        <i class="mdi mdi-arrow-left me-1"></i> Back to Volunteers
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <form action="{{ route('admin.volunteer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Name<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('name')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter name" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Title<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('title')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter title" name="title" value="{{ old('title') }}">
                                @error('title')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3 mb-4">
                                <label class="form-label">Facebook</label>
                                <input
                                    class="form-control @error('facebook')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter facebook link" name="facebook"
                                    value="{{ old('facebook') }}">
                                @error('facebook')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3 mb-4">
                                <label class="form-label">Twitter</label>
                                <input
                                    class="form-control @error('twitter')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter twitter link" name="twitter"
                                    value="{{ old('twitter') }}">
                                @error('twitter')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3 mb-4">
                                <label class="form-label">Instagram</label>
                                <input
                                    class="form-control @error('instagram')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter instagram link" name="instagram"
                                    value="{{ old('instagram') }}">
                                @error('instagram')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3 mb-4">
                                <label class="form-label">Linkedin</label>
                                <input
                                    class="form-control @error('linkedin')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter linkedin link" name="linkedin"
                                    value="{{ old('linkedin') }}">
                                @error('linkedin')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Photo<span class="text-danger">*</span></label>
                                <input
                                    class="form-control dropify @error('photo')
                                    is-invalid
                                @enderror"
                                    type="file" name="photo">
                                @error('photo')
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
