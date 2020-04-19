<?php

namespace App\Http\Controllers;

use App\Agreement;
use App\Customer;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return View::make('customers', compact('customers'));
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        $agreement = Agreement::findOrFail($customer->agreement_id);
        $invoices = Invoice::whereAgreement_id($agreement->id)->get();

        return View::make('customer', compact('customer'), compact('invoices'));
    }

    public function invoice($id)
    {
        $customer = Customer::findOrFail($id);

        $agreement = $customer->agreement;
        $deliveries = $customer->deliveries;
        
        $cutOffDate = $agreement->type === Agreement::TYPE_WEEKLY ? Carbon::now()->subWeek() : Carbon::now()->subMonth();

        // Sum all deliveries matching cutoff date criteria...
        $deliveriesCount = 0;
        foreach ($deliveries as $delivery){
            if (Carbon::parse($delivery->delivered_at)->gte($cutOffDate)){
                $deliveriesCount += $delivery->count;
            }
        }

        // Calculate legal invoice sequence number from database lookups...
        $previousInvoice = Invoice::latest('invoice_no')->first();
        $invoiceNo = $previousInvoice == NULL ? 1 : $previousInvoice->invoice_no + 1;

        // TODO: MadsBakholt
        // Should probably prevent invoicing action if previous (last) invoice has already
        // been executed within period per agreement, ie.:
        // if last invoice 'created_at' is '=> now() - week/month' then skip current invoice
        // creation - followed up by a proper message.
        $invoice = factory(Invoice::class)->create([
            'agreement_id' => $customer->agreement_id,
            'invoice_no' => $invoiceNo,
            'invoice_due_at' => Carbon::now()->addWeek(),
            'amount' => $deliveriesCount * $agreement->unit_price,
        ]);
        $invoice->save();

        return Redirect::action(class_basename(self::class).'@show',['id' => $id]);
    }
}
