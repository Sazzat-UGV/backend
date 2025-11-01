<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="waves-effect @if (Route::is('admin.dashboard')) active @endif">
                        <i class="bx bx-home-circle"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if (Auth::user()->role->name == 'User')
                    <li>
                        <a href="{{ route('userEventTicket') }}"
                            class="waves-effect">
                            <i class="bx bxs-calendar-event"></i>
                            <span>Event Ticket</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('userCauseDonation') }}"
                            class="waves-effect">
                            <i class="bx bx-diamond"></i>
                            <span>Cause Donation</span>
                        </a>
                    </li>
                @endif
                @can('browse-blog-category')
                    <li>
                        <a href="{{ route('admin.category.index') }}"
                            class="waves-effect @if (Route::is('admin.category.index')) active @endif">
                            <i class="bx bx-box"></i>
                            <span>Blog Categories</span>
                        </a>
                    </li>
                @endcan
                @can('browse-slider')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-slider"></i>
                            <span>Sliders</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('browse-slider')
                                <li class="@if (Route::is('admin.slider.index')) mm-active @endif"><a
                                        href="{{ route('admin.slider.index') }}"
                                        class="@if (Route::is('admin.slider.index')) active @endif">Slider List</a></li>
                            @endcan
                            @can('add-slider')
                                <li class="@if (Route::is('admin.slider.create')) mm-active @endif"><a
                                        href="{{ route('admin.slider.create') }}"
                                        class="@if (Route::is('admin.slider.create')) active @endif">Add New Slider</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('browse-feature')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-collection"></i>
                            <span>Features</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('browse-feature')
                                <li class="@if (Route::is('admin.feature.index')) mm-active @endif"><a
                                        href="{{ route('admin.feature.index') }}"
                                        class="@if (Route::is('admin.feature.index')) active @endif">Feature List</a></li>
                            @endcan
                            @can('add-feature')
                                <li class="@if (Route::is('admin.feature.create')) mm-active @endif"><a
                                        href="{{ route('admin.feature.create') }}"
                                        class="@if (Route::is('admin.feature.create')) active @endif">Add New Feature</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('browse-testimonial')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-user-badge"></i>
                            <span>Testimonials</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('browse-testimonial')
                                <li class="@if (Route::is('admin.testimonial.index')) mm-active @endif"><a
                                        href="{{ route('admin.testimonial.index') }}"
                                        class="@if (Route::is('admin.testimonial.index')) active @endif">Testimonial List</a></li>
                            @endcan
                            @can('add-testimonial')
                                <li class="@if (Route::is('admin.testimonial.create')) mm-active @endif"><a
                                        href="{{ route('admin.testimonial.create') }}"
                                        class="@if (Route::is('admin.testimonial.create')) active @endif">Add New Testimonial</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('browse-blog')
                    <li>
                        <a href="javascript: void(0);"
                            class="has-arrow waves-effect @if (Route::is('admin.browseComment') || Route::is('admin.browseReply')) mm-active @endif">
                            <i class="bx bxs-news"></i>
                            <span>Blogs</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('browse-blog')
                                <li class="@if (Route::is('admin.blog.index')) mm-active @endif"><a
                                        href="{{ route('admin.blog.index') }}"
                                        class="@if (Route::is('admin.blog.index')) active @endif">Blog List</a></li>
                            @endcan
                            @can('add-blog')
                                <li class="@if (Route::is('admin.blog.create')) mm-active @endif"><a
                                        href="{{ route('admin.blog.create') }}"
                                        class="@if (Route::is('admin.blog.create')) active @endif">Add New Blog</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('browse-event')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-calendar-event"></i>
                            <span>Events</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('browse-event')
                                <li class="@if (Route::is('admin.event.index')) mm-active @endif"><a
                                        href="{{ route('admin.event.index') }}"
                                        class="@if (Route::is('admin.event.index')) active @endif">Event List</a></li>
                            @endcan
                            @can('add-event')
                                <li class="@if (Route::is('admin.event.create')) mm-active @endif"><a
                                        href="{{ route('admin.event.create') }}"
                                        class="@if (Route::is('admin.event.create')) active @endif">Add New Event</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('browse-cause')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-diamond"></i>
                            <span>Causes</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('browse-cause')
                                <li class="@if (Route::is('admin.cause.index')) mm-active @endif"><a
                                        href="{{ route('admin.cause.index') }}"
                                        class="@if (Route::is('admin.cause.index')) active @endif">Cause List</a></li>
                            @endcan
                            @can('add-cause')
                                <li class="@if (Route::is('admin.cause.create')) mm-active @endif"><a
                                        href="{{ route('admin.cause.create') }}"
                                        class="@if (Route::is('admin.cause.create')) active @endif">Add New Cause</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('browse-faqs')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-message-dots"></i>
                            <span>FAQs</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('browse-faqs')
                                <li class="@if (Route::is('admin.faqs.index')) mm-active @endif"><a
                                        href="{{ route('admin.faqs.index') }}"
                                        class="@if (Route::is('admin.faqs.index')) active @endif">FAQ List</a></li>
                            @endcan
                            @can('add-faqs')
                                <li class="@if (Route::is('admin.faqs.create')) mm-active @endif"><a
                                        href="{{ route('admin.faqs.create') }}"
                                        class="@if (Route::is('admin.faqs.create')) active @endif">Add New FAQ</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('browse-volunteer')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-user-circle"></i>
                            <span>Volunteers</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('browse-volunteer')
                                <li class="@if (Route::is('admin.volunteer.index')) mm-active @endif"><a
                                        href="{{ route('admin.volunteer.index') }}"
                                        class="@if (Route::is('admin.volunteer.index')) active @endif">Volunteer List</a></li>
                            @endcan
                            @can('add-volunteer')
                                <li class="@if (Route::is('admin.volunteer.create')) mm-active @endif"><a
                                        href="{{ route('admin.volunteer.create') }}"
                                        class="@if (Route::is('admin.volunteer.create')) active @endif">Add New Volunteer</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('browse-subscriber')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-user-detail"></i>
                            <span>Subscribers</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('browse-subscriber')
                                <li class="@if (Route::is('admin.subscriber.index')) mm-active @endif"><a
                                        href="{{ route('admin.subscriber.index') }}"
                                        class="@if (Route::is('admin.volunteer.index')) active @endif">Subscriber List</a></li>
                            @endcan
                            @can('send-message-to-all')
                                <li class="@if (Route::is('admin.subscriber.sendMessagePage')) mm-active @endif"><a
                                        href="{{ route('admin.subscriber.sendMessagePage') }}"
                                        class="@if (Route::is('admin.subscriber.sendMessagePage')) active @endif">Send Message to All</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('edit-special-section')
                    <li>
                        <a href="{{ route('admin.editSpecial') }}"
                            class="waves-effect @if (Route::is('admin.editSpecial')) active @endif">
                            <i class="bx bxs-hand-right"></i>
                            <span>Special Section</span>
                        </a>
                    </li>
                @endcan
                @can('browse-gallery')
                    <li>
                        <a href="{{ route('admin.gallery.index') }}"
                            class="waves-effect @if (Route::is('admin.gallery.index') || Route::is('admin.gallery.create')) active @endif">
                            <i class="bx bxs-photo-album"></i>
                            <span>Galleries</span>
                        </a>
                    </li>
                @endcan
                @can('edit-counter')
                    <li>
                        <a href="{{ route('admin.editCounter') }}"
                            class="waves-effect @if (Route::is('admin.editCounter')) active @endif">
                            <i class="bx bxs-hand-right"></i>
                            <span>Counter</span>
                        </a>
                    </li>
                @endcan

                @can('browse-user')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-user"></i>
                            <span>Users</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('browse-user')
                                <li class="@if (Route::is('admin.user.index')) mm-active @endif"><a
                                        href="{{ route('admin.user.index') }}"
                                        class="@if (Route::is('admin.user.index')) active @endif">User List</a></li>
                            @endcan
                            @can('add-user')
                                <li class="@if (Route::is('admin.user.create')) mm-active @endif"><a
                                        href="{{ route('admin.user.create') }}"
                                        class="@if (Route::is('admin.user.create')) active @endif">Add New User</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('browse-module')
                    <li>
                        <a href="{{ route('admin.module.index') }}"
                            class="waves-effect @if (Route::is('admin.module.index')) active @endif">
                            <i class="bx bx-cube"></i>
                            <span>Modules</span>
                        </a>
                    </li>
                @endcan

                @can('browse-permission')
                    <li>
                        <a href="{{ route('admin.permission.index') }}"
                            class="waves-effect @if (Route::is('admin.permission.index')) active @endif">
                            <i class="bx bx-shield-quarter"></i>
                            <span>Permissions</span>
                        </a>
                    </li>
                @endcan

                @can('browse-role')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-group"></i>
                            <span>Roles</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('browse-role')
                                <li class="@if (Route::is('admin.role.index')) mm-active @endif"><a
                                        href="{{ route('admin.role.index') }}"
                                        class="@if (Route::is('admin.role.index')) active @endif">Role List</a></li>
                            @endcan
                            @can('add-role')
                                <li class="@if (Route::is('admin.role.create')) mm-active @endif"><a
                                        href="{{ route('admin.role.create') }}"
                                        class="@if (Route::is('admin.role.create')) active @endif">Add New Role</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @if (Auth::user()->haspermission('general-setting') || Auth::user()->haspermission('email-configuration'))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-cog"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('general-setting')
                                <li class="@if (Route::is('admin.general_setting_page')) mm-active @endif"><a
                                        href="{{ route('admin.general_setting_page', ['stage' => 'site']) }}"
                                        class="@if (Route::is('admin.general_setting_page')) active @endif">General Setting</a></li>
                            @endcan
                            @can('email-configuration')
                                <li class="@if (Route::is('admin.email_configuration_page')) mm-active @endif"><a
                                        href="{{ route('admin.email_configuration_page') }}"
                                        class="@if (Route::is('admin.email_configuration_page')) active @endif">Email Configuration</a>
                                </li>
                            @endcan
                            @can('terms-conditions')
                                <li class="@if (Route::is('admin.termscondition.termsConditionPage')) mm-active @endif"><a
                                        href="{{ route('admin.termscondition.termsConditionPage') }}"
                                        class="@if (Route::is('admin.termscondition.termsConditionPage')) active @endif">Terms & Conditions</a>
                                </li>
                            @endcan
                            @can('privacy-policy')
                                <li class="@if (Route::is('admin.privacypolicy.privacyPolicyPage')) mm-active @endif"><a
                                        href="{{ route('admin.privacypolicy.privacyPolicyPage') }}"
                                        class="@if (Route::is('admin.privacypolicy.privacyPolicyPage')) active @endif">Privacy Policy</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                @can('browse-database-backup')
                    <li>
                        <a href="{{ route('admin.backup.index') }}"
                            class="waves-effect  @if (Route::is('admin.backup.index')) active @endif">
                            <i class="bx bx-data"></i>
                            <span>Database Backup</span>
                        </a>
                    </li>
                @endcan

            </ul>
        </div>
    </div>
</div>
