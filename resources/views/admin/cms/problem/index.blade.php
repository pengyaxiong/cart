@extends('layouts.admin.partials.application')
@section('css')
    <style>
        .thumb {
            max-height: 60px;
        }
    </style>
@endsection
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">常见问题</strong> /
                <small>Problem List</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a type="button" class="am-btn am-btn-default" href="{{route('cms.problem.create')}}">
                            <span class="am-icon-plus"></span> 新增
                        </a>
                    </div>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">

            </div>

            <div class="am-u-sm-12 am-u-md-3">
                <form action="{{route('cms.problem.index')}}" method="get">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" class="am-form-field" name="keyword" value="{{Request::input('keyword')}}">
                        <span class="am-input-group-btn">
                            <button class="am-btn am-btn-default" type="submit">搜索</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form" id="form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-id">编号</th>
                            <th class="table-title">标题</th>
                            <th class="table-desc">描述</th>
                            <th class="table-top am-hide-sm-only">是否显示</th>
                            <th class="table-date am-hide-sm-only">发布日期</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($problems as $problem)
                            <tr data-id="{{$problem->id}}">
                                <td>{{$problem->id}}</td>
                                <td>
                                    {{$problem->title}}
                                </td>
                                <td style="text-overflow:ellipsis;width: 30%;">
                                    <div style="  width:100%;height:3em;overflow:hidden;">
                                        {{$problem->description}}
                                    </div>
                                </td>
                                <td class="am-hide-sm-only">
                                    {!! is_something('is_show', $problem) !!}
                                </td>
                                <td class="am-hide-sm-only">
                                    {{$problem->created_at}}
                                </td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                               href="{{route('cms.problem.edit', $problem->id)}}">
                                                <span class="am-icon-pencil-square-o"></span> 编辑
                                            </a>

                                            <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"
                                               href="{{route('cms.problem.destroy', $problem->id)}}"
                                               data-method="delete" data-token="{{csrf_token()}}" data-confirm="确认删除吗?">
                                                <span class="am-icon-trash-o"></span> 删除
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    共 {{$problems->total()}} 条记录

                    <div class="am-cf">
                        <div class="am-fr">
                            {!! $problems->links() !!}
                        </div>
                    </div>
                    <hr/>
                </form>
            </div>

        </div>

    </div>
@endsection

@section('js')
    <script>
        $(function () {
            //是否...
            $(".is_something").click(function () {
                var _this = $(this);
                var data = {
                    id: _this.parents("tr").data('id'),
                    attr: _this.data('attr')
                }

                $.ajax({
                    type: "PATCH",
                    url: "/cms/problem/is_something",
                    data: data,
                    success: function (data) {
                        if (data.status == 0) {
                            alert(data.msg);
                            return false;
                        }
                        _this.toggleClass('am-icon-close am-icon-check');
                    }
                });
            });
        });
    </script>
@endsection