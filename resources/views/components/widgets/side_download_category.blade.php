<div class="list-group left-menu">
    @foreach($categories as $category)
        <a href="{{$category->link}}" title="{{$category->name}}" class="list-group-item list-group-item-action @if($category_id == $category->id) active @endif">{{$category->name}}</a>
    @endforeach
</div>

