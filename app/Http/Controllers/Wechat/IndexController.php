<?php

namespace App\Http\Controllers\Wechat;

use App\Models\Shop\Customer;
use App\Models\System\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ads\Ad;
use App\Models\Shop\Product;

class IndexController extends Controller
{
    public function __construct()
    {
        view()->share('_index', 'on');
    }

    //获取GET请求
    function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    public function code_login()
    {
        //1.准备scope为snsapi_login网页授权页面
        $redirecturl = urlencode("https://cart.leanzn.com/wechat/code_login");
        $snsapi_userInfo_url = 'https://open.weixin.qq.com/connect/qrconnect?appid=wxff7d69201c42b292&redirect_uri='.$redirecturl.'&response_type=code&scope=snsapi_login&state=YQJ#wechat_redirect';
        //2.用户手动同意授权,同意之后,获取code
        //页面跳转至redirect_uri/?code=CODE&state=STATE
        $code = $_GET['code'];
        if( !isset($code) ){
            header('Location:'.$snsapi_userInfo_url);
        }

        //3.通过code换取网页授权access_token
        $curl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxff7d69201c42b292&secret=e501916d34a9d52e7556acf00ba704d4&code='.$code.'&grant_type=authorization_code';
        $content = $this->doHttpPost($curl);
        $result = json_decode($content);

        //4.通过access_token和openid拉取用户信息
        $webAccess_token = $result->access_token;
        $openid = $result->openid;
        $userInfourl = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$webAccess_token.'&openid='.$openid.'&lang=zh_CN ';

        $recontent = $this->doHttpPost($userInfourl);
        $userInfo = json_decode($recontent,true);
        return $userInfo;

    }

    public function auth(Request $request)
    {

//声明CODE，获取小程序传过来的CODE
        $code = $request->code;
//配置appid
        $appid = env('WECHAT_MINI_PROGRAM_APPID', 'wxff7d69201c42b292');
//配置appscret
        $secret = env('WECHAT_MINI_PROGRAM_SECRET', 'e501916d34a9d52e7556acf00ba704d4');
//api接口
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";

        $str = json_decode($this->httpGet($api), true);


        $openid = $str['openid'];

        $customer = Customer::where('openid', $openid)->first();


        if ($customer) {
            $customer->update([
                'openid' => $openid,
                'headimgurl' => $request->headimgurl,
                'nickname' => $request->nickname,
            ]);

        } else {
            $customer = Customer::create([
                'openid' => $openid,
                'headimgurl' => $request->headimgurl,
                'nickname' => $request->nickname,
            ]);

        }

        return success_data('授权成功', $str);
    }

    public function config()
    {
        $config = Config::first();
        return success_data('系统设置', ['config' => $config]);
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

            $path = $request->file->store('uploads', 'my_file');

            return success_data('上传成功', ['image' => '' . $path, 'image_url' => '' . $path]);
        }
    }

    public function upload_ocr(Request $request)
    {
        if ($request->hasFile('file') and $request->file('file')->isValid()) {

            //文件大小判断$filePath
            $max_size = 1024 * 1024 * 3;
            $size = $request->file('file')->getClientSize();
            if ($size > $max_size) {
                return ['status' => 0, 'msg' => '文件大小不能超过3M'];
            }

            $path = $request->file->store('ocr', 'my_file');

            // 图片base64编码
            $data = file_get_contents($path);
            $base64 = base64_encode($data);

            // 设置请求数据
            $appkey = 'hbDARnqCF8mwzRlL';
            $params = array(
                'app_id' => '2121122159',
                'image' => $base64,
                'time_stamp' => strval(time()),
                'nonce_str' => strval(rand()),
                'sign' => '',
            );
            $params['sign'] = $this->getReqSign($params, $appkey);

            // 执行API调用
            $url = 'https://api.ai.qq.com/fcgi-bin/ocr/ocr_generalocr';

            $response = $this->doHttpPost($url, $params);
            if ($response['msg'] == 'ok') {
                //删除本地图片
                unlink($path);
                $text = '';
                $item_list = $response['data']['item_list'];
                foreach ($item_list as $k => $v) {
                    $text .= $v['itemstring'] . '   ';
                }
                return success_data('识别成功', $text);
            } else {
                return error_data('识别失败，请重试~');
            }

        }
    }

    public function getReqSign($params /* 关联数组 */, $appkey /* 字符串*/)
    {
        // 1. 字典升序排序
        ksort($params);

        // 2. 拼按URL键值对
        $str = '';
        foreach ($params as $key => $value) {
            if ($value !== '') {
                $str .= $key . '=' . urlencode($value) . '&';
            }
        }

        // 3. 拼接app_key
        $str .= 'app_key=' . $appkey;

        // 4. MD5运算+转换大写，得到请求签名
        $sign = strtoupper(md5($str));
        return $sign;
    }

    // doHttpPost ：执行POST请求，并取回响应结果
    // 参数说明
    //   - $url   ：接口请求地址
    //   - $params：完整接口请求参数（特别注意：不同的接口，参数对一般不一样，请以具体接口要求为准）
    // 返回数据
    //   - 返回false表示失败，否则表示API成功返回的HTTP BODY部分
    public function doHttpPost($url, $params)
    {
        $curl = curl_init();

        $response = false;
        do {
            // 1. 设置HTTP URL (API地址)
            curl_setopt($curl, CURLOPT_URL, $url);

            // 2. 设置HTTP HEADER (表单POST)
            $head = array(
                'Content-Type: application/x-www-form-urlencoded'
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $head);

            // 3. 设置HTTP BODY (URL键值对)
            $body = http_build_query($params);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

            // 4. 调用API，获取响应结果
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_NOBODY, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
            if ($response === false) {
                $response = false;
                break;
            }

            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($code != 200) {
                $response = false;
                break;
            }
        } while (0);

        curl_close($curl);

        return json_decode($response, true);
    }
}
