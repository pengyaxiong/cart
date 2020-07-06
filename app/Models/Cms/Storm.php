<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Storm extends Model
{
    protected $guarded = [''];

    public function customer()
    {
        return $this->belongsTo('App\Models\Shop\Customer');
    }
}
