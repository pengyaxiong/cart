@extends('layouts.admin.partials.application')
@section('content')
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">商品品牌</strong> /
                <small>Good Brands</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a class="am-btn am-btn-default" href="{{ route('shop.brand.create') }}">
                            <span class="am-icon-plus"></span> 新增
                        </a>
                    </div>
                    @if(auth()->id()==1)
                        <div class="am-btn-toolbar">
                            <div class="am-btn-group am-btn-group-xs">
                                <a class="am-btn am-btn-default" id="update_mysql" href="javascript:void (0)">
                                    <span class="am-icon-cloud-upload"></span> 导入数据
                                </a>
                            </div>
                        </div>
                    @endif
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
                            <th class="table-id">首字母</th>
                            <th class="table-thumb">品牌Logo</th>
                            <th class="table-name">品牌名称</th>
                            <th>品牌商品</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($brands as $brand)
                            <tr data-id="{{$brand->id}}">
                                <td>{{$brand->bfirstletter}}</td>

                                <td><img src="{{$brand->logo}}" alt="" class="thumb"></td>

                                <td>{{$brand->name}}</td>

                                <td>
                                    {!! show_brand_products($brand) !!}
                                </td>

                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                               href="{{route('shop.brand.edit', $brand->id)}}">
                                                <span class="am-icon-pencil-square-o"></span> 编辑
                                            </a>

                                            <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"
                                               href="{{route('shop.brand.destroy', $brand->id)}}" data-method="delete"
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
                        共 {{$brands->total()}} 条记录
                        <div class="am-fr">
                            {!! $brands->appends(Request::all())->links() !!}
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
            $("#update_mysql").click(function () {

                $.ajax({
                    type: "PATCH",
                    url: "/shop/brand/update_mysql",
                    success: function (data) {
                        alert(data.msg);
                        // console.log(data)
                        location.href = location.href;
                    }
                });
            })

            //排序
            $("input[name='sort_order']").change(function () {
                var data = {
                    sort_order: $(this).val(),
                    id: $(this).parents("tr").data('id')
                }
                $.ajax({
                    type: "PATCH",
                    url: "/shop/brand/sort_order",
                    data: data
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
                    url: "/shop/brand/is_something",
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