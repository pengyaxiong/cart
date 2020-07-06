<?php

namespace App\Http\Controllers\Wechat;

use App\Models\Shop\Customer;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Shop\ProductGallery;

class CustomerController extends Controller
{
    function __construct()
    {
        view()->share([
            '_customer' => 'on',
        ]);
    }


    /** 会员中心
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $openid = $request->openid;
        $customer = Customer::withcount('products')->where('openid', $openid)->first();


        return success_data('会员中心', ['customer' => $customer]);
    }

    public function product(Request $request)
    {
        $openid = $request->openid;
        $customer = Customer::where('openid', $openid)->first();

        $messages = [
            'name_sn.unique' => '车架号不能重复!',
            'name_sn.required' => '车架号不能为空!',
            'price.required' => '价格不能为空!',
        ];
        $rules = [
            'name_sn' => 'required|unique:products,name_sn',
            'price' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return error_data($error);
        }

        $product = Product::create([
            'customer_id' => $customer->id,
            'brand_id' => $request->brand_id,
            'year_id' => $request->year_id,
            'type_id' => $request->type_id,
            'price_id' => $request->price_id,
            'name_sn' => $request->name_sn,
            'name' => $request->name,
            'time' => $request->time,
            'price' => $request->price,
      //      'age' => $request->age,
            'mileage' => $request->mileage,
     //       'box' => $request->box,
            'cc' => $request->cc,
             'address' => "武汉",
            'description' =>"车况精品，一手车！无事故无泡水",
        ]);

        //相册
        if ($request->has('imgs')) {
            foreach ($request->imgs as $img) {
                $product->product_galleries()->create(['photo' => $img]);
            }
        }

        if ($product) {
            $customer->money += 1;
            $customer->save();
        }
        return success_data('保存成功', $product);
    }

    public function products(Request $request)
    {
        $openid = $request->openid;
        $customer = Customer::where('openid', $openid)->first();

        $products = Product::with('brand','prices','year','type')->where('customer_id', $customer->id)->paginate($request->total);

		 foreach ($products as $k=>$v){
            $products[$k]['photo']=ProductGallery::where(array('product_id' => $v->id))->first();
        }
        
        $page = isset($page) ? $request['page'] : 1;
        $products = $products->appends(array(
            'page' => $page
        ));

        return success_data('我的上传列表', ['products' => $products]);
    }

	 public function product_destroy(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);
        $customer = Customer::find($product->customer_id);
        Product::destroy($id);
        
        $customer->money =  $customer->money-1;
        $customer->save();
            
        return success_data('删除成功');
    }
    
  
    public function product_show(Request $request)
    {

        $id=$request->id;
        $product = Product::with('brand','prices','year','type')->find($id);
        $product_galleries = ProductGallery::where(array('product_id' => $id))->get();

        return success_data('商品详情', ['product' => $product,'product_galleries' => $product_galleries]);
    }


     public function product_update(Request $request)
    {
    	 $id=$request->id;
    	 
        $messages = [
            'name_sn.unique' => '车架号不能重复!',
            'name_sn.required' => '车架号不能为空!',
            'price.required' => '价格不能为空!',
        ];
        
        $rules = [
            'name_sn' => 'required|unique:products,name_sn,'.$id,
            'price' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return error_data($error);
        }
    	 $product = Product::find($id);
         $product->update([
            'brand_id' => $request->brand_id,
            'year_id' => $request->year_id,
            'type_id' => $request->type_id,
            'price_id' => $request->price_id,
            'name_sn' => $request->name_sn,
            'name' => $request->name,
            'time' => $request->time,
            'price' => $request->price,
      //      'age' => $request->age,
            'mileage' => $request->mileage,
     //       'box' => $request->box,
            'cc' => $request->cc,
        ]);
		
        //相册
        if ($request->has('imgs')) {
       
           ProductGallery::where('product_id', $id)->delete();
         
            foreach ($request->imgs as $img) {
                $product->product_galleries()->create(['photo' => $img]);
            }
        }
        
        return success_data('修改成功', ['product' => '']);

    }
    
    
    public function update(Request $request)
    {
        $openid = $request->openid;
        $customer = Customer::where('openid', $openid)->first();

        $result = $customer->update([
            'realname' => $request->realname,
            'tel' => $request->tel,
            'address' => $request->address,
            'money' => $request->money,
        ]);

        return success_data('修改成功', ['customer' => $result]);

    }

}
