@extends('layouts.admin.partials.application')
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">微信设置</strong> /
                <small>Wechat Config</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-12">

                <div class="am-tab-panel">

                    <form class="am-form " action="{{route('wechat.config.update')}}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                wechat_app_id
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <textarea rows="2" name="wechat_app_id" placeholder="公众号AppID">{{$w_config->wechat_app_id}}</textarea>
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                wechat_secret
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <textarea rows="3" name="wechat_secret" placeholder="公众号AppSecret">{{$w_config->wechat_secret}}</textarea>
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                wechat_token
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="wechat_token" placeholder="公众号Token" value="{{$w_config->wechat_token}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                wechat_aes_key
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="wechat_aes_key" placeholder="公众号EncodingAESKey" value="{{$w_config->wechat_aes_key}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                pay_mch_id
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="pay_mch_id" placeholder="微信支付pay_mch_id" value="{{$w_config->pay_mch_id}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                pay_api_key
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="pay_api_key" placeholder="微信支付API 密钥" value="{{$w_config->pay_api_key}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                pay_cert_path
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="pay_cert_path" placeholder="微信支付pay_cert_path绝对路径" value="{{$w_config->pay_cert_path}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                pay_key_path
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="pay_key_path" placeholder="微信支付pay_key_path绝对路径" value="{{$w_config->pay_key_path}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                op_app_id
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="op_app_id" placeholder="开放平台AppID"
                                       value="{{$w_config->op_app_id}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                op_secret
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="op_secret" placeholder="开放平台AppSecret" value="{{$w_config->op_secret}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                op_token
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="op_token" placeholder="开放平台token" value="{{$w_config->op_token}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                op_aes_key
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="op_aes_key" placeholder="开放平台aes_key" value="{{$w_config->op_aes_key}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                work_corp_id
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="work_corp_id" placeholder="微信企业号corp_id" value="{{$w_config->work_corp_id}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                work_agent_id
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="work_agent_id" placeholder="微信企业号agent_id" value="{{$w_config->work_agent_id}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                work_secret
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="work_secret" placeholder="微信企业号secret" value="{{$w_config->work_secret}}">
                            </div>
                        </div>
                        <div class="am-margin">
                            <button type="submit" class="am-btn am-btn-primary">保存修改</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection