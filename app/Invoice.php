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

    // for cascading soft deletes
    protected static $relations_to_cascade = ['invoiceProducts'];

    public static function boot() {
        parent::boot();

        static::deleting(function($resource) {
            foreach (static::$relations_to_cascade as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });

        static::restoring(function($resource) {
            foreach (static::$relations_to_cascade as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }
        });
    }
    //

    public function getDateAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->format('d/m/Y');
    }

    public function client()
    {
        return $this->belongsTo(Client::class)->withTrashed();
    }

    public function invoiceProducts()
    {
        return $this->hasMany(InvoiceProduct::class)->withTrashed();
    }

    public function clientPayment()
    {
        return $this->belongsTo(ClientPayment::class,'payment_id')->withTrashed();
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('invoices.show', $this->id);

        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->client->name,$url);
    }
}
