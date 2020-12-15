<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <meta http-equiv="Cache-Control" content="no-transform"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="renderer" content="webkit">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="Description" content="@yield('description', settings('system.description'))">
    <meta name="Keywords" content="@yield('keywords', settings('system.keywords'))">
    <title>@yield('title', settings('system.title'))@if (request()->path() != '/') - {{ config('app.name', 'Laravel') }}@endif</title>
    <!-- Styles -->
    <link href="{{ asset(mix('/css/app.css')) }}" rel="stylesheet">
@stack('head')
</head>
<body>
<div id="app">
    <!-- Header -->
    <header>
        @include('layouts._header')
    </header>
    <!-- End Header -->
    @yield('jumbotron')
    @yield('content')
    <!-- Footer -->
    <footer>
        @include('layouts._footer')
    </footer>
    <!-- End Footer -->
    <go-top />
</div>
<!-- Scripts -->
<script src="{{ asset(mix('/js/manifest.js')) }}"></script>
<script src="{{ asset(mix('/js/vendor.js')) }}"></script>
<script src="{{ asset(mix('/js/app.js')) }}"></script>
@stack('scripts')
@stack('footer')
</body>
</html>
