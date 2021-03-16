<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Invoice extends Model implements Searchable
{
    use SoftDeletes;
    
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoiceProducts()
    {
        return $this->hasMany(InvoiceProduct::class);
    }

    public function clientPayment()
    {
        return $this->belongsTo(ClientPayment::class,'payment_id');
    }

    public function getDateAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->format('d/m/Y');
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('invoices.show', $this->id);

        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->client->name,$url);
    }
}
