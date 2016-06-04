@if($articles->count()>0)
    <div id="{{ $html_id }}" class="page-section widget-featured-articles">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-4"></div>
                <div class="col-xs-12 col-sm-4">
                    <hr>
                </div>
            </div>
            @if(!empty($name))
                <div class="text-center">
                    <h3 class="text-display-1">{{ $name }}</h3>
                    @if(!empty($description))
                        <p class="lead text-muted">{{ $description }}</p>
                    @endif
                </div>
                <br>
            @endif
            <div class="row" data-toggle="gridalicious">
                @foreach($articles as $article)
                    <?php
                    $trans_article = $article->translateOrDefault($international_locale);
                    ?>
                    <div class="media">
                        <div class="media-body">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="text-headline">
                                        <a href="{{ localizedURL('blog/{slug}-{id}', ['id'=>$trans_article->id,'slug' => $trans_article->slug]) }}">
                                            {{ $trans_article->title }}
                                        </a>
                                    </div>
                                    <p class="text-light text-caption">
                                        <?php
                                        $author = $article->author;
                                        ?>
                                        <span>
                                            {{ trans('label.author') }}:
                                            <a href="{{ localizedURL('blog/author/{id}', ['id' => $author->id]) }}">{{ $author->name }}</a>
                                        </span> |
                                        <span>
                                            <i class="fa fa-clock-o fa-fw"></i>
                                            <abbr class="time-ago" title="{{ defaultTimeTZ($article->created_at) }}">
                                                {{ defaultTime($article->created_at) }}
                                            </abbr>
                                        </span>
                                    </p>
                                    <p class="text-light">{{ htmlShorten($trans_article->content, $shorten_length) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center">
                <a role="button" class="btn btn-lg btn-success" href="{{ localizedURL('blog') }}">{{ trans('form.action_view_all') }} {{ trans_choice('label.blog_article_lc', 2) }}</a>
            </div>
        </div>
    </div>
@endif
