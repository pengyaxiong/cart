<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\Shop\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeController extends Controller
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

        $types = Type::where($where)->orderBy('sort_order')->paginate(config('admin.page_size'));
        return view('admin.shop.type.index', compact('types'));
    }

    /**
     * 新增
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.shop.type.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:type_categories|max:255',
        ]);
        $type = $request->all();
        Type::create($type);
        return redirect(route('shop.type.index'))->with('notice', '新增车型成功~');
    }

    /**
     * 修改
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $type = Type::find($id);
        return view('admin.shop.type.edit', compact('type'));
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

        $type = Type::find($id);
        $type->update($request->all());
        return redirect(route('shop.type.index'))->with('notice', '编辑车型成功~');
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (!Type::check_products($id)) {
            return back()->with('alert', '当前车型下有商品，请先将对应商品删除后再尝试删除~');
        }

        Type::destroy($id);
        return back()->with('notice', '删除车型成功~');
    }

    /**
     * Ajax排序
     * @param Request $request
     * @return array
     */
    public function sort_order(Request $request)
    {
        $type = Type::find($request->id);
        $type->sort_order = $request->sort_order;
        $type->save();
    }

    /**
     * Ajax修改属性
     * @param Request $request
     * @return array
     */
    public function is_something(Request $request)
    {
        $attr = $request->attr;
        $type = Type::find($request->id);
        $value = $type->is_show ? false : true;
        $type->$attr = $value;
        $type->save();
    }


}
