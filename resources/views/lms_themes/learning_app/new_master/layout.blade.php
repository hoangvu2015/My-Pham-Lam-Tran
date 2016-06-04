<!DOCTYPE html>
<html lang="{{ $site_locale }}" ng-app="Lms_App" ng-controller="appCtrl">
@include('lms_themes.learning_app.new_master.layout_header')
<body class="canvas @yield('body_class') general" @yield('body_attr')>
	@include('lms_themes.learning_app.new_master.layout_menu_top')

	@yield('layout_content')
	@include('lms_themes.learning_app.new_master.layout_sidebar_footer')
	@include('lms_themes.learning_app.new_master.layout_footer')