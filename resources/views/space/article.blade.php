@extends('space.layout')

@section('main')
    <div class="space-main">
        <h6 class="heading">{{$items->total()}} 篇文章</h6>
        <ul class="stream-list">
            <li>
                <div class="row">
                    <div class="col-md-8 title-warp">
                        <strong>标题</strong>
                    </div>
                    <div class="col-md-2">
                        <strong>浏览</strong>
                    </div>
                    <div class="col-md-2">
                        <strong>发布日期</strong>
                    </div>
                </div>
            </li>
            @foreach ($items as $item)
            <li>
                <div class="row">
                    <div class="col-md-8 title-warp">
                        <a class="item-title" href="{{$item->link}}">{{$item->title}}</a>
                    </div>
                    <div class="col-md-2"><span class="text-muted">{{$item->views}}</span></div>
                    <div class="col-md-2">
                        <span class="text-muted">{{$item->created_at}}</span>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        <div class="text-center p-2">
            {{ $items->links() }}
        </div>
    </div>
@endsection
