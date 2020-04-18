@extends('layout')
<?php /** @var $customer \App\Customer  */ ?>
<?php /** @var $invoices \App\Invoice[] */ ?>
@section('content')
    <h2>{{$customer->name}}</h2>
    <div>DKK{{$customer->agreement->amount}} {{$customer->agreement->type}}</div>
    <form method="get" action="/customer/invoice/{{$customer->id}}">
        <input type="submit" value="Invoice customer" />
    </form>

    <br />

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Due</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->invoice_no}}</td>
                <td>{{ $invoice->invoice_due_at }}</td>
                <td>{{ $invoice->amount}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection