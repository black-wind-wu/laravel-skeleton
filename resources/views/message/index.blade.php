@extends('layouts.app')

@section('title', __('My Messages'))

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="d-block col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <h4 class="mb-3">
                    短消息<span class="float-right"><send-message></send-message></span>
                </h4>
                <div class="message-list border-top">
                    @foreach($messages as $message)
                        <section id="session_{{$message->id}}" class="hover-show message-item">
                            <div class="stream-wrap media">
                                <div class="float-left pr-2">
                                    <a href="{{route('user.space',['id'=>$message->from->id])}}">
                                        <img class="media-object avatar-40" src="{{$message->from->avatar}}"
                                             alt="{{$message->from->username}}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <a href="{{route('user.space',['id'=>$message->from->id])}}">  {{$message->from->username}}</a>:
                                    <div class="full-text fmt"> {{$message->content}}</div>
                                    <div class="meta mt-2">
                                        <span class="text-muted">{{$message->created_at}}</span>
                                        <span class="float-right">
                                            <a href="{{route('user.messages.show',['user_id'=>$message->from_user_id])}}">查看对话详情</a> <span
                                                class="span-line">|</span>
                                            <delete-message session_id="{{$message->id}}"></delete-message>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endforeach
                </div>
                {{ $messages->links() }}
            </div>

            <div class="d-none d-lg-block col-lg-3">
                @include('layouts._right_messages_menu')
            </div>
        </div>
    </div>

@endsection
