<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BankDeposit extends Model
{
    protected $guarded = [];

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function getDateOfIssueAttribute($value)
    {
        if ($value)
        {
            $carbon = new Carbon($value);
            return $carbon->format('d/m/Y');
        }
    }

    public function getDateOfDrawAttribute($value)
    {
        if ($value)
        {
            $carbon = new Carbon($value);
            return $carbon->format('d/m/Y');
        }
    }
}
