<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'date',
        'coa_code',
        'description',
        'debit',
        'credit',
    ];

    public function ChartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'coa_code', 'code');
    }
}
