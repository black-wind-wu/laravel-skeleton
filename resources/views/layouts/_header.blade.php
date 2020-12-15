<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- 左侧 -->
            <ul class="navbar-nav d-flex mr-auto">
                <li class="nav-item @if (request()->path() == '/') active @endif">
                    <a class="nav-link" href="{{ url('/') }}">{{ __('Home') }}</a>
                </li>
                <li class="nav-item @if (request()->route()->getName() == 'news.index') active @endif">
                    <a class="nav-link" href="{{ route('news.index') }}">{{__('News')}}</a>
                </li>
                <li class="nav-item @if (request()->route()->getName() == 'articles.index') active @endif">
                    <a class="nav-link" href="{{ route('articles.index') }}">{{__('Articles')}}</a>
                </li>
                <li class="nav-item @if (request()->route()->getName() == 'downloads.index') active @endif">
                    <a class="nav-link" href="{{ route('downloads.index') }}">{{__('Downloads')}}</a>
                </li>
            </ul>

            <!-- 右侧 -->
            <form class="form-inline d-flex my-lg-0 d-none d-lg-block" action="{{route('search.index')}}" method="get">
                <div class="input-group">
                    <input type="text" id="search" class="form-control" name="q" value="@isset($q){{$q}}@endisset" placeholder="{{__('Search')}}" autocomplete="off">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-primary d-none d-md-block">
                            <i class="fa fa-search fa-w-16"></i>
                        </button>
                    </span>
                </div>
            </form>

            <ul class="navbar-nav navbar-right d-flex">
                <li class="nav-item dropdown my-lg-0 d-none d-lg-block" v-show="!guest">
                    <a id="dropdownAddButton" class="nav-link dropdown-toggle" href="javascript:" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-plus" aria-hidden="true"></i> 发布
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownAddButton">
                        <a class="dropdown-item" href="{{route('articles.create')}}">
                            {{__('Articles')}}
                        </a>
                        <a class="dropdown-item" href="{{route('downloads.create')}}">
                            {{__('Resource')}}
                        </a>
                    </div>
                </li>

                <!-- Authentication Links -->
                <li class="nav-item" v-show="guest">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item" v-show="guest">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif

                <li class="nav-item" v-show="!guest">
                    <a href="{{ route('user.notifications') }}" class="nav-link"><i class="fa fa-bell"></i></a>
                </li>
                <li class="nav-item" v-show="!guest">
                    <a href="{{ route('user.messages') }}" class="nav-link"><i class="fa fa-envelope"></i></a>
                </li>

                <li class="nav-item dropdown" style="display: none;" v-show="!guest">

                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="javascript:" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="avatar-1" v-bind:alt="username" v-bind:src="avatar">
                        <span v-text="username"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('settings.profile')}}">{{__('User Profile')}}</a>
                        <a class="dropdown-item" href="{{route('settings.account')}}">{{__('User Account')}}</a>
                        <a class="dropdown-item" href="{{route('settings.integral')}}">{{ __('User Integral') }}</a>
                        @if(settings('wallet.enable'))<a class="dropdown-item" href="{{route('settings.balance')}}">{{ __('User Balance') }}</a>@endif
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" data-no-instant>
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
