@extends('frontend.layouts.app')
@section('title')
Event
@endsection
@push('style')
@endpush
@section('content')
    @include('frontend.layouts.include.banner', ['page_name' => 'Event', 'subpage_name' => ''])
    <section id="upcoming_events" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading">
                        <h3>Upcoming events</h3>
                        <h2>Join our upcoming <span class="color_big_heading">events</span> for contribution</h2>
                    </div>
                </div>
            </div>
            <div class="row">
              @foreach ($events as $event)
              <div class="col-lg-6 mt-3">
                <div class="event_left_side_wrapper">
                    <div class="event_big_img">
                        <a href="{{ route('singleEventPage',$event->slug) }}"><img src="{{ asset('uploads/event') }}/{{ $event->featured_photo }}" alt="img"></a>
                    </div>
                    <div class="event_content_area big_content_padding">

                        <div class="event_heading_area">
                            <div class="event_heading">
                                <h3><a href="{{ route('singleEventPage',$event->slug) }}">{{$event->name}}</a></h3>
                            </div>
                            <div class="event_date">
                                <img src="{{ asset('assets/frontend') }}/img/icon/date.png" alt="icon">
                                <h6>{{ \Carbon\Carbon::parse($event->date)->format('j') }}<span>{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span><span>{{ \Carbon\Carbon::parse($event->date)->format('Y') }}</span></h6>
                            </div>
                        </div>
                        <div class="event_para">
                            <p>{{ Str::words($event->short_description, 50, '...') }}</p>
                        </div>
                        <div class="event_boxed_bottom_wrapper">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="event_bottom_boxed">
                                        <div class="event_bottom_icon">
                                            <img src="{{ asset('assets/frontend') }}/img/icon/map.png" alt="icon">
                                        </div>
                                        <div class="event_bottom_content">
                                            <h5>Location:</h5>
                                            <p>{{ $event->location }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="event_bottom_boxed">
                                        <div class="event_bottom_icon">
                                            <img src="{{ asset('assets/frontend') }}/img/icon/clock.png" alt="icon">
                                        </div>
                                        <div class="event_bottom_content">
                                            <h5>Starts at:</h5>
                                            <p>{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="event_button">
                            <a href="{{ route('singleEventPage',$event->slug) }}" class="btn btn_md btn_theme">Join event</a>
                        </div>
                    </div>
                </div>
            </div>
              @endforeach
              <div class="pagination p1 d-flex justify-content-center align-items-center text-center">
                {{ $events->links('vendor.pagination.frontend') }}
            </div>
            </div>
        </div>
    </section>

    @endsection
@push('script')
@endpush
