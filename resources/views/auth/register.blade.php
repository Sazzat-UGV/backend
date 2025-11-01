@extends('frontend.layouts.app')
@section('title')
    Register
@endsection
@push('style')
@endpush
@section('content')
    @include('frontend.layouts.include.banner', [
        'page_name' => 'Register',
        'subpage_name' => '',
    ])
    <section id="login_arae" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading">
                        <h3>Register your account</h3>
                        <h2>Become a
                            <span class="color_big_heading">member</span>
                            and enhance your hand
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="author_form_area">
                        <form method="POST" action="{{ route('register') }}" id="author_form">
                            @csrf
                            <div class="form-group">
                                <input type="text"
                                    class="form-control @error('name')
                                is-invalid
                            @enderror"
                                    placeholder="Enter name" name="name" value="{{ old('name') }}" required="">
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
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
                            <div class="form-group">
                                <input type="password"
                                    class="form-control @error('password_confirmation')
                                is-invalid
                            @enderror"
                                    placeholder="Retype password" name="password_confirmation" value="{{ old('password_confirmation') }}" required="">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="author_submit_form">
                                <button class="btn btn_theme btn_md">Register</button>
                                <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
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
