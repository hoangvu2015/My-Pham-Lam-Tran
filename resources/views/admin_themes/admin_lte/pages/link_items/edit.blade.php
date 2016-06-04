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

            jQuery('a.delete').off('click').on('click', function (e) {
                e.preventDefault();

                var $this = jQuery(this);

                x_confirm('{{ trans('form.action_delete') }}', '{{ trans('label.wanna_delete', ['name' => '']) }}', function () {
                    window.location.href = $this.attr('href');
                });

                return false;
            });
        });
        {!! cdataClose() !!}
    </script>
@endsection
@section('modals')
    @include('admin_themes.admin_lte.master.common_modals')
@endsection
@section('page_content')
<div class="row">
    <form method="post" action="{{ localizedAdminURL('link/items/update')}}">
        {!! csrf_field() !!}
        <input type="hidden" name="id" value="{{ $current_link_item->id }}">
        <div class="col-xs-12">
            <div class="margin-bottom">
                <a class="btn btn-primary" href="{{ localizedAdminURL('link/items/add') }}">
                    {{ trans('form.action_add') }} {{ trans_choice('label.link', 1) }}
                </a>
                <a class="btn btn-warning delete" href="{{ localizedAdminURL('link/items/{id}/delete', ['id'=> $current_link_item->id]) }}">
                    {{ trans('form.action_delete') }}
                </a>
            </div>
            <h4 class="box-title">{{ trans('form.action_edit') }} {{ trans_choice('label.category_lc', 1) }}</h4>
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
                          <label for="inputCategories">{{ trans_choice('label.link_category', 2) }}</label>
                          <select id="inputCategories"  class="form-control select2" name="link_categories[]" multiple="multiple" required
                                  data-placeholder="{{ trans('form.action_select') }} {{ trans_choice('label.link_category', 2) }}" style="width: 100%;">
                              @foreach ($link_categories as $link_category)
                                  <option value="{{ $link_category->id }}"{{ $current_link_category->contains('id', $link_category->id) ? ' selected' : '' }}>
                                      {{ $link_category->name }}
                                  </option>
                              @endforeach
                          </select>
                      </div>
                  </div>
            </div>
            <div class="form-group">
                  <label for="inputImage">{{ trans('label.picture') }}</label>
                  <input class="form-control image-from-documents" id="inputImage" name="image" placeholder="{{ trans('label.picture') }}" type="text" value="{{ $current_link_item->image }}">
            </div>

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
                        <?php
                        $trans = $current_link_item->translate($locale);
                        $name = $trans ? $trans->name : '';
                        $description = $trans ? $trans->description : '';
                        $link = $trans ? $trans->link : '';

                        ?>
                        <div class="tab-pane{{ $locale == $site_locale ? ' active' : '' }}" id="tab_{{ $locale }}">
                            <div class="form-group">
                                <label for="inputName_{{ $locale }}">{{ trans('label.name') }}</label>
                                <input class="form-control" id="inputName_{{ $locale }}" name="name[{{ $locale }}]" placeholder="{{ trans('label.name') }}" type="text" value="{{ $name }}">
                            </div>
                            <div class="form-group">
                                <label for="inputDescription_{{ $locale }}">{{ trans('label.description') }}</label>
                                <input class="form-control" id="inputDescription_{{ $locale }}" name="description[{{ $locale }}]" placeholder="{{ trans('label.description') }}" type="text" value="{{ $description }}">
                            </div>
                            <div class="form-group">
                                <label for="inputLink_{{ $locale }}">{{ trans_choice('label.link', 1) }}</label>
                                <input class="form-control" id="inputLink_{{ $locale }}" name="link[{{ $locale }}]" placeholder="{{ trans_choice('label.link', 1) }}" type="text" value="{{ $link }}">
                            </div>
                        </div><!-- /.tab-pane -->
                    @endforeach
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
            <div>
                <button class="btn btn-primary" type="submit">{{ trans('form.action_save') }}</button>
                <button class="btn btn-default" type="reset">{{ trans('form.action_reset') }}</button>
                <a role="button" class="btn btn-warning pull-right" href="{{ localizedAdminURL('link/items') }}">{{ trans('form.action_cancel') }}</a>
            </div>
        </div>
    </form>
</div>
@endsection