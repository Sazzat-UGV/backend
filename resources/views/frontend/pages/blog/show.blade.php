@extends('frontend.layouts.app')
@section('title')
    Blog Details
@endsection
@push('style')
    <style>
        .post_reply_wrapper {
            margin-left: 60px;
            padding-left: 40px;
        }

        .post_reply_item {
            display: flex;
            gap: 20px;
            margin-bottom: 10px;
        }
    </style>
@endpush
@section('content')
    @include('frontend.layouts.include.banner', [
        'page_name' => $blog_detail->title,
        'subpage_name' => 'Blog Details',
    ])
    <section id="news_details_main" class="section_padding">
        <div class="container">
            <div class="row" id="counter">
                <div class="col-lg-8">
                    <div class="details_wrapper_area">
                        <div class="details_big_img">
                            <img src="{{ asset('uploads/blog') }}/{{ $blog_detail->photo }}" alt="img">
                        </div>
                        <div class="details_text_wrapper">
                            <h2>{{ $blog_detail->title }}</h2>
                            <p>{!! $blog_detail->description !!}</p>
                        </div>

                        <div class="comment_area_details">
                            @php
                                $reply = $comments->sum('reply_count');
                                $comment = $comments->count();
                                $total_comment = $reply + $comment;
                            @endphp
                            <h3>{{ $total_comment }} Comments</h3>
                            <div class="post_comment_wrapper">
                                @foreach ($comments as $comment)
                                    <div class="post_comment_item">
                                        <div class="post_comment_img">
                                            <img src="{{ asset('uploads/profile_photo/default_profile.jpg') }}"
                                                alt="img" class="w-50 p-1"
                                                style="border: 1px solid black; border-radius: 5px">
                                        </div>
                                        <div class="post_comment_text">
                                            <div class="post_names_replay">
                                                <h5>{{ $comment->name }}</h5>
                                                <a href="javascript(0)" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $comment->id }}"> <i
                                                        class="fas fa-reply"></i>Reply</a>
                                            </div>
                                            <p>{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                    @foreach ($comment->reply as $reply)
                                        <div class="post_comment_wrapper post_reply_wrapper">
                                            <div class="post_comment_item post_reply_item">
                                                <div class="post_comment_img post_reply_img">
                                                    <img src="{{ asset('uploads/profile_photo/default_profile.jpg') }}"
                                                        alt="img" class="w-50 p-1"
                                                        style="border: 1px solid black; border-radius: 5px">
                                                </div>
                                                <div class="post_comment_text">
                                                    <div class="post_names_replay">
                                                        <h5 class="mr-2">{{ $reply->name }} </h5>
                                                        @if ($reply->user_type == 'Admin')
                                                            <span class="badge bg-success ml-1">Admin</span>
                                                        @endif
                                                    </div>
                                                    <p>{{ $reply->comment }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Reply Modal -->
                                    <div class="modal fade" id="exampleModal{{ $comment->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Give a reply</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('submitReply') }}"
                                                        id="reply_form_{{ $comment->id }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="comment_id"
                                                            value="{{ $comment->id }}">
                                                        <div class="row">
                                                            <div class="col-12 mb-4">
                                                                <div class="form-group">
                                                                    <input type="text"
                                                                        class="form-control @error('full_name') is-invalid @enderror"
                                                                        placeholder="Enter full name" name="full_name"
                                                                        value="{{ old('full_name') }}" required>
                                                                    @error('full_name')
                                                                        <span class="invalid-feedback"
                                                                            role="alert"><strong>{{ $message }}</strong></span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mb-4">
                                                                <div class="form-group">
                                                                    <input type="email"
                                                                        class="form-control @error('email') is-invalid @enderror"
                                                                        placeholder="Enter email address" name="email"
                                                                        value="{{ old('email') }}" required>
                                                                    @error('email')
                                                                        <span class="invalid-feedback"
                                                                            role="alert"><strong>{{ $message }}</strong></span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mb-4">
                                                                <div class="form-group">
                                                                    <textarea rows="5" placeholder="Write your reply" class="form-control @error('reply') is-invalid @enderror"
                                                                        name="reply" required>{{ old('reply') }}</textarea>
                                                                    @error('reply')
                                                                        <span class="invalid-feedback"
                                                                            role="alert"><strong>{{ $message }}</strong></span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn_theme">Submit</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="comment_form_area">
                            <h3>Leave a comment</h3>
                            <div class="comment_form">
                                <form action="{{ route('submitComment') }}" id="comment_form" method="POST">
                                    @csrf
                                    <input type="hidden" name="blog_id" id="" value="{{ $blog_detail->id }}">
                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <div class="form-group">
                                                <input type="text" style="margin-bottom: 0px !important;"
                                                    class="form-control @error('full_name')
                                                    is-invalid
                                                @enderror"
                                                    placeholder="Enter full name" name="full_name"
                                                    value="{{ old('full_name') }}" required="">
                                                @error('full_name')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="form-group">
                                                <input type="email" style="margin-bottom: 0px !important;"
                                                    class="form-control @error('email')
                                                    is-invalid
                                                @enderror"
                                                    placeholder="Enter email address" name="email"
                                                    value="{{ old('email') }}" required="">
                                                @error('email')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-4">
                                            <div class="form-group">
                                                <textarea rows="5" placeholder="Write your comments" style="margin-bottom: 0px !important;"
                                                    class="form-control @error('comment')
                                                    is-invalid
                                                @enderror"
                                                    name="comment" required="">{{ old('comment') }}</textarea>
                                                @error('comment')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="submit_btn">
                                                <button class="btn btn_theme btn_md">Submit comment</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar_first">

                        <!-- Recent Causes -->
                        <div class="recent_causes_wrapper sidebar_boxed">
                            <div class="sidebar_heading_main">
                                <h3>Recent news</h3>
                            </div>
                            @foreach ($recent_news as $news)
                                <div class="recent_donet_item">
                                    <div class="recent_donet_img">
                                        <a href="{{ route('singleBlogPage', $news->id) }}"><img
                                                src="{{ asset('uploads/blog') }}/{{ $news->photo }}"
                                                alt="img"></a>
                                    </div>
                                    <div class="recent_donet_text">
                                        <div class="sidebar_inner_heading">
                                            <h4><a
                                                    href="{{ route('singleBlogPage', $news->id) }}">{{ $news->title }}</a>
                                            </h4>
                                        </div>
                                        <h6>{{ $news->created_at->format('d M, Y') }}</h6>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <!-- Popular tags -->
                        <div class="share_causes_wrapper sidebar_boxed">
                            <div class="sidebar_heading_main">
                                <h3>Popular tags</h3>
                            </div>
                            <div class="popular_tags">
                                <ul>
                                    @foreach ($tags as $tag)
                                        <li><a href="javascript:void(0)">{{ $tag }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
@endpush
