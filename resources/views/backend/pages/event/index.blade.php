@extends('backend.layouts.app')
@section('title')
    Events
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
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Events',
        'page_name' => 'Event List',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-event')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.event.create') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New Event</a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <form action="{{ route('admin.event.index') }}" method="GET">
                        <div class="row d-flex justify-content-end">
                            <div class="col-auto mb-4 d-flex">
                                <input class="form-control me-2" type="text" placeholder="Search" name="search"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <i class="bx bx-search font-size-16 align-middle"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <table id="datatabl" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Created At</th>
                                <th>Photo</th>
                                <th>Event Name</th>
                                <th>Date & Time</th>
                                <th>Price</th>
                                <th>Total/Booked Seat</th>
                                @if (Auth::user()->haspermission('edit-event') ||
                                        Auth::user()->haspermission('read-event') ||
                                        Auth::user()->haspermission('event-ticket') ||
                                        Auth::user()->haspermission('delete-event'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($events as $index => $event)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $event->created_at->diffForHumans() }}</td>
                                    <td><img src="{{ asset('uploads/event') }}/{{ $event->featured_photo }}"
                                            alt="Event Photo" class="rounded" style="max-height:100px"></td>
                                    <td class="wrap">{{ $event->name }}</td>
                                    <td>
                                        <div><b>Date: </b>{{ $event->date }}</div>
                                        <div><b>Time: </b>{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</div>
                                    </td>


                                    <td>{{ $event->price }}<b>$</b></td>
                                    <td><span class="badge bg-success">{{ $event->total_seat }}</span>/<span
                                            class="badge bg-danger">{{ $event->booked_seat }}</span></td>
                                    @if (Auth::user()->haspermission('edit-event') ||
                                            Auth::user()->haspermission('read-event') ||
                                            Auth::user()->haspermission('event-ticket') ||
                                            Auth::user()->haspermission('delete-event'))
                                        <td>
                                            @can('edit-event')
                                                <a href="{{ route('admin.event.edit', $event->id) }}"
                                                    class="btn btn-warning position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-edit" style="font-size: 16px"></i>
                                                    </span>
                                                </a>
                                            @endcan
                                            @can('read-event')
                                                <a href="{{ route('admin.event.show', $event->id) }}"
                                                    class="btn btn-info position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-show" style="font-size: 16px"></i>
                                                    </span>
                                                </a>
                                            @endcan
                                            @can('delete-event')
                                                <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST"
                                                    class="btn btn-danger position-relative p-0 avatar-xs rounded">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger position-relative p-0 avatar-xs rounded show_confirm">
                                                        <span class="avatar-title bg-transparent">
                                                            <i class="bx bx-trash" style="font-size: 16px"></i>
                                                        </span>
                                                    </button>
                                                </form>
                                            @endcan
                                            @php
                                                $tickets = App\Models\EventTicket::where(
                                                    'event_id',
                                                    $event->id,
                                                )->count();
                                            @endphp
                                            @if ($tickets > 0)
                                                @can('event-ticket')
                                                    <a href="{{ route('admin.eventTicketPage', $event->id) }}"
                                                        class="btn btn-dark position-relative p-0 avatar-xs rounded editModule-btn">
                                                        <span class="avatar-title bg-transparent">
                                                            <i class="bx bx-money" style="font-size: 16px"></i>
                                                        </span>
                                                    </a>
                                                @endcan
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No data available in table</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $events->links('vendor.pagination.admin_dashboard') }}
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection

@push('script')
    <script>
        $(document).on('click', '.show_confirm', function(event) {
            event.preventDefault();
            var form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
