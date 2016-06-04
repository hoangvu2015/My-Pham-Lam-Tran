@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_faq_articles_title'))
@section('page_description', trans('pages.admin_faq_articles_desc'))

@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('faq/articles') }}">{{ trans('pages.admin_faq_articles_title') }}</a></li>
    </ol>
@endsection
@section('lib_styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
@endsection
@section('lib_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script src="{{ libraryAsset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ libraryAsset('ckeditor/adapters/jquery.js') }}"></script>
@endsection
@section('extended_scripts')
    <script>
        {!! cdataOpen() !!}
                jQuery(document).ready(function () {
                    jQuery('.select2').select2();
                    jQuery('[name^="title"]').each(function () {
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
                    jQuery('.ck-editor').ckeditor({
                        language : '{{ $site_locale }}',
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
@section('modals')
    @include('admin_themes.admin_lte.master.common_modals')
@endsection
@section('page_content')
<div class="row">
    <form class="check-slug" method="post">
        {!! csrf_field() !!}
        <div class="col-xs-12">
            <h4 class="box-title">{{ trans('form.action_add') }} {{ trans_choice('label.topic_lc', 1) }}</h4>
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
                        <label for="inputCategories">{{ trans_choice('label.category', 2) }}</label>
                        <select id="inputCategories" class="form-control select2" name="categories[]" multiple="multiple" required
                                data-placeholder="{{ trans('form.action_select') }} {{ trans_choice('label.category', 2) }}" style="width: 100%;">
                            @foreach ($faq_categories as $faq_category)
                                <option value="{{ $faq_category->id }}"{{ in_array($faq_category->id, old('categories', [])) ? ' selected' : '' }}>
                                    {{ $faq_category->name }}
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
                                <label for="inputTitle_{{ $locale }}">{{ trans('label.title') }}</label>
                                <input class="form-control" id="inputTitle_{{ $locale }}" name="title[{{ $locale }}]"
                                    placeholder="{{ trans('label.title') }}" type="text" value="{{ old('title_'.$locale) }}">
                            </div>

                            <div class="form-group">
                                <label for="inputSlug_{{ $locale }}">{{ trans('label.slug') }}</label>
                                <input class="form-control slug" id="inputSlug_{{ $locale }}" name="slug[{{ $locale }}]"
                                    placeholder="{{ trans('label.slug') }}" type="text" value="{{ old('slug_'.$locale) }}">
                            </div>

                            <div class="form-group">
                                <label for="inputContent{{ $locale }}">{{ trans('label.content') }}</label>
                                <textarea rows="10" class="form-control ck-editor" id="inputContent_{{ $locale }}"
                                name="content[{{ $locale }}]" placeholder="{{ trans('label.content') }}">{{ old('content_'.$locale) }}</textarea>
                            </div>

                        </div><!-- /.tab-pane -->
                    @endforeach
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
            <div class="margin-bottom">
                <button class="btn btn-primary" type="submit">{{ trans('form.action_add') }}</button>
                <button class="btn btn-default" type="reset">{{ trans('form.action_reset') }}</button>
                <a role="button" class="btn btn-warning pull-right" href="{{ localizedAdminURL('faq/articles') }}">{{ trans('form.action_cancel') }}</a>
            </div>
        </div>
    </form>
</div>

@endsection