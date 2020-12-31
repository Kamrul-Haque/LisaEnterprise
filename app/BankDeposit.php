<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankDeposit extends Model
{
    protected $guarded = [];

    public function bankAccount()
    {
        $this->belongsTo(BankAccount::class);
    }
}
