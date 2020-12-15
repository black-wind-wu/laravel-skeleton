@extends('layouts.app')

@push('head')
    <meta property="og:title" content="{{ settings('system.title') }}"/>
    <meta property="og:description" content="{{settings('system.description')}}"/>
    <meta property="og:url" content="{{ config('app.url') }}"/>
    <meta property="og:image" content="{{ asset('img/logo.png') }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="{{ config('app.name', 'Larva') }}"/>
@endpush

@section('content')
    <div class="container py-3">
        <div class="row  mb-3">
            <div class="d-block pr-lg-0 col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <x-widgets.home-carousel class="mb-3"/>

                <nav class="home_tab bg-white">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-main-tab" data-toggle="tab" href="#nav-main"
                           role="tab" aria-controls="nav-main" aria-selected="true">最新</a>
                        <a class="nav-item nav-link" id="nav-news-tab" data-toggle="tab" href="#nav-news" role="tab"
                           aria-controls="nav-news" aria-selected="false">快讯</a>
                        <a class="nav-item nav-link" id="nav-downloads-tab" data-toggle="tab" href="#nav-downloads" role="tab"
                           aria-controls="nav-downloads" aria-selected="false">下载</a>
                    </div>
                </nav>
                <div class="tab-content bg-white" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-main" role="tabpanel" aria-labelledby="nav-main-tab">
                        <x-widgets.home-article limit="10"/>
                    </div>
                    <div class="tab-pane fade show" id="nav-news" role="tabpanel" aria-labelledby="nav-news-tab">
                        <x-widgets.home-news limit="10"/>
                    </div>
                    <div class="tab-pane fade show" id="nav-downloads" role="tabpanel" aria-labelledby="nav-downloads-tab">
                        <x-widgets.home-download limit="10"/>
                    </div>
                </div>
            </div>

            <div class="d-none d-lg-block col-lg-3">
                @include('layouts._side')
            </div>
        </div>
        <x-widgets.home-link/>
    </div>
@endsection
