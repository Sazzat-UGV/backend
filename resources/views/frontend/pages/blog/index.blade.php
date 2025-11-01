@extends('frontend.layouts.app')
@section('title')
    Blog
@endsection
@push('style')
@endpush
@section('content')
    @include('frontend.layouts.include.banner', ['page_name' => 'Blog', 'subpage_name' => ''])
    <section id="home_four_blog_area" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="section_heading_four">
                        <h3>Blogs</h3>
                        <h2>What they are talking about our expertise</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($blogs as $blog)
                    <div class="col-lg-4 col-md-6 col-sm-12 mt-4">
                        <div class="blog_four_card_wrapper">
                            <div class="blog_four_card_img">
                                <a href="{{ route('singleBlogPage', $blog->id) }}"><img
                                        src="{{ asset('uploads/blog') }}/{{ $blog->photo }}" alt="img"></a>
                            </div>
                            <div class="blog_four_card_text">
                                <div class="blog_four_card_heading">
                                    <h3><a href="{{ route('singleBlogPage', $blog->id) }}">{{ $blog->title }}</a>
                                    </h3>
                                    <p>{{ Str::words($blog->short_description, 50, '...') }}<a
                                            href="{{ route('singleBlogPage', $blog->id) }}">
                                            Read
                                            more</a></p>
                                </div>
                                <div class="blog_four_boxed_bottom_wrapper">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 ">
                                            <div class="blog_four_bottom_boxed">
                                                <div class="blog_four_bottom_icon">
                                                    <img src="{{ asset('assets/frontend') }}/img/home-4/common/date.png"
                                                        alt="icon">
                                                </div>
                                                <div class="blog_four_bottom_content">
                                                    <h5>Date: <span>{{ $blog->created_at->format('d M, Y') }}</span> </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div class="blog_four_bottom_boxed blog_four_left_padding">
                                                <div class="blog_four_bottom_icon">
                                                    <img src="{{ asset('assets/frontend') }}/img/home-4/common/admin.png"
                                                        alt="icon">
                                                </div>
                                                <div class="blog_four_bottom_content">
                                                    <h5>By: <span>Admin</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="pagination p1 d-flex justify-content-center align-items-center text-center">
                    {{ $blogs->links('vendor.pagination.frontend') }}
                </div>

            </div>
        </div>
    </section>
@endsection
@push('script')
@endpush
