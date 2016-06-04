@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_blog_categories_title'))
@section('page_description', trans('pages.admin_blog_categories_desc'))
@section('page_breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
    <li><a href="{{ localizedAdminURL('blog/categories') }}">{{ trans('pages.admin_blog_categories_title') }}</a></li>
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
                    jQuery('[name^="name"]').each(function () {
                        var $this = jQuery(this);
                        $this.registerSlugTo($this.closest('.tab-pane').find('[name^="slug"]'));
                    });
                    var $slug = jQuery('.slug');
                    $slug.registerSlug();
                    jQuery('form.check-slug').on('submit', function () {
                        var vals = [];
                        var unique = true;
                        $slug.each(function () {
                            var val = $(this).val();
                            if (vals.indexOf(val) != -1) {
                                unique = false;
                            }
                            else {
                                vals.push(val);
                            }
                        });
                        if (!unique) {
                            x_alert('{{ trans('validation.unique', ['attribute' => 'slug']) }}');
                            return false;
                        }
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
    <form class="check-slug" method="post">
        {!! csrf_field() !!}
        <div class="col-xs-12">
            <h4 class="box-title">{{ trans('form.action_add') }} {{ trans_choice('label.category_lc', 1) }}</h4>
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
                        <label for="inputParentId">{{ trans('label.category_parent') }}</label>
                        <select id="inputParentId" class="form-control select2" name="parent" style="width: 100%;"
                                data-placeholder="{{ trans('form.action_select') }} {{ trans('label.category_parent') }}">
                            <option value="0">[{{ trans('label.not_set') }}]</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"{{ $category->id==old('parent') ? ' selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                        </select>
                    </div>
                </div>
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
                            <label for="inputSlug_{{ $locale }}">{{ trans('label.slug') }}</label>
                            <input class="form-control slug" id="inputSlug_{{ $locale }}" name="slug[{{ $locale }}]"
                            placeholder="{{ trans('label.slug') }}" type="text" value="{{ old('slug_'.$locale) }}">
                        </div>
                        <div class="form-group">
                                <label for="inputDesc_{{ $locale }}">{{ trans('label.description') }}</label>
                                <input class="form-control desc" id="inputDesc_{{ $locale }}" name="desc[{{ $locale }}]"
                                placeholder="{{ trans('label.description') }}" type="text" value="{{ old('desc_'.$locale) }}">
                            </div>
                    </div><!-- /.tab-pane -->
                @endforeach
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
            <div class="margin-bottom">
                <button class="btn btn-primary" type="submit">{{ trans('form.action_add') }}</button>
                <button class="btn btn-default" type="reset">{{ trans('form.action_reset') }}</button>
                <a role="button" class="btn btn-warning pull-right" href="{{ localizedAdminURL('blog/categories') }}">{{ trans('form.action_cancel') }}</a>
            </div>
        </div>
    </form>
</div>
@endsection