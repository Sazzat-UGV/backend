@extends('frontend.layouts.app')
@section('title')
    Home
@endsection
@push('style')
@endpush
@section('content')
    <!-- slider section -->
    <section id="home_five_banner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner_five_slider_wrapper owl-carousel owl-theme arrow_style owl-loaded owl-drag">
                        <div class="owl-stage-outer">
                            <div class="owl-stage"
                                style="transform: translate3d(0px, 0px, 0px); transition: all; width: 100%;">
                                @foreach ($sliders as $slider)
                                    <div class="owl-item" style="width: 100%;">
                                        <div class="banner_slider_item bg_one"
                                            style="background-image: url('{{ asset('uploads/slider') }}/{{ $slider->image }}'); width: 100%;">
                                            <div class="banner_five_text">
                                                <h1>{{ $slider->title }}</h1>
                                                <p>{{ $slider->description }}</p>
                                                @if ($slider->button_link)
                                                    <div class="home_five_banner_button">
                                                        <a href="{{ $slider->button_link }}"
                                                            class="btn btn_theme btn_md">{{ $slider->button_name }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="owl-nav">
                            <button type="button" role="presentation" class="owl-prev">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <button type="button" role="presentation" class="owl-next">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- special section -->
    @if ($special->status == 1)
        <section id="about_area" class="pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="about_area_img">
                            <img src="{{ asset('uploads/others') }}/{{ $special->photo }}" alt="img">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="about_area_main_text">
                            <div class="about_area_heading">
                                <img src="{{ asset('assets/frontend') }}/img/icon/about.png" alt="img">
                            </div>
                            <div class="about_area_heading_two">
                                <h2>{{ $special->heading }}</h2>
                                <h3>{{ $special->sub_heading }}</h3>
                            </div>
                            <div class="about_area_para">
                                <h5>{!! $special->text !!}</h5>
                            </div>
                            <div class="about_vedio_area">
                                @if ($special->button_link)
                                    <a href="{{ $special->button_link }}"
                                        class="btn btn_theme btn_md">{{ $special->button_name }}</a>
                                @endif
                                @if ($special->video_id)
                                    <a href="https://www.youtube.com/watch?v={{ $special->video_id }}"
                                        class="vedio_btn popup-vimeo"><i
                                            class="fa fa-play"></i>{{ $special->video_button_name }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- feature section -->
    <section id="home_five_card_area" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading">
                        <h3>Our Services</h3>
                        <h2> We are dedicated to providing <span class="color_big_heading">support</span> to those in need
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($features as $feature)
                    <div class="col-lg-4 col-md-6 col-sm-12 mt-5">
                        <a href="#!">
                            <div class="card_five_wrapper">
                                <img src="{{ asset('uploads/feature') }}/{{ $feature->icon }}" alt="icon">
                                <h3>{{ $feature->title }}</h3>
                                <p>{{ $feature->text }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="trending_causes" class="section_after section_padding bg-color">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading">
                        <h3>Trending causes</h3>
                        <h2> We are always where other people <span class="color_big_heading">need</span> help</h2>
                    </div>
                </div>
            </div>
            <div class="row" id="counter">
                @foreach ($causes as $cause)
                    <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                        <div class="case_boxed_wrapper causes_boxed_two">
                            <div class="case_boxed_img">
                                <a href="{{ route('singleCausePage', $cause->slug) }}"><img
                                        src="{{ asset('uploads/cause') }}/{{ $cause->featured_photo }}"
                                        alt="img"></a>
                            </div>
                            <div class="causes_boxed_text">
                                <div class="causes_boxed_text_center">
                                    <h3><a href="{{ route('singleCausePage', $cause->slug) }}">{{ $cause->name }}</a>
                                    </h3>
                                    <p>{{ $cause->short_description }}</p>
                                </div>
                                <div class="class-full causes_pro_bar progress_bar">
                                    <div class="class-full-bar-box">
                                        <h3 class="h3-title">Goal: <span>${{ $cause->goal }}</span></h3>
                                        @php
                                            $perc = 0;
                                            $perc = ($cause->raised / $cause->goal) * 100;
                                            $perc = ceil($perc);
                                        @endphp
                                        <div class="class-full-bar-percent">
                                            <h2><span class="counting-data"
                                                    data-count="{{ $perc }}">{{ $perc }}</span>
                                                <span>%</span>
                                            </h2>
                                        </div>
                                        <div class="skill-bar class-bar" data-width="{{ $perc }}%">
                                            <div class="skill-bar-inner class-bar-in"
                                                style="width: {{ $perc }}%; overflow: hidden;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section id="upcoming_events" class="section_padding_bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading">
                        <h3>Upcoming events</h3>
                        <h2>Join our upcoming
                            <span class="color_big_heading">events</span> for contribution
                        </h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="event_left_side_wrapper">
                        <div class="event_big_img">
                            <a href="{{ route('singleEventPage', $event->first()->slug) }}"><img
                                    src="{{ asset('uploads/event') }}/{{ $event->first()->featured_photo }}"
                                    alt="img"></a>
                        </div>
                        <div class="event_content_area big_content_padding">

                            <div class="event_heading_area">
                                <div class="event_heading">
                                    <h3><a
                                            href="{{ route('singleEventPage', $event->first()->slug) }}">{{ $event->first()->name }}</a>
                                    </h3>
                                </div>
                                <div class="event_date">
                                    <img src="{{ asset('assets/frontend') }}/img/icon/date.png" alt="icon">
                                    <h6>{{ \Carbon\Carbon::parse($event->first()->date)->format('j') }}<span>{{ \Carbon\Carbon::parse($event->first()->date)->format('M') }}</span><span>{{ \Carbon\Carbon::parse($event->first()->date)->format('Y') }}</span>
                                    </h6>
                                </div>
                            </div>
                            <div class="event_para">
                                <p>{{ Str::words($event->first()->short_description, 50, '...') }}</p>
                            </div>
                            <div class="event_boxed_bottom_wrapper">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="event_bottom_boxed">
                                            <div class="event_bottom_icon">
                                                <img src="{{ asset('assets/frontend') }}/img/icon/map.png"
                                                    alt="icon">
                                            </div>
                                            <div class="event_bottom_content">
                                                <h5>Location:</h5>
                                                <p>{{ $event->first()->location }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="event_bottom_boxed">
                                            <div class="event_bottom_icon">
                                                <img src="{{ asset('assets/frontend') }}/img/icon/clock.png"
                                                    alt="icon">
                                            </div>
                                            <div class="event_bottom_content">
                                                <h5>Starts at:</h5>
                                                <p>{{ \Carbon\Carbon::parse($event->first()->time)->format('h:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="event_button">
                                <a href="{{ route('singleEventPage', $event->first()->slug) }}"
                                    class="btn btn_md btn_theme">Join event</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    @foreach ($event->skip(1)->take(3)->get() as $levent)
                        <div class="event_left_side_wrapper">
                            <div class="event_content_area small_content_padding">
                                <div class="event_heading_area">
                                    <div class="event_heading">
                                        <h3><a
                                                href="{{ route('singleEventPage', $levent->slug) }}">{{ $levent->name }}</a>
                                        </h3>
                                    </div>
                                    <div class="event_date">
                                        <img src="{{ asset('assets/frontend') }}/img/icon/date.png" alt="icon">
                                        <h6>{{ \Carbon\Carbon::parse($levent->date)->format('j') }}<span>{{ \Carbon\Carbon::parse($levent->date)->format('M') }}</span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="event_para">
                                    <p>{{ Str::words($levent->short_description, 50, '...') }}</p>
                                </div>
                                <div class="event_boxed_bottom_wrapper">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div class="event_bottom_boxed">
                                                <div class="event_bottom_icon">
                                                    <img src="{{ asset('assets/frontend') }}/img/icon/map.png"
                                                        alt="icon">
                                                </div>
                                                <div class="event_bottom_content">
                                                    <h5>Location:</h5>
                                                    <p>{{ $levent->location }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div class="event_bottom_boxed">
                                                <div class="event_bottom_icon">
                                                    <img src="{{ asset('assets/frontend') }}/img/icon/clock.png"
                                                        alt="icon">
                                                </div>
                                                <div class="event_bottom_content">
                                                    <h5>Starts at:</h5>
                                                    <p>{{ \Carbon\Carbon::parse($levent->time)->format('h A') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section id="counter_area" style="padding-top: 100px; padding-bottom:50px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="counter_area_wrapper">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="counter_item">
                                    <img src="{{ asset('uploads/counter') }}/{{ $counter->icon1 }}" class="w-25"
                                        alt="icon">
                                    <h2 class="">{{ $counter->number1 }}</h2>
                                    <p>{{ $counter->title1 }}</p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="counter_item">
                                    <img src="{{ asset('uploads/counter') }}/{{ $counter->icon2 }}" class="w-25"
                                        alt="icon">
                                    <h2 class="">{{ $counter->number2 }}</h2>
                                    <p>{{ $counter->title2 }}</p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="counter_item">
                                    <img src="{{ asset('uploads/counter') }}/{{ $counter->icon3 }}" class="w-25"
                                        alt="icon">
                                    <h2 class="">{{ $counter->number3 }}</h2>
                                    <p>{{ $counter->title3 }}</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="counter_item">
                                    <img src="{{ asset('uploads/counter') }}/{{ $counter->icon4 }}" class="w-25"
                                        alt="icon">
                                    <h2 class="">{{ $counter->number4 }}</h2>
                                    <p>{{ $counter->title4 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="home_blog_area" class="section_after bg-color">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading">
                        <h3>Our latest news</h3>
                        <h2>Check all
                            <span class="color_big_heading">our latest</span> news and updates
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($blogs as $blog)
                    <div class="col-lg-4">
                        <div class="blog_card_wrapper">
                            <div class="blog_card_img">
                                <a href="{{ route('singleBlogPage', $blog->id) }}"><img
                                        src="{{ asset('uploads/blog') }}/{{ $blog->photo }}" alt="img"></a>
                            </div>
                            <div class="blog_card_text">
                                <div class="blog_card_heading">
                                    <h3><a href="{{ route('singleBlogPage', $blog->id) }}">{{ $blog->title }}</a>
                                    </h3>
                                    <p>{{ Str::words($blog->short_description, 50, '...') }}<a
                                            href="{{ route('singleBlogPage', $blog->id) }}">
                                            Read
                                            more</a></p>
                                </div>
                                <div class="blog_boxed_bottom_wrapper">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div class="blog_bottom_boxed">
                                                <div class="blog_bottom_icon">
                                                    <img src="{{ asset('assets/frontend') }}/img/icon/cal.png"
                                                        alt="icon">
                                                </div>
                                                <div class="blog_bottom_content">
                                                    <h5>Date: <span>{{ $blog->created_at->format('d M, Y') }}</span> </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div class="blog_bottom_boxed blog_left_padding">
                                                <div class="blog_bottom_icon">
                                                    <img src="{{ asset('assets/frontend') }}/img/icon/user.png"
                                                        alt="icon">
                                                </div>
                                                <div class="blog_bottom_content">
                                                    <h5>By:</h5>
                                                    <p>Admin</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
@push('script')
@endpush
