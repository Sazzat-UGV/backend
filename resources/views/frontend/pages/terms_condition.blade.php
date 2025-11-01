@extends('frontend.layouts.app')
@section('title')
    Terms & Conditions
@endsection
@push('style')
@endpush
@section('content')
    @include('frontend.layouts.include.banner', [
        'page_name' => 'Terms & Conditions',
        'subpage_name' => '',
    ])

    <section id="faqs_arae_main" class="section_padding_bottom mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading">
                        <h3>Terms & Conditions</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    {!! $data->terms_condition !!}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
@endpush
