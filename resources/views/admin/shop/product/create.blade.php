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
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">新增车辆</strong> /
                <small>Create A New Product</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-12">
                <form class="am-form" action="{{ route('shop.product.store') }}" method="post">
                    {{ csrf_field() }}

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
                                                <option value="{{ $brand->id }}">
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
                                                <option value="{{ $year->id }}">
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
                                                <option value="{{ $type->id }}">
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
                                                <option value="{{ $price->id }}">
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
                                        <input type="text" class="am-input-sm" name="name_sn">
                                    </div>
                                    <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        车辆名称
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="name">
                                    </div>
                                </div>
								
								<div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        地址
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end"> 
                                        <input type="text" class="am-input-sm" name="address" value="武汉">
                                    </div>
                                </div>


                                <div class="am-g am-margin-top sort">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        上牌日期
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="time"    autocomplete="off" >
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        车主报价
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="price" placeholder="8.88万">
                                    </div>
                                </div>

                                <!--<div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        车龄
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="age" value="">
                                    </div>
                                </div>-->

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        里程
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="mileage" value="">
                                    </div>
                                </div>

                                <!--<div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        变速箱
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="box" value="">
                                    </div>
                                </div>-->

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        排量
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input type="text" class="am-input-sm" name="cc" value="">
                                    </div>
                                </div>


                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        上架
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <label class="am-radio-inline">
                                            <input type="radio" value="1" name="is_onsale" checked> 是
                                        </label>
                                        <label class="am-radio-inline">
                                            <input type="radio" value="0" name="is_onsale"> 否
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
                                            <label class="am-btn am-btn-default am-btn-xs am-round">
                                                <input type="checkbox" name="is_top" value="1"> 置顶
                                            </label>
                                            <label class="am-btn am-btn-default am-btn-xs am-round">
                                                <input type="checkbox" name="is_recommend" value="1"> 推荐
                                            </label>
                                            <label class="am-btn am-btn-default am-btn-xs am-round">
                                                <input type="checkbox" name="is_new" value="1"> 新品
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
                                                <textarea rows="24" name="description">车况精品，一手车！无事故无泡水</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="am-tab-panel am-fade" id="tab3">

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

            //单个时间插件
            $('input[name=time]').daterangepicker(
                {
                    singleDatePicker: true,//设置为单个的datepicker，而不是有区间的datepicker 默认false
                    showDropdowns: true,//当设置值为true的时候，允许年份和月份通过下拉框的形式选择 默认false
                    autoUpdateInput: false,//1.当设置为false的时候,不给与默认值(当前时间)2.选择时间时,失去鼠标焦点,不会给与默认值 默认true
                    timePicker24Hour : true,//设置小时为24小时制 默认false
                    timePicker : false,//可选中时分 默认false
                    locale: {
                        format: "YYYY-MM-DD",
                        separator: " - ",
                        daysOfWeek: ["日","一","二","三","四","五","六"],
                        monthNames: ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"]
                    }

                }
            ).on('cancel.daterangepicker', function(ev, picker) {
                $("input[name=time]").val("请选择日期");
                $("#submitDate").val("");
            }).on('apply.daterangepicker', function(ev, picker) {
                $("#submitDate").val(picker.startDate.format('YYYY-MM-DD'));
                $("input[name=time]").val(picker.startDate.format('YYYY-MM-DD'));

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
        });
    </script>
@endsection