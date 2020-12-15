@extends('layouts.app')

@section('title', __('Contact us'))

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="d-none d-lg-block col-lg-2">
                @include('page._left')
            </div>
            <div class="d-block col-md-12 col-lg-10 bg-white">
                <div class="site-content">
                    <div class="entry-header">
                        <div class="entry-title">{{__('Contact us')}}</div>
                    </div>
                    <div class="entry-content">
                        <p><span style="color: #1054ff;"><strong>媒体合作</strong></span></p>
                        <p>企鹅：79109681</p>
                        <p>微信：xutongle</p>
                        <p>E-Mail：xutongle@larva.com.cn</p>
                        <p>新浪微博：<a href="https://weibo.com/xutongle" target="_blank" rel="noopener">http://weibo.com/xutongle</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

