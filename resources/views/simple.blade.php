<!DOCTYPE html>
<html lang="{{ $site_locale }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('site_meta')
    <title>{{ $site_name }}@yield('site_title')</title>
    <meta name="description" content="@section('site_description'){{ $site_description }}@show">
@include('favicons')
    @yield('lib_styles')
    @yield('extended_styles')
</head>
<body>
@yield('body')
@yield('lib_scripts')
@yield('extended_scripts')
</body>
</html>