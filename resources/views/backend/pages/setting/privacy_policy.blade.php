@extends('backend.layouts.app')
@section('title')
Privacy Policy
@endsection
@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"
        integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Settings',
        'page_name' => 'Privacy Policy',
    ])
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.privacypolicy.privacyPolicy') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-12 mb-4">
                                <label class="form-label">Privacy Policy<span class="text-danger">*</span></label>
                                <textarea name="privacy_policy" id="editor" cols="30" rows="5"
                                    class="form-control @error('privacy_policy')
                                is-invalid
                                @enderror"
                                    placeholder="Enter privacy policy">{{ old('privacy_policy', $pages->privacy_policy) }}</textarea>
                                @error('privacy_policy')
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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
