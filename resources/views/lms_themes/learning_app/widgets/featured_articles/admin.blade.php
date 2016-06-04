@extends('widgets.default.admin')
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
            jQuery('.select2').select2()
        });
        {!! cdataClose() !!}
    </script>
@endsection
@section('extended_widget_bottom')
    <div class="margin-bottom">
        <a class="btn btn-primary"
           href="{{ localizedAdminURL('teachers/add') }}">{{ trans('form.action_add') }} {{ trans_choice('label.teacher', 1) }}</a>
    </div>
    <div class="box">
        <div class="box-body">
            <div class="form-group">
                <label for="inputArticles">{{ trans('form.action_select') }} {{ trans_choice('label.blog_article_lc', 2) }}</label>
                <select id="inputArticles" class="form-control select2" name="article_ids[]" multiple="multiple" required style="width: 100%;"
                        data-placeholder="{{ trans('form.action_select') }} {{ trans_choice('label.blog_article_lc', 2) }}">
                    @foreach ($all_articles as $article)
                        <option value="{{ $article->id }}" {{in_array($article->id, $article_ids) ? ' selected' : '' }}>
                            {{ $article->title  }} ({{ $article->categories->implode('name', ', ') }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@endsection
