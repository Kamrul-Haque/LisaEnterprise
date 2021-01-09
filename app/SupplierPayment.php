<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class SupplierPayment extends Model implements Searchable
{
    protected $guarded = [];

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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('clients.show',$this->id);

        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->supplier->name,$url);
    }
}
