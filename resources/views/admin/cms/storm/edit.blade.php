@extends('layouts.admin.partials.application')

@section('content')
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">编辑头脑风暴</strong> /
                <small>Edit Storm</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')


        <form class="am-form" action="{{ route('cms.storm.update', $storm->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    会员
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <select data-am-selected="{btnWidth: '100%',  btnStyle: 'secondary', btnSize: 'sm', maxHeight: 360, searchBox: 1}"
                            name="customer_id">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" @if($customer->id==$storm->customer_id) selected @endif>
                                {{ $customer->nickname }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    标题
                </div>
                <div class="am-u-sm-8 am-u-md-4">
                    <input type="text" class="am-input-sm" name="title" value="{{$storm->title}}">
                </div>
                <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    缩略图
                </div>

                <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                    <div class="am-form-group am-form-file new_thumb">
                        <button type="button" class="am-btn am-btn-success am-btn-sm">
                            <i class="am-icon-cloud-upload" id="loading"></i> 上传新的缩略图
                        </button>
                        <input type="file" id="image_upload">
                        <input type="hidden" name="image" value="{{$storm->image}}">
                    </div>

                    <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

                    <div>
                        {!! @image_url($storm, ['id'=>'img_show']) !!}
                    </div>
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    内容
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <textarea rows="4" name="description">{{$storm->description}}</textarea>
                </div>
            </div>

            <div class="am-margin">
                <button type="submit" class="am-btn am-btn-primary am-radius">提交保存</button>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="/js/jquery.html5-fileupload.js"></script>
    <script src="/js/upload.js"></script>
@endsection