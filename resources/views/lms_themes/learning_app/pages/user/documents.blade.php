@extends('lms_themes.learning_app.master.user_board')
@section('sidebar_footer')
@endsection
@section('lib_styles')
    <link rel="stylesheet" href="{{ libraryAsset('elfinder/css/elfinder.min.css') }}">
    <link rel="stylesheet" href="{{ libraryAsset('elfinder/css/theme.css') }}">
@endsection
@section('lib_scripts')
    <script src="{{ libraryAsset('elfinder/js/elfinder.min.js') }}"></script>
    <script src="{{ libraryAsset('elfinder/js/i18n/elfinder.'.$site_locale.'.js') }}"></script>
@endsection
@section('extended_scripts')
    <script>
        {!! cdataOpen() !!}
        jQuery(document).ready(function() {
            jQuery('#elfinder').elfinder({
                lang: '{{ $site_locale }}',
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url : '{{ localizedURL('documents/connector') }}',
                uiOptions : {
                    toolbar: [
                        ['back', 'forward'],
                        ['home', 'reload', 'up'],
                        ['mkdir', 'mkfile', 'upload'],
                        ['open', 'download', 'getfile'],
                        ['info', 'quicklook'],
                        ['copy', 'cut', 'paste'],
                        ['rm'],
                        ['duplicate', 'rename', 'edit', 'resize', 'pixlr'],
                        ['search'],
                        ['view', 'sort']
                    ]
                },
                dateFormat : '{{ $dateFormat }} {{ $timeFormat }}'
            });
        });
        {!! cdataClose() !!}
    </script>
@endsection
@section('page_content')
    <div class="page-section padding-top-none">
        <div class="media v-middle">
            <div class="media-body">
                <h1 class="text-display-1 margin-none">{{ trans('pages.my_documents_title') }}</h1>
                <p class="text-subhead text-light">{{ trans('pages.my_documents_desc') }}</p>
            </div>
        </div>
    </div>
    <div class="panel panel-default paper-shadow" data-z="0.5">
        <div id="elfinder"></div>
    </div>
@endsection