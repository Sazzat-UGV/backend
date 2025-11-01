@extends('backend.layouts.app')
@section('title')
    Donations
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
        'parent_page' => 'Cause',
        'page_name' => 'Donation',
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
                                <th>Cause Name</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cause_donation as $index => $donation)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td class="wrap">{{ $donation->created_at->diffForHumans() }}</td>
                                    <td class="wrap">{{ $donation->cause->name }}</td>
                                    <td class="wrap">{{ $donation->payment_method }}</td>
                                    <td class="wrap">{{ $donation->amount }}<b>$</b></td>
                                    <td>
                                        <a href="{{ route('userCauseDonationInvoice',$donation->id) }}"
                                            class="btn btn-dark position-relative p-0 avatar-xs rounded editModule-btn">
                                            <span class="avatar-title bg-transparent">
                                                <i class="bx bx-spreadsheet" style="font-size: 16px"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No data available in table</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection

@push('script')
@endpush
