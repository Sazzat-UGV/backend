<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ $setting->site_name ?? config('app.name') }}</title>
    @include('backend.layouts.include.style')

</head>

<body data-sidebar="dark">
    <div id="layout-wrapper">
        @include('backend.layouts.include.header')
        @include('backend.layouts.include.sidebar')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('backend.layouts.include.footer')
        </div>
    </div>
    @include('backend.layouts.include.script')
</body>

</html>
