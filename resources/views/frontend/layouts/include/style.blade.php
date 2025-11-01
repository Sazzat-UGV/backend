    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/bootstrap.min.css">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/animate.min.css">
    <!-- Fontawesome css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/fontawesome.all.min.css">
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/owl.carousel.min.css">
    <!-- owl.theme.default css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/owl.theme.default.min.css">
    <!-- Magnific popup css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/magnific-popup.min.css">
    <!-- navber css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/navber.css">
    <!-- meanmenu css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/meanmenu.css">
    <!-- Style css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/responsive.css">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('uploads/settings') }}/{{ $setting->site_favicon }}">

    <style>
        #common_banner_area {
            background-image: url("{{ asset('uploads/settings/' . $setting->breadcrumb_image) }}");
            background-size: cover;
            background-position: center;
            padding: 145px 0;
        }
    </style>


    @stack('style')
