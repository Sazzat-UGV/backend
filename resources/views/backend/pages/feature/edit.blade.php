@extends('backend.layouts.app')
@section('title')
    Edit Feature
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
        'parent_page' => 'Features',
        'page_name' => 'Edit Feature',
    ])
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('browse-feature')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="">
                                    <a href="{{ route('admin.feature.index') }}"
                                        class="btn btn-secondary btn-rounded waves-effect waves-light addContact-modal mb-2">
                                        <i class="mdi mdi-arrow-left me-1"></i> Back to Features
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <form action="{{ route('admin.feature.update',$feature->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 col-md-10 mb-4">
                                <label class="form-label">Title<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('title')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter title" name="title" value="{{ old('title',$feature->title) }}">
                                @error('title')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-2 mb-4">
                                <label class="form-label">Status</label>
                                <select
                                    class="form-select @error('status')
                                        is-invalid
                                    @enderror"
                                    name="status">
                                    <option value="1" {{ old('status', $feature->status) == 1 ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ old('status', $feature->status) == 0 ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Text<span class="text-danger">*</span></label>
                                <textarea name="text" id="" cols="30" rows="5"
                                    class="form-control @error('text')
                                is-invalid
                                @enderror"
                                    placeholder="Enter text">{{ old('text',$feature->text) }}</textarea>
                                @error('text')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Icon<span class="text-danger">*</span></label>
                                <input
                                    class="form-control dropify @error('icon')
                                    is-invalid
                                @enderror"
                                    type="file" name="icon" data-default-file="{{ asset('uploads/feature') }}/{{ $feature->icon }}">
                                @error('icon')
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
