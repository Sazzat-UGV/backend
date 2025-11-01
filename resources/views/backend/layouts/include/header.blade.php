<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('uploads/settings') }}/{{ $setting->site_favicon }}" alt="" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('uploads/settings') }}/{{ $setting->site_logo }}" alt="" height="35">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <a href="{{ route('homePage') }}" class="btn btn-danger rounded-pill px-4">Home Page</a>
            </form>

        </div>

        <div class="d-flex">

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect d-flex align-items-center"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img class="rounded-circle header-profile-user"
                        src="{{ asset('uploads/profile_photo') }}/{{ Auth::user()->profile_photo }}"
                        alt="Profile Picture">
                    <div class="d-none d-xl-inline-block ms-2 text-start">
                        <span key="t-henry">{{ Auth::user()->first_name }}
                            {{ Auth::user()->last_name ?? '' }}</span>
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            {{ Auth::user()->role->name ?? '' }}
                        </p>
                    </div>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block ms-2"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('admin.profile_page') }}"><i
                            class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">My
                            Profile</span></a>
                    <a class="dropdown-item d-block" href="{{ route('admin.change_password_page') }}"><i
                            class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Change
                            Password</span></a>
                    <div class="dropdown-divider"></div>

                    <form action="{{ route('admin.logout') }}" method="POST" id="logout" class="dropdown-item">
                        @csrf
                        <button type="submit"
                            style="border: none; background: none; cursor: pointer; padding: 0; color: inherit; text-align: left; width: 100%;">
                            <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i><span
                                key="t-logout" class="text-danger">Logout</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
