<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Entry extends Model implements Searchable
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function godown()
    {
        return $this->belongsTo(Godown::class);
    }

    public function getDateAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->format('d/m/Y');
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('admin.entries.show',$this->id);
        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->sl_no,$url);
    }
}
