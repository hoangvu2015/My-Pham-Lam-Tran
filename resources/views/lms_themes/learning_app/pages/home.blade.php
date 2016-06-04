@extends('lms_themes.learning_app.new_master.layout')
@section('body_class', 'home')
@section('extended_styles')
<style>
    input[type=text] {
        color: #000 !important;
    }
    .button-reg{text-align: center;display: block;padding: 15px 0;min-height: 50px;height: auto !important;}
</style>
@endsection
@section('extended_scripts')
<script>
    window.toBecomeTutorLink = "{{ localizedURL('auth/register') }}?selected_roles=teacher";
    window.pageName = 'Homepage';
        // https://megalytic.com/blog/tracking-youtube-videos-using-google-analytics
        // This code loads the IFrame Player API code asynchronously
        var tag = document.createElement('script');
        tag.src = "http://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // This code is called by the YouTube API to create the player object
        function onYouTubeIframeAPIReady(event) {
          player = new YT.Player('youTubePlayer', {
            events: {
              'onReady': onPlayerReady,
              'onStateChange': onPlayerStateChange
          }
      });
      }

      var pauseFlag = false;
      function onPlayerReady(event) {
           // do nothing, no tracking needed
       }
       function onPlayerStateChange(event) {
            // track when user clicks to Play
            if (event.data == YT.PlayerState.PLAYING) {
                GA('Homepage', 'ClickPlayVideoOnClassSection', 'Homepage');
                pauseFlag = true;
            }
            // track when user clicks to Pause
            if (event.data == YT.PlayerState.PAUSED && pauseFlag) {
                GA('Homepage', 'ClickPlayVideoOnClassSection', 'Homepage');
                pauseFlag = false;
            }
            // track when video ends
            if (event.data == YT.PlayerState.ENDED) {
                GA('Homepage', 'ClickPlayVideoOnClassSection', 'Homepage');
            }
        }
        //Auto play video in popup
        $('#youtube-1').click(function(event) {
            /* Act on the event */
            $('#popup-banner >iframe').attr('src','https://www.youtube.com/embed/qkt8mJol_KY?autoplay=1')
        });
        $.magnificPopup.instance.close = function () {
            $('#popup-banner >iframe').attr('src','https://www.youtube.com/embed/qkt8mJol_KY?autoplay=0')
            $.magnificPopup.proto.close.call(this);
        };
    </script>
    @endsection
    @section('layout_content')
    <div id="mod-home">
    {{--   <div id="popup-ad">
            <button id="popup" class="hidden" onclick="GA('PopupAds', 'ShowPopup1t6', 'Homepage');">Lorem ipsum dolor sit amet</button>
            <div id="popup-ads" class="bzPopup bzPopupAnimation mfp-hide">
                <a href="{{localizedURL('external-learning-request-kid/step-{step}', ['step' => 1])}}" onclick="GA('PopupAds', 'ClickPopup1t6', 'Homepage');">
                    <img src="{{url()}}/public/images/New-Layout/popup_1_6-02.jpg" alt="" class="img-responsive" onclick="mainJs.closePopup()">
                </a>
            </div>
        </div>--}}
        <div id="banner">
            <div class="container-fluid">
                <h1>
                    {!!trans('new_label.homepage_banner_headline')!!}
                </h1>

                <p class="with">
                    {!!trans('new_label.homepage_banner_subheadline')!!}
                </p>

                <div class="fb-like" data-width="200"
                data-href="https://www.facebook.com/antoree.global" data-layout="standard" data-action="like"
                data-show-faces="false" data-share="false"></div>
            </p>
            <p style="margin-top: 10px;">
                Hotline tư vấn: <a href="" class="link" style="color: #d0021b;"> (+84) 969 765 955</a>
            </p>
            <a onclick="GA('Homepage', 'ClickRegisterClassOnBanner', 'Homepage');"
            href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}" class="new-button button-reg">
            {{trans('new_label.homepage_register_trial')}}
        </a>

        <a href="javascript:void(0);" onclick="GA('Homepage', 'ClickPlayVideoOnBanner', 'Homepage');" class="popup-youtube" id="youtube-1">
            <img src="{{url()}}/public/images/New-Layout/play-youtube-popup.png" alt="">
        </a>
        <div id="popup-banner" class="bzPopup bzPopupAnimation mfp-hide">
            <iframe width="100%" height="360"
            src="https://www.youtube.com/embed/qkt8mJol_KY?autoplay=0"
            frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>
