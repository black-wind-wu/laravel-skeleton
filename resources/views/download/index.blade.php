@extends('layouts.app')

@if (isset($category))
    @section('title', $category->title.'_'. __('Downloads'))
    @section('keywords', $category->keywords)
    @section('description', $category->description)
@else
    @section('title', __('Downloads'))
    @section('keywords', '程序源代码,开源程序,开发,分享,搜索,下载,code,Android,iOS,Matlab,c++, python, java, perl,c#,javascript,PHP,c语言,编程,程序员')
    @section('description', '非常全面、好用的源代码分享、下载网站。我们致力于为广大 IT 开发者、程序员、编程爱好者、互联网领域工作者提供海量的程序源代码、开源程序、开源工程，开发、分享、搜索和下载服务。')
@endif

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
                <div class="side_box">
                    <div class="box-header">
                        <div class="box-title">@if (isset($category)) {{$category->title}} @else {{__('Downloads')}} @endif</div>
                    </div>
                    <ul class="list-unstyled download-list">
                        @foreach ($items as $item)
                            <li class="media p-4 bg-white">
                                <img  class="mr-4 download_img" src="{{ $item->fileIcon }}">
                                <div class="media-body position-relative">
                                    <a href="{{$item->link}}" target="_blank" title="{{$item->title}}">
                                        <h4 class="download_title">{{$item->title}}</h4>
                                        <div class="download_excerpt">{{$item->description}}</div>
                                    </a>
                                    <div class="row download_userinfo small mx-0">
                                        <div class="col-4 text-truncate px-0">
                                            <span class="text-black-50 small">上传 :</span>
                                            <a href="{{route('space.index',[$item->user])}}" class="article_author small mr-2">{{$item->user->username}}</a>
                                        </div>
                                        <div class="col-8 text-right text-truncate px-0" style="color: #888;">
                                            已有 <span class="read_number_style">{{$item->views}}</span>
                                            人查看・<span class="read_number_style">{{$item->download_count}}</span>
                                            次下载<span>・{{$item->created_at}}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="text-center p-2">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>

            <div class="d-none d-lg-block col-lg-3">
                @include('layouts._side')
            </div>
        </div>
        <x-widgets.inner-link/>
    </div>
@endsection
