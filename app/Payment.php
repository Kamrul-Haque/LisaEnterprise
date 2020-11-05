<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Payment extends Model implements Searchable
{
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getDateOfIssueAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->format('d/m/Y');
    }

    public function getDateOfDrawAttribute($value)
    {
        if ($value)
        {
            $carbon = new Carbon($value);
            return $carbon->format('d/m/Y');
        }
        else
        {
            return "N/A";
        }
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('payments.show', $this->id);
        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->sl_no,$url);
    }
}
