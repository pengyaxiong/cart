<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\Shop\Price;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PriceController extends Controller
{
    /**
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

        $prices = Price::where($where)->orderBy('sort_order')->paginate(config('admin.page_size'));
        return view('admin.shop.price.index', compact('prices'));
    }

    /**
     * 新增
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.shop.price.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:price_categories|max:255',
        ]);
        $price = $request->all();
        Price::create($price);
        return redirect(route('shop.price.index'))->with('notice', '新增价格区间成功~');
    }

    /**
     * 修改
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $price = Price::find($id);
        return view('admin.shop.price.edit', compact('price'));
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

        $price = Price::find($id);
        $price->update($request->all());
        return redirect(route('shop.price.index'))->with('notice', '编辑价格区间成功~');
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (!Price::check_products($id)) {
            return back()->with('alert', '当前价格区间下有商品，请先将对应商品删除后再尝试删除~');
        }

        Price::destroy($id);
        return back()->with('notice', '删除价格区间成功~');
    }

    /**
     * Ajax排序
     * @param Request $request
     * @return array
     */
    public function sort_order(Request $request)
    {
        $price = Price::find($request->id);
        $price->sort_order = $request->sort_order;
        $price->save();
    }

    /**
     * Ajax修改属性
     * @param Request $request
     * @return array
     */
    public function is_something(Request $request)
    {
        $attr = $request->attr;
        $price = Price::find($request->id);
        $value = $price->is_show ? false : true;
        $price->$attr = $value;
        $price->save();
    }


}
