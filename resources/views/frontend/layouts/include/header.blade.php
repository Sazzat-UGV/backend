<header class="main_header_arae">

    <!-- Navbar Bar -->
    <div class="navbar-area">
        <div class="main-responsive-nav">
            <div class="container">
                <div class="main-responsive-menu">
                    <div class="logo">
                        <a href="{{ route('homePage') }}">
                            <img src="{{ asset('uploads/settings') }}/{{ $setting->site_logo }}" alt="logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-navbar">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <a class="navbar-brand" href="{{ route('homePage') }}">
                        <img src="{{ asset('uploads/settings') }}/{{ $setting->site_logo }}" alt="logo">
                    </a>
                    <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="{{ route('homePage') }}"
                                    class="nav-link {{ Route::is('homePage') ? 'active' : '' }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('aboutPage') }}"
                                    class="nav-link {{ Route::is('aboutPage') ? 'active' : '' }}">About</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('eventPage') }}"
                                    class="nav-link {{ Route::is('eventPage') || Route::is('singleEventPage') ? 'active' : '' }}">Events</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('causePage') }}"
                                    class="nav-link {{ Route::is('causePage') || Route::is('singleCausePage') ? 'active' : '' }}">Causes</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('volunteerPage') }}"
                                    class="nav-link {{ Route::is('volunteerPage') ? 'active' : '' }}">Volunteers</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('galleryPage') }}"
                                    class="nav-link {{ Route::is('galleryPage') ? 'active' : '' }}">Gallery</a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('faqPage') }}"
                                    class="nav-link {{ Route::is('faqPage') ? 'active' : '' }}">FAQ</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('blogPage') }}"
                                    class="nav-link {{ Route::is('blogPage') || Route::is('singleBlogPage') ? 'active' : '' }}">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('contactPage') }}"
                                    class="nav-link {{ Route::is('contactPage') ? 'active' : '' }}">Contact</a>
                            </li>

                        </ul>
                        <div class="others-options d-flex align-items-center">

                            <div class="option-item">
                                @auth
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn_navber">Dashboard</a>
                                @endauth
                                @guest
                                    <a href="{{ route('login') }}" class="btn btn_navber">Login</a>
                                    <a href="{{ route('register') }}" class="btn btn_navber">Register</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="others-option-for-responsive">
            <div class="container">
                <div class="dot-menu">
                    <div class="inner">
                        <div class="circle circle-one"></div>
                        <div class="circle circle-two"></div>
                        <div class="circle circle-three"></div>
                    </div>
                </div>
                <div class="container">
                    <div class="option-inner">
                        <div class="others-options d-flex align-items-center">
                            <div class="option-item">
                                @auth
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn_navber">Dashboard</a>
                                @endauth
                                @guest
                                    <a href="{{ route('login') }}" class="btn btn_navber">Login</a>
                                    <a href="{{ route('register') }}" class="btn btn_navber">Register</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
