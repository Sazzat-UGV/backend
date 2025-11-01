@extends('backend.layouts.app')
@section('title')
    Edit Special Section
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
        'parent_page' => '',
        'page_name' => 'Edit Special Section',
    ])
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.updateSpecial') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label">Heading<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('heading')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter heading" name="heading"
                                    value="{{ old('heading', $special->heading) }}">
                                @error('heading')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Sub Heading<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('sub_heading')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter sub heading" name="sub_heading"
                                    value="{{ old('sub_heading', $special->sub_heading) }}">
                                @error('sub_heading')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Text<span class="text-danger">*</span></label>
                                <textarea name="text" id="text" cols="30" rows="5"
                                    class="form-control @error('text')
                                            is-invalid
                                        @enderror"
                                    placeholder="Enter text">{{ old('text', $special->text) }}</textarea>
                                @error('text')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Button Name</label>
                                <input
                                    class="form-control @error('button_name')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter button name" name="button_name"
                                    value="{{ old('button_name', $special->button_name) }}">
                                @error('button_name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Button Link</label>
                                <input
                                    class="form-control @error('button_link')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter button link" name="button_link"
                                    value="{{ old('button_link', $special->button_link) }}">
                                @error('button_link')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Video Button Name</label>
                                <input
                                    class="form-control @error('video_button_name')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter video button name" name="video_button_name"
                                    value="{{ old('video_button_name', $special->video_button_name) }}">
                                @error('video_button_name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Video Id</label>
                                <input
                                    class="form-control @error('video_id')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter video id " name="video_id"
                                    value="{{ old('video_id', $special->video_id) }}">
                                @error('video_id')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Status</label>
                                <select
                                    class="form-select @error('status')
                                        is-invalid
                                    @enderror"
                                    name="status">
                                    <option value="1" {{ old('status', $special->status) == 1 ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ old('status', $special->status) == 0 ? 'selected' : '' }}>
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
                                    type="file" name="photo"
                                    data-default-file="{{ asset('uploads/others') }}/{{ $special->photo }}">
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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#text'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
