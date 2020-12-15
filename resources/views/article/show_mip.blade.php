@extends('layouts.mip')

@section('title', ($article->metas['title'] ?? $article->title).'_'.$article->category->name.'_'.__('Articles'))
@section('keywords', $article->metas['keywords'] ?? $article->tag_values)
@section('description', $article->metas['description'] ?? $article->description)

@push('head')
    <link rel="canonical" href="{{$article->link}}">
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
    <article class="mip-article">
        <header class="mip-article-header">
            <h1 class="mip-title">{{ $article->title }}</h1>
            <div class="mip-meta mip-byline">
                <mip-img src="{{$article->user->avatar}}" alt="{{$article->user->username}}" width="24" height="24"
                         layout="fixed" class="i-miphtml-layout-fixed i-miphtml-layout-size-defined"
                         style="width:24px;height:24px;" i-miphtml-layout="fixed"></mip-img>
                <span class="mip-author author vcard">{{$article->user->username}}</span>
            </div>

            <div class="mip-meta mip-posted-on">
                <time datetime="{{$article->created_at}}">{{$article->created_at->diffForHumans()}}</time>
            </div>
        </header>

        <div class="mip-article-content">
            {!! $article->detail->content !!}
        </div>

        <footer class="mip-article-footer">
            <div class="mip-meta mip-tax-category">
                Categories: <a href="{{ $article->category->link }}"
                               rel="category tag">{{ $article->category->name }}</a></div>
        </footer>
    </article>
@endsection
