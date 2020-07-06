<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    protected $guarded = [''];

    public function customer()
    {
        return $this->belongsTo('App\Models\Shop\Customer');
    }
}
