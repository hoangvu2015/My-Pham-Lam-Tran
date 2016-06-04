@extends('lms_themes.learning_app.new_master.blog')
@section('body_class', 'blog blog-detail-new')
@section('post_blog', 'display:inline-block;')
@section('extended_scripts')
<script src="//cdn.bootcss.com/jquery-timeago/1.4.3/jquery.timeago.min.js"></script>
<script src="{{ libraryAsset('time_ago/locales/jquery.timeago.'. $site_locale .'.js') }}"></script>
<script>
    window.pageName = 'BlogDetail';
    jQuery(document).ready(function () {
        jQuery('.time-ago').timeago();
    });
</script>
@endsection
@section('extended_styles')
<style>
    .social ul{padding-left: 0 !important;}
    .social ul li{margin-bottom:10px !important;}
    #mod-blog-detail .social.affix {z-index: 100;}
    /*#mod-blog-detail .content-right strong{font-size: 20px;}*/
</style>
@endsection
@section('blog_content')
<div id="mod-blog-detail">
    <?php $pageName =  'BlogDetail'; ?>
    <div id="mod-banner-green">
        <div class="banner">
            <div class="top text-left">
                <span>
                    @if(isset($categories[0]) && !empty($categories[0]->name))
                    {{$categories[0]->name}}
                    @else
                    Antoree Blog
                    @endif
                </span>
                <p>
                    @if(isset($categories[0]))
                    <?php
                    $trans_category = null;
                    foreach ($categories[0]->translations as $key => $value) {
                        if($value['locale'] == $site_locale){
                            $trans_category = $value;
                        }
                    }
                    ?>
                    {{shorten($trans_category->description,150)}}
                    @else
                    Tổng hợp các bài viết về kinh nghiệm học tiếng Anh giao tiếp, IELTS, TOEIC, TOEFL và tiếng Anh chuyên ngành như tiếng Anh cho kế toán, Tiếng Anh cho lập trình.
                    @endif
                </p>
            </div>
            @include('lms_themes.learning_app.pages.blog.common.email_register_form')
        </div>
    </div>
    <div class="container">

        <div id="mod-questionleft" class="canvas" data-spy="affix" data-offset-top="125" data-offset-bottom="625">
            <div class="fb-page" 
            data-href="https://www.facebook.com/antoree.global"
            data-width="350" 
            data-hide-cover="false"
            data-show-facepile="false" 
            data-show-posts="false"></div>
            <div class="text" id="list-old">
                <h3 class="h3Title" style="margin-top: 0;">Giải pháp tiếng Anh tốt nhất cho người đi làm</h3>
                <span class="problem">Vấn đề học tiếng Anh của bạn?</span>
                <form class="form-group">
                    <input id=chek1 type="checkbox" class="check" /><label style="margin-left: 0px;" for="chek1">Học lâu nhưng không tiến bộ</label></br>
                    <input id=chek2 type="checkbox" class="check"/><label style="margin-left: 0px;" for="chek2">Không có thời gian học</label></br>
                    <input id=chek3 type="checkbox" class="check"/><label style="margin-left: 0px;" for="chek3">Mất gốc không biết bắt đầu từ đâu</label></br>
                    <input id=chek4 type="checkbox" class="check"/><label style="margin-left: 0px;" for="chek4">Không có môi trường để luyện tập</label></br>
                    <input id=chek5 type="checkbox" class="check"/><label style="margin-left: 0px;" for="chek5">Khác</label></br>
                    <a onclick="GA('BlogDetail', 'ClickRegisterClassButtonOnLeftSide', 'BlogDetail');" href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}" class="btn bt-question-left">ĐĂNG KÝ HỌC THỬ MIỄN PHÍ</a>
                </form>
            </div>
            <div class="blog-related">
                <div class="header-text">
                    {{trans('new_label.blog_label_mostread')}}
                </div>

                <div class="text">
                    @if(sizeof($most_read))
                    @foreach($most_read as $article_read)
                    <div class="post">
                        <div class="title">
                            <?php
                            $article_trans = $article_read->translate($international_locale);
                            $author1 = \Antoree\Models\User::find($article_read->auth_id);
                            $article_url = localizedURL('blog/{slug}-{id}',['slug'=> $article_trans->slug, 'id'=> $article_trans->art_id]);
                            ?>
                            <a href="{{ $article_url }}" class="title-link" onclick="GA('BlogDetail', 'ClickMostRead', 'BlogDetail');">
                                {{ htmlShorten($article_trans->title, 70) }}
                            </a>
                        </div>
                        <div class="author">
                            <p>
                                @if($author1)
                                {{ $author1->name }}
                                @endif
                            </p>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <?php

        $article_url_view = localizedURL('blog/{slug}-{id}',['slug'=> $trans_article->slug, 'id'=> $trans_article->art_id]);
        ?>
        <div class="social" data-spy="affix" data-offset-top="200" data-offset-bottom="625">
            <p>{{ intval($article->views*6.5) }}</p>
            <p style="margin-bottom: 10px;">{{trans('new_label.blog_label_view')}}</p>
            <ul style="display:inline-block; float:left; padding-left:10px;">
                <li style="display:inline-block; vertical-align:top;">
                    <div class="fb-like" data-href="{{$article_url_view}}" data-layout="box_count" data-action="like" data-show-faces="true" data-share="true"></div>
                </li>
                <li style="display:inline-block; vertical-align:top;">
                    <script type="IN/Share" data-url="{{$article_url_view}}" data-counter="right"></script>
                </li>
                <li style="display:inline-block; vertical-align:top;">
                    <a href="https://twitter.com/share" class="twitter-share-button" {count} data-url="{{$article_url_view}}" data-via="antoree_edu">Tweet</a>
                </li>
                <li style="display:inline-block; vertical-align:top;">
                    <div class="g-plusone" data-size="tall" data-annotation="bubble" data-href="{{$article_url_view}}"></div>
                </li>
            </ul>
            <!-- {!! content_place('social_sharing', [$trans_article]) !!} -->
        </div>
        <div class="col-xs-12 col-md-8 content-right">
            <div class="text-content-right" itemscope itemtype="http://schema.org/Article">
                <h1 class="h2Title"  itemprop="name">{{ $trans_article->title }}</h1>
                <div class="user">
                    @if($author)
                    <a><img src="{{ $author->profile_picture }}" class="img-circle width-30 height-30"></a>
                    @endif
                    @if($author)
                    <span class="name-user" itemprop="author" itemscope itemtype="http://schema.org/Person">&nbsp&nbsp{{trans('new_label.blog_label_postby')}} <meta itemprop="name" content="{{ $author->name }}">{{ $author->name }}</span>
                    <span>
                        @endif
                        <i class="fa fa-clock-o fa-fw"></i>
                        <abbr class="time-ago" title="{{ defaultTimeTZ($createdAt) }}">
                            {{ defaultTime($createdAt) }}
                        </abbr>
                    </span>
                </div>

                <div class="text-blog" itemprop="articleBody">
                    {!! $trans_article->content !!}
                </div>
                {{--
                <div class="text-question-end">
                    <p>Bạn muốn cải thiện trình độ tiếng Anh? <a onclick="GA('BlogDetail', 'ClickRegisterClassButtonOnPost', 'BlogDetail');" href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}" class="register">Đăng ký học thử miễn phí với Antoree</a></p>
                </div>
                --}}
            </div>
            <div class="imfomation-user-post">
                @if($author)
                <div class="imfomate-post">
                    <div class="row">
                        <div class="col-xs-12 col-sm-2">
                            <a href="{{ localizedURL('blog/author/{id}', ['id' => $author->id]) }}"><img src="{{ $author->profile_picture }}" class="img-circle width-90"></a>
                        </div>
                        <div class="col-xs-12 col-sm-10 text-posts">
                            <p class="post-and-user"><span class="post-by">{{trans('new_label.blog_label_postby')}}</span> <span class="user-post">{{ $author->name }}</span></p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="coment-box">
                @include('lms_themes.learning_app.pages.blog.with_social_comments')
            </div>
        </div>
        <div class="col-xs-1" style="display:none;">
            <ul>
                <li><a href=""></a></li>
                <li><a href=""><img src="{{url()}}/public/images/social-longitudinal.png"></a></li>
            </ul>
        </div>
    </div>
    <div class="banner">
        <div class="content-banner">
            <span class="text">
                Luyện tiếng anh Online 1 thầy - 1 trò với gia sư bản ngữ
            </span><br/>
            <a onclick="GA('BlogDetail', 'ClickRegisterClassButtonOnBottom', 'BlogDetail');" class="bt-banner btn" href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}" style="text-transform: uppercase;">{{trans('new_label.homepage_subheadline_trial')}}</a>
        </div>
    </div>
</div>
@endsection