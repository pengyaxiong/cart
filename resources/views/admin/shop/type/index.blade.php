@extends('layouts.admin.partials.application')
@section('content')
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">车型</strong> /
                <small>Good Types</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a class="am-btn am-btn-default" href="{{ route('shop.type.create') }}">
                            <span class="am-icon-plus"></span> 新增
                        </a>
                    </div>
                </div>
            </div>

            <div class="am-u-sm-12 am-u-md-3">
                <form method="get">
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
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-id">ID</th>
                            <th class="table-thumb">车型</th>
                            <th class="table-name">是否显示</th>
                            <th class="table-sort-order am-hide-sm-only" style="width:10%">排序</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($types as $type)
                            <tr data-id="{{$type->id}}">
                                <td>{{$type->id}}</td>

                                <td>{{$type->name}}</td>

                                <td class="am-hide-sm-only">
                                    {!! is_something('is_show', $type) !!}
                                </td>

                                <td class="am-hide-sm-only">
                                    <input type="text" name="sort_order" class="am-input-sm"
                                           value="{{$type->sort_order}}">
                                </td>

                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                               href="{{route('shop.type.edit', $type->id)}}">
                                                <span class="am-icon-pencil-square-o"></span> 编辑
                                            </a>

                                            <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"
                                               href="{{route('shop.type.destroy', $type->id)}}" data-method="delete"
                                               data-token="{{csrf_token()}}" data-confirm="确认删除吗?">
                                                <span class="am-icon-trash-o"></span> 删除
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="am-cf">
                        共 {{$types->total()}} 条记录
                        <div class="am-fr">
                            {!! $types->appends(Request::all())->links() !!}
                        </div>
                    </div>
                    <hr/>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(function () {

            //排序
            $("input[name='sort_order']").change(function () {
                var data = {
                    sort_order: $(this).val(),
                    id: $(this).parents("tr").data('id')
                }
                $.ajax({
                    type: "PATCH",
                    url: "/shop/type/sort_order",
                    data: data,
                    success: function (data) {

                        location.href = location.href;
                    }
                });
            })

            //是否...
            $(".is_something").click(function () {
                var _this = $(this);
                var data = {
                    id: _this.parents("tr").data('id'),
                    attr: _this.data('attr')
                }

                $.ajax({
                    type: "PATCH",
                    url: "/shop/type/is_something",
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