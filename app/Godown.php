<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Godown extends Model implements Searchable
{
    protected $guarded = [];

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'godown_product')->withPivot('quantity');
    }

    public function invoiceProducts()
    {
        return $this->hasMany(InvoiceProduct::class);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('godowns.show',$this->id);

        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->name,$url);
    }
}
