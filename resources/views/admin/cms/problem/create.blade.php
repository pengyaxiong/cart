@extends('layouts.admin.partials.application')

@section('css')
@endsection
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">新增问题</strong> /
                <small>Create A New Problem</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-12">

                <form class="am-form" action="{{ route('cms.problem.store') }}" method="post">
                    {{ csrf_field() }}

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            问题标题
                        </div>
                        <div class="am-u-sm-8 am-u-md-4">
                            <input type="text" class="am-input-sm" name="title" value="{{old('title')}}">
                        </div>
                        <div class="am-hide-sm-only am-u-md-6">*必填</div>
                    </div>

                    <div class="am-g am-margin-top sort">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            描述信息
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <textarea rows="4" name="description">{{old('description')}}</textarea>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            是否显示
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input type="radio" name="is_show" value="1" @if(old('is_show') == '1')) checked @endif> 是
                            <input type="radio" name="is_show" value="0" @if(!old('is_show') or old('is_show') =='0'))
                                   checked @endif> 否
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

@endsection