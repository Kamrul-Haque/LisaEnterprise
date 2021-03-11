<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductTransfer extends Model
{
    protected $guarded = [];

    public function getDateAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->format('d/m/Y');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function godownFrom()
    {
        return $this->belongsTo(Godown::class,'godown_from');
    }

    public function godownTo()
    {
        return $this->belongsTo(Godown::class,'godown_to');
    }
}
