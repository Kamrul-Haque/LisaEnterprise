<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    // for cascading soft deletes
    protected static $relations_to_cascade = ['bankDeposits','bankWithdraws','cashResister'];

    public static function boot() {
        parent::boot();

        static::deleting(function($resource) {
            foreach (static::$relations_to_cascade as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });

        static::restoring(function($resource) {
            foreach (static::$relations_to_cascade as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }
        });
    }
    //

    public function bankDeposits()
    {
        return $this->hasMany(BankDeposit::class)->withTrashed();
    }

    public function bankWithdraws()
    {
        return $this->hasMany(BankWithdraw::class)->withTrashed();
    }

    public function cashResister()
    {
        return $this->hasOne(CashRegister::class)->withTrashed();
    }
}
