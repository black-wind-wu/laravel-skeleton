<div class="side_box mb-3">
    <div class="box-header">
        <div class="box-title">快讯</div>
    </div>
    <div class="articles-li">
        <div class="articles-change">
            @foreach($items as $item)
                <div class="articles-title">
                    <a href="{{$item->link}}" class="ignored"
                       title="{{$item->title}}">{{$item->title}}</a>
                    <span>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
