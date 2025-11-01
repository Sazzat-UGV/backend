@extends('frontend.layouts.app')
@section('title')
    Login
@endsection
@push('style')
@endpush
@section('content')
    @include('frontend.layouts.include.banner', [
        'page_name' => 'Login',
        'subpage_name' => '',
    ])
<section id="login_arae" class="section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                <div class="section_heading">
                    <h3>Login your account</h3>
                    <h2>Join our
                        <span class="color_big_heading">community</span>
                        to help peoples
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="author_form_area">
                    <form action="{{ route('login') }}" method="POST" id="author_form">
                        @csrf
                        <div class="form-group">
                            <input type="text"
                                class="form-control @error('email')
                            is-invalid
                        @enderror"
                                placeholder="Enter email" name="email" value="{{ old('email') }}" required="">
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password"
                                class="form-control @error('password')
                            is-invalid
                        @enderror"
                                placeholder="Enter password" name="password" value="{{ old('password') }}" required="">
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="author_submit_form">
                            <button class="btn btn_theme btn_md" type="submit">Login</button>
                            <p>Dont have an account? <a href="{{ route('register') }}">Register now</a></p>
                            <p>Or</p>
                            <p><a href="{{ route('password.request') }}">Forgot Password</a></p>
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
