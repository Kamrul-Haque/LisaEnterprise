<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Supplier extends Model implements Searchable
{
    use SoftDeletes;

    protected $guarded = [];

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function supplierPayments()
    {
        return $this->hasMany(SupplierPayment::class);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('supplier.show',$this->id);

        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->name,$url);
    }
}
