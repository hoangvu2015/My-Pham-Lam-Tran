@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_ui_lang_php_title'))
@section('page_description', trans('pages.admin_ui_lang_php_desc'))
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
        <li><a href="#">{{ trans('pages.admin_ui_lang_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('ui-lang/php') }}">{{ trans('pages.admin_ui_lang_php_title') }}</a></li>
    </ol>
@endsection
@section('page_content')
    <div class="row">
        @include('admin_themes.admin_lte.pages.ui_lang.file')
    </div>
@endsection