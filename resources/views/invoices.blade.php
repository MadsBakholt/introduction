@extends('layout')
<?php /** @var $invoices \App\Invoice[] */ ?>
<?php /** @var $customers \App\Customer[] */ ?>
@section('content')
    <h2>Invoices</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Due</th>
                <th>Amount</th>
                <th>Customer</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->invoice_no}}</td>
                <td>{{ $invoice->invoice_due_at }}</td>
                <td>{{ $invoice->amount}}</td>
                <td>{{ $customers[$invoice->invoice_no]->name }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection