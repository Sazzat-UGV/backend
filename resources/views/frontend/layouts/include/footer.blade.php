<section id="subscribe_area">
    <div class="container">
        <div class="subscribe_wrapper">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="subscribe_text">
                        <p>Newsletter</p>
                        <h3>To get weekly & monthly news,
                            <span class="color_big_heading">Subscribe</span> to our newsletter.
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="cta_right_side">
                        <form action="{{ route('subscribe') }}" id="subscribe_form" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email')
                                    is-invalid
                                @enderror"
                                    placeholder="Your mail address" required="">
                                <button class="btn btn_theme btn_md" type="submit">Subscribe</button>
                                @error('email')
                                    <span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer id="footer_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="footer_area_about">
                    {{-- @dd($setting) --}}
                    <img src="{{ asset('uploads/settings') }}/{{ $setting->site_logo }}" alt="img">
                    <p>{{ $setting->site_description }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-12 col-12">
                <div class="footer_navitem_ara">
                    <h3>Quick links</h3>
                    <div class="nav_item_footer">
                        <ul>
                            <li><a href="{{ route('aboutPage') }}">About us</a></li>
                            <li><a href="{{ route('causePage') }}">Causes</a></li>
                            <li><a href="{{ route('eventPage') }}">Events</a></li>
                            <li><a href="{{ route('galleryPage') }}">Gallery</a></li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-12 col-12">
                <div class="footer_navitem_ara">
                    <h3>Support</h3>
                    <div class="nav_item_footer">
                        <ul>
                            <li><a href="{{ route('faqPage') }}">FAQ</a></li>
                            <li><a href="{{ route('contactPage') }}">Contact us</a></li>
                            <li><a href="{{ route('privacyPolicy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('termsCondition') }}">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="footer_navitem_ara">
                    <h3>Our Information</h3>
                    <div class="footer_twitter_area">
                        @if ($setting->physical_address)
                        <h6><strong>Address:</strong> {{ $setting->physical_address }}</h6>
                        @endif
                        @if ($setting->phone_number)
                        <h6><strong>Phone:</strong> <a href="tel:{{ $setting->phone_number }}">{{ $setting->phone_number }}</a></h6>
                        @endif
                        @if ($setting->email)
                        <h6><strong>Email:</strong> <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a></h6>
                        @endif
                        <h6>{{ date('F d, Y h:i A') }}</h6>

                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
