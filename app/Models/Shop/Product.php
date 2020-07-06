<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = ['category_id','imgs','image', 'file'];


//    public function photo()
//    {
//        return $this->belongsTo('App\Models\System\Photo');
//    }
    //品牌
    public function brand()
    {
        return $this->belongsTo('App\Models\Shop\Brand');
    }
    //年限
    public function year()
    {
        return $this->belongsTo('App\Models\Shop\Year');
    }
    //价格
    public function prices()
    {
        return $this->belongsTo('App\Models\Shop\Price', 'price_id', 'id');
    }
    //类型
    public function type()
    {
        return $this->belongsTo('App\Models\Shop\Type');
    }

    //类型
    public function customer()
    {
        return $this->belongsTo('App\Models\Shop\Customer');
    }

    //商品可以属于多个分类
    public function categories()
    {
        return $this->belongsToMany('App\Models\Shop\Category');
    }

    //一个商品有很多相册图片
    public function product_galleries()
    {
        return $this->hasMany('App\Models\Shop\ProductGallery');
    }

}
