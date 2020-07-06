<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\Resource;
use App\Models\System\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceController extends Controller
{
    /**
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

        $resources= Resource::with('photo')->where($where)->orderBy('sort_order')->paginate(config('admin.page_size'));
        return view('admin.cms.resource.index', compact('resources'));
    }

    /**
     * 新增
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.cms.resource.create');
    }

    /**
     * 保存
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $photo = Photo::create(['identifier' => $request->image]);
        $resource = $request->all();
        $photo->resource()->create($resource);

        return redirect(route('cms.resource.index'))->with('notice', '新增资源成功~');
    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $resource = Resource::find($id);
        return view('admin.cms.resource.edit', compact('resource'));
    }

    /**
     * 更新
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $resource = Resource::find($id);
        $resource->update($request->all());
        $resource->photo()->update(['identifier' => $request->image]);

        return back()->with('notice', '修改资源信息成功');
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Resource::destroy($id);
        return back()->with('notice', '删除资源成功');
    }

    /**
     * Ajax排序
     * @param Request $request
     * @return array
     */
    function sort_order(Request $request)
    {
        $resource = Resource::find($request->id);
        $resource->sort_order = $request->sort_order;
        $resource->save();

    }

    /**
     * Ajax修改属性
     * @param Request $request
     * @return array
     */
    function is_something(Request $request)
    {
        $attr = $request->attr;
        $resource = Resource::find($request->id);
        $value = $resource->$attr ? false : true;
        $resource->$attr = $value;
        $resource->save();

    }
}
