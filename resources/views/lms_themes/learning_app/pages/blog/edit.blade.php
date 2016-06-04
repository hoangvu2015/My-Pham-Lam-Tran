@extends('lms_themes.learning_app.new_master.blog')
@section('body_class', 'blog-post')
@section('lib_styles')
<link rel="stylesheet" href="{{ libraryAsset('select2/css/select2.min.css') }}">
@endsection
@section('lib_scripts')
<script src="{{ libraryAsset('select2/js/select2.min.js') }}"></script>
<script src="{{ libraryAsset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ libraryAsset('ckeditor/adapters/jquery.js') }}"></script>
@endsection
@section('extended_scripts')
@include('file_manager.open_documents_script')
<script>
    function checkAction(action){
        $('#inputAction').attr('value', action);
        console.log(action);
    }
    function successUpImagePostBlog(id_input,urlImage){
        $('#relaceImage').attr('src', urlImage);
        // console.log('ok',id_input,'lll',urlImage);
    }
    {!! cdataOpen() !!}
    jQuery(document).ready(function () {
        jQuery('#mod-footer').addClass('none');
        jQuery('.select2').select2();
        jQuery('[name="title"]').registerSlugTo(jQuery('[name="slug"],span.slug-text'));
        jQuery('.slug').registerSlug(jQuery('span.slug-text'));
        jQuery('.ck-editor').ckeditor({
            language : '{{ $site_locale }}',
            filebrowserBrowseUrl : '{{ localizedURL('documents/for/ckeditor') }}',
            filebrowserFlashBrowseUrl : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=flash',
            filebrowserFlashUploadUrl  : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=flash',
            filebrowserImageBrowseLinkUrl : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=images',
            filebrowserImageBrowseUrl : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=images',
            customConfig : '{{ libraryAsset('ckeditor/config_article.js') }}'
        });
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
@include('lms_themes.learning_app.new_master.common_modals')
@endsection
@section('blog_content')
<?php
$status_text = '<span class="label label-default">' . trans('label.status_draft') . '</span>';
switch ($blog_article->status) {
    case $status_published:
    $status_text = '<span class="label label-success">' . trans('label.status_published') . '</span>';
    break;
    case $status_requested:
    $status_text = '<span class="label label-warning">' . trans('label.status_requested') . '</span>';
    break;
    case $status_rejected:
    $status_text = '<span class="label label-danger">' . trans('label.status_rejected') . '</span>';
    break;
}
?>

@if($is_author)
<a class="delete btn btn-warning pull-right hidden" href="{{ localizedURL('blog/{id}/delete', ['id'=> $blog_article->id]) }}">
    {{ trans('form.action_delete') }}
</a>
@endif

<div id="mod-blog-post">
    <div class="container">
        <div class="content">
            <form method="post" action="{{ localizedURL('blog/update') }}">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{ $blog_article->id }}">

                @if (count($errors) > 0)
                <br/>
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <label class="title"></label>
                <label class="title" style="display: inline;">{{ trans('label.status') }}</label>:
                <span>{!! $status_text !!}</span>

                <label class="title">{{ trans('label.title') }}</label>
                <input id="inputTitle" name="title" placeholder="{{ trans('label.title') }}" type="text" value="{{ $trans_blog_article->title }}" class="input" required/><br/>
                
                <!-- <label for="inputSlug" class="title">{{ trans('label.slug') }}</label> -->
                <input class="form-control slug" id="inputSlug" name="slug"
                placeholder="{{ trans('label.slug') }}" type="hidden" value="{{ $trans_blog_article->slug }}">
                <!-- <p class="help-block">{{ localizedURL('blog/{slug}', ['slug'=>''], $site_locale) }}/<span class="slug-text">{{ $trans_blog_article->slug }}</span></p> -->

                <label class="title">{{ trans_choice('label.category', 2) }}</label>
                <select id="inputCategories" class="select2" name="categories[]" multiple="multiple" required data-placeholder="{{ trans('form.action_select') }} {{ trans_choice('label.category', 2) }}" style="width: 100%;">
                    @foreach ($blog_categories as $blog_category)
                    <option value="{{ $blog_category->id }}"{{ $article_categories->contains('id', $blog_category->id) ? ' selected' : '' }}>{{ $blog_category->name }}</option>
                    @endforeach
                </select>

                <label class="title">{{ trans('label.picture') }} (600x180)</label>
                @if($blog_article->featured_image)
                <img id="relaceImage" src="{{$blog_article->featured_image}}">
                @else
                <img id="relaceImage" src="">
                @endif

                <div class="upfile">
                    <input class="image-from-documents" id="inputImagePostBlog" name="featured_image" placeholder="{{ trans('label.picture') }}" type="text" value="{{ $blog_article->featured_image }}"/><br/>
                </div>

                <label for="inputContent" class="title">{{ trans('label.content') }}</label>
                <textarea rows="20" class="form-control ck-editor" id="inputContent" name="content" placeholder="{{ trans('label.content') }}" required>{{ $trans_blog_article->content }}</textarea><br/>

                <input id="inputAction" type="hidden" name="action" value="" />
                <input onclick="checkAction('publish')" type="submit" class="submit bz-btn" value="{{ trans('form.action_edit') }}" />
            </form>
        </div>

    </div>
</div>
@endsection
