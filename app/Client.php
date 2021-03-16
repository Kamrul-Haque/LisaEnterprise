<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Client extends Model implements Searchable
{
    use SoftDeletes;

    protected $guarded = [];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function clientPayments()
    {
        return $this->hasMany(ClientPayment::class);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('clients.show',$this->id);

        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->name,$url);
    }
}
