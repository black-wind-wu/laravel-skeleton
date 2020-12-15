@extends('layouts.app')

@section('title', ($download->metas['title'] ?? $download->title).'_'.$download->category->title.'_'.__('Downloads'))
@section('keywords', $download->metas['keywords'] ?? $download->tag_values)
@section('description', $download->metas['description'] ?? $download->description)

@push('head')
    <meta property="og:type" content="soft"/>
    <meta property="og:site_name" content="{{ config('app.name', 'Larva') }}"/>
    <meta property="og:soft:file_size" content="{{$download->sizeFormat}}"/>
    <meta property="og:release_date" content="{{$download->created_at}}"/>
    <meta property="og:url" content="{{$download->link}}"/>
    <meta property="og:title" content="{{$download->title}}"/>
    <meta property="og:description" content="{{$download->description}}"/>

    <meta itemprop="name" content="{{$download->title}}"/>
    <meta itemprop="description" content="{{$download->description}}"/>
@endpush

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="d-none d-lg-block pr-lg-0 col-lg-1">
                @if (isset($category))
                    <x-widgets.side-download-category id="{{$category->id}}"/>
                @else
                    <x-widgets.side-download-category/>
                @endif
            </div>

            <div class="d-block pr-0 col-xs-12 col-sm-12 col-md-12 col-lg-8">
                <!-- 内容主题部分 -->
                <div class="resource_box">
                    <div class="resource_box_info">
                        <h1>
                            <span class="resource_title">{{$download->title}}</span>
                        </h1>
                        <div class="dl_bread_score">
                            <strong class="info_box">
                                <span>所需积分：<em class="cost">{{$download->score}}</em></span>
                                <span>下载次数：{{$download->download_count}}</span>
                                <span>查看：{{$download->views}}</span>
                                <span><time datetime="{{$download->created_at}}">{{\Carbon\Carbon::parse($download->created_at)->diffForHumans()}}</time></span>
                                <span>{{$download->sizeFormat}}</span>
                                <span>{{$download->file_type}}</span>
                            </strong>
                        </div>
                        <div class="clearfix">
                            <dl class="resource_box_dl">
                                <dd>
                                    <div class="resource_box_desc">
                                        <div class="resource_description">
                                            <p>
                                                {{$download->description}}
                                            </p>
                                        </div>
                                        <div class="resource_box_b">
                                            @if($download->tag_values)
                                                <label class="resource_tags">
                                                    @foreach($download->tags as $tag)
                                                        <a href="{{ route('tag.downloads',['id'=>$tag->id]) }}" class="tag" target="_blank" title="{{$tag->name}}">{{$tag->name}}</a>
                                                    @endforeach
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="resource_box_fn clearfix">
                        <div class="left_fn">
                            <a href="#" class="btn btn-outline-primary float-left mr-2" role="button" aria-disabled="true">立即下载</a>
                            <support id="{{$download->id}}" type="download" num="{{$download->support_count}}"></support>
                            <collect id="{{$download->id}}" type="download" ></collect>
                            <integral-recharge></integral-recharge>
                        </div>
                    </div>
                </div>

                <!-- 用户评论 -->

                <!-- 相关推荐 -->
                <div class="resource_recommend my-2">
                    <div class="download-list">

                    </div>
                </div>

            </div>
            <div class="d-none d-lg-block col-lg-3">
                <div class="side_box mb-3">
                    <div class="box-body">
                        <div class="text-center mt-3">
                            <img src="{{$download->user->avatar}}" class="avatar-5 position-relative"
                                 alt="{{$download->user->username}}">
                        </div>
                        <div class="py-4 bg-white">
                            <a href="{{route('space.index',[$download->user])}}" title="{{$download->user->username}}">
                                <h5 class="text-center mb-2">{{$download->user->username}}</h5>
                            </a>
                            <div class="row mx-0 text-center mb-3">
                                <div class="col px-0">
                                    <div><span class="color0099ee follow_size">{{$download->user->extra->downloads}}</span></div>
                                    <div class="text-muted">资源数</div>
                                </div>
                                <div class="col px-0">
                                    <div><span class="color0099ee">{{$download->user->extra->articles}}</span></div>
                                    <div class="text-muted">文章数</div>
                                </div>
                            </div>
                            <div class="text-center">
                                <!--
                                <a class="btn btn-sm btn-primary" role="button" href="javascript:void(0);" title="点我关注">关注</a>
                                -->
                            </div>
                        </div>
                    </div>
                </div>
                @include('layouts._side')
            </div>
        </div>
        <x-widgets.inner-link/>
    </div>
@endsection
