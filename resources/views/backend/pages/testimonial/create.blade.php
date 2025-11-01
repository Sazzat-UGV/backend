@extends('backend.layouts.app')
@section('title')
    Create Testimonial
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
        'parent_page' => 'Testimonials',
        'page_name' => 'Add New Testimonial',
    ])
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('browse-testimonial')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="">
                                    <a href="{{ route('admin.testimonial.index') }}"
                                        class="btn btn-secondary btn-rounded waves-effect waves-light addContact-modal mb-2">
                                        <i class="mdi mdi-arrow-left me-1"></i> Back to Testimonials
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <form action="{{ route('admin.testimonial.store') }}" method="POST" enctype="multipart/form-data">
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
                                <label class="form-label">Designation<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('designation')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter designation" name="designation"
                                    value="{{ old('designation') }}">
                                @error('designation')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Comment<span class="text-danger">*</span></label>
                                <textarea name="comment" id="" cols="30" rows="5"
                                    class="form-control @error('comment')
                                is-invalid
                                @enderror"
                                    placeholder="Enter comment">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Rating<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('rating')
                                            is-invalid
                                        @enderror"
                                    type="number" placeholder="Enter rating" name="rating" value="{{ old('rating') }}">
                                @error('rating')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status">
                                    <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>

                                @error('status')
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
