<?php

namespace App\Http\Controllers\Wechat;

use App\Handlers\WechatConfigHandler;
use App\Models\Shop\Brand;
use App\Models\Shop\Price;
use App\Models\Shop\Product;
use App\Models\Shop\ProductGallery;
use App\Models\Shop\Type;
use App\Models\Shop\Year;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use Cache,DB;
class ProductController extends Controller
{
    protected $jssdk;

    function __construct(WechatConfigHandler $wechat)
    {
        view()->share([
            '_category' => 'on',
        ]);

        $app = $wechat->app(1);
        $this->jssdk = $app->jssdk;
    }


    /** 商品列表,首页的全局搜索：输入关键词后搜索结果跳到商品列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //多条件查找
        $where = function ($query) use ($request) {
			
			 if ($request->has('name') and $request->name != '') {

                $search = "%" . $request->name . "%";
                $query->where('name', 'like', $search);
            }
            
            if ($request->has('brand_id') and $request->brand_id != '') {

                $query->where('brand_id', $request->brand_id);
            }

            if ($request->has('year_id') and $request->year_id != '') {

                $query->where('year_id', $request->year_id);
            }

            if ($request->has('price_id') and $request->price_id != '') {

                $query->where('price_id', $request->price_id);
            }

            if ($request->has('type_id') and $request->type_id != '') {

                $query->where('type_id', $request->type_id);
            }

            if ($request->has('is_recommend')) {
                $query->where('is_recommend', true);
            }

            if ($request->has('is_new')) {
                $query->where('is_new', true);
            }

            $query->where('is_onsale', true);
            $query->orderby('is_top', 'desc');
        };

        $products = Product::with('brand','prices','year','type')->where($where)->paginate($request->total);

        $page = isset($page) ? $request['page'] : 1;
        $products = $products->appends(array(
            'page' => $page
        ));

        $brands = Brand::orderby('bfirstletter')->get();
        $years = Year::where('is_show', true)->orderby('sort_order')->get();
        $prices = Price::where('is_show', true)->orderby('sort_order')->get();
        $types = Type::where('is_show', true)->orderby('sort_order')->get();

        foreach ($products as $k=>$v){
            $products[$k]['photo']=ProductGallery::where(array('product_id' => $v->id))->first();
        }
        return success_data('商品列表', ['products' => $products]);
    }


    /** 搜索
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $products = Product::with('brand','prices','year','type')->where('is_recommend', true)->orderBy('is_top', 'desc')->orderBy('created_at')->get();

        foreach ($products as $k=>$v){
            $products[$k]['photo']=ProductGallery::where(array('product_id' => $v->id))->first();
        }

        // return view('wechat.products.search', compact('products'));

        return success_data('搜索', $products);
    }

    public function brand()
    {
        $brands = Cache::rememberForever('product_brands', function () {
        	
        	$array=Brand::orderby('bfirstletter')->get()->groupby('bfirstletter')->toarray();
    		 list($result['keys'], $result['values'])=array_divide($array);
            return $result;
        });
        return success_data('所有品牌', $brands);
    }

	  public function price()
    {
        $prices = Price::where('is_show', true)->orderby('sort_order')->get();
        
        return success_data('所有价格区间', $prices);
    }
    
    	  public function year()
    {
        $years = Year::where('is_show', true)->orderby('sort_order')->get();
        
        return success_data('所有年限区间', $years);
    }
    
    	  public function type()
    {
         $types = Type::where('is_show', true)->orderby('sort_order')->get();
        
        return success_data('所有车型', $types);
    }
    
    /** 所有分类
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category()
    {
        $categories = Category::orderBy('sort_order', 'desc')->get();

        //return view('wechat.products.category', compact('categories'));

        return success_data('所有分类', $categories);
    }


    /**
     *  商品详情
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function show(Request $request, $id)
    {

        $jsApiList = ['onMenuShareTimeline', 'onMenuShareAppMessage'];//分享给好友 分享到朋友圈

        $jssdk_json = $this->jssdk->buildConfig($jsApiList, false, false, true);

        $jssdk_config = json_decode($jssdk_json, true);

        //获取JSSDK的配置数组，默认返回 JSON 字符串，当 $json 为 false 时返回数组，你可以直接使用到网页中。
        // $app->jssdk->setUrl($url)
        //设置当前URL，如果不想用默认读取的URL，可以使用此方法手动设置，通常不需要。

        $product = Product::with('brand','prices','year','type')->find($id);
        $product_galleries = ProductGallery::where(array('product_id' => $id))->get();

//        $recommends = Product::with('photo')->where('is_recommend', true)->where('id', '<>', $id)
//            ->orderBy('is_top', 'desc')->get();

        // return view('wechat.products.show', compact('product', 'recommends', 'product_galleries', 'jssdk_config'));

        return success_data('商品详情', ['product' => $product,'product_galleries' => $product_galleries, 'jssdk_config' => $jssdk_config]);
    }

}
