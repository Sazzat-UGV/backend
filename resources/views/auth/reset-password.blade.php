@extends('frontend.layouts.app')
@section('title')
    Reset Password
@endsection
@push('style')
@endpush
@section('content')
    @include('frontend.layouts.include.banner', [
        'page_name' => 'Reset Password',
        'subpage_name' => '',
    ])
    <section id="login_arae" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading">
                        <h3 class="mb-2">Reset your password</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="author_form_area">
                        <form method="POST" action="{{ route('password.store') }}" id="author_form">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <div class="form-group">
                                <input type="email"
                                    class="form-control @error('email')
                                is-invalid
                            @enderror"
                                    placeholder="Enter email" name="email" value="{{ old('email', $request->email) }}"
                                    required="">
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password"
                                    class="form-control @error('password')
                                is-invalid
                            @enderror"
                                    placeholder="Enter password" name="password" value="{{ old('password') }}"
                                    required="">
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password"
                                    class="form-control @error('password_confirmation')
                                is-invalid
                            @enderror"
                                    placeholder="Retype password" name="password_confirmation"
                                    value="{{ old('password_confirmation') }}" required="">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="author_submit_form">
                                <button class="btn btn_theme btn_md">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
@endpush
