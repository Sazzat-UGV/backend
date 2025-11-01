@extends('backend.layouts.app')
@section('title')
    User Profile
@endsection
@push('style')
    <style>
        .profile-card-background {
            background-image: url("{{ asset('uploads/cover_photo') }}/{{ $user->cover_photo }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .profile-card-background .card-body {
            background-color: #4a4a4a39;
        }

        .user-info-list.no-bio {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .user-info-list.no-bio li {
            flex: 1;
            min-width: 200px;
        }

        .user-info-list.has-bio li {
            margin-bottom: 15px;
        }

        .user-info-list.no-bio {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 15px;
        }

        .user-info-list.no-bio li {
            flex: 1 1 30%;
            min-width: 200px;
        }

        .user-info-list li {
            word-break: break-word;
        }

        @media (max-width: 768px) {
            .user-info-list.no-bio {
                flex-direction: column;
                align-items: flex-start;
            }

            .user-info-list.no-bio li {
                flex: unset;
                min-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .profile-card-background {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .user-info-list.no-bio {
                flex-direction: column;
            }

            .user-info-list.no-bio li {
                flex: unset;
                min-width: 100%;
            }
        }

        @media (max-width: 576px) {
            .avatar-lg {
                width: 100px;
                height: 100px;
            }
        }
    </style>
@endpush

@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Users',
        'page_name' => 'User Profile',
    ])
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card profile-card-background mx-n4 mt-n4">
                <div class="card-body">
                    @can('browse-user')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="">
                                    <a href="{{ route('admin.user.index') }}"
                                        class="btn btn-secondary btn-rounded waves-effect waves-light addContact-modal mb-2">
                                        <i class="mdi mdi-arrow-left me-1"></i> Back to Users
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <div class="text-center mb-4">
                        <img src="{{ asset('uploads/profile_photo') }}/{{ $user->profile_photo }}" alt="User Photo"
                            class="avatar-lg rounded-circle mx-auto d-block"
                            style="border: 3px solid #FABC3F; background-color: white">
                        <h2 class="mt-3 mb-1" style="font-weight: 600;">{{ $user->first_name }} {{ $user->last_name }}</h2>
                        <h6 class="mb-3" style="font-weight: 600;">{{ $user->role->name }}</h6>
                        <div class="mx-auto">
                            @if ($user->status == 1)
                                <span class="badge text-bg-success px-2 py-1" style="font-size: 11px">Active</span>
                            @else
                                <span class="badge text-bg-danger px-2 py-1" style="font-size: 11px">Deactive</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <ul class="list-unstyled hstack gap-3 mb-0 flex-grow-1">
                            @if ($user->country)
                                <li>
                                    <i class="bx bx-map align-middle" style="font-weight: 600;"></i>
                                    <span class="mb-3" style="font-weight: 600;">{{ $user->country }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="{{ $user->bio ? 'col-lg-3' : 'col-lg-12' }}">
            <div class="card">
                <div class="card-body">

                    <ul class="list-unstyled user-info-list {{ $user->bio ? 'has-bio' : 'no-bio' }}">
                        <li>
                            <div class="d-flex">
                                <i class="bx bx-envelope font-size-18 text-primary"></i>
                                <div class="ms-3">
                                    <h6 class="mb-1 fw-semibold">Email:</h6>
                                    <span class="text-muted">{{ $user->email }}</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex">
                                <i class="bx bx-phone-call font-size-18 text-primary"></i>
                                <div class="ms-3">
                                    <h6 class="mb-1 fw-semibold">Phone:</h6>
                                    <span class="text-muted">{{ $user->phone }}</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex">
                                <i class="bx bx-map-pin font-size-18 text-primary"></i>
                                <div class="ms-3">
                                    <h6 class="mb-1 fw-semibold">Address:</h6>
                                    <span class="text-muted">{{ $user->address }}</span>
                                </div>
                            </div>
                        </li>
                        @if ($user->date_of_birth)
                            <li>
                                <div class="d-flex">
                                    <i class="bx bx-calendar font-size-18 text-primary"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-1 fw-semibold">Date of Birth:</h6>
                                        {{ $user->date_of_birth }}
                                    </div>
                                </div>
                            </li>
                        @endif
                        @if ($user->postal_code)
                            <li>
                                <div class="d-flex">
                                    <i class="mdi mdi-post-outline font-size-18 text-primary"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-1 fw-semibold">Postal Code:</h6>
                                        <span class="text-muted">{{ $user->postal_code }}</span>
                                    </div>
                                </div>
                            </li>
                        @endif
                        @if ($user->city)
                            <li>
                                <div class="d-flex">
                                    <i class="mdi mdi-city font-size-18 text-primary"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-1 fw-semibold">City:</h6>
                                        <span class="text-muted">{{ $user->city }}</span>
                                    </div>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        @if ($user->bio)
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Bio</h5>
                        <p class="text-muted">{{ $user->bio }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('script')
@endpush
