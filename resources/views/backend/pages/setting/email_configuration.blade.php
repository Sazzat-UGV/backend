@extends('backend.layouts.app')
@section('title')
    Email Configuration
@endsection
@push('style')
@endpush

@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Settings',
        'page_name' => 'Email Configuration',
    ])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.email_configuration_submit') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Mail Mailer<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('mail_mailer')
                                            is-invalid
                                        @enderror"
                                    type="test" placeholder="Enter mail mailer" name="mail_mailer"
                                    value="{{ old('mail_mailer', Setting('mail_mailer')) }}">
                                @error('mail_mailer')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Mail Host<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('mail_host')
                                            is-invalid
                                        @enderror"
                                    type="test" placeholder="Enter mail host" name="mail_host"
                                    value="{{ old('mail_host', Setting('mail_host')) }}">
                                @error('mail_host')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Mail Port<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('mail_port')
                                            is-invalid
                                        @enderror"
                                    type="test" placeholder="Enter mail port" name="mail_port"
                                    value="{{ old('mail_port', Setting('mail_port')) }}">
                                @error('mail_port')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Mail Username<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('mail_username')
                                            is-invalid
                                        @enderror"
                                    type="test" placeholder="Enter mail username" name="mail_username"
                                    value="{{ old('mail_username', Setting('mail_username')) }}">
                                @error('mail_username')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Mail Password<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('mail_password')
                                            is-invalid
                                        @enderror"
                                    type="test" placeholder="Enter mail password" name="mail_password"
                                    value="{{ old('mail_password', Setting('mail_password')) }}">
                                @error('mail_password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Mail Enctyption<span class="text-danger">*</span><span
                                        class="text-danger" style="font-size: 11px">(Default type "null")</span></label>
                                <input
                                    class="form-control @error('mail_enctyption')
                                            is-invalid
                                        @enderror"
                                    type="test" placeholder="Enter mail enctyption" name="mail_enctyption"
                                    value="{{ old('mail_enctyption', Setting('mail_enctyption')) }}">
                                @error('mail_enctyption')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Mail Form Address<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('mail_form_address')
                                            is-invalid
                                        @enderror"
                                    type="test" placeholder="Enter mail form address" name="mail_form_address"
                                    value="{{ old('mail_form_address', Setting('mail_form_address')) }}">
                                @error('mail_form_address')
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
@endpush
