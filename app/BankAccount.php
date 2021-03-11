<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $guarded = [];

    public function bankDeposits()
    {
        return $this->hasMany(BankDeposit::class);
    }

    public function bankWithdraws()
    {
        return $this->hasMany(BankWithdraw::class);
    }

    public function cashResister()
    {
        return $this->hasOne(CashRegister::class);
    }
}
