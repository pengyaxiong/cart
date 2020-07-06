<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\Daily;
use App\Models\Shop\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DailyController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //多条件查找
        $where = function ($query) use ($request) {

            if ($request->has('title') and $request->title != '') {

                $search = "%" . $request->title . "%";
                $query->where('title', 'like', $search);
            }

            if ($request->has('customer_id') and $request->customer_id != '-1') {

                $query->where('customer_id', $request->customer_id);
            }

            if ($request->has('created_at') and $request->created_at != '') {
                $time = explode(" ~ ", $request->input('created_at'));
                $start = $time[0] . ' 00:00:00';
                $end = $time[1] . ' 23:59:59';
                $query->whereBetween('created_at', [$start, $end]);
            }
        };

        $dailies = Daily::with('customer')->where($where)->orderBy('created_at','desc')->paginate(config('admin.page_size'));
        $customers=Customer::all();
        return view('admin.cms.daily.index', compact('dailies','customers'));
    }

    /**
     * 新增
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $customers=Customer::all();
        return view('admin.cms.daily.create',compact('customers'));
    }

    /**
     * 保存
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $daily = $request->all();
        Daily::create($daily);
        return redirect(route('cms.daily.index'))->with('notice', '新增成功~');
    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $daily = Daily::with('customer')->find($id);
        $customers=Customer::all();
        return view('admin.cms.daily.edit', compact('daily','customers'));
    }

    /**
     * 更新
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $daily = Daily::with('customer')->find($id);
        $daily->update($request->all());

        return back()->with('notice', '修改信息成功');
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Daily::destroy($id);
        return back()->with('notice', '删除成功');
    }
}
