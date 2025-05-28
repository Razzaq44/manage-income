<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoaCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function chartOfAccounts()
    {
        return $this->hasMany(ChartOfAccount::class, 'category_id');
    }
}
