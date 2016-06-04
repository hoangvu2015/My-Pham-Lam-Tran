<!doctype html>
<html>
<head>
    <title>404 - Not Found.</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="fragment" content="!">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="robots" content="index, follow">
    <meta name="description" content="">
    <meta name="keywords" content="">
    @include('favicons')

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,400,400italic,500,500italic,700,700italic&subset=latin,vietnamese,latin-ext">
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('vendor.css') }}">
    @yield('lib_styles')
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('main.css') }}">
</head>
<body class="verify">
    <!--[if lt IE 10]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <div id="mod-header">
        <div class="menu-mobile canvas" id="menuMobile">
            <div class="dropdown">
                <div class="logo">
                    <a href="{{homeURL()}}" class="logo logo-mb-not-home">
                        <img src="{{url()}}/public/images/New-Layout/home-page.svg" class="img-responsive" alt="">
                        <p class="home-text">{{trans('new_label.menu_headline')}}</p>
                    </a>
                    <a href="{{homeURL()}}" class="logo logo-mb-in-home">
                        <img src="{{url()}}/public/images/New-Layout/home-page.svg" class="img-responsive" alt="">
                        <p class="home-text">{{trans('new_label.menu_headline')}}</p>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="list-menu-mb navbar-fixed-top" id="list-menu-mb">
                <div class="top-menu-mb"><a href="">
                    <img src="{{url()}}/public/images/New-Layout/home-page.svg"></a><span id="close-button"><img src="{{url()}}/public/images/ic_close.png"></span></div>
                </div>
            </div>

            <!-- Start: Header for blog -->
            <div class="header-blog navbar-fixed-top">
                <div class="menu-blog style-menu">
                    <div class="top">
                        <a href="{{homeURL()}}" class="logo float-left">
                            <img src="{{url()}}/public/images/New-Layout/home-page.svg" class="img-responsive" alt="">
                            <p class="home-text">{{trans('new_label.menu_headline')}}</p>
                        </a>
                    </div>
                </div>
            </div>
            <!-- End: Header for blog -->
        </div>

        <div id="mod-not-found">
            <div class="container">
                <div class="text-center">
                    <div class="alert">
                        <h1>
                            404
                        </h1>
                    </div>
                    <p class="text-alert">
                        {{trans('new_label.not_found')}}
                    </p>
                    <a href="{{homeURL()}}" class="home-btn">{{trans('new_label.back_home')}}</a>
                </div>
            </div>
        </div>
    </body>
    </html>
