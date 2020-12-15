@extends('layouts.app')

@section('title', ($article->metas['title'] ?? $article->title).'_'.$article->category->name.'_'.__('Articles'))
@section('keywords', $article->metas['keywords'] ?? $article->tag_values)
@section('description', $article->metas['description'] ?? $article->description)

@push('head')
    <link rel="canonical" href="{{$article->link}}">
    @if(settings('system.system.amp_enabled'))
        <link rel="amphtml" href="{{$article->ampLink}}"/>@endif
    @if(settings('system.system.mip_enabled'))
        <link rel="miphtml" href="{{$article->mipLink}}"/>@endif
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="{{ config('app.name', 'Larva') }}"/>
    <meta property="og:image" content="{{$article->thumb}}"/>
    <meta property="og:release_date" content="{{$article->created_at}}"/>
    <meta property="og:url" content="{{$article->link}}"/>
    <meta property="og:title" content="{{$article->title}}"/>
    <meta property="og:description" content="{{$article->description}}"/>
    <meta itemprop="name" content="{{$article->title}}"/>
    <meta itemprop="description" content="{{$article->description}}"/>
    <meta itemprop="image" content="{{$article->thumb}}"/>
@endpush

@section('content')
    <div class="container">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ url('/')}}"><i class="fa fa-home"></i> {{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">{{ __('Articles') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ $article->category->link }}">{{ $article->category->name }}</a></li>
            <li class="breadcrumb-item active">正文</li>
        </ol>
        <div class="row">
            <div class="d-block pr-md-0 col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="article bg-white position-relative p-3">
                    <div class="article-header">
                        <h2 class="article-title">{{ $article->title }}</h2>
                        <div class="article-meta">
                            @if($article->detail->extra['from'])
                                <span class="item">来源： <a href="{{$article->detail->extra['from_url']}}"
                                                          title="{{$article->detail->extra['from']}}"
                                                          target="_blank">{{$article->detail->extra['from']}}</a></span>
                            @endif
                            <span class="item">发布时间：{{$article->created_at}}</span>
                            <span class="item">阅读：{{$article->views}}</span>
                        </div>
                    </div>
                    <article class="ck-content">
                        <x-widgets.ads id="3"/>
                        {!! $article->detail->content !!}

                        <div class="text-center">
                            <support id="{{$article->id}}" type="article" num="{{$article->support_count}}" size="lg"></support>
                            <collect id="{{$article->id}}" type="article" size="lg"></collect>
                        </div>
                    </article>
                    <div class="d-none d-md-block article-footer">
                        <div>文章为作者独立观点，不代表{{config('app.name')}}立场。</div>
                        <div>本文由{{$article->user->username}}发表，转载此文章须经作者同意，并请附上出处( {{config('app.name')}} )及本页链接。
                        </div>
                        <div class="mylink">原文链接 {{$article->link}}</div>
                        @if($article->tag_values)
                            <div class="keywords">
                                @foreach($article->tags as $tag)
                                    <a href="{{ route('tag.articles',$tag) }}" title="{{$tag->name}}">{{$tag->name}}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div>
                        <x-widgets.ads id="4"/>
                    </div>
                </div>
            </div>

            <div class="d-none d-lg-block col-lg-3">
                <div class="side_box mb-3">
                    <div class="box-body">
                        <div class="text-center mt-3">
                            <img src="{{$article->user->avatar}}" class="avatar-5 position-relative"
                                 alt="{{$article->user->username}}">
                        </div>
                        <div class="py-4 bg-white">
                            <a href="{{route('space.index',[$article->user])}}" title="{{$article->user->username}}">
                                <h5 class="text-center mb-2">{{$article->user->username}}</h5>
                            </a>
                            <div class="row mx-0 text-center mb-3">
                                <div class="col px-0">
                                    <div><span
                                            class="color0099ee follow_size">{{$article->user->extra->downloads}}</span>
                                    </div>
                                    <div class="text-muted">资源数</div>
                                </div>
                                <div class="col px-0">
                                    <div><span class="color0099ee">{{$article->user->extra->articles}}</span></div>
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

                <x-widgets.side-article-category id="{{$article->category_id}}"/>
                @include('layouts._side')
            </div>
        </div>

        <x-widgets.inner-link/>
    </div>
@endsection
