@extends('backend.layouts.app')
@section('title')
    Tickets
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
        'page_name' => 'Tickets',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Created at</th>
                                <th>User</th>
                                <th>Payment ID</th>
                                <th>Unit Price</th>
                                <th>No of Ticket</th>
                                <th>Total Price</th>
                                <th>Payment Method</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_ticket = 0; 
                            @endphp
                            @forelse ($eventTicket as $index => $ticket)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td class="wrap">{{ $ticket->created_at->diffForHumans() }}</td>
                                    <td class="">
                                        <span><b>Name:</b> {{ $ticket->user->first_name }}
                                            {{ $ticket->user->last_name }}</span><br>
                                        <span><b>Email:</b> {{ $ticket->user->email }}</span><br>
                                        @if ($ticket->user->phone)
                                            <span><b>Phone:</b> {{ $ticket->user->phone }}</span><br>
                                        @endif
                                        @if ($ticket->user->address)
                                            <span><b>Address:</b> {{ $ticket->user->address }}</span><br>
                                        @endif
                                    </td>
                                    <td class="wrap">{{ $ticket->payment_id }}</td>
                                    <td class="wrap">{{ $ticket->unit_price }} <b>$</b></td>
                                    <td class="wrap">{{ $ticket->number_of_tickets }}</td>
                                    <td class="wrap">{{ $ticket->total_price }} <b>$</b></td>
                                    <td class="wrap">{{ $ticket->payment_method }}</td>
                                    <td>
                                        <a href="{{ route('admin.eventTicketInvoice',$ticket->id) }}"
                                            class="btn btn-dark position-relative p-0 avatar-xs rounded editModule-btn">
                                            <span class="avatar-title bg-transparent">
                                                <i class="bx bx-spreadsheet" style="font-size: 16px"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                @php
                                    $total_ticket += $ticket->number_of_tickets;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No data available in table</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tr>
                            <td colspan="5" style="text-align: right"><b>Total Tickets: </b></td>
                            <td colspan="4"><b>{{ $total_ticket }}</b></td>
                        </tr>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection

@push('script')
@endpush
