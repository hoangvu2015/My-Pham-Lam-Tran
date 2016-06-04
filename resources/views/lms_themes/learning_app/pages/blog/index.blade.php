@extends('lms_themes.learning_app.new_master.blog')
@section('body_class', 'blog')
@section('active_blog', 'active')
@section('post_blog', 'display:inline-block;')
@section('extended_styles')
<style>
    #mod-blog-list .content-right .row {margin:auto 0 !important;}
    #mod-blog-list .content-right .h2Title {margin-top: 30px;}
    #mod-blog-list .content-right .tag-and-social {margin-bottom: 30px;}
    #mod-blog-list .content-right .text-in-right {margin-bottom: 20px;}
    #mod-blog-list .time-ago { margin-left: 5px; color: #999; font-size: 12px;}
    .text-tag{text-decoration:none !important;}
    .img-blog{display: block;max-width: 100%;height: 250px;}
</style>
@endsection
@section('extended_scripts')
<script src="//cdn.bootcss.com/jquery-timeago/1.4.3/jquery.timeago.min.js"></script>
<script src="{{ libraryAsset('time_ago/locales/jquery.timeago.'. $site_locale .'.js') }}"></script>
<script>
    window.pageName = 'BlogList';
    jQuery(document).ready(function () {
        jQuery('.time-ago').timeago();
    });
</script>
@endsection
@section('blog_content')
<div id="mod-blog-list">
    <?php $pageName =  'BlogList'; ?>

    <div id="mod-banner-green">
        <div class="banner">
            <div class="top text-left">
                <h1>
                    @if(isset($by_category) && !empty($by_category->name))
                    {{$by_category->name}}
                    @else
                    Antoree Blog
                    @endif
                </h1>
                <p>
                    @if(isset($by_category))
                    <?php 
                    $trans_category = null;
                    foreach ($by_category->translations as $key => $value) {
                        if($value['locale'] == $site_locale){
                            $trans_category = $value;
                        }
                    }
                    ?>
                    {{shorten($trans_category->description,150)}}
                    @else
                    Tổng hợp các bài viết kinh nghiệm về học Tiếng anh cho người đi làm, dạy và học Tiếng Anh cho Trẻ em, tiếng Anh luyện thi.
                    @endif
                </p>
            </div>
            @include('lms_themes.learning_app.pages.blog.common.email_register_form')
        </div>
    </div>
</div>
<div id="mod-blog-list">
    <div class="container">
        <div id="mod-questionleft" class="canvas" data-spy="affix" data-offset-top="200" data-offset-bottom="625">  
            <div class="fb-page" 
            data-href="https://www.facebook.com/antoree.global"
            data-width="300" 
            data-hide-cover="false"
            data-show-facepile="false" 
            data-show-posts="false"></div>
            <div class="text">
                <h3 class="h3Title" style="margin-top: 0;">Giải pháp tiếng Anh tốt nhất cho người đi làm</h3>
                <span class="problem">Vấn đề học tiếng Anh của bạn?</span>
                <form class="form-group">
                    <input id=chek1 type="checkbox" class="check" /><label style="margin-left: 0px;" for="chek1">Học lâu nhưng không tiến bộ</label></br>
                    <input id=chek2 type="checkbox" class="check"/><label style="margin-left: 0px;" for="chek2">Không có thời gian học</label></br>
                    <input id=chek3 type="checkbox" class="check"/><label style="margin-left: 0px;" for="chek3">Mất gốc không biết bắt đầu từ đâu</label></br>
                    <input id=chek4 type="checkbox" class="check"/><label style="margin-left: 0px;" for="chek4">Không có môi trường để luyện tập</label></br>
                    <input id=chek5 type="checkbox" class="check"/><label style="margin-left: 0px;" for="chek5">Khác</label></br>
                    <a onclick="GA('BlogList', 'ClickRegisterClassButtonOnLeftSide', 'BlogList');" href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}" class="btn bt-question-left">ĐĂNG KÝ HỌC THỬ MIỄN PHÍ</a>
                </form>
            </div>
        </div>
        <div class="col-xs-12 col-md-8 content-right">
            @if(!$not_found)
            @foreach($articles as $article)
            <?php
            $trans_article = $article->translate($international_locale);
            $article_url = localizedURL('blog/{slug}-{id}', ['id'=>$trans_article->art_id,'slug' => $trans_article->slug]);
            $author = $article->author;
            ?>

            <div class="text-content-right">
                <h2 class="h2Title"><a onclick="GA('BlogList', 'ClickTitlePost', 'BlogList');" href="{{ $article_url }}" class="link-text-color">{{ $trans_article->title }}</a></h2>
                <div class="row view-and-social">
                    <div class="col-xs-3 tag-and-social">
                        <img class="eye-view" src="{{ LmsTheme::imageAsset('eye-view.png') }}">
                        <div class="num-view">
                            <p><span class="number">{{ intval($article->views*6.5) }}</span>{{trans('new_label.blog_label_view')}}</p>
                        </div>
                    </div>
                    <div class="col-xs-9 tag-and-social">
                        <div class="right-mb">
                            {!! content_place('social_sharing', [$trans_article]) !!}
                        </div>
                    </div>
                </div>
                @if(!empty($article->featured_image))
                <a>
                    <span style="background: url({{ $article->featured_image }}) no-repeat;background-size: cover;background-position: 50% 50%;" class="img-blog"></span>
                </a>
                @endif
                <div class="text-in-right">
                    <p>
                        {{ htmlShorten($trans_article->content, 200) }}<a onclick="GA('BlogList', 'ClickReadmorePostButton', 'BlogList');" href="{{ $article_url }}" class="readmore">  {{trans('new_label.blog_button_readmore')}}</a>
                    </p>
                </div>
                <div class="row user-and-tag">
                    <div class="col-xs-6 tag-and-social">
                        <div class="">
                            @if($author)
                            <img src="{{ $author->profile_picture }}" class="img-responsive float-left img-circle width-30" style="display:inline-block;">
                            @endif
                            <div>
                                @if($author)
                                <span class="name-user">{{ $author->name }}</span>
                                @endif
                                <div>
                                    <span class="time-ago" title="{{ defaultTimeTZ($article->created_at) }}" style="margin-left: 5px;">
                                        {{ defaultTime($article->created_at) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $article_category_index = 0;
                    $article_categories = $article->categories;
                    $count_article_categories = $article_categories->count();
                    ?>
                    <div class="col-xs-6 tag-and-social">
                        <div class="right-mb">
                            <img src="{{ LmsTheme::imageAsset('icon-tag.png') }}">
                            @foreach($article_categories as $article_category)
                            <?php
                            ++$article_category_index;
                            ?>
                            @if($article_category_index!=$count_article_categories)

                            <a onclick="GA('BlogList', 'ClickCategoryTag', 'BlogList');" href="{{ localizedURL('blog/category/view/{slug}-{id}', ['slug' => $article_category->slug,'id'=>$article_category->id]) }}"><span class="text-tag">#{{ $article_category->name }}  </span></a>,
                            @else
                            <a onclick="GA('BlogList', 'ClickCategoryTag', 'BlogList');" href="{{ localizedURL('blog/category/view/{slug}-{id}', ['slug' => $article_category->slug,'id'=>$article_category->id]) }}" class="text-tag">#{{  $article_category->name }}</a>
                            @endif
                            @endforeach
                            <div class="clear-fix"></div> 
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif

            <div class="nav-slider">
                <ul class="list-inline page_page">
                    <li class="first"><a href="{{ $query->prepare()->update('page', $page_helper->first)->toString() }}">&laquo;</a></li>
                    <li class="prev{{ $page_helper->atFirst ? ' disabled':'' }}"><a href="{{ $query->prepare()->update('page', $page_helper->prev)->toString() }}">&lsaquo;</a></li>
                    @for($i=$page_helper->start;$i<=$page_helper->end;++$i)
                    <li{!! $i==$page_helper->current ? ' class="active"':'' !!}><a href="{{ $query->prepare()->update('page', $i)->toString() }}">{{ $i }}</a></li>
                    @endfor
                    <li class="next{{ $page_helper->atLast ? ' disabled':'' }}">
                        <a href="{{ $query->prepare()->update('page', $page_helper->next)->toString() }}">&rsaquo;</a>
                    </li>
                    <li class="last">
                        <a href="{{ $query->prepare()->update('page', $page_helper->last)->toString() }}">&raquo;</a>
                    </li>
                </ul>
            </div>

        </div>

    </div>
    <div class="banner">
        <div class="content-banner">
            <span class="text">
                Luyện tiếng anh Online 1 thầy - 1 trò với gia sư bản ngữ
            </span></br>
            <a onclick="GA('BlogList', 'ClickRegisterClassButtonOnBottom', 'BlogList');" class="bt-banner btn" href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}" style="text-transform: uppercase;">{{trans('new_label.homepage_subheadline_trial')}}</a>
        </div>
    </div>
</div>
</div>

@endsection