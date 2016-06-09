<head>

    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{!! theme_title() !!}</title>
    <meta name="author" content="{!! theme_author() !!}">
    <meta name="description" content="{!! theme_description() !!}">
    <meta name="keywords" content="{!! theme_keywords() !!}">
    <meta name="robots" content="index, follow" />
    @include('favicons')

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->

    <link rel="stylesheet" href="{{MPasset('css/main.css')}}?version={{versionJs()}}">
    @yield('theme_mp_css')
    <link rel="stylesheet" href="{{MPasset('css/responsive.css')}}?version={{versionJs()}}">
    <!-- 
    =========Vu Custom CSS======== -->
    @yield('lib_styles')
    @yield('extended_styles')

    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
        <link rel="stylesheet" type="text/css" href="css/ie8-and-down.css" />
        <![endif]-->

    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon" href="{{url()}}/resources/assets/theme_mypham/images/favicon.ico">
    <link rel="apple-touch-icon" href="{{url()}}/resources/assets/theme_mypham/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{url()}}/resources/assets/theme_mypham/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{url()}}/resources/assets/theme_mypham/images/apple-touch-icon-114x114.png">

</head>