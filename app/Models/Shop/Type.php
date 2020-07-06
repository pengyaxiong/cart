<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //黑名单为空
    protected $guarded = [''];
    protected $table = 'type_categories';

    public function products()
    {
        return $this->hasMany('App\Models\Shop\Product');
    }

    /**
     * 检查是否有商品
     */
    static function check_products($id)
    {
        $type = self::with('products')->find($id);
        if ($type->products->isEmpty()) {
            return true;
        }
        return false;
    }
}
