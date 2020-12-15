@extends('layouts.amp')

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
    <article class="amp-article">
        <header class="amp-article-header">
            <h1 class="amp-title">{{ $article->title }}</h1>
            <div class="amp-meta amp-byline">
                <amp-img src="{{$article->user->avatar}}" alt="{{$article->user->username}}" width="24" height="24"
                         layout="fixed" class="i-amphtml-layout-fixed i-amphtml-layout-size-defined"
                         style="width:24px;height:24px;" i-amphtml-layout="fixed"></amp-img>
                <span class="amp-author author vcard">{{$article->user->username}}</span>
            </div>
            <div class="amp-meta amp-posted-on">
                <time datetime="{{$article->created_at}}">{{$article->created_at->diffForHumans()}}</time>
            </div>
        </header>

        <div class="amp-article-content">
            {!! $article->detail->content !!}
        </div>

        <footer class="amp-article-footer">
            <div class="amp-meta amp-tax-category">
                Categories: <a href="{{ $article->category->link }}"
                               rel="category tag">{{ $article->category->name }}</a></div>
        </footer>
    </article>
@endsection
