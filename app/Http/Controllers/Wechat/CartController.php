<?php

namespace App\Http\Controllers\Wechat;

use App\Models\Shop\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Address;
class CartController extends Controller
{
    /**
     * 购物车列表
     */
    public function index()
    {
        $carts = Cart::with('product')->where('customer_id', session('wechat.customer.id'))->get();
       // $carts = Cart::with('product')->where('customer_id', 1)->get();

        $count = Cart::count_cart($carts);
//        return $count;

        return success_data('获取成功',['carts'=>$carts,'count'=>$count,]);
      //  return view('wechat.carts.index', compact('carts', 'count'));
    }

    /** 点击立即购买跳到购物车页面，也就是把商品加入购物车
     * @param Request $request
     */
    function store(Request $request)
    {
        $addresses = Address::where('customer_id', session('wechat.customer.id'))->get();
        if (empty($addresses)){
          //  redirect(route('wechat.address.create'));
            return error_data('请添加收货地址');
        }

        //判断购物车是否有当前商品,如果有,那么 num +1
        $product_id = $request->product_id;
        $cart = Cart::where('product_id', $product_id)->where('customer_id', session('wechat.customer.id'))->first();


        if ($cart) {
            Cart::where('id', $cart->id)->increment('num');
            return success_data('增加数量成功');
        }

        //否则购物车表,创建新数据
        Cart::create([
            'product_id' => $request->product_id,
            'customer_id' => session('wechat.customer.id'),
        ]);
        return success_data('新增购物车成功');
    }

    /** 修改购物车数量
     * @param Request $request
     * @return array
     */
    function change_num(Request $request)
    {
        if ($request->type == 'add') {
            Cart::where('id', $request->id)->increment('num');
        } else {
            Cart::where('id', $request->id)->decrement('num');
        }
        $count=Cart::count_cart();
       // return $count;
        return success_data('修改购物车数量成功',$count);
    }


    /**
     * 删除
     * @param Request $request
     * @return array
     */
    function destroy(Request $request)
    {
        $id = $request->id;
        Cart::destroy($id);
        $count=Cart::count_cart();
        // return $count;
        return success_data('删除成功',$count);
    }


}
