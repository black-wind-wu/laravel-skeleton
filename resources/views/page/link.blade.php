@extends('layouts.app')

@section('title', __('Friend Link'))

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="d-none d-lg-block col-lg-2">
                @include('page._left')
            </div>
            <div class="d-block col-md-12 col-lg-10 bg-white">
                <div class="site-content">
                    <div class="entry-header">
                        <div class="entry-title">{{__('Friend Link')}}</div>
                    </div>
                    <div class="entry-content">
                        <h6>申请要求：</h6>
                        <p>1、 ALEXA排名2万以内，未被百度、Google等搜索引擎封杀的网站；<br>
                            2、 百度收录≥5万；<br>
                            3、 百度权重≥3；<br>
                            4、 友链要求互联网相关行业站点优先的网站。</p>
                        <p>以上数据查询结果以爱站网为准，同时满足以上三点站点，即可申请与{{ config('app.name', 'Laravel') }}申请友情链接！</p>
                        <h6>申请步骤：</h6>
                        <p>1、 请先在贵站做{{ config('app.name', 'Laravel') }}的文字友情链接：</p>
                        <blockquote><p>链接文字：{{ config('app.name', 'Laravel') }}<br>
                                链接地址：{{ config('app.url') }}</p></blockquote>
                        <p>2、 做好链接后，请通过邮箱：{{ settings('system.support_email') }} 建立联系。<br>
                            3、 已经链接我站友情链接且内容健康，符合本站友情链接要求的网站，经管理员审核后，可在我方友情链接页面显示。</p>
                        <p><span style="color: #ff0000;">注：{{ config('app.name', 'Laravel') }}做为信息平台，主要依托在搜索引擎的排名结果获取大量的流量来源，所以{{ config('app.name', 'Laravel') }}只希望与高质量，高收录的网站进行友情链接，如贵站未满足我站友情链接要求，还请谅解！</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
