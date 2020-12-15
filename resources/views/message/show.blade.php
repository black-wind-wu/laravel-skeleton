@extends('layouts.app')

@section('title', __('My Messages'))

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="d-block col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="text-muted">
                    <span>发私信给 <a href="{{route('user.space',['id'=>$from->id])}}">{{$from->username}}</a> ： </span>
                    <span class="float-right"><a href="{{ route('user.messages') }}" class="text-muted">返回</a></span>
                </div>
                <div class="mt-3">
                    <form method="POST" action="{{ route('user.messages.store') }}">
                        @csrf
                        <input type="hidden" name="to_user_id" value="{{$from->id}}">
                        <div class="form-group">
                            <textarea name="content" placeholder="请输入私信内容" class="form-control @error('content') is-invalid @enderror"
                                      style="height:100px;">{{ old('content') }}</textarea>
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary float-right">发&nbsp;&nbsp;送</button>
                        </div>
                    </form>
                </div>


                <div class="message-list mt-6 border-top">
                    @foreach($messages as $message)
                        <section id="session_{{$message->id}}" class="hover-show message-item">
                            <div class="media">
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
                                            <delete-message session_id="{{$message->id}}"></delete-message>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
