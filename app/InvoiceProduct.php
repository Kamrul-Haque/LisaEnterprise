<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceProduct extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class)->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function godown()
    {
        return $this->belongsTo(Godown::class)->withTrashed();
    }
}
