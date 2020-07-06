<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $guarded = ['image'];

    public function photo()
    {
        return $this->belongsTo('App\Models\System\Photo');
    }

}
