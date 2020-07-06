<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\Shop\Year;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class YearController extends Controller
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

        $years = Year::where($where)->orderBy('sort_order')->paginate(config('admin.page_size'));
        return view('admin.shop.year.index', compact('years'));
    }

    /**
     * 新增
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.shop.year.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:year_categories|max:255',
        ]);
        $year = $request->all();
        Year::create($year);
        return redirect(route('shop.year.index'))->with('notice', '新增年限区间成功~');
    }

    /**
     * 修改
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $year = Year::find($id);
        return view('admin.shop.year.edit', compact('year'));
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

        $year = Year::find($id);
        $year->update($request->all());
        return redirect(route('shop.year.index'))->with('notice', '编辑年限区间成功~');
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (!Year::check_products($id)) {
            return back()->with('alert', '当前年限区间下有商品，请先将对应商品删除后再尝试删除~');
        }

        Year::destroy($id);
        return back()->with('notice', '删除年限区间成功~');
    }

    /**
     * Ajax排序
     * @param Request $request
     * @return array
     */
    public function sort_order(Request $request)
    {
        $year = Year::find($request->id);
        $year->sort_order = $request->sort_order;
        $year->save();
    }

    /**
     * Ajax修改属性
     * @param Request $request
     * @return array
     */
    public function is_something(Request $request)
    {
        $attr = $request->attr;
        $year = Year::find($request->id);
        $value = $year->is_show ? false : true;
        $year->$attr = $value;
        $year->save();
    }


}
