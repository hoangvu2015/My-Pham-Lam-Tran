@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_company_address_options_title'))
@section('page_description', trans('pages.admin_company_address_options_desc'))
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('app-options') }}">{{ trans('pages.admin_app_options_title') }}</a></li>
    </ol>
@endsection
@section('lib_scripts')
    <script src="{{ libraryAsset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ libraryAsset('ckeditor/adapters/jquery.js') }}"></script>
@endsection
@section('extended_scripts')
    <script>
        {!! cdataOpen() !!}
        jQuery(document).ready(function () {
                    jQuery('.ck-editor').ckeditor({
                        language : '{{ $site_locale }}',
                        extraPlugins : 'youtube,slideshow',
                        filebrowserBrowseUrl : '{{ localizedURL('documents/for/ckeditor') }}',
                        filebrowserFlashBrowseUrl : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=flash',
                        filebrowserFlashUploadUrl  : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=flash',
                        filebrowserImageBrowseLinkUrl : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=images',
                        filebrowserImageBrowseUrl : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=images',
                        customConfig : '{{ libraryAsset('ckeditor/config_article.js') }}'
                    });
                });
        {!! cdataClose() !!}
    </script>
@endsection
@section('page_content')
    <div class="row">
        <div class="col-xs-12">
            <form method="post" action="{{ currentURL() }}">
            {!! csrf_field() !!}
                <h4 class="box-title">{{ trans('form.action_edit') }} {{ trans('label.company_address') }} </h4>
                <div id="company-address" class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        @foreach(allSupportedLocales() as $locale => $properties)
                            <li{!! $locale == $site_locale ? ' class="active"' : '' !!}>
                                  <a href="#company-address-tab-{{ $locale }}" data-toggle="tab">
                                      {{ $properties['native'] }}
                                  </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                    @foreach(allSupportedLocales() as $locale => $properties)
                        <div class="tab-pane{{ $locale == $site_locale ? ' active' : '' }}" id="company-address-tab-{{ $locale }}">
                              <div class="form-group">
                                    <label for="inputAddress-{{ $locale }}">{{ trans('label.company_address') }}</label>
                                     <textarea rows="5" class="form-control ck-editor" id="inputAddress{{ $locale }}"
                                     name="company_address[{{ $locale }}]" placeholder="{{ trans('label.content') }}">{{ $company_address[$locale] }}</textarea>
                              </div>
                        </div>
                    @endforeach
                    </div><!-- /.tab-content -->
                </div><!-- nav-tabs-custom -->
                <div class="margin-bottom">
                    <button class="btn btn-primary" type="submit">{{ trans('form.action_save') }}</button>
                    <button class="btn btn-default" type="reset">{{ trans('form.action_reset') }}</button>
                    <a role="button" class="btn btn-warning pull-right" href="{{ localizedAdminURL('app-options') }}">{{ trans('form.action_cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection