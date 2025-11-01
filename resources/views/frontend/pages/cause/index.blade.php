@extends('frontend.layouts.app')
@section('title')
    Cause
@endsection
@push('style')
@endpush
@section('content')
    @include('frontend.layouts.include.banner', ['page_name' => 'Cause', 'subpage_name' => ''])
    <section id="trending_causes_main" class="section_padding">
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
                                        src="{{ asset('uploads/cause') }}/{{ $cause->featured_photo }}" alt="img"></a>
                            </div>
                            <div class="causes_boxed_text">
                                <div class="causes_boxed_text_center">
                                    <h3><a href="{{ route('singleCausePage', $cause->slug) }}">{{ $cause->name }}</a></h3>
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
                <div class="pagination p1 d-flex justify-content-center align-items-center text-center">
                    {{ $causes->links('vendor.pagination.frontend') }}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
@endpush
