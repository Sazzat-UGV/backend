@extends('frontend.layouts.app')
@section('title')
    Contact
@endsection
@push('style')
    <style>
        iframe {
            height: 550 !important;
            border: 0 !important;
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    @include('frontend.layouts.include.banner', ['page_name' => 'Contact', 'subpage_name' => ''])

    <section id="contact_arae_main" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading">
                        <h3>Contact with us</h3>
                        <h2>Get in
                            <span class="color_big_heading">touch</span>with us &amp;
                            stay updates
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact_area_left">
                        @if ($setting->physical_address)
                            <div class="contact_left_item">
                                <div class="contact_left_icon">
                                    <img src="{{ asset('assets/frontend') }}/img/icon/map_color.png" alt="icon">
                                </div>
                                <div class="contact_left_text">
                                    <h3>Address:</h3>
                                    <p>{{ $setting->physical_address }}</p>
                                </div>
                            </div>
                        @endif
                        @if ($setting->email)
                            <div class="contact_left_item">
                                <div class="contact_left_icon">
                                    <img src="{{ asset('assets/frontend') }}/img/icon/email-color.png" alt="icon">
                                </div>
                                <div class="contact_left_text">
                                    <h3>Email:</h3>
                                    <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                                </div>
                            </div>
                        @endif
                        @if ($setting->phone_number)
                            <div class="contact_left_item">
                                <div class="contact_left_icon">
                                    <img src="{{ asset('assets/frontend') }}/img/icon/phon-color.png" alt="icon">
                                </div>
                                <div class="contact_left_text">
                                    <h3>Phone number:</h3>
                                    <a href="tel:{{ $setting->phone_number }}">{{ $setting->phone_number }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact_form_Wrapper">
                        <h3>Leave us a message</h3>
                        <form action="{{ route('contactSubmit') }}" id="contact_form" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control @error('full_name')
                                    is-invalid
                                @enderror" name="full_name" placeholder="Your full name*"  value="{{ old('full_name') }}" required="">
                                @error('full_name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control @error('email')
                                    is-invalid
                                @enderror" placeholder="Your email address*"  value="{{ old('email') }}" required="">
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control @error('subject')
                                    is-invalid
                                @enderror" placeholder="Subject*" name="subject"  value="{{ old('subject') }}" required="">
                                @error('subject')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <textarea class="form-control @error('message')
                                    is-invalid
                                @enderror" rows="6" name="message" placeholder="Message*" required="">{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="contact_submit_form">
                                <button class="btn btn_theme btn_md">Send message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact_full_map" class="section_padding_bottom mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact_map_area">
                        {!! $setting->map !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
@endpush
