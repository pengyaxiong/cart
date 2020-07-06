<?php

namespace App\Http\Controllers\Wechat;

use App\Models\Cms\Problem;
use App\Http\Controllers\Controller;

class ProblemController extends Controller
{

    /** 商品列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $problems = Problem::orderby('created_at', 'desc')->get();

        return success_data('常见问题列表', $problems);
    }


    /**
     * 常见问题详情
     * @param $id
     * @return array
     */
    public function show($id)
    {

        $problem = Problem::find($id);

        return success_data('常见问题详情', $problem);
    }

}
