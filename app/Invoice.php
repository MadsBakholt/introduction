<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $invoice_no
 * @property string $invoice_due_at
 * @property string $amount
 *
 * @package App
 */
class Invoice extends Model
{
    protected $fillable = [
        'agreement_id', 'invoice_no', 'invoice_due_at', 'amount'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agreements()
    {
        return $this->hasMany(Agreement::class);
    }
}
