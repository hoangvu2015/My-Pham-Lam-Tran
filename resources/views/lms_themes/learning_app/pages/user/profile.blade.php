@extends('lms_themes.learning_app.master.user_board')
@section('main_column_class', 'col-md-8')
@section('right_column_class', 'col-md-4')
@section('public_profile_link')
@endsection
@section('sidebar_footer')
@endsection
@section('page_content')
    <div class="row">
        <div class="col-md-12">
            <p class="margin-v-0-15">
                @include('lms_themes.learning_app.pages.user.brief_list')
            </p>
            @if($user_articles->count()>0)
                <h2 id="teaching-method" class="text-headline margin-none">
                    {{ trans_choice('label.blog_article', 2) }}
                </h2>
                <p class="text-subhead text-light">{{ trans('pages.page_blog_desc') }}</p>
                @foreach($user_articles as $article)
                    <?php
                    $article_url = localizedURL('blog/view/{slug}', ['slug' => $article->slug]);
                    ?>
                    <div class="panel panel-default paper-shadow" data-z="0.5">
                        <div class="panel-body">
                            <div class="media media-clearfix-xs">
                                @if(!empty($article->featured_image))
                                    <div class="media-left v-middle">
                                        <img class="width-240" src="{{ $article->featured_image }}">
                                    </div>
                                @endif
                                <div class="media-body">
                                    <div class="pull-right">
                                        <a href="{{ $article_url.'#comment-section' }}" class="btn btn-white btn-flat">
                                            <i class="fa fa-comments fa-fw"></i> {{ $article->reviews()->count() }}</a>
                                    </div>
                                    <h4 class="text-title media-heading">
                                        <a href="{{ $article_url }}" class="link-text-color">
                                            {{ $article->title }}
                                        </a>
                                    </h4>
                                    <p class="text-light text-caption">
                                        <?php
                                        $article_category_index = 0;
                                        $article_categories = $article->categories;
                                        $count_article_categories = $article_categories->count();
                                        ?>
                                        <span>{{ trans_choice('label.category', 1) }}:
                                            @foreach($article_categories as $article_category)
                                                <?php
                                                ++$article_category_index;
                                                ?>
                                                @if($article_category_index!=$count_article_categories)
                                                    <a href="{{ localizedURL('blog/category/view/{slug}', ['slug' => $article_category->slug]) }}">{{ $article_category->name }}</a>,
                                                @else
                                                    <a href="{{ localizedURL('blog/category/view/{slug}', ['slug' => $article_category->slug]) }}">{{ $article_category->name }}</a>
                                                @endif
                                            @endforeach
                                        </span> |
                                        <span>
                                            <i class="fa fa-clock-o fa-fw"></i>
                                            <abbr class="time-ago" title="{{ defaultTimeTZ($article->created_at) }}">
                                                {{ defaultTime($article->created_at) }}
                                            </abbr>
                                        </span>
                                    </p>
                                    <p class="text-light">
                                        {{ htmlShorten($article->content, $article_shorten_length) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
@section('after_user_menu')
    <div class="panel panel-default" data-toggle="panel-collapse" data-open="true">
        <div class="panel-heading panel-collapse-trigger">
            <h4 class="panel-title">{{ trans('label.personal_details') }}</h4>
        </div>
        <div class="panel-body">
        @if(!empty($user_profile->dateOfBirth))
            <p><strong>{{ trans('label.birthday') }}:</strong> {{ $user_profile->dateOfBirth }} (<strong>{{ trans('label.age') }}:</strong> {{ $user_profile->age }})</p>
        @endif
            <p><strong>{{ trans('label.gender') }}:</strong> {{ trans('label.gender_'.$user_profile->gender) }}</p>
        @if(!empty($user_profile->address))
            <p><strong>{{ trans('label.address') }}:</strong> {{ $user_profile->address }}</p>
        @endif
        @if(!empty($user_profile->city))
            <p><strong>{{ trans('label.city') }}:</strong> {{ $user_profile->city }}</p>
        @endif
            <p><strong>{{ trans('label.nationality') }}:</strong> {{ allCountry($user_profile->country, 'name') }}</p>
        </div>
    </div>
    <hr>
    @if(count($user_works)>0)
        <h4 class="text-center">{{ trans('label.work') }}</h4>
        @foreach($user_works as $work)
            <div class="panel panel-default" data-toggle="panel-collapse" data-open="true">
                <div class="panel-body">
                    <p><strong>{{ trans('label.company') }}:</strong> {{ $work->company }}</p>
                    @if(!empty($work->position))
                        <p><strong>{{ trans('label.position') }}:</strong> {{ $work->position }}</p>
                    @endif
                    @if(!empty($work->description))
                        <p><strong>{{ trans('label.description') }}:</strong> {{ $work->description }}</p>
                    @endif
                    @if(!empty($work->start) || !empty($work->end) || $work->current == true)
                        <p>
                            <strong>{{ trans('label.duration') }}:</strong>
                            @if(!empty($work->start))
                                {{ trans('label.from') }} {{ $work->start }}
                            @endif
                            @if(!empty($work->end))
                                {{ trans('label.to') }} {{ $work->end }}
                            @elseif($work->current == true)
                                {{ trans('label.to') }} {{ trans('label.current') }}
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
    @if(count($user_educations)>0)
        <h4 class="text-center">{{ trans('label.education') }}</h4>
        @foreach($user_educations as $education)
            <div class="panel panel-default" data-toggle="panel-collapse" data-open="true">
                <div class="panel-body">
                    <p><strong>{{ trans('label.school') }}:</strong> {{ $education->school }}</p>
                    @if(!empty($education->field))
                        <p><strong>{{ trans('label.field') }}:</strong> {{ $education->field }}</p>
                    @endif
                    @if(!empty($education->description))
                        <p><strong>{{ trans('label.description') }}:</strong> {{ $education->description }}</p>
                    @endif
                    @if(!empty($education->start) || !empty($education->end) || $education->current == true)
                        <p>
                            <strong>{{ trans('label.duration') }}:</strong>
                            @if(!empty($education->start))
                                {{ trans('label.from') }} {{ $education->start }}
                            @endif
                            @if(!empty($education->end))
                                {{ trans('label.to') }} {{ $education->end }}
                            @elseif($education->current == true)
                                {{ trans('label.to') }} {{ trans('label.current') }}
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
@endsection