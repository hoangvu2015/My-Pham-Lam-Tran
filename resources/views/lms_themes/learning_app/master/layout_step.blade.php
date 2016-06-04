<!DOCTYPE html>
<html class="transition-navbar-scroll top-navbar-xlarge bottom-footer" lang="{{ $site_locale }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{!! theme_title() !!}</title>
    <meta name="author" content="{!! theme_author() !!}">
    <meta name="description" content="{!! theme_description() !!}">
    <meta name="keywords" content="{!! theme_keywords() !!}">
    @include('favicons')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,400,400italic,500,500italic,700,700italic&subset=latin,vietnamese,latin-ext">
    <link rel="stylesheet" href="{{ libraryAsset('common_libs/css/full.no-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('all.css') }}">
    @yield('lib_styles')
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('app.css') }}">
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('extra.css') }}">
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('fix.css') }}">
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('main_step.css') }}">
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('vendor_step.css') }}">
    @yield('extended_styles')
    {!! theme_header() !!}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
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
    <body class="@yield('body_class')" style="padding-top: 0;">
        <!-- Fixed navbar -->
        <div id="mod-header" class="">
           <div class="container">
              <a class="logo"><img src="{{ LmsTheme::imageAsset('New-Layout/home-page.svg') }}" class="img-responsive" alt=""></a>
              <div class="text"><span>@yield('head_line')</span></div>
          </div>
      </div>
      @yield('layout_content')
      @include('lms_themes.learning_app.master.layout_sidebar_footer')
      @include('lms_themes.learning_app.master.layout_footer_step')
