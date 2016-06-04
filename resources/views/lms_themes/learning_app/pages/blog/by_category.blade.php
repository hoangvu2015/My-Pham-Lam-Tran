@extends('lms_themes.learning_app.pages.blog.index')
@section('blog_content_top')
    <div class="page-section padding-top-none">
        <div class="media v-middle">
            <div class="media-body">
                <h1 class="text-display-1 margin-none">{{ trans_choice('label.category', 1) }}: <em>{{ $by_category->name }}</em></h1>
                {{--<p class="text-subhead text-light">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores, illo.</p>--}}
            </div>
            @if($can_add)
                <div class="media-right">
                    <a href="{{ localizedURL('blog/add') }}" class="btn btn-white paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated="">
                        <i class="fa fa-fw fa-plus"></i>
                        {{ trans('form.action_add') }} {{ trans_choice('label.blog_article_lc', 1) }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection