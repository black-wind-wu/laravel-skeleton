@extends('layouts.app')

@section('content')
    <div class="container my-3">
        <div class="row">
            <div class="d-none d-lg-block pr-0 col-lg-3">
                左侧菜单
            </div>

            <div class="d-block col-xs-12 col-sm-12 col-md-12 col-lg-9">
                右侧操作
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
