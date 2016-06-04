<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{!! theme_title() !!}</title>
    <meta name="author" content="{!! theme_author() !!}">
    <meta name="description" content="{!! theme_description() !!}">
    <meta name="keywords" content="{!! theme_keywords() !!}">
    <meta name="robots" content="index, follow" />
    @include('favicons')

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('vendor.css') }}?version={{versionJs()}}">
    @yield('lib_styles')
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('main.css') }}?version={{versionJs()}}">
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('fix_new_template.css') }}?version={{versionJs()}}">
    @yield('extended_styles')

    <meta name="google-signin-client_id" content="{{env('GOOGLE_CLIENT_ID_JS')}}">
    {!! theme_header() !!}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    </head>
