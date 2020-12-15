@extends('layouts.app')

@if (isset($category))
    @section('title', $category->title.'_'. __('Articles'))
@section('keywords', $category->keywords)
@section('description', $category->description)
@else
    @section('title', __('Articles'))
@section('keywords', '科技媒体,大数据,企业级服务')
@endif

@section('content')
    <div class="container">
        <div class="page-header">
            <div class="page-title">@if (isset($category)) {{$category->name}} @else {{__('Articles')}} @endif</div>
        </div>
        <div class="row">
            <div class="d-block pr-md-0  col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <ul class="list-unstyled">
                    @foreach ($items as $item)
                        <li class="media p-4 bg-white" style="overflow: hidden;">
                            <img class="mr-4 article_img rounded" src="{{$item->thumb}}" alt="{{$item->title}}">
                            <div class="media-body position-relative">
                                <a href="{{$item->link}}" target="_blank" title="{{$item->title}}">
                                    <h4 class="article_title">{{$item->title}}</h4>
                                    <div class="article_excerpt">{{$item->description}}</div>
                                </a>
                                <div class="row article_userinfo small mx-0">
                                    <div class="col-4 text-truncate px-0">
                                        <span class="text-black-50 small">作者 :</span>
                                        <a href="{{route('space.index',[$item->user])}}" class="article_author small mr-2">{{$item->user->username}}</a>
                                    </div>
                                    <div class="col-8 text-right text-truncate px-0" style="color: #888;">
                                        已有 <span class="read_number_style">{{$item->views}}</span>
                                        人阅读・<span>{{$item->created_at}}</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @if($loop->iteration % 5 == 0)
                            <li class="p-4 bg-white">广告位</li>
                        @endif
                    @endforeach
                </ul>
                <div class="text-center p-2">
                    {{ $items->links() }}
                </div>
            </div>

            <div class="d-none d-lg-block col-lg-3">
                @if (isset($category))
                    <x-widgets.side-article-category id="{{$category->id}}"/>
                @else
                    <x-widgets.side-article-category/>
                @endif
                @include('layouts._side')
            </div>
        </div>
        <x-widgets.inner-link/>
    </div>
@endsection
