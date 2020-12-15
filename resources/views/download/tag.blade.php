@extends('layouts.app')

@section('title', $tag->title.'_'.__('Articles'))
@section('keywords', $tag->keywords)
@section('description', $tag->description)

@section('content')
    <div class="container">
        <div class="page-header">
            <div class="page-title">{{$tag->name}}</div>
        </div>

        <div class="row">
            <div class="d-block pr-lg-0 col-xs-12 col-sm-12 col-md-12 col-lg-9">
                @include('tag._header',['tag'=>$tag])

            </div>
            <div class="d-none d-lg-block col-lg-3">
                @include('layouts._side')
            </div>
        </div>
        <x-widgets.inner-link/>
    </div>
@endsection
