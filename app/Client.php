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

    // for cascading soft deletes
    protected static $relations_to_cascade = ['invoices','invoiceProducts','clientPayments'];

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

    public function invoices()
    {
        return $this->hasMany(Invoice::class)->withTrashed();
    }

    public function invoiceProducts()
    {
        return $this->hasManyThrough(InvoiceProduct::class, Invoice::class)->withTrashed();
    }

    public function clientPayments()
    {
        return $this->hasMany(ClientPayment::class)->withTrashed();
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('clients.show',$this->id);

        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->name,$url);
    }
}
