@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_link_items_title'))
@section('page_description', trans('pages.admin_link_items_desc'))
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('link/items') }}">{{ trans('pages.admin_link_items_title') }}</a></li>
    </ol>
@endsection
@section('lib_styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
@endsection
@section('lib_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
@endsection
@section('extended_scripts')
    <script>
        {!! cdataOpen() !!}
        jQuery(document).ready(function () {
            jQuery('.select2').select2();
        });
        {!! cdataClose() !!}
    </script>
@endsection

@section('page_content')
<div class="row">
    <form method="post">
        {!! csrf_field() !!}
        <div class="col-xs-12">
            <h4 class="box-title">{{ trans('form.action_add') }} {{ trans_choice('label.link', 1) }}</h4>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label for="inputLinkCategories">{{ trans_choice('label.link_category', 2) }}</label>
                        <select id="inputLinkCategories" class="form-control select2" name="link_categories[]" multiple="multiple" required
                                data-placeholder="{{ trans('form.action_select') }} {{ trans_choice('label.link_category', 2) }}" style="width: 100%;">
                            @foreach ($link_categories as $link_category)
                                <option value="{{ $link_category->id }}"{{ in_array($link_category->id, old('categories', [])) ? ' selected' : '' }}>
                                    {{ $link_category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputImage">{{ trans('label.picture') }}</label>
                <input class="form-control image-from-documents" id="inputImage" name="image"
                    placeholder="{{ trans('label.picture') }}" type="text" value="{{ old('image') }}">
            </div>
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                   @foreach(allSupportedLocales() as $locale => $properties)
                       <li{!! $locale == $site_locale ? ' class="active"' : '' !!}>
                           <a href="#tab_{{ $locale }}" data-toggle="tab">
                               {{ $properties['native'] }}
                           </a>
                       </li>
                   @endforeach
                </ul>
                <div class="tab-content">
                    @foreach(allSupportedLocales() as $locale => $properties)
                        <div class="tab-pane{{ $locale == $site_locale ? ' active' : '' }}" id="tab_{{ $locale }}">
                            <div class="form-group">
                                <label for="inputName_{{ $locale }}">{{ trans('label.name') }}</label>
                                <input class="form-control" id="inputName_{{ $locale }}" name="name[{{ $locale }}]"
                                    placeholder="{{ trans('label.name') }}" type="text" value="{{ old('name_'.$locale) }}">
                            </div>

                            <div class="form-group">
                                <label for="inputDescription{{ $locale }}">{{ trans('label.description') }}</label>
                                <input class="form-control" id="inputDescription_{{ $locale }}" name="description[{{ $locale }}]"
                                                                    placeholder="{{ trans('label.description') }}" type="text" value="{{ old('description_'.$locale) }}">
                            </div>

                            <div class="form-group">
                                <label for="inputLink_{{ $locale }}">{{ trans_choice('label.link', 1) }}</label>
                                <input class="form-control" id="inputLink_{{ $locale }}" name="link[{{ $locale }}]"
                                    placeholder="{{ trans_choice('label.link', 1) }}" type="text" value="{{ old('link_'.$locale) }}">
                            </div>


                        </div><!-- /.tab-pane -->
                    @endforeach
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
            <div class="margin-bottom">
                <button class="btn btn-primary" type="submit">{{ trans('form.action_add') }}</button>
                <button class="btn btn-default" type="reset">{{ trans('form.action_reset') }}</button>
                <a role="button" class="btn btn-warning pull-right" href="{{ localizedAdminURL('link/items') }}">{{ trans('form.action_cancel') }}</a>
            </div>
        </div>
    </form>
</div>

@endsection