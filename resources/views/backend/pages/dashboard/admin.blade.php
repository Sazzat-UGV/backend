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
                            <p class="text-muted fw-medium">Total Users</p>
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
                            <p class="text-muted fw-medium">Total Causes</p>
                            <h4 class="mb-0">{{ $total_cause }}</h4>
                        </div>

                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bx-diamond font-size-24"></i>
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
                            <p class="text-muted fw-medium">Total Events</p>
                            <h4 class="mb-0">{{ $total_event }}</h4>
                        </div>

                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bxs-calendar-event font-size-24"></i>
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
                            <p class="text-muted fw-medium">Total Testimonials</p>
                            <h4 class="mb-0">{{ $total_testimonial }}</h4>
                        </div>

                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bxs-user-badge font-size-24"></i>
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
                            <p class="text-muted fw-medium">Total Volunteers</p>
                            <h4 class="mb-0">{{ $total_volunteer }}</h4>
                        </div>

                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bxs-user-circle font-size-24"></i>
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
                            <p class="text-muted fw-medium">Total Subscribers</p>
                            <h4 class="mb-0">{{ $total_subscriber }}</h4>
                        </div>

                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bxs-user-detail font-size-24"></i>
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
                            <p class="text-muted fw-medium">Total Blog</p>
                            <h4 class="mb-0">{{ $total_blog }}</h4>
                        </div>

                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bxs-news font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Monthly Earnings</h4>
                    <canvas id="monthlyStats" width="800"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card pb-4">
                <div class="card-body">
                    <h4 class="card-title mb-4">Total Earnings</h4>
                    <canvas id="totalEarning" height="500"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const barCtx = document.getElementById('monthlyStats');

        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($monthlyData->toArray())) !!},
                datasets: [
                    {
                        label: 'Tickets Sold (in USD)',
                        data: {!! json_encode($monthlyData->pluck('tickets')->values()) !!},
                        backgroundColor: '#34C38F',
                        borderWidth: 1
                    },
                    {
                        label: 'Donations (in USD)',
                        data: {!! json_encode($monthlyData->pluck('donations')->values()) !!}, // Donation data
                        backgroundColor: '#556EE6',
                        borderWidth: 1
                    }
                ]

            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const pieCtx = document.getElementById('totalEarning');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: [
                    'Tickets',
                    'Donation',
                ],
                datasets: [{
                    label: 'Total Earnings',
                    data: [{{ $ticket_booked_amount }}, {{ $donation_amount }}],
                    backgroundColor: [
                        '#34C38F',
                        '#556EE6',
                    ],
                    hoverOffset: 4
                }]
            }
        });
    </script>
@endpush
