<?php

namespace App\Http\Controllers;

use App\Agreement;
use App\Customer;
use App\Invoice;
use Illuminate\Support\Facades\View;

class InvoiceController
{
    public function index()
    {
        $customers = [];
        $invoices = Invoice::all();

        foreach ($invoices as $invoice){
            $agreement = Agreement::find($invoice->agreement_id);
            $customer = Customer::whereAgreement_id($agreement->id)->firstOrFail();
            $customers[$invoice->invoice_no] = $customer;
        }

        return View::make('invoices', compact('invoices'), compact('customers'));
    }
}