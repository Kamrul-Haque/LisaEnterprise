<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class ClientPayment extends Model implements Searchable
{
    use SoftDeletes;

    protected $guarded = [];

    // for cascading soft deletes
    protected static $relations_to_cascade = ['invoice'];

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
        return $this->belongsTo(Client::class)->withTrashed();
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class,'payment_id')->withTrashed();
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('client-payment.show',$this->id);

        // TODO: Implement getSearchResult() method.
        return new SearchResult($this,$this->client->name,$url);
    }
}
