@extends('backend.layouts.app')
@section('title')
    Invoice
@endsection
@push('style')
@endpush
@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Invoices',
        'page_name' => 'Detail',
    ])
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-16">Order #{{ $TicketInvoice->payment_id }}</h4>
                        <div class="auth-logo mb-4">
                            <img src="{{ asset('uploads/settings') }}/{{ $setting->site_logo }}" alt="logo"
                                class="auth-logo-dark" height="30">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <address>
                                <strong>Billed To:</strong><br>
                                {{ $billed_to->first_name }} {{ $billed_to->last_name ?? ' ' }}<br>
                                {{ $billed_to->email }}<br>
                                {{ $billed_to->phone }}<br>
                                {{ $billed_to->address }}<br>
                            </address>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <address class="mt-2 mt-sm-0">
                                <strong>Shipped To:</strong><br>
                                {{ $TicketInvoice->user->first_name }} {{ $TicketInvoice->user->last_name ?? ' ' }}<br>
                                {{ $TicketInvoice->user->email }}<br>
                                {{ $TicketInvoice->user->phone }}<br>
                                {{ $TicketInvoice->user->address }}<br>
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mt-3">
                            <address>
                                <strong>Payment Method:</strong><br>
                                {{ $TicketInvoice->payment_method }}<br>
                            </address>
                        </div>
                        <div class="col-sm-6 mt-3 text-sm-end">
                            <address>
                                <strong>Order Date:</strong><br>{{ $TicketInvoice->created_at->format('F d, Y') }}<br><br>
                            </address>
                        </div>
                    </div>
                    <div class="py-2 mt-3">
                        <h3 class="font-size-15 fw-bold">Order summary</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">No.</th>
                                    <th>Item</th>
                                    <th class="text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>{{ $TicketInvoice->event->name }}</td>
                                    <td class="text-end">{{ $TicketInvoice->unit_price }}$</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end">No of Tikets</td>
                                    <td class="text-end">{{ $TicketInvoice->number_of_tickets }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border-0 text-end">
                                        <strong>Total</strong>
                                    </td>
                                    <td class="border-0 text-end">
                                        <h4 class="m-0">{{ $TicketInvoice->total_price }}$</h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i
                                    class="fa fa-print"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
