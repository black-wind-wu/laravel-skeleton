@extends('layouts.app')

@section('title', __('Search'))

@section('content')
    <div class="search-box bg-white">
        <h2 class="text-center">
            <span class="text-success">实时</span>搜索
        </h2>
        <div class="container d-flex justify-content-center mt-5">
            <div class="row" style="width:70%;" >
                <div class="col-12 position-relative">
                    <form role="form" class="" method="GET" action="{{route('search.index')}}">
                        <div class="form-group input-group input-group-lg">
                            <input type="text" class="form-control" name="q" placeholder="输入关键字，搜索本站精彩" autofocus>
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit">{{__('Search')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
