@extends('frontend.layouts.app')
@section('title')
    Forgot Password
@endsection
@push('style')
@endpush
@section('content')
    @include('frontend.layouts.include.banner', [
        'page_name' => 'Forgot Password',
        'subpage_name' => '',
    ])
    <section id="login_arae" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading">
                        <p class="mb-2">Forgot your password? No problem. Just let us know your email address and we will
                            email you a
                            password reset link that will allow you to choose a new one.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="author_form_area">

                        <p class="text-center text-success text-bold mb-3">
                            {{ session('status') }}
                        </p>
                        <form method="POST" action="{{ route('password.email') }}" id="author_form">
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

                            <div class="author_submit_form">
                                <button class="btn btn_theme btn_md">Email Password Reset Link</button>
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
