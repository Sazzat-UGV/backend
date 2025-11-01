@extends('backend.layouts.app')
@section('title')
    Dashboard
@endsection
@push('style')
    <style>
        .wrap {
            white-space: normal !important;
            word-wrap: break-word;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-12 col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total User</p>
                            <h4 class="mb-0">{{ $total_user }}</h4>
                        </div>

                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bx-user font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total Admin</p>
                            <h4 class="mb-0">{{ $total_admin }}</h4>
                        </div>

                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bx-user font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total Role</p>
                            <h4 class="mb-0">{{ $role->whereNot('id', 1)->count() }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center ">
                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-user font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Active Role</p>
                            <h4 class="mb-0">{{ $role->whereNot('id', 1)->where('status', 1)->count() }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center ">
                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-user font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Latest Users</h4>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">Registered At</th>
                                    <th class="align-middle">Name</th>
                                    <th class="align-middle">Role</th>
                                    <th class="align-middle">Email</th>
                                    @can('read-user')
                                    <th class="align-middle">View Details</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($new_register_users as $index => $user)
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                        <td class="wrap">{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td><span class="badge rounded-pill badge-soft-success px-2"
                                                style="font-size: 12px">{{ $user->role->name }}</span>
                                        </td>
                                        <td class="wrap">{{ $user->email }}</td>
                                        @can('read-user')
                                        <td>
                                            <a href="{{ route('admin.user.show', $user->id) }}"
                                                class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                View Details
                                            </a>
                                        </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
