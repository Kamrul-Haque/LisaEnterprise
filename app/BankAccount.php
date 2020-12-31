<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $guarded = [];

    public function bankDeposits()
    {
        $this->hasMany(BankDeposit::class);
    }

    public function bankWithdraws()
    {
        $this->hasMany(BankWithdraw::class);
    }
}
