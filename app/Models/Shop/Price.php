<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    //黑名单为空
    protected $guarded = [''];
    protected $table = 'price_categories';

    public function products()
    {
        return $this->hasMany('App\Models\Shop\Product');
    }

    /**
     * 检查是否有商品
     */
    static function check_products($id)
    {
        $price = self::with('products')->find($id);
        if ($price->products->isEmpty()) {
            return true;
        }
        return false;
    }
}
