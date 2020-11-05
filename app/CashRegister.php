<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class CashRegister extends Model implements Searchable
{
    protected $guarded = [];

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
}
