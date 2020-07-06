<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    //黑名单为空
    protected $guarded = [''];
    protected $table = 'year_categories';

    public function products()
    {
        return $this->hasMany('App\Models\Shop\Product');
    }

    /**
     * 检查是否有商品
     */
    static function check_products($id)
    {
        $year = self::with('products')->find($id);
        if ($year->products->isEmpty()) {
            return true;
        }
        return false;
    }
}
