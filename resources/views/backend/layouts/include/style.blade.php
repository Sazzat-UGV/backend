<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('uploads/settings') }}/{{ $setting->site_favicon }}">
<!-- Bootstrap Css -->
<link href="{{ asset('assets/backend') }}/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ asset('assets/backend') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ asset('assets/backend') }}/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{ asset('assets/backend') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/backend') }}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('assets/backend') }}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- select2 css -->
<link href="{{ asset('assets/backend') }}/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

@stack('style')
