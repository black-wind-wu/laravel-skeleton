@extends('layouts.app')

@section('title', __('News'))
@section('keywords', '科技媒体,大数据,企业级服务')

@section('content')
    <div class="container">
        <div class="page-header">
            <div class="page-title">{{__('News')}}</div>
        </div>
        <div class="row">
            <div class="d-block pr-lg-0 col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <ul class="list-unstyled">
                    @foreach ($items as $item)
                        <li class="media p-4 bg-white" style="overflow: hidden;">
                                <div class="media-body position-relative">
                                    <a href="{{$item->link}}" target="_blank" class="article_url"
                                       title="{{$item->title}}">
                                        <h4 class="article_title">{{$item->title}}</h4>
                                        <div class="article-excerpt">{{$item->description}}</div>
                                    </a>
                                    <div class="row article_userinfo small mx-0">
                                        <div class="col-4 text-truncate px-0">
                                            @if($item->from)
                                                <span class="text-black-50">来源：{{$item->from}}</span>
                                            @endif
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
                @include('layouts._side')
            </div>
        </div>
        <x-widgets.inner-link/>
    </div>
@endsection
