@extends('layouts.app')

@section('title', __('Upload Resource'))

@section('content')
    <div class="container">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ url('/')}}"><i class="fa fa-home"></i> {{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('downloads.index') }}">{{ __('Downloads') }}</a></li>
            <span class="breadcrumb-item active">{{ __('Upload Resource') }}</span>
        </ol>
        <div class="row mb-3">
            <div class="d-block bg-white p-3 col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <form id="article_form" method="POST" role="form" enctype="multipart/form-data"
                      action="{{ route('downloads.store') }}">
                    @csrf

                    <x-forms.file name="file" label="资源文件" placeholder="请输入资源描述"/>

                    <x-forms.text name="title" label="资源标题" placeholder="我想起那天下午在夕阳下的奔跑,那是我逝去的青春"/>

                    <x-forms.textarea name="content" label="资源描述" placeholder="请输入资源描述"/>

                    <div class="form-row">
                        <x-forms.download-category-select name="category_id" label="资源栏目" class="col-md-4"/>
                        <x-forms.tags name="tag_values" label="资源标签" class="col-md-8"/>
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
