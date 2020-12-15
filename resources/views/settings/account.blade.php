@extends('settings.layout')

@section('title', __('User Account'))

@push('footer')
    <!-- 腾讯防水墙 -->
    <script src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
@endpush

@section('panel')
    <settings-account></settings-account>
@endsection
