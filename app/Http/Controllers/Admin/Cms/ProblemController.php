<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\Problem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProblemController extends Controller
{
    public function __construct()
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查找
        $where = function ($query) use ($request) {
            if ($request->has('keyword') and $request->keyword != '') {
                $search = "%" . $request->keyword . "%";
                $query->where('title', 'like', $search);
            }
        };

        $problems = Problem::where($where)
            ->orderBy('created_at', 'desc')
            ->paginate(config('admin.page_size'));

        //分页处理
        $page = isset($page) ? $request['page'] : 1;
        $problems = $problems->appends(array(
            'title' => $request->keyword,
            'page' => $page
        ));

        return view('admin.cms.problem.index', compact('problems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cms.problem.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
        ]);
        $problem = $request->all();
        Problem::create($problem);
        return back()->with('notice', '新增成功~');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function edit($id)
    {
        $problem = Problem::find($id);
        return view('admin.cms.problem.edit', compact('problem'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
        ]);

        $problem = Problem::find($id);
        $problem->update($request->all());
        return back()->with('notice', '编辑成功~');
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function destroy($id)
    {
        Problem::destroy($id);
        return back()->with('notice', '删除成功~');
    }


    /**
     * Ajax修改属性
     * @param Request $request
     * @return array
     */
    function is_something(Request $request)
    {
        $attr = $request->attr;
        $problem = Problem::find($request->id);
        $value = $problem->$attr ? false : true;
        $problem->$attr = $value;
        $problem->save();
    }
}
