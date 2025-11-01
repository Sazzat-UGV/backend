<section id="common_banner_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="commn_banner_page">
                    <h2><span class="color_big_heading">{{ $page_name }}</span></h2>
                    <ul class="breadcrumb_wrapper">
                        <li class="breadcrumb_item"><a href="{{ route('homePage') }}">Home</a></li>
                        <li class="breadcrumb_item"><img src="{{ asset('assets/frontend') }}/img/icon/arrow.png"
                                alt="img"></li>
                        @if ($subpage_name != null)
                            <li class="breadcrumb_item"><span class="text-white">{{ $subpage_name }}</span></li>
                            <li class="breadcrumb_item"><img src="{{ asset('assets/frontend') }}/img/icon/arrow.png"
                                    alt="img"></li>
                        @endif
                        <li class="breadcrumb_item active">{{ $page_name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
