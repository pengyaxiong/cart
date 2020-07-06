<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //白名单
    protected $fillable = ['identifier'];


    public function getThumbAttribute()
    {
        if ($this->link) {
            return $this->link . '-thumb';
        }
    }

    public function ad()
    {
        return $this->hasMany('App\Models\Ads\Ad');
    }

    public function article()
    {
        return $this->hasMany('App\Models\Cms\Article');
    }

    public function resource()
    {
        return $this->hasMany('App\Models\Cms\Resource');
    }

    public function strategy()
    {
        return $this->hasMany('App\Models\Shop\Strategy');
    }

    public function tool()
    {
        return $this->hasMany('App\Models\Shop\Tool');
    }

    public function product()
    {
        return $this->hasMany('App\Models\Shop\Product');
    }
}