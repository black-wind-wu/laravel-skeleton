<div class="row py-3">
    <div class="d-none d-md-block col-md-12">
        <div class="side_box mb-3">
            <div class="box-header">
                <div class="box-title">{{__('Friend Link')}}</div>
                <a href="{{route('page.link')}}" class="box-title-link">申请链接</a>
            </div>
            <div class="box-body">
                @foreach ($links as $link)
                    <a href="{{$link->url}}" target="_blank" title="{{$link->title}}">{{$link->title}}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
