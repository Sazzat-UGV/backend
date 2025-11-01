@extends('frontend.layouts.app')
@section('title')
    Gallery
@endsection
@push('style')
@endpush
@section('content')
    @include('frontend.layouts.include.banner', ['page_name' => 'Gallery', 'subpage_name' => ''])
    <section id="gallery_grid_area" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading">
                        <h3>Gallery</h3>
                        <h2> Explore our <span class="color_big_heading">gallery</span> to know
                            how we work</h2>
                    </div>
                </div>
            </div>
            <div class="row popup-gallery">
                @foreach ($photos as $photo)
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="gallery_item">
                            <img src="{{ asset('uploads/gallery') }}/{{ $photo->photo }}" alt="img">
                            <div class="gallery_overlay">
                                <a href="{{ asset('uploads/gallery') }}/{{ $photo->photo }}"
                                    title="{{ $photo->title }}"><img
                                        src="{{ asset('assets/frontend') }}/img/icon/arrow-round.png" alt="icon"></a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="pagination p1 d-flex justify-content-center align-items-center text-center">
                    {{ $photos->links('vendor.pagination.frontend') }}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
@endpush
