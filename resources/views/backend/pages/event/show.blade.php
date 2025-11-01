@extends('backend.layouts.app')

@section('title', 'Event Details')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"
        integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 20px;
        }
    </style>
@endpush

@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Events',
        'page_name' => 'Event Details',
    ])

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="pt-3">
                        <div class="row justify-content-center">
                            <div class="col-xl-8">
                                <div class="text-center">
                                    <h4>{{ $event->name }}</h4>
                                    <p class="text-muted mb-4">
                                        <i class="mdi mdi-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}
                                        {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                                    </p>
                                </div>
                                <hr>

                                <div class="row text-center">
                                    <div class="col-sm-4">
                                        <h5 class="font-size-15"><b>Price: </b>{{ $event->price }}<b>$</b></h5>
                                        <h5 class="font-size-15"><b>Total Seat: </b>{{ $event->total_seat }}</h5>
                                        <h5 class="font-size-15"><b>Booked Seat: </b>{{ $event->booked_seat }}</h5>
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted mb-2">Email</p>
                                        <h5 class="font-size-15">{{ $event->email }}</h5>
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted mb-2">Phone</p>
                                        <h5 class="font-size-15">{{ $event->phone }}</h5>
                                    </div>
                                </div>
                                <hr>

                                <div class="my-5 text-center">
                                    <img src="{{ asset('uploads/event/' . $event->featured_photo) }}" alt="Event Image"
                                        class="img-thumbnail mx-auto d-block">
                                </div>
                                <hr>

                                <div class="mt-4">
                                    <h5 class="mb-3">Short Description: </h5>
                                    <p>{{ $event->short_description }}</p>

                                    <h5 class="mb-3">Description: </h5>
                                    <p>{!! $event->description !!}</p>

                                    <h5 class="mb-3">Location: </h5>
                                    <p>{{ $event->location }}</p>

                                    <h5 class="mb-3">Map: </h5>
                                    <p>{!! $event->map !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>
@endpush
