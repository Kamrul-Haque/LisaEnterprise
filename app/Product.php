<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Product extends Model implements Searchable
{
    protected $guarded = [];

    public function totalPrice()
    {
        return $this->entries->sum('total_buying_price');
    }

    public function totalQuantity()
    {
        return $this->entries->sum('quantity');
    }

    public function unitPrice()
    {
        if ($this->totalQuantity())
        {
            return $this->totalPrice() / $this->totalQuantity();
        }
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function godowns()
    {
        return $this->belongsToMany(Godown::class, 'godown_product')->withPivot('godown_quantity');
    }

    public function invoiceProducts()
    {
        return $this->hasMany(InvoiceProduct::class);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('products.show', $this->id);

        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->name,$url);
    }
}
