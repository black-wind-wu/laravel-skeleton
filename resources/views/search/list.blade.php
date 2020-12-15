@extends('layouts.app')

@section('title', $q.' - '.__('Search'))
@section('keywords', $q)
@section('description', $q.' - 搜索结果')

@push('head')
    <link rel="canonical" href="{{route('search.query',['q'=>$q])}}"/>
@endpush

@section('content')
    <div class="container">
        <div class="page-header">
            <div class="page-title">{{$q}}:的搜索结果</div>
        </div>

        <div class="row">
            <div class="d-block col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <nav class="home_tab bg-white">
                    <div class="nav nav-tabs">
                        <a class="nav-item nav-link @if (request()->route()->getName() == 'tag.articles') active @endif"
                           id="nav-main-tab" data-toggle="tab" href="xxx"
                           role="tab" aria-controls="nav-main" aria-selected="true">{{__('Articles')}}</a>
                    </div>
                </nav>

                <ul class="list-unstyled">
                    @foreach ($items as $item)
                        <li class="media p-4 bg-white" style="overflow: hidden;">
                            <img class="mr-4 article-img rounded" src="{{$item->thumb}}"
                                 alt="Generic placeholder image">
                            <div class="media-body position-relative">
                                <a href="{{ route('articles.show',$item) }}" target="_blank" class="article_url"
                                   title="{{$item->title}}">
                                    <h4 class="article_title">{{$item->title}}</h4>
                                    <div class="article-excerpt">{{$item->description}}</div>
                                </a>
                                <div class="row article_userinfo small mx-0">
                                    <div class="col-4 text-truncate px-0">
                                        <span class="text-black-50 small">作者 :</span>
                                        <a href="#" class="article_author small mr-2">{{$item->user->username}}</a>
                                    </div>
                                    <div class="col-8 text-right text-truncate px-0" style="color: #888;">
                                        已有 <span class="read_number_style">{{$item->views}}</span>
                                        人阅读・<span>{{$item->created_at}}</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="text-center mt-4">

                </div>
            </div>
            <div class="d-none d-xl-block col-lg-3">
                @include('layouts._side')
            </div>
        </div>

        <x-widgets.inner-link/>
    </div>
@endsection
