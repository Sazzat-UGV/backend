<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title') | {{ $setting->site_name ?? config('app.name') }}</title>
    @include('frontend.layouts.include.style')
</head>

<body>
    @include('frontend.layouts.include.preloader')
    @include('frontend.layouts.include.header')

    @yield('content')

    @include('frontend.layouts.include.script')
    @include('frontend.layouts.include.footer')
    @include('frontend.layouts.include.copyright')

    <div class="go-top">
        <i class="fas fa-chevron-up"></i>
        <i class="fas fa-chevron-up"></i>
    </div>

    @include('frontend.layouts.include.script')
</body>

</html>
