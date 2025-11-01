@extends('frontend.layouts.app')
@section('title')
    Account Verify
@endsection
@push('style')
@endpush
@section('content')
    @include('frontend.layouts.include.banner', [
        'page_name' => 'Account Verify',
        'subpage_name' => '',
    ])
    <section id="login_arae" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading">
                        <p class="mb-2">Thanks for signing up! Before getting started, could you verify your email address by clicking on
                            the link we just emailed to you? If you didn't receive the email, we will gladly send you
                            another.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="author_form_area">
                        @if (session('status') == 'verification-link-sent')
                            <p class="text-center text-success text-bold mb-3">
                                A new verification link has been sent to the email address you provided during registration.
                            </p>
                        @endif

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <div class="author_submit_form" style="padding-top: 0px !important;">
                                <button class="btn btn_theme btn_md">Resend Verification Email</button>
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
