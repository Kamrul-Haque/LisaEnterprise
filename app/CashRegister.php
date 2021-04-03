<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class CashRegister extends Model implements Searchable
{
    use SoftDeletes;

    protected $guarded = [];

    public static function balance()
    {
        $deposit = CashRegister::where('type', 'deposit')->sum('amount');
        $withdraw = CashRegister::where('type', 'withdraw')->sum('amount');
        return $deposit - $withdraw;
    }

    public function getDateAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->format('d/m/Y');
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('admin.cash-register.show', $this->id);
        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->title,$url);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class)->withTrashed();
    }
}
