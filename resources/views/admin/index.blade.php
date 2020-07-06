@extends('layouts.admin.partials.application')
@section('css')

@endsection
@section('content')
    <div class="admin-content">
        <div class="admin-content-body">

            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">首页</strong> /
                    <small>{{Auth::id()==1?'数据统计':'欢迎'}}</small>
                </div>
            </div>

            @include("layouts.admin.partials._flash")
            <ul class="am-avg-sm-1 am-avg-md-3 am-margin am-padding am-text-center admin-content-list ">
                <li><a href="javascript:void (0)" class="am-text-success"><span class="am-icon-btn am-icon-car"></span><br>车辆总量<br>{{\App\Models\Shop\Product::count()}}</a></li>
                <li><a href="javascript:void (0)" class="am-text-danger"><span class="am-icon-btn am-icon-recycle"></span><br>总访问量<br>{!! uv() !!}</a></li>
                <li><a href="javascript:void (0)" class="am-text-secondary"><span class="am-icon-btn am-icon-user-md"></span><br>注册用户<br>{{\App\Models\Shop\Customer::count()}}</a></li>
            </ul>
            <div class="am-g">
                <div class="am-u-sm-12">

                    <div id="statistics_customer" style="width: 100%;height:400px;"></div>

                </div>
                <div class="am-u-sm-12">

                    <div id="statistics_product" style="width: 100%;height:400px;"></div>

                </div>
            </div>

            <hr data-am-widget="divider" style="" class="am-divider am-divider-default"/>

            <div class="am-g">
                <div class="am-u-sm-12">
                    <div class="am-u-sm-7">
                        <div id="customer_province" style="width: 100%;height:600px;"></div>
                    </div>
                    <div class="am-u-sm-5">
                        <div id="sex_count" style="width: 100%;height:600px;"></div>
                    </div>
                </div>
            </div>
            @include('layouts.admin.partials._footer')
        </div>
    </div>
@endsection
@section('js')
    <script src="/vendor/echarts/echarts.min.js"></script>
    <script src="/vendor/echarts/macarons.js"></script>
    <script src="/vendor/echarts/china.js"></script>

    <script src="/js/visualization/statistics_customer.js"></script>
    <script src="/js/visualization/statistics_product.js"></script>
    <script src="/js/visualization/sex_count.js"></script>
    <script src="/js/visualization/customer_province.js"></script>
    <script src="/js/visualization/top.js"></script>
    {{--<script src="/js/visualization/sales_area.js"></script>--}}
    <script src="/js/visualization/sales_amount.js"></script>
    <script src="/js/visualization/sales_count.js"></script>
@endsection

