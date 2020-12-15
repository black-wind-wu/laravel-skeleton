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
