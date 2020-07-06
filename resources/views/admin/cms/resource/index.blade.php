@extends('layouts.admin.partials.application')
@section('content')
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">{{$config->company}}资源</strong> /
            <small>Resource Manage</small>
        </div>
    </div>

    @include('layouts.admin.partials._flash')

    <div class="am-g">
        <div class="am-u-sm-12 am-u-md-6">
            <div class="am-btn-toolbar">
                <div class="am-btn-group am-btn-group-xs">
                    <a class="am-btn am-btn-default" href="{{ route('cms.resource.create') }}">
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
                            <th>编号</th>
                            <th class="table-thumb">缩略图</th>
                            <th>资源名称</th>
                            <th>资源描述</th>
                            <th>浏览量</th>
                            <th>是否显示</th>
                            <th style="width:10%">排序</th>
                            <th class="table-set">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resources as $resource)
                        <tr data-id="{{$resource->id}}">
                            <td>{{ $resource->id }}</td>
                            <td>
                                {!! @image_url($resource, ['class'=>'thumb'],true) !!}
                            </td>
                            <td>{{ $resource->name }}</td>
                            <td>{{ $resource->description }}</td>

                            <td>{{ $resource->see_num }}</td>
                            <td class="am-hide-sm-only">
                                {!! is_something('is_show', $resource) !!}
                            </td>

                            <td class="am-hide-sm-only">
                                <input type="text" name="sort_order" class="am-input-sm" value="{{$resource->sort_order}}">
                            </td>

                            <td>
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <a class="am-btn am-btn-default am-btn-xs am-text-secondary" href="{{ route('cms.resource.edit', $resource->id) }}">
                                            <span class="am-icon-list-alt"></span> 编辑
                                        </a>
                                        <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" href="{{ route('cms.resource.destroy', $resource->id) }}" data-method="delete" data-token="{{csrf_token()}}" data-confirm="确定删除吗？">
                                            <span class="am-icon-trash-o"></span> 删除
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                共 {{$resources->total()}} 条记录

                <div class="am-cf">
                    <div class="am-fr">

                        {!! $resources->links() !!}
                    </div>
                </div>

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
                    url: "/cms/resource/sort_order",
                    data: data,
                    success: function (data) {
                        if (data.status == 0) {
                            alert(data.msg);
                            return false;
                        }
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
                    url: "/cms/resource/is_something",
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

