<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Godown extends Model implements Searchable
{
    use SoftDeletes;

    protected $guarded = [];

    // for cascading soft deletes
    protected static $relations_to_cascade = ['entries','invoiceProducts','productTransfers'];

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

    public function productTransfers()
    {
        return $this->hasMany(ProductTransfer::class);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('godowns.show',$this->id);

        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->name,$url);
    }
}
