@extends('frontend.layouts.app')
@section('title')
    Volunteers
@endsection
@push('style')
@endpush
@section('content')
    @include('frontend.layouts.include.banner', ['page_name' => 'Volunteers', 'subpage_name' => ''])

    <section id="volunteer_area_main" class="section_padding ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading">
                        <h3>Ready to help</h3>
                        <h2> We have thousands of happy
                            volunteer to <span class="color_big_heading">help</span> you</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($volunteers as $volunteer)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="volunteer_wrapper">
                            <div class="volunteer_img">
                                <img src="{{ asset('uploads/volunteer') }}/{{ $volunteer->photo }}" alt="img">
                                <div class="volunteer_icon">
                                    <ul>
                                        @if ($volunteer->facebook)
                                            <li>
                                                <a href="{{ $volunteer->facebook }}"><i class="fab fa-facebook"></i></a>
                                            </li>
                                        @endif
                                        @if ($volunteer->twitter)
                                            <li>
                                                <a href="{{ $volunteer->twitter }}"><i class="fab fa-twitter"></i></a>
                                            </li>
                                        @endif
                                        @if ($volunteer->instagram)
                                            <li>
                                                <a href="{{ $volunteer->instagram }}"><i class="fab fa-instagram"></i></a>
                                            </li>
                                        @endif
                                        @if ($volunteer->linkedin)
                                            <li>
                                                <a href="{{ $volunteer->linkedin }}"><i class="fab fa-linkedin"></i></a>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                            </div>
                            <div class="volunteer_text">
                                <h3><a href="#!">{{ $volunteer->name }}</a></h3>
                                <p>{{ $volunteer->title }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="pagination p1 d-flex justify-content-center align-items-center text-center">
                    {{ $volunteers->links('vendor.pagination.frontend') }}
                </div>

            </div>
        </div>
    </section>
@endsection
@push('script')
@endpush
