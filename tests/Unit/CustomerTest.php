<?php

namespace Tests\Unit;

use App\Agreement;
use App\Customer;
use App\Delivery;
use App\Invoice;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomerTest extends TestCase
{
    /**
     * @var Customer
     */
    private $customer;

    /*
     * @var Delivery[]
     */
    private $deliveries;

    public function setUp()
    {
        parent::setUp();

        $this->customer = factory(Customer::class)->create([
            'name' => 'Søren Petersen',
            'agreement_id' => factory(\App\Agreement::class)->create([
                'unit_price' => 12.00,
                'type' => Agreement::TYPE_WEEKLY,
            ])->id,
        ]);

        $this->deliveries[] = factory(Delivery::class)->create([
            'delivered_at' => Carbon::now()->subDays(3),
            'count' => 5,
            'customer_id' => $this->customer->id,
        ]);
        $this->deliveries[] = factory(Delivery::class)->create([
            'delivered_at' => Carbon::now()->subDays(8),
            'count' => 2,
            'customer_id' => $this->customer->id,
        ]);
    }

    public function testCreateWeeklyInvoice()
    {
        $this->customer->agreement->type = Agreement::TYPE_WEEKLY;

        // TODO: Implement test for create weekly invoice
        $deliveriesCount = array_reduce($this->deliveries, function($carry, $delivery)
        {
            if ($delivery->delivered_at >= Carbon::now()->subWeek()){
                return $carry + $delivery->count;
            }else{
                return $carry;
            }
        });

        $invoice = factory(Invoice::class)->create([
            'agreement_id' => $this->customer->agreement_id,
            'invoice_no' => 1,
            'invoice_due_at' => Carbon::now()->addWeek(),
            'amount' => $deliveriesCount * $this->customer->agreement->unit_price,
        ]);

        $this->assertEquals(60, $invoice->amount);
    }

    public function testCreateMonthlyInvoice()
    {
        $this->customer->agreement->type = Agreement::TYPE_MONTHLY;

        // TODO: Implement test for create monthly invoice
        $deliveriesCount = array_reduce($this->deliveries, function($carry, $delivery)
        {
            if ($delivery->delivered_at >= Carbon::now()->subMonth()){
                return $carry + $delivery->count;
            }else{
                return $carry;
            }
        });

        $invoice = factory(Invoice::class)->create([
            'agreement_id' => $this->customer->agreement_id,
            'invoice_no' => 1,
            'invoice_due_at' => Carbon::now()->addWeek(),
            'amount' => $deliveriesCount * $this->customer->agreement->unit_price,
        ]);

        $this->assertEquals(84, $invoice->amount);
    }
}
