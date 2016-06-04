<!DOCTYPE html>
<html lang="{{ $site_locale }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('site_meta')
    <title>{{ $site_name }} @yield('site_title')</title>
    <meta name="description" content="@yield('site_description')@show">
    <meta name="author" content="{{ $site_author }}">
@include('favicons')
    <link rel='stylesheet' href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,600,600italic,700,700italic,300italic,300&subset=latin,vietnamese,latin-ext">
    <link rel="stylesheet" href="{{ libraryAsset('common_libs/css/tiny.min.css') }}">
    @yield('lib_styles')
    <link rel="stylesheet" href="{{ AdminTheme::cssAsset('style.min.css') }}">
    <link rel="stylesheet" href="{{ libraryAsset('iCheck/square/blue.css') }}">
    @yield('extended_styles')
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','//connect.facebook.net/en_US/fbevents.js');

            fbq('init', '1014567625274594');
            fbq('track', "PageView");
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1014567625274594&ev=PageView&noscript=1"
            />
        </noscript>
        <!-- End Facebook Pixel Code -->

    <!-- Hotjar Tracking Code for http://antoree.com/ -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:156782,hjsv:5};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
</head>
<body class="hold-transition @yield('auth_type')-page">
<div class="@yield('auth_type')-box">
    <div class="@yield('auth_type')-logo">
        <a href="{{ homeURL() }}"><strong>{{ $site_name }}</strong></a>
    </div>
    <div class="@yield('auth_type')-box-body">
        @yield('title_email')
        <p class="@yield('auth_type')-box-msg">@yield('box_message')</p>
        @yield('auth_form')
    </div>
</div>
<script src="{{ libraryAsset('common_libs/tiny.min.js') }}"></script>
<script src="{{ libraryAsset('iCheck/icheck.min.js') }}"></script>
@yield('lib_scripts')
<script>
    {!! cdataOpen() !!}
    jQuery(document).ready(function () {
        jQuery('[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
    {!! cdataClose() !!}
</script>
<!-- Google Analytics -->
<script>window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga('create', '{{env('GA-LOGIN')}}', 'auto');
ga('send', 'pageview');</script>
<script async src="//www.google-analytics.com/analytics.js"></script>
<!-- End Google Analytics -->
@yield('extended_scripts')
</body>
</html>
