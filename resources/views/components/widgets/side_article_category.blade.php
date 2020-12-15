<div class="side_box mb-3">
    <div class="box-header">
        <div class="box-title">分类目录</div>
    </div>
    <div class="list-group rounded-0">
        @foreach($categories as $category)
        <a href="{{$category->link}}" class="list-group-item list-group-item-action border-0 @if($category_id == $category->id) active @endif">
            {{$category->name}}
        </a>
        @endforeach
    </div>
</div>
