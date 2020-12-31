<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded = [];

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
