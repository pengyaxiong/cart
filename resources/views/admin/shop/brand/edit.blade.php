@extends('layouts.admin.partials.application')
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">修改品牌</strong> /
                <small>Edit Brand</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <form class="am-form" action="{{ route('shop.brand.update', $brand->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    商品品牌
                </div>
                <div class="am-u-sm-8 am-u-md-4">
                    <input type="text" class="am-input-sm" name="name"
                           value="{{ old('name') ? old('name'): $brand->name }}">
                </div>
                <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    品牌首字母
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text"  name="bfirstletter" value=" {{$brand->bfirstletter}} ">
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    品牌Logo
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text"  name="logo" value=" {{$brand->logo}} ">
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