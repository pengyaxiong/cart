@extends('layouts.admin.partials.application')
@section('css')
    <link rel="stylesheet" href="/vendor/daterangepicker/daterangepicker.css">
@endsection
@section('content')
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">日进一</strong> /
            <small>Daily Manage</small>
        </div>
    </div>

    @include('layouts.admin.partials._flash')

    <div class="am-g" style="height: 37px;">
        <div class="am-u-sm-12 am-u-md-6">
            <div class="am-btn-toolbar">
                <div class="am-btn-group am-btn-group-xs">
                    <a class="am-btn am-btn-default" href="{{ route('cms.daily.create') }}">
                        <span class="am-icon-plus"></span> 新增
                    </a>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="am-g">
        <div class="am-u-sm-12 am-u-md-12">
            <form class="am-form-inline" role="form" method="get">

                <div class="am-form-group">
                    <input type="text" name="title" class="am-form-field am-input-sm" placeholder="标题" value="{{ Request::input('title') }}">
                </div>

                <div class="am-form-group">
                    <select data-am-selected="{btnSize: 'sm', maxHeight: 360, searchBox: 1}"
                            name="customer_id" id="">
                        <option value="-1">所有会员</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}"
                                    @if($customer->id == Request::input('customer_id')) selected @endif>
                                {{ $customer->nickname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="am-form-group">
                    <input type="text" id="created_at" placeholder="选择时间日期" name="created_at"
                           value="{{ Request::input('created_at') }}" class="am-form-field am-input-sm"/>
                </div>

                <button type="submit" class="am-btn am-btn-default am-btn-sm">查询</button>
            </form>
        </div>
    </div>

    <div class="am-g">
        <div class="am-u-sm-12">
            <form class="am-form">
                <table class="am-table am-table-striped am-table-hover table-main">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th class="table-thumb">缩略图</th>
                            <th>标题</th>
                            <th>会员</th>
                            <th>内容</th>
                            <th class="table-set">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailies as $daily)
                        <tr data-id="{{$daily->id}}">
                            <td>{{ $daily->id }}</td>
                            <td>
                                {!! @image_url($daily, ['class'=>'thumb']) !!}
                            </td>
                            <td>{{ $daily->title }}</td>

                            <td>{{ $daily->customer->nickname }}</td>

                            <td class="am-hide-sm-only">
                                {!! sub($daily->description) !!}
                            </td>

                            <td>
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <a class="am-btn am-btn-default am-btn-xs am-text-secondary" href="{{ route('cms.daily.edit', $daily->id) }}">
                                            <span class="am-icon-list-alt"></span> 编辑
                                        </a>
                                        <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" href="{{ route('cms.daily.destroy', $daily->id) }}" data-method="delete" data-token="{{csrf_token()}}" data-confirm="确定删除吗？">
                                            <span class="am-icon-trash-o"></span> 删除
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                共 {{$dailies->total()}} 条记录

                <div class="am-cf">
                    <div class="am-fr">

                        {!! $dailies->links() !!}
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@section('js')
    <script src="/vendor/daterangepicker/moment.js"></script>
    <script src="/vendor/moment/locale/zh-cn.js"></script>
    <script src="/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="/js/daterange_config.js"></script>
@endsection

