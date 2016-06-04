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
        $('#formBlog').submit();
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
    });
    {!! cdataClose() !!}
</script>
@endsection
@section('blog_content')
<div id="mod-blog-post">
    <div class="container">
        <div class="content">
            <form id="formBlog" method="post">
                {!! csrf_field() !!}

                @if (count($errors) > 0)
                <br/>
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <label class="title">{{ trans('new_label.blog_field_title') }}</label>
                <input id="inputTitle" name="title" placeholder="{{ trans('new_label.blog_field_title') }}" type="text" value="{{ old('title') }}" class="input" required/><br/>

                <input type="hidden" class="form-control slug" id="inputSlug" name="slug" placeholder="{{ trans('label.slug') }}" type="text" value="{{ old('slug') }}">

                <label class="title">{{ trans('new_label.blog_field_category') }}</label>
                <select id="inputCategories" class="select2" name="categories[]" multiple="multiple" required
                data-placeholder="{{ trans('form.action_select') }} {{ trans('new_label.blog_field_category') }}" style="width: 100%;">
                @foreach ($blog_categories as $blog_category)
                <option value="{{ $blog_category->id }}"{{ in_array($blog_category->id, old('categories', [])) ? ' selected' : '' }}>
                    {{ $blog_category->name }}
                </option>
                @endforeach
            </select>
            <label class="title">{{ trans('new_label.blog_field_image') }}</label>
            <img id="relaceImage" src="{{ old('featured_image') }}">
            <div class="upfile">
                <input class="image-from-documents" id="inputImagePostBlog" name="featured_image" placeholder="{{ trans('new_label.blog_field_image') }}" type="text" value="{{ old('featured_image') }}" required/><br/>
            </div>
            
            <label for="inputContent" class="title">{{ trans('new_label.blog_field_content') }}</label>
            <textarea rows="20" class="form-control ck-editor" id="inputContent" name="content" placeholder="{{ trans('new_label.blog_field_content') }}" required>{{ old('content') }}</textarea><br/>
            
            <input id="inputAction" type="hidden" name="action" value="" />
            <input onclick="checkAction('publish')" type="submit" class="submit bz-btn" value="{{ trans('new_label.blog_button_publish') }}" />

        </form>
    </div>

</div>
</div>
@endsection