<div id="learn-eng">
    <div class="container-fluid">
        <div id="learn-eng">
            <h2 class="h2Title">{{trans('new_label.homepage_headline_learnenglish')}}</h2>
            <div class="list">
                <div class="learn">
                    <div class="head-learn">
                        <div class="icon">
                            <img src="{{url()}}/public/images/New-Layout/b-1.png">
                        </div>
                        <h3 class="h3Title">{{trans('new_label.homepage_subheadline_registerclass')}} </h3>
                        <img src="{{url()}}/public/images/New-Layout/arrow-circle.png" class="img-arrow">
                        <div class="line-long near right"></div>
                    </div>
                    <ul>
                        {!!trans('new_label.homepage_content_registerclass')!!}
                    </ul>
                </div>
                <div class="learn">
                    <div class="head-learn">
                        <div class="icon">
                            <img src="{{url()}}/public/images/New-Layout/b-2.png">
                        </div>
                        <h3 class="h3Title">{{trans('new_label.homepage_subheadline_trial')}}</h3>
                        <img src="{{url()}}/public/images/New-Layout/arrow-circle.png" class="img-arrow">
                        <div class="line-long"></div>
                    </div>
                    <ul>
                        {!!trans('new_label.homepage_content_trial')!!}
                    </ul>
                </div>
                <div class="learn">
                    <div class="head-learn">
                        <div class="icon">
                            <img src="{{url()}}/public/images/New-Layout/b-3.png">
                        </div>
                        <h3 class="h3Title">{{trans('new_label.homepage_subheadline_route')}}</h3>
                        <img src="{{url()}}/public/images/New-Layout/arrow-circle.png" class="img-arrow">
                        <div class="line-long"></div>
                    </div>
                    <ul>
                        {!!trans('new_label.homepage_content_route')!!}
                    </ul>
                </div>

                <div class="learn col">
                    <div class="head-learn">
                        <div class="icon">
                            <img src="{{url()}}/public/images/New-Layout/b-4.png">
                        </div>
                        <h3 class="h3Title">{{trans('new_label.homepage_subheadline_learnonline')}}</h3>
                        <img src="{{url()}}/public/images/New-Layout/arrow-circle.png" class="img-arrow">
                        <div class="line-long"></div>
                    </div>
                    <ul>
                        {!!trans('new_label.homepage_content_learnonline')!!}
                    </ul>
                </div>
                <div class="learn col">
                    <div class="head-learn">
                        <div class="icon">
                            <img src="{{url()}}/public/images/New-Layout/b-5.png">
                        </div>
                        <h3 class="h3Title">{!!trans('new_label.homepage_subheadline_rating')!!}</h3>
                        <img src="{{url()}}/public/images/New-Layout/arrow-circle.png" class="img-arrow">
                        <div class="line-long near left"></div>
                    </div>
                    <ul>
                        {!!trans('new_label.homepage_content_rating')!!}
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<div id="register">
    <div class="content">
        <div class="container-fluid">
            <div class="button-register-home">
                <a onclick="GA('Homepage', 'ClickRegisterClassOnLearnStep', 'Homepage');"
                href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}"
                class="new-button button-reg" style="margin: auto;" id="btDangKyODuoi">{{trans('new_label.homepae_button_registerclassnow')}}</a>
            </div>
        </div>
    </div>
</div>

<div id="information">
    <div class="container-fluid">

        <div class="row information-list">
            <div class="col-sm-4">
                <div class="information-image float-left">
                    <img src="{{url()}}/public/images/New-Layout/infor-1.png" alt="">
                </div>
                <div class="information-text text-left">
                    <p class="head">300+</p>

                    <p class="infor-text">{{trans('new_label.homepage_label_openclass')}}</p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-sm-4">
                <div class="information-image float-left">
                    <img src="{{url()}}/public/images/New-Layout/infor-2.png" alt="">
                </div>
                <div class="information-text text-left">
                    <p class="head">1000+</p>

                    <p class="infor-text">{{trans('new_label.homepage_label_tutorworld')}}</p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-sm-4">
                <div class="information-image float-left">
                    <img src="{{url()}}/public/images/New-Layout/infor-3.png" alt="">
                </div>
                <div class="information-text text-left">
                    <p class="head">20.000+</p>

                    <p class="infor-text">{{trans('new_label.homepage_label_learneryearold')}}</p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>


        <!-- <script src="https://www.youtube.com/iframe_api"></script>

        <script>
            var player, playing = false;
            function onYouTubeIframeAPIReady() {
                player = new YT.Player('video', {
                    height: '360',
                    width: '640',
                    videoId: 'o8kvtzBT940',
                    events: {
                        'onStateChange': onPlayerStateChange
                    }
                });
            }

            function onPlayerStateChange(event) {
                if (!playing) {
                    GA('Homepage', 'ClickPlayVideoOnClassSection', 'Homepage');
                    playing = true;
                }
            }
        </script> -->

        <div id="lesson-antoree">
            <h2 class="h2Title">{{trans('new_label.homepage_headline_class')}}</h2>

            <div class="video">
                <!-- <div id="video"></div> -->
                <iframe id="youTubePlayer"
                src="https://www.youtube.com/embed/MSqDO4QqSZ4" 
                frameborder="0" allowfullscreen></iframe>
                <!-- https://www.youtube.com/watch?v=nN4ZsO7m8Hg&list=PLiI_5X8_LDdZXB5976EBpaDm8sWJfRDlA&index=3 -->
            </div>
            <div class="button">
                <a href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}" class="new-button trial-learn" onclick="ga('send', {
                    hitType: 'event',
                    eventCategory: 'Homepage',
                    eventAction: 'ClickRegisterClassOnClassSample',
                    eventLabel: 'Homepage'});">{{ trans('new_label.menu_registerclass') }}</a>
                </div>
            </div>
            <div id="best-teacher">
                <h2 class="h2Title">{{ trans('new_label.homepage_headline_toptutor') }}</h2>
                <div class="content-best-teacher">
                    <div class="teacher-grid-list">
                        <div class="teacher-list">
                            <div class="teacher gridder-list" data-griddercontent="#teacher-1" onclick="GA('Homepage', 'ClickTopTutorAvatar', 'Homepage');">
                                <div class="teacher-content">
                                    <img src="{{url()}}/public/images/New-Layout/teacher-best-1.jpg" alt="" class="img-responsive image-teacher">
                                    <div class="detail-teacher">
                                        <div class="info-teacher">
                                            <div class="teacher-name">
                                                <span>{{ trans("new_label.footter_label_tutor") }} ZIN</span>
                                            </div>
                                            <div class="teacher-place">
                                                <span>Pakistan</span>
                                            </div>
                                            <div class="teacher-score">
                                                <ul class="list-inline">
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                                </ul>
                                                <span class="score-text">(4,71)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="image-arrow-teacher" src="{{url()}}/public/images/New-Layout/teacher-best-arrow.png">
                                </div>
                                <div id="teacher-1" class="gridder-content hidden">
                                    <div class="header">
                                        <span class="name">{{ trans("new_label.footter_label_tutor") }} ZIN</span>
                                        <span class="place"> - Pakistan</span>
                                        <div class="score-content" style="margin-right: 50px;">
                                            <ul class="list-inline">
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                            </ul>
                                            <span class="score-text">(4,71)</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        {!!trans('new_label.homepage_best_teacher_zinc_amide')!!}
                                    </div>
                                    <div class="button-register-home">
                                        <a href="{{ localizedURL('teacher/{id?}', ['id' => 24]) }}" onclick="GA('Homepage', 'ClickSeeDetailOnTopTutor', 'Homepage');" target="_blank">{{ trans("new_label.homepage_register_tutor")}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="teacher gridder-list" data-griddercontent="#teacher-2" onclick="GA('Homepage', 'ClickTopTutorAvatar', 'Homepage');">
                                <div class="teacher-content">
                                    <img src="{{url()}}/public/images/New-Layout/teacher-best-2.jpg" alt="" class="img-responsive image-teacher">
                                    <div class="detail-teacher">
                                        <div class="info-teacher">
                                            <div class="teacher-name">
                                                <span>{{ trans("new_label.footter_label_tutor") }} MIA</span>
                                            </div>
                                            <div class="teacher-place">
                                                <span>Philippines</span>
                                            </div>
                                            <div class="teacher-score">
                                                <ul class="list-inline">
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                                </ul>
                                                <span class="score-text">(4,78)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="image-arrow-teacher" src="{{url()}}/public/images/New-Layout/teacher-best-arrow.png">
                                </div>
                                <div id="teacher-2" class="gridder-content hidden">
                                    <div class="header">
                                        <span class="name">{{ trans("new_label.footter_label_tutor") }} MIA</span>
                                        <span class="place"> - Philippines</span>
                                        <div class="score-content" style="margin-right: 50px;">
                                            <ul class="list-inline">
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                            </ul>
                                            <span class="score-text">(4,78)</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        {!!trans('new_label.homepage_best_teacher_mia')!!}
                                    </div>
                                    <div class="button-register-home">
                                        <a href="{{ localizedURL('teacher/{id?}', ['id' => 136]) }}" onclick="GA('Homepage', 'ClickSeeDetailOnTopTutor', 'Homepage');" target="_blank">{{ trans("new_label.homepage_register_tutor")}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="teacher gridder-list" data-griddercontent="#teacher-3" onclick="GA('Homepage', 'ClickTopTutorAvatar', 'Homepage');">
                                <div class="teacher-content">
                                    <img src="{{url()}}/public/images/New-Layout/teacher-best-3.jpg" alt="" class="img-responsive image-teacher">
                                    <div class="detail-teacher">
                                        <div class="info-teacher">
                                            <div class="teacher-name">
                                                <span>{{ trans("new_label.footter_label_tutor") }} MATT</span>
                                            </div>
                                            <div class="teacher-place">
                                                <span>United Kingdom</span>
                                            </div>
                                            <div class="teacher-score">
                                                <ul class="list-inline">
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                                </ul>
                                                <span class="score-text">(4,8)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="image-arrow-teacher" src="{{url()}}/public/images/New-Layout/teacher-best-arrow.png">
                                </div>
                                <div id="teacher-3" class="gridder-content hidden">
                                    <div class="header">
                                        <span class="name">{{ trans("new_label.footter_label_tutor") }} MATT</span>
                                        <span class="place"> - United Kingdom</span>
                                        <div class="score-content" style="margin-right: 50px;">
                                            <ul class="list-inline">
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                            </ul>
                                            <span class="score-text">(4,8)</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        {!!trans('new_label.homepage_best_teacher_matt_wilkie')!!}
                                    </div>
                                    <div class="button-register-home">
                                        <a href="{{ localizedURL('teacher/{id?}', ['id' => 823]) }}" onclick="GA('Homepage', 'ClickSeeDetailOnTopTutor', 'Homepage');" target="_blank">{{ trans("new_label.homepage_register_tutor")}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="teacher gridder-list" data-griddercontent="#teacher-4" onclick="GA('Homepage', 'ClickTopTutorAvatar', 'Homepage');">
                                <div class="teacher-content">
                                    <img src="{{url()}}/public/images/New-Layout/teacher-best-4.jpg" alt="" class="img-responsive image-teacher">
                                    <div class="detail-teacher">
                                        <div class="info-teacher">
                                            <div class="teacher-name">
                                                <span>{{ trans("new_label.footter_label_tutor") }} REBECA</span>
                                            </div>
                                            <div class="teacher-place">
                                                <span>Argentina</span>
                                            </div>
                                            <div class="teacher-score">
                                                <ul class="list-inline">
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                </ul>
                                                <span class="score-text">(5)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="image-arrow-teacher" src="{{url()}}/public/images/New-Layout/teacher-best-arrow.png">
                                </div>
                                <div id="teacher-4" class="gridder-content hidden">
                                    <div class="header">
                                        <span class="name">{{ trans("new_label.footter_label_tutor") }} REBECA</span>
                                        <span class="place"> - Argentina</span>
                                        <div class="score-content" style="margin-right: 50px;">
                                            <ul class="list-inline">
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                            </ul>
                                            <span class="score-text">(5)</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        {!!trans('new_label.homepage_best_teacher_rebeca')!!}
                                    </div>
                                    <div class="button-register-home">
                                        <a href="{{ localizedURL('teacher/{id?}', ['id' => 193]) }}" onclick="GA('Homepage', 'ClickSeeDetailOnTopTutor', 'Homepage');" target="_blank">{{ trans("new_label.homepage_register_tutor")}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="teacher gridder-list" data-griddercontent="#teacher-5" onclick="GA('Homepage', 'ClickTopTutorAvatar', 'Homepage');">
                                <div class="teacher-content">
                                    <img src="{{url()}}/public/images/New-Layout/teacher-best-5.jpg" alt="" class="img-responsive image-teacher">
                                    <div class="detail-teacher">
                                        <div class="info-teacher">
                                            <div class="teacher-name">
                                                <span>{{ trans("new_label.footter_label_tutor") }} MASON</span>
                                            </div>
                                            <div class="teacher-place">
                                                <span>United States</span>
                                            </div>
                                            <div class="teacher-score">
                                                <ul class="list-inline">
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                </ul>
                                                <span class="score-text">(5)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="image-arrow-teacher" src="{{url()}}/public/images/New-Layout/teacher-best-arrow.png">
                                </div>
                                <div id="teacher-5" class="gridder-content hidden">
                                    <div class="header">
                                        <span class="name">{{ trans("new_label.footter_label_tutor") }} MASON</span>
                                        <span class="place"> - United States</span>
                                        <div class="score-content" style="margin-right: 50px;">
                                            <ul class="list-inline">
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                            </ul>
                                            <span class="score-text">(5)</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        {!!trans('new_label.homepage_best_teacher_joseph_mason')!!}
                                    </div>
                                    <div class="button-register-home">
                                        <a href="{{ localizedURL('teacher/{id?}', ['id' => 59]) }}" onclick="GA('Homepage', 'ClickSeeDetailOnTopTutor', 'Homepage');" target="_blank">{{ trans("new_label.homepage_register_tutor")}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="teacher gridder-list" data-griddercontent="#teacher-6" onclick="GA('Homepage', 'ClickTopTutorAvatar', 'Homepage');">
                                <div class="teacher-content">
                                    <img src="{{url()}}/public/images/New-Layout/teacher-best-6.jpg" alt="" class="img-responsive image-teacher">
                                    <div class="detail-teacher">
                                        <div class="info-teacher">
                                            <div class="teacher-name">
                                                <span>{{ trans("new_label.footter_label_tutor") }} KIT KAT</span>
                                            </div>
                                            <div class="teacher-place">
                                                <span>Việt Nam</span>
                                            </div>
                                            <div class="teacher-score">
                                                <ul class="list-inline">
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                                </ul>
                                                <span class="score-text">(4,91)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="image-arrow-teacher" src="{{url()}}/public/images/New-Layout/teacher-best-arrow.png">
                                </div>
                                <div id="teacher-6" class="gridder-content hidden">
                                    <div class="header">
                                        <span class="name">{{ trans("new_label.footter_label_tutor") }} KIT KAT</span>
                                        <span class="place"> - Việt Nam</span>
                                        <div class="score-content" style="margin-right: 50px;">
                                            <ul class="list-inline">
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                            </ul>
                                            <span class="score-text">(4,91)</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        {!!trans('new_label.homepage_best_teacher_kit_kat')!!}
                                    </div>
                                    <div class="button-register-home">
                                        <a href="{{ localizedURL('teacher/{id?}', ['id' => 10]) }}" onclick="GA('Homepage', 'ClickSeeDetailOnTopTutor', 'Homepage');" target="_blank">{{ trans("new_label.homepage_register_tutor")}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="teacher gridder-list" data-griddercontent="#teacher-7" onclick="GA('Homepage', 'ClickTopTutorAvatar', 'Homepage');">
                                <div class="teacher-content">
                                    <img src="{{url()}}/public/images/New-Layout/teacher-best-7.jpg" alt="" class="img-responsive image-teacher">
                                    <div class="detail-teacher">
                                        <div class="info-teacher">
                                            <div class="teacher-name">
                                                <span> {{ trans("new_label.footter_label_tutor") }} DORA</span>
                                            </div>
                                            <div class="teacher-place">
                                                <span>Argentina</span>
                                            </div>
                                            <div class="teacher-score">
                                                <ul class="list-inline">
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                                </ul>
                                                <span class="score-text">(4,91)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="image-arrow-teacher" src="{{url()}}/public/images/New-Layout/teacher-best-arrow.png">
                                </div>
                                <div id="teacher-7" class="gridder-content hidden">
                                    <div class="header">
                                        <span class="name"> {{ trans("new_label.footter_label_tutor") }} DORA</span>
                                        <span class="place"> - Argentina</span>
                                        <div class="score-content" style="margin-right: 50px;">
                                            <ul class="list-inline">
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                            </ul>
                                            <span class="score-text">(4,91)</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        {!!trans('new_label.homepage_best_teacher_dora')!!}
                                    </div>
                                    <div class="button-register-home">
                                        <a href="{{ localizedURL('teacher/{id?}', ['id' => 146]) }}" onclick="GA('Homepage', 'ClickSeeDetailOnTopTutor', 'Homepage');" target="_blank">{{ trans("new_label.homepage_register_tutor")}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="teacher gridder-list" data-griddercontent="#teacher-8" onclick="GA('Homepage', 'ClickTopTutorAvatar', 'Homepage');">
                                <div class="teacher-content">
                                    <img src="{{url()}}/public/images/New-Layout/teacher-best-8.jpg" alt="" class="img-responsive image-teacher">
                                    <div class="detail-teacher">
                                        <div class="info-teacher">
                                            <div class="teacher-name">
                                                <span>{{ trans("new_label.footter_label_tutor") }} ELSA</span>
                                            </div>
                                            <div class="teacher-place">
                                                <span>Philippines</span>
                                            </div>
                                            <div class="teacher-score">
                                                <ul class="list-inline">
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                                </ul>
                                                <span class="score-text">(4,7)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="image-arrow-teacher" src="{{url()}}/public/images/New-Layout/teacher-best-arrow.png">
                                </div>
                                <div id="teacher-8" class="gridder-content hidden">
                                    <div class="header">
                                        <span class="name">{{ trans("new_label.footter_label_tutor") }} ELSA</span>
                                        <span class="place"> - Philippines</span>
                                        <div class="score-content" style="margin-right: 50px;">
                                            <ul class="list-inline">
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                            </ul>
                                            <span class="score-text">(4,78)</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        {!!trans('new_label.homepage_best_teacher_elsa')!!}
                                    </div>
                                    <div class="button-register-home">
                                        <a href="{{ localizedURL('teacher/{id?}', ['id' => 207]) }}" onclick="GA('Homepage', 'ClickSeeDetailOnTopTutor', 'Homepage');" target="_blank">{{ trans("new_label.homepage_register_tutor")}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="teacher gridder-list" data-griddercontent="#teacher-9" onclick="GA('Homepage', 'ClickTopTutorAvatar', 'Homepage');">
                                <div class="teacher-content">
                                    <img src="{{url()}}/public/images/New-Layout/teacher-best-9.jpg" alt="" class="img-responsive image-teacher">
                                    <div class="detail-teacher">
                                        <div class="info-teacher">
                                            <div class="teacher-name">
                                                <span>{{ trans("new_label.footter_label_tutor") }} KEN</span>
                                            </div>
                                            <div class="teacher-place">
                                                <span>Australia</span>
                                            </div>
                                            <div class="teacher-score">
                                                <ul class="list-inline">
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                </ul>
                                                <span class="score-text">(5)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="image-arrow-teacher" src="{{url()}}/public/images/New-Layout/teacher-best-arrow.png">
                                </div>
                                <div id="teacher-9" class="gridder-content hidden">
                                    <div class="header">
                                        <span class="name">{{ trans("new_label.footter_label_tutor") }} KEN</span>
                                        <span class="place"> - Australia</span>
                                        <div class="score-content" style="margin-right: 50px;">
                                            <ul class="list-inline">
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                            </ul>
                                            <span class="score-text">(5)</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        {!!trans('new_label.homepage_best_teacher_kenneth_wyatt')!!}
                                    </div>
                                    <div class="button-register-home">
                                        <a href="{{ localizedURL('teacher/{id?}', ['id' => 22]) }}" onclick="GA('Homepage', 'ClickSeeDetailOnTopTutor', 'Homepage');" target="_blank">{{ trans("new_label.homepage_register_tutor")}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="teacher gridder-list" data-griddercontent="#teacher-10" onclick="GA('Homepage', 'ClickTopTutorAvatar', 'Homepage');">
                                <div class="teacher-content">
                                    <img src="{{url()}}/public/images/New-Layout/teacher-best-10.jpg" alt="" class="img-responsive image-teacher">
                                    <div class="detail-teacher">
                                        <div class="info-teacher">
                                            <div class="teacher-name">
                                                <span>{{ trans("new_label.footter_label_tutor") }} CHAU</span>
                                            </div>
                                            <div class="teacher-place">
                                                <span>Việt Nam</span>
                                            </div>
                                            <div class="teacher-score">
                                                <ul class="list-inline">
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                    <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                                    <li class="review-text">
                                                    </li>
                                                </ul>
                                                <span class="score-text">(4,73)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="image-arrow-teacher" src="{{url()}}/public/images/New-Layout/teacher-best-arrow.png">
                                </div>
                                <div id="teacher-10" class="gridder-content hidden">
                                    <div class="header">
                                        <span class="name">{{ trans("new_label.footter_label_tutor") }} CHAU</span>
                                        <span class="place"> - Việt Nam</span>
                                        <div class="score-content" style="margin-right: 50px;">
                                            <ul class="list-inline">
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star-2.png"></li>
                                                <li><img src="{{url()}}/public/images/ic_star_half-2.png"></li>
                                            </ul>
                                            <span class="score-text">(4,73)</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        {!!trans('new_label.homepage_best_teacher_chau_t')!!}
                                    </div>
                                    <div class="button-register-home">
                                        <a href="{{ localizedURL('teacher/{id?}', ['id' => 647]) }}" onclick="GA('Homepage', 'ClickSeeDetailOnTopTutor', 'Homepage');" target="_blank">{{ trans("new_label.homepage_register_tutor")}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">

                <div class="student-say">
                    <h2 class="h2Title">{{trans('new_label.homepage_headline_review')}}</h2>

                    <div class="comment-list">
                        <div class="row">
                            <div class="col-sm-5 teacher">
                                <div class="avatar text-left">
                                    <img src="{{url()}}/public/images/New-Layout/avatar1.png" class="float-left">

                                    <p class="name">{{trans('new_label.homepage_haininh_name')}}</p>

                                    <p class="office">{{trans('new_label.homepage_haininh_work')}}</p>

                                    <p class="study-with">{{trans('new_label.homepage_haininh_class')}}<a
                                        style="color: #009A5F;" target="_blank"
                                        href="{{ localizedURL('teacher/{id?}',['id'=>61]) }}">  {{trans('new_label.homepage_haininh_teacher')}}</a></span>
                                    </p>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="text">
                                    <p>
                                        {{trans('new_label.homepage_haininh_review')}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>

                            <div class="col-sm-5 teacher margin-up">
                                <div class="avatar text-left">
                                    <img src="{{url()}}/public/images/New-Layout/avatar2.png" class="float-left">

                                    <p class="name">{{trans('new_label.homepage_binhduc_name')}}</p>

                                    <p class="office">{{trans('new_label.homepage_binhduc_work')}}</p>
                                    <p class="study-with">{{trans('new_label.homepage_binhduc_class')}}<a
                                        style="color: #009A5F;" target="_blank"
                                        href="{{ localizedURL('teacher/{id?}',['id'=>38]) }}"> {{trans('new_label.homepage_binhduc_teacher')}}</a></span>
                                    </p>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="text">
                                    <p>
                                        {{trans('new_label.homepage_binhduc_review')}}
                                    </p>
                                </div>
                            </div>

                            <div class="col-sm-5 teacher margin-down">
                                <div class="avatar text-left">
                                    <img src="{{url()}}/public/images/New-Layout/avatar3.png" class="float-left">

                                    <p class="name">{{trans('new_label.homepage_ducdung_name')}}</p>

                                    <p class="office">{{trans('new_label.homepage_ducdung_work')}}</p>

                                    <p class="study-with">{{trans('new_label.homepage_ducdung_class')}}<a
                                        style="color: #009A5F;" target="_blank"
                                        href="{{ localizedURL('teacher/{id?}',['id'=>57]) }}"> {{trans('new_label.homepage_ducdung_teacher')}}</a></span>
                                    </p>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="text">
                                    <p>
                                        {{trans('new_label.homepage_ducdung_review')}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>

                            <div class="col-sm-5 teacher ">
                                <div class="avatar text-left">
                                    <img src="{{url()}}/public/images/New-Layout/avatar4.png" class="float-left">

                                    <p class="name">{{trans('new_label.homepage_bichthuy_name')}}</p>

                                    <p class="office">{{trans('new_label.homepage_bichthuy_work')}}</p>

                                    <p class="study-with">{{trans('new_label.homepage_bichthuy_class')}}<a
                                        style="color: #009A5F;" target="_blank"
                                        href="{{ localizedURL('teacher/{id?}',['id'=>23]) }}"> {{trans('new_label.homepage_bichthuy_teacher')}}</a></span>
                                    </p>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="text">
                                    <p>
                                        {{trans('new_label.homepage_bichthuy_review')}}
                                    </p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                    <a href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}" class="new-button trial-learn" onclick="GA('Homepage', 'ClickRegisterClassOnReview', 'Homepage');">{{ trans('new_label.menu_registerclass') }}</a>
                </div>
            </div>

            <div id="why">
                <div class="container">
                    <h2 class="h2Title">
                        {{trans('new_label.homepage_headline_whyantoree')}}
                        <img src="{{url()}}/public/images/New-Layout/heart-why.png" alt="" class="image-heart">
                    </h2>

                    <div class="list">
                        <div class="child-of-list">
                            <img src="{{url()}}/public/images/New-Layout/good-1.png">

                            <h3 class="h3Title">{!!trans('new_label.homepage_subheadline_oneonone')!!}</h3>

                            <div style="text-align: left;">{!!trans('new_label.homepage_content_oneonone')!!}</div>
                        </div>
                        <div class="child-of-list">
                            <img src="{{url()}}/public/images/New-Layout/good-2.png">

                            <h3 class="h3Title">{!!trans('new_label.homepage_subheadline_practice')!!}</h3>

                            <div style="text-align: left;">{!!trans('new_label.homepage_content_practice')!!}</div>
                        </div>
                        <div class="child-of-list">
                            <img src="{{url()}}/public/images/New-Layout/good-3.png">

                            <h3 class="h3Title">{!!trans('new_label.homepage_subheadline_flexible')!!}</h3>

                            <div style="text-align: left;">{!!trans('new_label.homepage_content_flexible')!!}</div>
                        </div>

                        <div class="child-of-list">
                            <img src="{{url()}}/public/images/New-Layout/good-4.png">

                            <h3 class="h3Title">{!!trans('new_label.homepage_subheadline_cost')!!}</h3>

                            <div style="text-align: left;">{!!trans('new_label.homepage_content_cost')!!}</div>
                        </div>
                        <div class="child-of-list">
                            <img src="{{url()}}/public/images/New-Layout/good-5.png">

                            <h3 class="h3Title">{!!trans('new_label.homepage_subheadline_freedoc')!!}</h3>

                            <div style="text-align: left;">{!!trans('new_label.homepage_content_freedoc')!!}</div>
                        </div>
                        <div class="child-of-list">
                            <img src="{{url()}}/public/images/New-Layout/good-6.png">

                            <h3 class="h3Title">{!!trans('new_label.homepage_subheadline_learntrial')!!}</h3>

                            <div style="text-align: left;">{!!trans('new_label.homepage_content_learntrial')!!}</div>
                        </div>
                        <div class="child-of-list">
                            <img src="{{url()}}/public/images/New-Layout/good-7.png">

                            <h3 class="h3Title">{!!trans('new_label.homepage_subheadline_support247')!!}</h3>

                            <div style="text-align: left;">{!!trans('new_label.homepage_content_support247')!!}</div>
                        </div>
                    </div>
                    <div class="button-register">
                        <a href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}" class="new-button trial-learn" onclick="ga('send', {
                            hitType: 'event',
                            eventCategory: 'Homepage',
                            eventAction: 'ClickRegisterClassOnWhyAntoree',
                            eventLabel: 'Homepage'});">{{ trans('new_label.menu_registerclass') }}</a>
                        </div>
                    </div>
                </div>

                <div id="media" class="bg-gray">
                    <div class="container">
                        <h2 class="h2Title">{{trans('new_label.homepage_headline_media')}}</h2>

                        <div class="list">
                            <div class="row">

                                <div class="col-sm-4 col-xs-12">
                                    <div class="img">
                                        <p><a target="_blank"
                                          href="http://ictnews.vn/khoi-nghiep/antoree-san-giao-dich-hoc-tieng-anh-dau-tien-cho-nguoi-viet-121863.ict">
                                          <img src="{{url()}}/public/images/New-Layout/img_ict_new.png"
                                          class="img-responsive" alt=""></a>
                                      </p>
                                  </div>
                                  <p>“Dạy và học tiếng Anh cùng gia sư giờ đây sẽ trở nên đơn giản hơn nhờ sự trợ giúp của
                                    Antoree”</p>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <div class="img">
                                        <p><a target="_blank"
                                          href="http://ndh.vn/co-gai-8x-bo-luong-3-000-usd-thang-de-khoi-nghiep-voi-mo-hinh-gia-su-kieu-uber--20160304085045463p128c143.news">
                                          <img src="{{url()}}/public/images/New-Layout/img_ndh.png" class="img-responsive"
                                          alt="">
                                      </a></p>
                                  </div>
                                  <p>“Cô gái 8X bỏ lương 3.000 USD/tháng để khởi nghiệp với mô hình gia sư "kiểu Uber"”</p>
                              </div>
                              <div class="col-sm-4 col-xs-12">
                                <div class="img">
                                    <p><a target="_blank"
                                      href="http://thanhnien.vn/gioi-tre/co-gai-tre-khoi-nghiep-bang-du-an-uber-tim-gia-su-676801.html">
                                      <img src="{{url()}}/public/images/New-Layout/thanhnien.png"
                                      class="img-responsive" alt=""></a>
                                  </p>
                              </div>
                              <p>“Cô gái trẻ khởi nghiệp bằng dự án ‘Uber’ tìm gia sư”</p>
                          </div>
                          <div class="clearfix"></div>
                      </div>
                  </div>
              </div>
          </div>
          <div id="clients">
            <div class="container-fluid">
                <h2 class="h2Title">{{trans('new_label.homepage_headline_partner')}}</h2>

                <div class="table">
                    <a>
                        <img src="{{url()}}/public/images/New-Layout/customer-client-1.png" alt="">
                    </a>
                    <a>
                        <img src="{{url()}}/public/images/New-Layout/customer-client-2.png" alt="">
                    </a>
                    <a>
                        <img src="{{url()}}/public/images/New-Layout/customer-client-3.png" alt="">
                    </a>
                    <a>
                        <img src="{{url()}}/public/images/New-Layout/customer-client-4.png" alt="">
                    </a>
                    <a>
                        <img src="{{url()}}/public/images/New-Layout/customer-client-5.png" alt="">
                    </a>
                    <a>
                        <img src="{{url()}}/public/images/New-Layout/customer-client-6.png" alt="">
                    </a>
                    <a>
                        <img src="{{url()}}/public/images/New-Layout/customer-client-7.png" alt="">
                    </a>
                </div>
            </div>
        </div>

        <div id="form-register">
            <!-- Form register -->
            <div class="form">
                <h2 class="h4Title">{{trans('new_label.homepage_register_trial')}}</h2>

                <form action="{{localizedURL('external-learning-request/step-{step}', ['step' => 0])}}" method="post"
                  name="frmRegister">
                  {!! csrf_field() !!}
                  <p>{{trans('new_label.homepage_label_freetrial')}}</p>

                  <div class="form-group">
                    <input name="name" type="text" class="form-control" id="exampleInputText"
                    placeholder="{{trans('label.user_name')}}" required/>

                    <div class="error-messages">
                        <!-- <div ng-message="required">Chưa nhập họ tên.</div> -->
                        <!-- <div ng-message="pattern">Tên không được chứa các ký tự đặc biệt.</div> -->
                    </div>
                </div>
                <div class="form-group">
                    <input style="color:#000;" name="phone" type="number" class="form-control" id="exampleInputSDT"
                    placeholder="{{trans('label.phone')}}" required/>

                    <div class="error-messages">
                        <!-- <div ng-message="required">Chưa nhập số điện thoại.</div> -->
                        <!-- <div ng-message="pattern">Số điện thoại không hợp lệ.</div> -->
                    </div>
                </div>
                <div class="form-group">
                    <input style="color:#000;" name="email" type="email" class="form-control" id="exampleInputEmail"
                    placeholder="{{trans('label.email')}}" ng-model="register.formData.email"
                    ng-pattern="/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" required/>

                    <div class="error-messages">
                        <!-- <div ng-message="required">Chưa nhập email.</div> -->
                        <!-- <div ng-message="pattern">Email không hợp lệ.</div> -->
                    </div>
                </div>
                <p>
                    {{trans('new_label.homepage_label_receiveebook')}}
                </p>

                <div class="btnSubmit">
                    <button onclick="GA('Homepage', 'ClickRegisterSubmitFormButton', 'Homepage');"
                    class="bz-btn btn-default bg-onrange register" type="submit">
                    <span class="content">{{trans('new_label.homepage_button_register')}}</span>
                    <span class="prosse"></span>
                </button>
            </div>
        </form>
    </div>
    <!-- End: Form register -->
</div>
</div>
@endsection