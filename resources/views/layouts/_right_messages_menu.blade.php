<div class="widget-messages">
    <a class="widget-message-item @if(request()->route()->getName() == 'user.notifications') active @endif"
       href="{{route('user.notifications')}}">{{__('My Notifications')}}</a>
    <a class="widget-message-item  @if(request()->route()->getName() == 'user.messages') active @endif"
       href="{{route('user.messages')}}">{{__('My Messages')}}</a>
</div>
