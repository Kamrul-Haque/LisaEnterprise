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

    // for cascading soft deletes
    protected static $relations_to_cascade = ['entries','supplierPayments'];

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
        return $this->hasMany(Entry::class)->withTrashed();
    }

    public function supplierPayments()
    {
        return $this->hasMany(SupplierPayment::class)->withTrashed();
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('suppliers.show',$this->id);

        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->name,$url);
    }
}
