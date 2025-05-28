<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'code',
        'name',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(CoaCategory::class, 'category_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'coa_code', 'code');
    }
}
