<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="vi"> <!--<![endif]-->
@include('theme_mypham.master.layout_header')
<body class="@yield('body_class')" @yield('body_attr')>
	@include('theme_mypham.master.layout_menu_top')

	@yield('layout_content')
	@include('theme_mypham.master.layout_sidebar_footer')
	@include('theme_mypham.master.layout_footer')