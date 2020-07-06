@extends('layouts.admin.partials.application')
@section('css')
    <link rel="stylesheet" href="/vendor/markdown/css/editormd.min.css"/>
@endsection
@section('content')
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">编辑资源</strong> /
                <small>Edit Resource</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')


        <form class="am-form" action="{{ route('cms.resource.update', $resource->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    资源名称
                </div>
                <div class="am-u-sm-8 am-u-md-4">
                    <input type="text" class="am-input-sm" name="name" value="{{$resource->name}}">
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
                        <input type="hidden" name="image" value="{{$resource->photo?$resource->photo->identifier:''}}">
                    </div>

                    <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

                    <div>
                        {!! @image_url($resource, ['id'=>'img_show'],true) !!}
                    </div>
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    浏览量
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text" class="am-input-sm" name="see_num" value="{{$resource->see_num}}">
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    资源描述
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <textarea rows="4" name="description">{{$resource->description}}</textarea>
                </div>
            </div>


            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    是否可用
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="is_show" @if($resource->is_show == '1') checked @endif> 是
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="is_show" @if($resource->is_show == '0') checked @endif> 否
                    </label>
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    排序
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text" name="sort_order" class="am-input-sm" value="{{$resource->sort_order}}">
                </div>
            </div>


            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    内容
                </div>
                <div class="am-u-sm-8 am-u-md-10 am-u-end col-end">
                    <div id="markdown">
                        <textarea rows="10" name="content" style="display:none;">{{$resource->content}}</textarea>
                    </div>
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
    <script src="/vendor/markdown/editormd.min.js"></script>
    <script src="/js/editormd_config.js"></script>
@endsection