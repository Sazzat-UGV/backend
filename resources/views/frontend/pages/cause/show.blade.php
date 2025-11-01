@extends('frontend.layouts.app')
@section('title')
Cause details
@endsection
@push('style')
@endpush
@section('content')
    @include('frontend.layouts.include.banner', [
        'page_name' => $cause->name,
        'subpage_name' => 'Cause details',
    ])
<section id="trending_causes_main" class="section_padding">
    <div class="container">
        <div class="row" id="counter">
            <div class="col-lg-8">
                <div class="details_wrapper_area">
                    <div class="details_big_img">
                        <img src="{{ asset('uploads/cause') }}/{{ $cause->featured_photo }}" alt="img">
                    </div>
                    <div class="details_skill_area">
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
                    <div class="details_text_wrapper">
                        <h2>{{ $cause->name }}</h2>
                        <p>
                            {!! $cause->description !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar_first">
                    <div class="recent_causes_wrapper sidebar_boxed">
                        <div class="sidebar_heading_main">
                            <h3>Donate Now</h3>
                        </div>
                        <form action="{{ route('causePayment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cause_id" value="{{ $cause->id }}">
                            <div class="register_now_details">
                                <div class="mb-3">
                                    <label for="" class="form-label">Enter Donation Amount<span class='text-danger'>*</span></label>
                                    <input type="number" class="form-control @error('amount')
                                        is-invalid
                                    @enderror" name="amount" required='' value="{{ old('amount') }}">
                                    @error('amount')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <select class="form-select @error('payment_method') is-invalid @enderror"
                                    name="payment_method" id="">
                                    <option value=""
                                        {{ old('payment_method') == '' ? 'selected' : '' }}>Select Payment
                                        Method</option>
                                    <option value="paypal"
                                        {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal
                                    </option>
                                    <option value="stripe"
                                        {{ old('payment_method') == 'stripe' ? 'selected' : '' }}>Stripe
                                    </option>
                                </select>
                                @error('payment_method')
                                <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                                </div>
                                <button class="btn btn_theme btn_md w-100">Donate Now</button>
                            </div>
                        </form>
                    </div>
                    <div class="sidebar_boxed">
                        <div class="sidebar_heading_main">
                            <h3>Information</h3>
                        </div>
                        <div class="event_details_list">
                            <ul>
                                <li>Goal: <span>{{ $cause->goal }}<b>$</b></span></li>
                                <li>Raised: <span>{{ $cause->raised }}<b>$</b></span></li>
                                <li>Remaining: <span>{{ $cause->goal-$cause->raised }}<b>$</b></span></li>
                                <li>Percentage: <span>{{ $perc }}%</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="project_recentdonet_wrapper sidebar_boxed">
                        <div class="sidebar_heading_main">
                            <h3>Recent Causes</h3>
                        </div>
                        @foreach ($recent_cause as $cause)
                        <div class="recent_donet_item">
                            <div class="recent_donet_img">
                                <a href="{{ route('singleCausePage',$cause->slug) }}"><img src="{{ asset('uploads/cause') }}/{{ $cause->featured_photo }}" alt="img"></a>
                            </div>
                            <div class="recent_donet_text">
                                <div class="sidebar_inner_heading">
                                    <h4><a href="{{ route('singleCausePage',$cause->slug) }}">Mike richard</a></h4>
                                </div>
                                <p>{{ $cause->name }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')

@endpush
