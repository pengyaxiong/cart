<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\Shop\Brand;
use App\Models\System\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    /**
     * 品牌列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $where = function ($query) use ($request) {
            if ($request->has('keyword') and $request->keyword != '') {
                $search = "%" . $request->keyword . "%";
                $query->where('name', 'like', $search);
            }
        };

        $brands = Brand::where($where)->orderby('bfirstletter')->paginate(config('admin.page_size'));
        return view('admin.shop.brand.index', compact('brands'));
    }

    /**
     * 新增
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.shop.brand.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:brands|max:255',
        ]);
        $brand = $request->all();
        Brand::create($brand);
        return redirect(route('shop.brand.index'))->with('notice', '新增分类成功~');
    }

    /**
     * 修改
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.shop.brand.edit', compact('brand'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $brand = Brand::find($id);
        $brand->update($request->all());
        return redirect(route('shop.brand.index'))->with('notice', '编辑分类成功~');
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (!Brand::check_products($id)) {
            return back()->with('alert', '当前分类下有商品，请先将对应商品删除后再尝试删除~');
        }

        Brand::destroy($id);
        return back()->with('notice', '删除分类成功~');
    }

    /**
     * Ajax排序
     * @param Request $request
     * @return array
     */
    public function sort_order(Request $request)
    {
        $brand = Brand::find($request->id);
        $brand->sort_order = $request->sort_order;
        $brand->save();
    }

    /**
     * Ajax修改属性
     * @param Request $request
     * @return array
     */
    public function is_something(Request $request)
    {
        $attr = $request->attr;
        $brand = Brand::find($request->id);
        $value = $brand->is_show ? false : true;
        $brand->$attr = $value;
        $brand->save();
    }

    public function update_mysql()
    {

        $url = "https://tool.bitefu.net/car/?type=brand&pagesize=9999";
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);
        $array = json_decode($res, true);

        if ($array['status'] == 1) {

            $brand_array = $array['info'];

            foreach ($brand_array as $brand) {
                if ($brand['img']) {
                    Brand::create([
                        'name' => $brand['name'],
                        'logo' => 'http:' . $brand['img'],
                        'bfirstletter' => $brand['firstletter'],
                    ]);
                } else {
                    continue;
                }
            }
            return success_data('导入成功');

        } else {
            return error_data('网络数据错误');

        }
    }

}
