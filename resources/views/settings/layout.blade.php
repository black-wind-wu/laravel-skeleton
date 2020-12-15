@extends('layouts.app')

@section('content')
    <div class="container py-3">
        <div class="row">
            <!--左侧菜单-->
            <div class="d-none d-lg-block col-lg-2">
                <div class="list-group left-menu" role="menu">
                    <a href="{{route('settings.profile')}}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'settings.profile') active @endif"><span>个人信息</span></a>
                    <a href="{{route('settings.account')}}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'settings.account') active @endif"><span>帐户管理</span></a>
                    <a href="{{route('settings.login-histories')}}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'settings.login-histories') active @endif"><span>帐户安全</span></a>
                    <a href="{{route('settings.settle')}}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'settings.settle') active @endif"><span>提现账户</span></a>
                    @if(settings('wallet.enable'))
                        <a href="{{route('settings.balance')}}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'settings.balance') active @endif"><span>余额管理</span></a>
                    @endif
                    <a href="{{route('settings.integral')}}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'settings.integral') active @endif"><span>积分管理</span></a>
                    <a href="{{route('settings.tokens')}}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'settings.tokens') active @endif"><span>Token</span></a>
                    <a href="{{route('settings.applications')}}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'settings.applications') active @endif"><span>OAuth 应用</span></a>
                    <a href="{{route('settings.authorization')}}" class="list-group-item list-group-item-action @if (request()->route()->getName() == 'settings.authorization') active @endif"><span>授权</span></a>
                </div>
            </div>

            <div class="d-block col-lg-10 bg-white">
                @yield('panel')
            </div>
        </div>
    </div>
@endsection
