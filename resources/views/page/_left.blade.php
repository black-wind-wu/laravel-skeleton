<div class="list-group page-menu border">
    <a href="{{ route('page.about') }}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'page.about') active @endif">{{__('About us')}}</a>
    <a href="{{ route('page.contact') }}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'page.contact') active @endif">{{__('Contact us')}}</a>
    <a href="{{ route('page.terms') }}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'page.terms') active @endif">{{__('Terms')}}</a>
    <a href="{{ route('page.privacy') }}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'page.privacy') active @endif">{{__('Privacy')}}</a>
    <a href="{{ route('page.copyright') }}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'page.copyright') active @endif">{{__('Copyright')}}</a>
    <a href="{{ route('page.adm') }}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'page.adm') active @endif">{{__('Advertising Services')}}</a>
    <a href="{{ route('page.delete') }}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'page.delete') active @endif">{{__('Infringement Deletion')}}</a>
    <a href="{{ route('page.link') }}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'page.link') active @endif">{{__('Friend Link')}}</a>
</div>
