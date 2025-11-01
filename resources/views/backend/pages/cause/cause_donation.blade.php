@extends('backend.layouts.app')
@section('title')
    Cause Donation
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
        'parent_page' => 'Causes',
        'page_name' => 'Cause Donation',
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
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_donate = 0;
                            @endphp
                            @forelse ($causeDonation as $index => $donation)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td class="wrap">{{ $donation->created_at->diffForHumans() }}</td>
                                    <td class="">
                                        <span><b>Name:</b> {{ $donation->user->first_name }}
                                            {{ $donation->user->last_name }}</span><br>
                                        <span><b>Email:</b> {{ $donation->user->email }}</span><br>
                                        @if ($donation->user->phone)
                                            <span><b>Phone:</b> {{ $donation->user->phone }}</span><br>
                                        @endif
                                        @if ($donation->user->address)
                                            <span><b>Address:</b> {{ $donation->user->address }}</span><br>
                                        @endif
                                    </td>
                                    <td class="wrap">{{ $donation->payment_id }}</td>
                                    <td class="wrap">{{ $donation->amount }}<b>$</b></td>
                                    <td class="wrap">{{ $donation->payment_method }}</td>
                                    <td>
                                        <a href="{{ route('admin.causeDonationInvoice', $donation->id) }}"
                                            class="btn btn-dark position-relative p-0 avatar-xs rounded editModule-btn">
                                            <span class="avatar-title bg-transparent">
                                                <i class="bx bx-spreadsheet" style="font-size: 16px"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                @php
                                    $total_donate += $donation->amount;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No data available in table</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tr>
                            <td colspan="4" style="text-align: right"><b>Total Donation: </b></td>
                            <td colspan="2"><b>{{ $total_donate }}$</b></td>
                        </tr>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection

@push('script')
@endpush
