<?php

namespace App\Http\Controllers\Wechat;

use App\Models\Shop\Customer;
use App\Models\Shop\OrderAddress;
use App\Models\Shop\OrderProduct;
use App\Models\Shop\Product;
use App\Models\Shop\Recharge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Cart;
use App\Models\Shop\Address;
use App\Models\Shop\Order;
use App\Handlers\WechatConfigHandler;

class OrderController extends Controller
{
    protected $wechat;

    public function __construct(WechatConfigHandler $wechat)
    {
        $this->wechat = $wechat;
    }

    /**
     * 订单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function index(Request $request)
    {
        //多条件查找
        $where = function ($query) use ($request) {
            $query->where('customer_id', session('wechat.customer.id'));

            switch ($request->brand_id) {
                case '2':
                    $query->where('brand_id', 2);
                    break;
                case '1':
                    $query->where('brand_id', 1);   //项目模板
                    break;
                default:
                    $query->where('brand_id', 1);
                    break;
            }
        };

        $orders = Order::where($where)->with('order_products.product', 'customer')
            ->orderBy('created_at', 'desc')->get();

        $app = $this->wechat->app(1);
        $jsApiList = ['chooseWXPay'];//支付
        $jssdk_json = $app->jssdk->buildConfig($jsApiList, false, false, true);
        $jssdk_config = json_decode($jssdk_json, true);

        // return view('wechat.order.index', compact('orders', 'order_status', 'jssdk_config'));

        return success_data('订单列表', ['orders' => $orders, 'jssdk_config' => $jssdk_config]);
    }


    /**
     * 购物车点击结算跳到下单页面，即check_out
     * 此页面需要的数据：用户的收货地址；要购买的商品信息；若购物车没有商品，跳回购物车页面。
     */
    public function checkout()
    {
        $carts = Cart::with('product')->where('customer_id', session('wechat.customer.id'))->get();
        // $carts = Cart::with('product.photo')->where('customer_id', 1)->get();
        $count = Cart::count_cart();

        //如果购物车没有商品，跳回购物车页面
        if ($carts->isEmpty()) {
            //  return redirect('/wechat/cart');
            return error_data('购物车空空如也');
        }

        $address = Address::find(session('wechat.customer.address_id'));
        // $address = Address::find(1);
//        return $address;
        //   return view('wechat.order.checkout', compact('carts', 'count', 'address'));

        return success_data('结算', ['carts' => $carts, 'count' => $count, 'address' => $address]);
    }

    public function upload_img(Request $request)
    {
        if ($request->hasFile('file') and $request->file('file')->isValid()) {

            //文件大小判断$filePath
            $max_size = 1024 * 1024 * 3;
            $size = $request->file('file')->getClientSize();
            if ($size > $max_size) {
                return ['status' => 0, 'msg' => '文件大小不能超过3M'];
            }

            $path = $request->file->store('shop', 'my_file');

            return ['status' => 1, 'image' => '/' . $path, 'image_url' => '/' . $path];
        }
    }

    public function refund(Request $request)
    {
        $order_id = $request->order_id;
        $order = Order::find($order_id);
        $order->refund_title = $request->refund_title;
        $order->refund_description = $request->refund_description;
        $order->refund_imgs = implode('|', $request->imgs);
        $order->status = 5;
        $order->save();
        return success_data('申请成功');
    }

    /**
     * @param Request $request
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function pay(Request $request)
    {
        $openid = $request->openid;
        $customer = Customer::where('openid', $openid)->first();

        $product_id = $request->product_id;
        $product = Product::find($product_id);

        $app = $this->wechat->pay(1);


        if ($product) {

            $total_price = $product->price;
            $order_sn = date('YmdHms', time()) . '_' . $customer->id;
            $title = $product->name;

            $order_config = [
                'body' => $title,
                'out_trade_no' => $order_sn,
                'total_fee' => $total_price * 100,
                //'spbill_create_ip' => '', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
                'notify_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/api/wechat/paid', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
                'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
                'openid' => $openid,
            ];

            //生成订单
            $result = $app->order->unify($order_config);
            if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
                $order = Order::create([
                    'customer_id' => $customer->id,
                    'order_sn' => $order_sn,
                    'total_price' => $total_price,
                ]);

                $order->order_products()->create(['product_id' => $product_id, 'num' => 1]);

                $prepayId = $result['prepay_id'];

                $config = $app->jssdk->sdkConfig($prepayId);
                return response()->json($config);
            }

        } else {

            return error_data('参数错误~');

        }

    }

    public function recharge(Request $request)
    {
        $app = $this->wechat->pay(1);

        $recharge_id = $request->id;
        $recharge = Recharge::find($recharge_id);
        $total_price = $recharge->price;
        $order_sn = date('YmdHms', time()) . '_' . session('wechat.customer.id');

        $title = '充值';

        $order_config = [
            'body' => $title,
            'out_trade_no' => $order_sn,
            'total_fee' => $total_price * 100,
            //'spbill_create_ip' => '', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
            'notify_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/api/wechat/paid', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => session('wechat.customer.openid'),
        ];

        //生成订单
        $result = $app->order->unify($order_config);
        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            /******/
            Order::create([
                'customer_id' => session('wechat.customer.id'),
                'order_sn' => $order_sn,
                'total_price' => $total_price,
                'recharge_id' => $recharge_id,
                'order_type' => 1,
            ]);
            //
            $prepayId = $result['prepay_id'];

            $config = $app->jssdk->sdkConfig($prepayId);
            return response()->json($config);
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Kernel\Exceptions\Exception
     */
    public function paid(Request $request)
    {
        $app = $this->wechat->pay(1);
        $response = $app->handlePaidNotify(function ($message, $fail) {
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order = Order::where('order_sn', $message['out_trade_no'])->first();

            if (!$order || $order->pay_time) { // 如果订单不存在 或者 订单已经支付过了
                $order->status = 2; //支付成功,
                $order->save(); // 保存订单
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (array_get($message, 'result_code') === 'SUCCESS') {

                    $order->pay_time = date('Y-m-d H:m:s', time()); // 更新支付时间为当前时间

                    $order->status = 2; //支付成功,
                    $order->save(); // 保存订单

                    //商品销量增加
                    $order = Order::with('order_products.product')->find($order->id);
                    $products = $order->order_products;
                    foreach ($products as $product) {
                        $product_id = $product->product_id;
                        $p = Product::find($product_id);
                        $p->sale_num += 1;
                        $p->save();
                    }

                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }

            return true; // 返回处理完成
        });

        return $response;
    }


    public function destroy(Request $request)
    {
        $id = $request->id;
        Order::destroy($id);
        OrderAddress::where('order_id', $id)->delete();
        OrderProduct::where('order_id', $id)->delete();

        return success_data('删除成功');
    }

}
