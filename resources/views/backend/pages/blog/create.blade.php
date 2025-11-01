@extends('backend.layouts.app')
@section('title')
    Create Blog
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
        'parent_page' => 'Blogs',
        'page_name' => 'Add New Blog',
    ])
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('browse-blog')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="">
                                    <a href="{{ route('admin.blog.index') }}"
                                        class="btn btn-secondary btn-rounded waves-effect waves-light addContact-modal mb-2">
                                        <i class="mdi mdi-arrow-left me-1"></i> Back to Blogs
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" name="category">
                                    <option>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
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
                            <div class="col-12 mb-4">
                                <label class="form-label">Short Description<span class="text-danger">*</span></label>
                                <textarea name="short_description" id="" cols="30" rows="5"
                                    class="form-control @error('short_description')
                                is-invalid
                                @enderror"
                                    placeholder="Enter short description">{{ old('short_description') }}</textarea>
                                @error('short_description')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Description<span class="text-danger">*</span></label>
                                <textarea name="description" id="description" cols="30" rows="5"
                                    class="form-control @error('description')
                                is-invalid
                                @enderror"
                                    placeholder="Enter description">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            @php

                                $subscriber = App\Models\Subscriber::where('status', 1)->count();
                            @endphp
                            <div class="{{ $subscriber > 0 ? 'col-12 col-md-8' : 'col-12' }} mb-4">
                                <label class="form-label">Tags</label>
                                <input type="text" id="tags" name="tags" value="{{ old('tags') }}"
                                    class="form-control">
                                @error('designation')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="{{ $subscriber > 0 ? 'col-12 col-md-4' : 'col-12' }} mb-4">
                                <label class="form-label">Send Message to All Subscriber?</label>
                                <select class="form-select" name="send_message_to_subscribers">
                                    <option value="0"
                                        {{ old('send_message_to_subscribers', 0) == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1"
                                        {{ old('send_message_to_subscribers', 0) == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                                <small class="text-muted">Choose "Yes" to send a message to all subscribers.</small>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        $('.dropify').dropify();
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        var input = document.querySelector('#tags');
        var tagify = new Tagify(input);
    </script>
@endpush
