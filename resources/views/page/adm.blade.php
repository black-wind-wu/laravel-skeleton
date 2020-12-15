@extends('layouts.app')

@section('title', __('Advertising Services'))

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="d-none d-lg-block col-lg-2">
                @include('page._left')
            </div>
            <div class="d-block col-md-12 col-lg-10 bg-white">
                <div class="site-content">
                    <div class="entry-header">
                        <div class="entry-title">{{__('Advertising Services')}}</div>
                    </div>

                    <div class="entry-content">
                        广告服务
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
