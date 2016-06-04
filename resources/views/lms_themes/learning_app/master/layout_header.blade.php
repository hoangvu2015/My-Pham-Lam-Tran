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
        
        <!-- Intercom -->
        <script>
            window.intercomSettings = {
                app_id: "aqxlr9mv"
            };
        </script>
        <script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/aqxlr9mv';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()
        </script>

    </head>
    <body class="@yield('body_class')">
        <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top navbar-size-large navbar-size-xlarge paper-shadow @yield('class_menu')" data-z="0" data-animated role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
                        <span class="sr-only">{{ trans('label.toggle_navigation') }}</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="navbar-brand navbar-brand-logo">
                        <a class="svg" href="{{ homeURL() }}">
                        </a>
                    </div>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="main-nav">
                    {!! $main_menu !!}
                    <div class="navbar-right">
                        {!! $main_menu_right !!}
                        @if(!$is_auth)
                        <span class="auth-links">
                            {{--<a href="{{ localizedURL('auth/register') }}?selected_roles=teacher" class="navbar-btn btn btn-danger">
                                {{ trans('pages.teacher_becoming') }}
                            </a>--}}
                            <a href="{{ localizedURL('auth/register-tutor') }}" class="navbar-btn btn btn-danger">
                                {{ trans('pages.teacher_becoming') }}
                            </a>
                            <a href="{{ localizedURL('auth/login') }}" class="navbar-btn btn btn-success">
                                {{ trans('form.action_login') }}
                            </a>
                        </span>
                        @endif
                    </div>
                </div>
                <!-- /.navbar-collapse -->
            </div>
        </div>