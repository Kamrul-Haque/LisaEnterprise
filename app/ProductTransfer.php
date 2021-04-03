<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTransfer extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function getDateAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->format('d/m/Y');
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function godownFrom()
    {
        return $this->belongsTo(Godown::class,'godown_from')->withTrashed();
    }

    public function godownTo()
    {
        return $this->belongsTo(Godown::class,'godown_to')->withTrashed();
    }
}
