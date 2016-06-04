@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_blog_articles_title'))
@section('page_description', trans('pages.admin_blog_articles_desc'))
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('blog/articles') }}">{{ trans('pages.admin_blog_articles_title') }}</a></li>
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
                    jQuery('[name="title"]').registerSlugTo(jQuery('[name="slug"]'));
                    jQuery('.slug').registerSlug();
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
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h4 class="box-title">{{ trans('form.action_add') }} {{ trans_choice('label.blog_article_lc', 1) }}</h4>
                </div>
                <form method="post">
                    {!! csrf_field() !!}
                    <div class="box-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="inputCategories">{{ trans_choice('label.category', 2) }}</label>
                                    <select id="inputCategories" class="form-control select2" name="categories[]" multiple="multiple" required
                                            data-placeholder="{{ trans('form.action_select') }} {{ trans_choice('label.category', 2) }}" style="width: 100%;">
                                        @foreach ($blog_categories as $blog_category)
                                            <option value="{{ $blog_category->id }}"{{ in_array($blog_category->id, old('categories', [])) ? ' selected' : '' }}>
                                                {{ $blog_category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputImage">{{ trans('label.picture') }}</label>
                            <input class="form-control image-from-documents" id="inputImage" name="featured_image" placeholder="{{ trans('label.picture') }}" type="text" value="{{ old('featured_image') }}">
                        </div>
                        <div class="form-group">
                            <label for="inputTitle">{{ trans('label.title') }}</label>
                            <input class="form-control" id="inputTitle" name="title"
                                   placeholder="{{ trans('label.title') }}" type="text" value="{{ old('title') }}">
                        </div>

                        <div class="form-group">
                            <label for="inputSlug">{{ trans('label.slug') }}</label>
                            <input class="form-control slug" id="inputSlug" name="slug"
                                   placeholder="{{ trans('label.slug') }}" type="text" value="{{ old('slug') }}">
                        </div>

                        <div class="form-group">
                            <label for="inputContent">{{ trans('label.content') }}</label>
                              <textarea rows="10" class="form-control ck-editor" id="inputContent"
                                        name="content" placeholder="{{ trans('label.content') }}">{{ old('content') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputContent">Meta data</label>
                              <textarea rows="10" class="form-control" id="meta_description"
                                        name="meta_description" placeholder="Meta data">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button class="btn btn-primary" type="submit" name="action" value="publish">
                            {{ trans('form.action_publish') }}
                        </button>
                        <button class="btn bg-gray" type="submit" name="action" value="draft">
                            {{ trans('form.action_save_draft') }}
                        </button>
                        <div class="pull-right">
                            <button class="btn btn-default" type="reset">{{ trans('form.action_reset') }}</button>
                            <a role="button" class="btn btn-warning" href="{{ localizedAdminURL('blog/articles') }}">{{ trans('form.action_cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection