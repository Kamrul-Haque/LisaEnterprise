<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class ClientPayment extends Model implements Searchable
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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class,'payment_id');
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('client-payment.show',$this->id);

        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->client->name,$url);
    }
}
