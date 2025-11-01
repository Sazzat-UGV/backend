@extends('frontend.layouts.app')
@section('title')
    About
@endsection
@push('style')
@endpush
@section('content')
    @include('frontend.layouts.include.banner', ['page_name' => 'About us', 'subpage_name' => ''])
    <section id="about_area" class="section_padding_bottom pt-5 ">
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
    <!-- counter -->
    @if ($counter->status==1)
    <section id="counter_area" style="padding-top: 100px; padding-bottom:50px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="counter_area_wrapper">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="counter_item">
                                    <img src="{{ asset('uploads/counter') }}/{{ $counter->icon1 }}" class="w-25" alt="icon">
                                    <h2 class="">{{ $counter->number1 }}</h2>
                                    <p>{{ $counter->title1   }}</p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="counter_item">
                                    <img src="{{ asset('uploads/counter') }}/{{ $counter->icon2 }}" class="w-25" alt="icon">
                                    <h2 class="">{{ $counter->number2 }}</h2>
                                    <p>{{ $counter->title2   }}</p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="counter_item">
                                    <img src="{{ asset('uploads/counter') }}/{{ $counter->icon3 }}" class="w-25" alt="icon">
                                    <h2 class="">{{ $counter->number3 }}</h2>
                                    <p>{{ $counter->title3   }}</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="counter_item">
                                    <img src="{{ asset('uploads/counter') }}/{{ $counter->icon4 }}" class="w-25" alt="icon">
                                    <h2 class="">{{ $counter->number4 }}</h2>
                                    <p>{{ $counter->title4   }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- testimonial section -->
    <section id="testimonial_area_three" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading_two">
                        <h3>Our testimonials</h3>
                        <h2>What they are talking about our expertise</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($testimonials as $testimonial)
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="testimonial_three_boxed">
                            <img src="{{ asset('assets/frontend') }}/img/home-3/common/quate.png" alt="icon"
                                class="test_quate_area">
                            <img src="{{ asset('uploads/testimonial') }}/{{ $testimonial->photo }}" alt="img"
                                class="w-25 rounded">
                            <p>{{ $testimonial->comment }}</p>
                            <div class="test_three_bottom">
                                <div class="test_three_bottom_left">
                                    <h3>{{ $testimonial->name }}</h3>
                                    <h6>{{ $testimonial->designation }}</h6>
                                </div>
                                <div class="test_three_bottom_right">
                                    <div class="test_three_icon">
                                        @for ($i = 0; $i < $testimonial->rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
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
