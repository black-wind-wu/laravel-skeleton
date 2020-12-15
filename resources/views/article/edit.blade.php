@extends('layouts.app')

@section('title', __('Edit Article'))

@section('content')
    <div class="container">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ url('/')}}"><i class="fa fa-home"></i> {{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">{{ __('Articles') }}</a></li>
            <span class="breadcrumb-item active">{{ __('Edit Article') }}</span>
        </ol>
        <div class="row mb-3">
            <div class="d-block bg-white p-3 col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <form id="article_form" method="POST" role="form" enctype="multipart/form-data"
                      action="{{ route('articles.update',[$article]) }}">
                    @method('PUT')
                    @csrf
                    <x-forms.text name="title" label="文章标题" value="{{$article->title}}"/>

                    <div class="form-row">
                        <x-forms.article-category-select name="category_id" label="文章栏目" value="{{$article->category_id}}"
                                                 class="col-md-4"/>
                        <x-forms.tags name="tag_values" label="文章标签" value="{{$article->tag_ids}}" class="col-md-8"/>
                    </div>

                    <x-forms.ckeditor name="content" label="文章正文" value="{!! $article->detail->content !!}"/>

                    <div class="form-row">
                        <x-forms.text name="extra[from]" label="" value="{{$article->detail->extra['from']}}"
                                      placeholder="文章出处" class="col-md-4"/>
                        <x-forms.text name="extra[from_url]" label="" value="{{$article->detail->extra['from_url']}}"
                                      placeholder="原文链接" class="col-md-8"/>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>

            <div class="d-none d-lg-block col-lg-3">
                <div class="side_box mb-3">
                    <div class="box-header">
                        <div class="box-title"> 发布提示</div>
                    </div>
                    <div class="box-body">
                        <div class="box-content">
                            1、标签应尽可能短，请勿包含其他标点符号。<br/>
                            2、请勿发布国家法律法规禁止发布的内容。<br/>
                            3、与人为善，比聪明更重要！
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
