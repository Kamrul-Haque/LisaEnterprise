<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Entry extends Model implements Searchable
{
    use SoftDeletes;

    protected $guarded = [];

    public function getDateAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->format('d/m/Y');
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function godown()
    {
        return $this->belongsTo(Godown::class)->withTrashed();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withTrashed();
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('admin.entries.show',$this->id);
        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->supplier->name,$url);
    }
}
