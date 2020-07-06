@extends('layouts.admin.partials.application')

@section('css')
    <link rel="stylesheet" href="/vendor/markdown/css/editormd.min.css"/>
    <link rel="stylesheet" href="/vendor/webupload/dist/webuploader.css"/>
    <link rel="stylesheet" type="text/css" href="/vendor/webupload/style.css"/>
    <link rel="stylesheet" href="/vendor/daterangepicker/daterangepicker.css">
    <style>
        .applyBtn {
            color: #fff;
            background-color: #5eb95e;
            border-color: #5eb95e;
            border-radius: 4px;
            width: auto;
            padding: 0px 14px;
        }

        .cancelBtn {
            color: #fff;
            background-color: #dd514c;
            border-color: #dd514c;
            border-radius: 4px;
            width: auto;
            padding: 0px 14px;
        }
    </style>
@endsection
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">编辑车辆</strong> /
                <small>Edit Product</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-12">


                <form class="am-form" action="{{ route('shop.product.update', $product->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}


                    <div class="am-tabs am-margin" data-am-tabs>
                        <ul class="am-tabs-nav am-nav am-nav-tabs">
                            <li class="am-active"><a href="#tab1">基本信息</a></li>
                            <li><a href="#tab2">详细信息</a></li>
                            <li><a href="#tab3">车辆相册</a></li>
                        </ul>

                        <div class="am-tabs-bd">
                            <div class="am-tab-panel am-fade am-in am-active" id="tab1">
                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        品牌
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <select data-am-selected="{btnWidth: '100%',  btnStyle: 'secondary', btnSize: 'sm', maxHeight: 360, searchBox: 1}"
                                                name="brand_id">
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}" @if($brand->id==$product->brand_id) selected @endif>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        年限
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <select data-am-selected="{btnWidth: '100%',  btnStyle: 'secondary', btnSize: 'sm', maxHeight: 360, searchBox: 1}"
                                                name="year_id">
                                            @foreach ($years as $year)
                                                <option value="{{ $year->id }}" @if($year->id==$product->year_id) selected @endif>
                                                    {{ $year->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        车型
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <select data-am-selected="{btnWidth: '100%',  btnStyle: 'secondary', btnSize: 'sm', maxHeight: 360, searchBox: 1}"
                                                name="type_id">
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}" @if($type->id==$product->type_id) selected @endif>
                                                    {{ $type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        价格区间
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <select data-am-selected="{btnWidth: '100%',  btnStyle: 'secondary', btnSize: 'sm', maxHeight: 360, searchBox: 1}"
                                                name="price_id">
                                            @foreach ($prices as $price)
                                                <option value="{{ $price->id }}" @if($price->id==$product->price_id) selected @endif>
                                                    {{ $price->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        车架号
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4">
                                        <input type="text" class="am-input-sm" name="name_sn" value="{{$product->name_sn}}">
                                    </div>
                                    <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        车辆名称
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="name" value="{{$product->name}}">
                                    </div>
                                </div>
                                
                                 <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        地址
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="address" value="{{$product->address}}">
                                    </div>
                                </div>

                                <div class="am-g am-margin-top sort">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        上牌日期
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="time"    autocomplete="off"  value="{{$product->time}}">
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        车主报价
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="price" value="{{$product->price}}">
                                    </div>
                                </div>

                                <!--<div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        车龄
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="age" value="{{$product->age}}">
                                    </div>
                                </div>-->

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        里程
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="mileage" value="{{$product->mileage}}">
                                    </div>
                                </div>

                                <!--<div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        变速箱
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="box" value="{{$product->box}}">
                                    </div>
                                </div>-->

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        排量
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="cc" value="{{$product->cc}}">
                                    </div>
                                </div>


                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        上架
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <label class="am-radio-inline">
                                            <input type="radio" value="1" name="is_onsale"
                                                   @if($product->is_onsale == 1) checked @endif> 是
                                        </label>
                                        <label class="am-radio-inline">
                                            <input type="radio" value="0" name="is_onsale"
                                                   @if($product->is_onsale == 0) checked @endif> 否
                                        </label>
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        加入推荐
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="hidden" name="is_top" value="0">
                                        <input type="hidden" name="is_recommend" value="0">
                                        <input type="hidden" name="is_new" value="0">

                                        <div class="am-btn-group" data-am-button="">
                                            <label class="am-btn am-btn-default am-btn-xs am-round @if($product->is_top == 1) am-active @endif">
                                                <input type="checkbox" name="is_top" value="1"
                                                       @if($product->is_top == 1) checked @endif> 置顶
                                            </label>
                                            <label class="am-btn am-btn-default am-btn-xs am-round @if($product->is_recommend == 1) am-active @endif">
                                                <input type="checkbox" name="is_recommend" value="1"
                                                       @if($product->is_recommend == 1) checked @endif> 推荐
                                            </label>
                                            <label class="am-btn am-btn-default am-btn-xs am-round @if($product->is_new == 1) am-active @endif">
                                                <input type="checkbox" name="is_new" value="1"
                                                       @if($product->is_new == 1) checked @endif> 新品
                                            </label>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="am-tab-panel am-fade" id="tab2">
                                <div class="am-g am-margin-top-sm">
                                    <div class="am-u-sm-12 am-u-md-12">
                                        <div class="am-g am-margin-top sort">
                                            <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                                描述信息
                                            </div>
                                            <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                                                <textarea rows="24" name="description">{{$product->description}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="am-tab-panel am-fade" id="tab3">

                                <ul data-am-widget="gallery"
                                    class="am-gallery am-avg-sm-2 am-avg-md-4 am-avg-lg-6 am-gallery-imgbordered xGallery"
                                    data-am-gallery="{ pureview: true }">

                                    @foreach($product->product_galleries as $gallery)
                                        <li>
                                            <div class="am-gallery-item">
                                                <a href="/{{$gallery->photo}}" class="">
                                                    <img src="/{{$gallery->photo}}"/>
                                                </a>
                                                <div class="file-panel">
                                                    <span class="cancel" data-id="{{$gallery->id}}">删除</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>


                                <div id="uploader">
                                    <div class="queueList">
                                        <div id="dndArea" class="placeholder">
                                            <div id="filePicker"></div>
                                            <p>或将照片拖到这里，单次最多可选300张</p>
                                        </div>
                                    </div>
                                    <div class="statusBar" style="display:none;">
                                        <div class="progress">
                                            <span class="text">0%</span>
                                            <span class="percentage"></span>
                                        </div>
                                        <div class="info"></div>
                                        <div class="btns">
                                            <div id="filePicker2"></div>
                                            <div class="uploadBtn">开始上传</div>
                                        </div>
                                    </div>

                                    <div id="imgs"></div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="am-margin">
                        <button type="submit" class="am-btn am-btn-primary am-radius">提交保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="/js/jquery.html5-fileupload.js"></script>
    <script src="/js/upload.js"></script>

    <script src="/vendor/markdown/editormd.min.js"></script>
    <script src="/js/editormd_config.js"></script>

    <script type="text/javascript" src="/vendor/webupload/dist/webuploader.js"></script>
    <script type="text/javascript" src="/vendor/webupload/upload.js"></script>
    <script src="/vendor/daterangepicker/moment.js"></script>
    <script src="/vendor/moment/locale/zh-cn.js"></script>
    <script src="/vendor/daterangepicker/daterangepicker.js"></script>
    <script>
        $(function () {
            var info_editor = editormd("info_markdown", {
                path: "/vendor/markdown/lib/",
                imageUpload: true,
                imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                imageUploadURL: "/vendor/markdown/php/upload.php",
                saveHTMLToTextarea: true,//获得html
                emoji: true,//表情
                htmlDecode: "style,script,iframe|on*",
                width: "100%",
                height: "666",
            });
            var case_editor = editormd("case_markdown", {
                path: "/vendor/markdown/lib/",
                imageUpload: true,
                imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                imageUploadURL: "/vendor/markdown/php/upload.php",
                saveHTMLToTextarea: true,//获得html
                emoji: true,//表情
                htmlDecode: "style,script,iframe|on*",
                width: "100%",
                height: "666",
            });

            //时间插件
            $('#seckill_time').daterangepicker({
                "timePicker": true, //显示时间
                "autoUpdateInput": false,
                "autoApply": true,
                "timePickerSeconds": true,//时间显示到秒
                "startDate": moment().hours(0).minutes(0).seconds(0), //设置开始日期
                "endDate": moment(new Date()), //设置结束器日期
                //"maxDate": moment(new Date()), //设置最大日期
                "opens": "center",
                "ranges": {
                    // '今天': [moment(), moment()],
                    '昨天': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '上周': [moment().subtract(6, 'days'), moment()],
                    '前30天': [moment().subtract(29, 'days'), moment()],
                    '本月': [moment().startOf('month'), moment().endOf('month')],
                    '上月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "locale": {
                    "format": "YYYY-MM-DD HH:mm:ss",
                    "applyLabel": "确定",
                    "cancelLabel": "取消",
                    "customRangeLabel": '自定义',
                }
            }, function (start, end, label) {
                this.element[0].value = start.format('YYYY-MM-DD HH:mm:ss') + ' ~ ' + end.format('YYYY-MM-DD HH:mm:ss');
            });

            //删除相册
            $(".am-gallery-item").hover(function () {
                $(this).children('.file-panel').fadeIn(300);
            }, function () {
                $(this).children('.file-panel').fadeOut(300);
            });

            $(".cancel").click(function () {
                var _this = $(this);
                $.ajax({
                    type: "delete",
                    url: "/shop/product/destroy_gallery",
                    data: {gallery_id: _this.data('id')},
                    success: function (data) {
                        if (data.status == 0) {
                            alert(data.msg);
                            return false;
                        }
                        _this.parents("li").remove();
                    }
                });
            });
        })
    </script>
@endsection