@extends('layouts.admin.partials.application')
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">新增年限区间</strong> /
                <small>Create A New Year</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <form class="am-form" action="{{ route('shop.year.store') }}" method="post">
            {{ csrf_field() }}


            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    年限区间
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text"  name="name" value="  ">
                </div>
            </div>

            <div class="am-g am-margin-top sort">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    排序
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text" name="sort_order" class="am-input-sm" value="99">
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    显示在导航栏
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="is_show" checked>
                        是
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="is_show" >
                        否
                    </label>
                </div>
            </div>


            <div class="am-margin">
                <button type="submit" class="am-btn am-btn-primary am-radius">提交保存</button>
            </div>
        </form>
    </div>
@endsection

@section('js')

@endsection

