@extends('backend.layouts.app')
@section('title')
    Edit Counter
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
        'page_name' => 'Edit Counter',
    ])
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.editCounter') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-8 mb-4">
                                <label class="form-label">Title 1<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('title1')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter title" name="title1"
                                    value="{{ old('title1', $counter->title1) }}">
                                @error('title1')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Number 1<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('number1')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter number" name="number1"
                                    value="{{ old('number1', $counter->number1) }}">
                                @error('number1')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Icon 1<span class="text-danger">*</span></label>
                                <input
                                    class="form-control dropify @error('icon1')
                                    is-invalid
                                @enderror"
                                    type="file" name="icon1"
                                    data-default-file="{{ asset('uploads/counter') }}/{{ $counter->icon1 }}">
                                @error('icon1')
                                    <span class="text-danger" style="font-size: 11px"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-8 mb-4">
                                <label class="form-label">Title 2<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('title2')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter title" name="title2"
                                    value="{{ old('title2', $counter->title2) }}">
                                @error('title2')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Number 2<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('number2')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter number" name="number2"
                                    value="{{ old('number2', $counter->number2) }}">
                                @error('number2')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Icon 2<span class="text-danger">*</span></label>
                                <input
                                    class="form-control dropify @error('icon2')
                                    is-invalid
                                @enderror"
                                    type="file" name="icon2"
                                    data-default-file="{{ asset('uploads/counter') }}/{{ $counter->icon2 }}">
                                @error('icon2')
                                    <span class="text-danger" style="font-size: 11px"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-8 mb-4">
                                <label class="form-label">Title 3<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('title3')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter title" name="title3"
                                    value="{{ old('title3', $counter->title3) }}">
                                @error('title3')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Number 3<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('number3')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter number" name="number3"
                                    value="{{ old('number3', $counter->number3) }}">
                                @error('number3')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Icon 3<span class="text-danger">*</span></label>
                                <input
                                    class="form-control dropify @error('icon3')
                                    is-invalid
                                @enderror"
                                    type="file" name="icon3"
                                    data-default-file="{{ asset('uploads/counter') }}/{{ $counter->icon3 }}">
                                @error('icon3')
                                    <span class="text-danger" style="font-size: 11px"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-8 mb-4">
                                <label class="form-label">Title 4<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('title4')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter title" name="title4"
                                    value="{{ old('title4', $counter->title4) }}">
                                @error('title4')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Number 4<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('number4')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter number" name="number4"
                                    value="{{ old('number4', $counter->number4) }}">
                                @error('number4')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Icon 4<span class="text-danger">*</span></label>
                                <input
                                    class="form-control dropify @error('icon4')
                                    is-invalid
                                @enderror"
                                    type="file" name="icon4"
                                    data-default-file="{{ asset('uploads/counter') }}/{{ $counter->icon4 }}">
                                @error('icon4')
                                    <span class="text-danger" style="font-size: 11px"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Status</label>
                                <select
                                    class="form-select @error('status')
                                        is-invalid
                                    @enderror"
                                    name="status">
                                    <option value="1" {{ old('status', $counter->status) == 1 ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ old('status', $counter->status) == 0 ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
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
