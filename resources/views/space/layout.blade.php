@extends('layouts.app')

@section('jumbotron')
    <div class="space pt-5 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <a class="text-left" href="{{route('space.index',[$user])}}">
                        <img class="avatar-128" src="{{$user->avatar}}" alt="{{$user->username}}">
                    </a>
                </div>
                <div class="col-md-7">
                    <div class="m-0 h3">{{$user->username}}</div>
                    <hr class="my-4">
                    <div>
                        <span class="text-muted">性别： <i class="fa fa-fw fa-lg @if($user->profile->gender==1) fa-mars @elseif($user->profile->gender==2) fa-venus @else fa-genderless @endif"></i> </span>
                        <span class="text-muted"><i class="fa fa-fw fa-map-marker"></i> {{$user->profile->address}} </span>
                        <span class="text-muted"><i class="fa fa-fw fa-calendar"></i> 注册于 {{$user->created_at}}</span>
                    </div>
                    <div class="space-header-desc mt-3"><p>{{$user->profile->bio}}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mt-3">
                        <follow id="{{$user->username}}" type="user" ></follow>
                        <button class="btn btn-default btnMessageTo" data-toggle="modal" data-target="#sendTo_message_model" data-to_user_id="9123" data-to_user_name="{{$user->username}}">发私信</button>
                    </div>
                    <div class="space-header-info row mt-4">
                        <div class="col-md-4">
                            <span class="h3">
                                <a href="coins">10</a>
                            </span>
                            <span class="text-muted">积分数</span>
                        </div>
                        <div class="col-md-4">
                            <span class="h3">
                                <a href="credits">30</a>
                            </span>
                            <span class="text-muted">经验值</span>
                        </div>
                        <div class="col-md-4">
                        <span class="h3">
                            <a id="follower-num" href="followers">0</a>
                        </span>
                            <span class="text-muted">个粉丝</span>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top text-muted">
                        <i class="fa fa-paw"></i> 主页被访问 {{$user->extra->views}} 次
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-4">
        <div class="row">
            <div class="d-none d-lg-block col-lg-2">
                <ul class="nav space-nav flex-column">
                    <li class="nav-item"><a class="nav-link @if (request()->route()->getName() == 'space.index') active @endif" href="{{route('space.index',[$user])}}">TA的主页</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->route()->getName() == 'space.articles') active @endif" href="{{route('space.articles',[$user])}}">TA的文章</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->route()->getName() == 'space.downloads') active @endif" href="{{route('space.downloads',[$user])}}">TA的资源</a></li>
                    <li class="divider"></li>
                    <li class="nav-item"><a class="nav-link @if (request()->route()->getName() == 'space.index') active @endif" href="{{route('space.index',[$user])}}">TA的积分</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->route()->getName() == 'space.collections') active @endif" href="{{route('space.collections',[$user])}}">TA的收藏</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->route()->getName() == 'space.index') active @endif" href="{{route('space.index',[$user])}}">TA的粉丝</a></li>
                </ul>
            </div>

            <div class="d-block col-xs-12 col-sm-12 col-md-12 col-lg-10 bg-white">
                @yield('main')
            </div>
        </div>
    </div>
@endsection
