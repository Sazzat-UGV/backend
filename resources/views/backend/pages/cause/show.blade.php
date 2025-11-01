@extends('backend.layouts.app')

@section('title', 'Cause Details')

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
        'parent_page' => 'Causes',
        'page_name' => 'Cause Details',
    ])

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="pt-3">
                        <div class="row justify-content-center">
                            <div class="col-xl-8">
                                <div class="text-center">
                                    <h4>{{ $cause->name }}</h4>
                                </div>
                                <hr>


                                <div class="my-5 text-center">
                                    <img src="{{ asset('uploads/cause/' . $cause->featured_photo) }}" alt="Cause Image"
                                        class="img-thumbnail mx-auto d-block">
                                </div>
                                <hr>

                                <div class="mt-4">
                                    <h5 class="mb-3">Short Description: </h5>
                                    <p>{{ $cause->short_description }}</p>

                                    <h5 class="mb-3">Description: </h5>
                                    <p>{!! $cause->description !!}</p>

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
