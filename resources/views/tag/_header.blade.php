<nav class="home_tab bg-white">
    <div class="nav nav-tabs">
        <a class="nav-item nav-link @if (request()->route()->getName() == 'tag.articles') active @endif" href="{{route('tag.articles',$tag)}}">{{__('Articles')}}</a>
        <a class="nav-item nav-link @if (request()->route()->getName() == 'tag.news') active @endif" href="{{route('tag.news',$tag)}}">{{__('News')}}</a>
        <a class="nav-item nav-link @if (request()->route()->getName() == 'tag.downloads') active @endif" href="{{route('tag.downloads',$tag)}}">{{__('Downloads')}}</a>
    </div>
</nav>

