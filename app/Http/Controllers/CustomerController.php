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
        return View::make('customer', compact('customer'));
    }

    public function invoice($id)
    {
        $customer = Customer::findOrFail($id);
        // TODO: Create invoice for customer
        $agreement = $customer->agreement;
        $deliveries = $customer->deliveries;
        
        $cutOffDate = $agreement->type === Agreement::TYPE_WEEKLY ? Carbon::now()->subWeek() : Carbon::now()->subMonth();

        $deliveriesCount = 0;
        foreach ($deliveries as $delivery){
            if (Carbon::parse($delivery->delivered_at)->gte($cutOffDate)){
                $deliveriesCount += $delivery->count;
            }
        }

        $previousInvoice = Invoice::latest('invoice_no')->first();
        $invoiceNo = $previousInvoice == NULL ? 1 : $previousInvoice->invoice_no + 1;

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
