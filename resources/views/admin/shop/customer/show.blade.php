@extends('layouts.admin.partials.application')

@section('content')
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">会员详情</strong> /
                <small>Customer Info</small>
            </div>
        </div>

        <form class="am-form" action="" method="post">

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    微信昵称
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text" class="am-input-sm" name="title" value="{{$customer->nickname}}">
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    微信头像
                </div>

                <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                    <img src="{{$customer->headimgurl}}" class="thumb" alt="">
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    真实姓名
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text" class="am-input-sm" name="realname" value="{{$customer->realname}}">
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    性别
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="sex" @if($customer->sex == '1') checked @endif> 男
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="sex" @if($customer->sex == '0') checked @endif> 女
                    </label>
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    是否入会
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="is_join" @if($customer->is_join == '1') checked @endif> 会员
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="is_join" @if($customer->is_join == '0') checked @endif> 非会员
                    </label>
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    手机号
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text" class="am-input-sm" name="tel" value="{{$customer->tel}}">
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    地址信息
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text" class="am-input-sm" name="address" value="{{$customer->address}}">
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    所属行业
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text" class="am-input-sm" name="trade" value="{{$customer->trade}}">
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    人员数量
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text" class="am-input-sm" name="employee_num" value="{{$customer->employee_num}}">
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    经营时间
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text" class="am-input-sm" name="operating_time" value="{{$customer->operating_time}}">
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    营收状况
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <textarea rows="4" name="revenue_situation">{{$customer->revenue_situation}}</textarea>
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    目前需求
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <textarea rows="4" name="need">{{$customer->need}}</textarea>
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    最擅长的
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <textarea rows="4" name="adept">{{$customer->adept}}</textarea>
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    接受项目置换
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="is_change" @if($customer->is_change == '1') checked @endif>
                        接受
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="is_change" @if($customer->is_change == '0') checked @endif>
                        不接受
                    </label>
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    接受项目出售
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="is_sale" @if($customer->is_sale == '1') checked @endif> 接受
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="is_sale" @if($customer->is_sale == '0') checked @endif> 不接受
                    </label>
                </div>
            </div>
        </form>
        <br>
    </div>
@endsection
@section('js')

@endsection