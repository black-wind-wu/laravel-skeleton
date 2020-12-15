@extends('layouts.app')

@section('title', __('Tags'))

@section('content')
    <div class="container">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ url('/')}}"><i class="fa fa-home"></i> {{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tag.index') }}">{{ __('Tags') }}</a></li>
        </ol>

        <div class="row">
            <div class="d-block col-md-12">
                <div class="side_box mb-3">
                    <div class="box-header">
                        <div class="box-title">标签聚合</div>
                    </div>
                    <div class="box-body">
                        @foreach($tags as $tag)
                            <a target="_blank" href="{{$tag->link}}">{{$tag->name}}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
