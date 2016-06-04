<div id="mod-header" ng-controller="menuCtrl">
    <div class="menu-mobile canvas" id="menuMobile">
        <div class="dropdown">
            <div class="logo">
                <a href="{{homeURL()}}" class="logo logo-mb-not-home">
                    <img src="{{url()}}/public/images/New-Layout/home-page.svg" class="img-responsive" alt="">
                    <p class="home-text">{{trans('new_label.menu_headline')}}</p>
                </a>
                <a href="{{homeURL()}}" class="logo logo-mb-in-home">
                    <img src="{{url()}}/public/images/New-Layout/home-page.svg" class="img-responsive" alt="">
                    <p class="home-text">{{trans('new_label.menu_headline')}}</p>
                </a>
            </div>
            <div class="icon" id="justify-icon">
                <span class="justify-icon-not-home"><img src="{{url()}}/public/images/New-Layout/ic_menu.png"></span>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="list-menu-mb navbar-fixed-top" id="list-menu-mb">
            <div class="top-menu-mb"><a href=""><img src="{{url()}}/public/images/New-Layout/home-page.svg"></a><span id="close-button"><img src="{{url()}}/public/images/ic_close.png"></span></div>
            <ul>
                <li><a onclick="GA('Menu', 'ClickRegisterClassButton', window.pageName);" href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}">{{trans('new_label.menu_registerclass')}}</a></li>

                @if(!$is_auth)
                <li><a onclick="GA('Menu', 'ClickBecomATutorButton', window.pageName);" href="{{ localizedURL('auth/register') }}?selected_roles=teacher">{{ trans('new_label.menu_becomeatutor') }}</a></li>
                <li><a onclick="GA('Menu', 'ClickLoginButton', window.pageName);" href="" class="log-in" ng-click="showLogin()">{{ trans('form.action_login') }}</a></li>
                @endif

                @if(isAuth())
                <li class="drop"><a href="" class="dd-profile"><img class="img-responsive img-circle width-40 height-40 profile-mb" src="{{authUser()->profile_picture}}">{{authUser()->name}}</a>
                    <ul class="dropdown-mn">

                        @if(authUser()->hasRole('admin'))
                        <li><a href="{{adminHomeURL()}}" class="personal">
                            <img src="{{url()}}/public/images/New-Layout/admin-menu.png" alt=""> {{trans('pages.page_admin')}}</a></li>
                        @endif

                        <li><a href="{{localizedURL('profile')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/profile-menu.png" alt=""> {{trans('new_label.menu_profile')}}</a></li>
                        <li><a href="{{localizedURL('yourcourses')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/course-menu.png" alt="" class="image-menu">{{trans('new_label.ycourse_label_yourcourse')}}</a></li>

                        <li><a href="{{localizedURL('auth/logout')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/logout-menu.png" alt=""> {{trans('form.action_logout')}}</a></li>
                    </ul>
                </li>
                @endif

                <li><a href="{{localizedURL('teachers')}}">{{trans('new_label.menu_tutor')}}</a></li>
                <li class="drop"><a href="{{localizedURL('blog')}}">{{trans('new_label.menu_blog')}}</a>
                    <ul class="dropdown-mn">
                        <li>
                            <a href="{{localizedURL('blog')}}">
                                {{trans('new_label.menu_bloghome')}}
                            </a>
                        </li>
                        @foreach($blog_categories as $category)
                        <li>
                            <a href="{{ localizedURL('blog/category/view/{slug}-{id}', ['slug' => $category->slug, 'id'=>$category->id]) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="{{localizedURL('faq/view/{slug?}-{id}',['slug'=>'ve-chung-toi','id'=>3])}}">{{trans('new_label.footter_label_aboutantoree')}}</a>
                    <li><a href="" class="drop">{{trans('label.language')}}</a>
                        <ul class="dropdown-mn">
                            @foreach (allSupportedLocales() as $localeCode => $properties)
                            <?php
                                $event_action = "";
                                if ($localeCode == "en") $event_action = "ClickChooseEnglishButton";
                                if ($localeCode == "vi") $event_action = "ClickChooseVietnameseButton";
                            ?>
                            <li class="{{$localeCode == currentLocale() ? 'active' : ''}}"><a class="a-flag" href="{{currentURL($localeCode)}}" onclick="GA('Menu', '{{ $event_action }}', window.pageName);"><img class="flag-24 img-responsive pull-right" src="{{flagAssetFromLanguage($localeCode, 24)}}">{{$properties['native']}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Start: Header for blog -->
        <div class="header-blog navbar-fixed-top">
            <div class="menu-blog style-menu">
                <div class="top">
                    <a href="{{homeURL()}}" class="logo float-left">
                        <img src="{{url()}}/public/images/New-Layout/home-page.svg" class="img-responsive" alt="">
                        <p class="home-text">{{trans('new_label.menu_headline')}}</p>
                    </a>
                    <div class="link float-left">
                        <div class="item">
                            <a class="@yield('active_teacher') item-link" href="{{localizedURL('teachers')}}">{{trans('new_label.menu_tutor')}}</a>
                        </div>
                        <div class="item dropdown-list">
                            <a class="@yield('active_blog') item-link" href="{{localizedURL('blog')}}">{{trans('pages.page_blog_title')}}</a>
                            <ul class="dropdown-menu-list" style="text-align: left;">
                                <li>
                                    <a class="menu-list-link" href="{{localizedURL('blog')}}">{{trans('new_label.menu_bloghome')}}</a>
                                </li>
                                @foreach($blog_categories as $category)
                                <li>
                                    <a class="menu-list-link" href="{{ localizedURL('blog/category/view/{slug}-{id}', ['slug' => $category->slug, 'id'=>$category->id]) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="item">
                            <a class="@yield('active_help') item-link" href="{{localizedURL('faq/view/{slug?}-{id}',['slug'=>'ve-chung-toi','id'=>3])}}">{{trans('new_label.footter_label_aboutantoree')}}</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    @if(!$is_auth)
                    <div class="account float-right">
                        <ul class="list-inline">
                            <li class="reg-log">
                                <a style='background: #00AB6B;margin: 0;' class="learn-trial-btn" onclick="GA('Menu', 'ClickBecomATutorButton', window.pageName);" href="{{ localizedURL('auth/register') }}?selected_roles=teacher">{{trans('new_label.menu_becomeatutor')}}</a>
                                {{--
                                <a class="learn-trial-btn" onclick="GA('Menu', 'ClickRegisterClassButton', window.pageName);" href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}">{{trans('new_label.menu_registerclass')}}</a>
                                --}}
                                
                                <!-- <a style="border-right: 1px solid #576366;" href="{{ localizedURL('auth/register') }}" class="register">{{ trans('form.action_register') }}</a> -->
                                <a onclick="GA('Menu', 'ClickLoginButton', window.pageName);" href="" class="log-in" ng-click="showLogin()">{{ trans('form.action_login') }}</a>
                            </li>

                            <li class="vn-flag dropdown"><a href="" class="dropdown-toggle" data-toggle="dropdown"><img src="{{flagAssetFromLanguage(null, 24)}}"></a>
                                <ul class="dropdown-menu language">
                                    @foreach (allSupportedLocales() as $localeCode => $properties)
                                    <?php
                                        $event_action = "";
                                        if ($localeCode == "en") $event_action = "ClickChooseEnglishButton";
                                        if ($localeCode == "vi") $event_action = "ClickChooseVietnameseButton";
                                    ?>
                                    <li class="{{$localeCode == currentLocale() ? 'active' : ''}}"><a class="a-flag" href="{{currentURL($localeCode)}}" onclick="GA('Menu', '{{ $event_action }}', window.pageName);"><img class="flag-24 img-responsive pull-right" src="{{flagAssetFromLanguage($localeCode, 24)}}">{{$properties['native']}} &nbsp&nbsp</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                    @endif

                    @if($is_auth)
                    <div class="float-right">
                        <ul class="list-inline" style="height: 35px;">
                            <li style="display:none;@yield('post_blog')">
                                <a href="{{ localizedURL('blog/add') }}" class="post-new-blog" style="position: relative; top:-10px;" onclick="GA('Menu', 'ClickWriteBlogButton', window.pageName);">
                                    {{ trans('new_label.blog_button_postblog') }}
                                </a>

                            </li>
                            <li class="vn-flag dropdown" style="top: -10px;">
                             @if(!authUser()->hasRole('teacher'))
                             <a style='background: #00AB6B; margin: 0 20px 0 -20px; color: white; padding: 10px; border-radius: 3px; text-decoration: none;' class="learn-trial-btn" onclick="GA('Menu', 'ClickBecomATutorButton', window.pageName);" href="{{ localizedURL('auth/register') }}?selected_roles=teacher">{{trans('new_label.menu_becomeatutor')}}
                             </a>
                             @endif

                             <a href="" class="dropdown-toggle" data-toggle="dropdown"><img src="{{flagAssetFromLanguage(null, 24)}}"></a>
                             <ul class="dropdown-menu language">
                                @foreach (allSupportedLocales() as $localeCode => $properties)
                                <?php
                                $event_action = "";
                                if ($localeCode == "en") $event_action = "ClickChooseEnglishButton";
                                if ($localeCode == "vi") $event_action = "ClickChooseVietnameseButton";
                                ?>
                                <li class="{{$localeCode == currentLocale() ? 'active' : ''}}"><a class="a-flag" href="{{currentURL($localeCode)}}" onclick="GA('Menu', '{{ $event_action }}', window.pageName);"><img class="flag-24 img-responsive pull-right" src="{{flagAssetFromLanguage($localeCode, 24)}}">{{$properties['native']}} &nbsp&nbsp</a></li>
                                @endforeach
                            </ul>
                        </li>

                        @if(isAuth())
                        <li class="profile display-iblock"><a href="" class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive img-circle width-40" src="{{authUser()->profile_picture}}"></a>
                            <ul class="dropdown-menu exit-or-profile">

                                @if(authUser()->hasRole('admin'))
                                <li><a href="{{adminHomeURL()}}" class="personal">
                                    <img src="{{url()}}/public/images/New-Layout/admin-menu.png" alt=""> {{trans('pages.page_admin')}}</a></li>
                                @endif

                                <li><a href="{{localizedURL('profile')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/profile-menu.png" alt=""> {{trans('new_label.menu_profile')}}</a></li>
                                <li><a href="{{localizedURL('yourcourses')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/course-menu.png" alt="" class="image-menu">{{trans('new_label.ycourse_label_yourcourse')}}</a></li>

                                <li><a href="{{localizedURL('auth/logout')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/logout-menu.png" alt=""> {{trans('form.action_logout')}}</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
                @endif

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- End: Header for blog -->

    <!-- Start: Header for tutor profile -->
    <div class="header-tutor-profile navbar-fixed-top">

        <div class="menu-tutor-profile style-menu">
            <div class="top">
                <a href="{{homeURL()}}" class="logo float-left">
                    <img src="{{url()}}/public/images/New-Layout/home-page.svg" class="img-responsive" alt="">
                    <p class="home-text">{{trans('new_label.menu_headline')}}</p>
                </a>

                <div class="link float-left">
                    <div class="item">
                        <a class="item-link" href="{{localizedURL('teachers')}}">{{trans('new_label.menu_tutor')}}</a>
                    </div>
                    <div class="item dropdown-list">
                        <a class="item-link" href="{{localizedURL('blog')}}">{{trans('pages.page_blog_title')}}</a>
                        <ul class="dropdown-menu-list" style="text-align: left;">
                            <li>
                                <a class="menu-list-link" href="{{localizedURL('blog')}}">{{trans('new_label.menu_bloghome')}}</a>
                            </li>
                            @foreach($blog_categories as $category)
                            <li>
                                <a class="menu-list-link" href="{{ localizedURL('blog/category/view/{slug}-{id}', ['slug' => $category->slug, 'id'=>$category->id]) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="item">
                        <a class="item-link" href="{{localizedURL('faq/view/{slug?}-{id}',['slug'=>'ve-chung-toi','id'=>3])}}">{{trans('new_label.footter_label_aboutantoree')}}</a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="account float-right">
                    <ul class="list-inline">
                        <li class="vn-flag dropdown">
                          @if($is_auth)
                          @if(!authUser()->hasRole('teacher'))
                          <a style='background: #00AB6B; margin: 0 10px; color: white; padding: 10px; border-radius: 3px;' class="learn-trial-btn" onclick="GA('Menu', 'ClickBecomATutorButton', window.pageName);" href="{{ localizedURL('become-a-tutor/step-1') }}">{{trans('new_label.menu_becomeatutor')}}
                          </a>
                          @endif
                          @endif
                          <a href="" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{flagAssetFromLanguage(null, 24)}}">
                        </a>
                        <ul class="dropdown-menu language">
                            @foreach (allSupportedLocales() as $localeCode => $properties)
                            <?php
                            $event_action = "";
                            if ($localeCode == "en") $event_action = "ClickChooseEnglishButton";
                            if ($localeCode == "vi") $event_action = "ClickChooseVietnameseButton";
                            ?>
                            <li class="{{$localeCode == currentLocale() ? 'active' : ''}}"><a class="a-flag" href="{{currentURL($localeCode)}}" onclick="GA('Menu', '{{ $event_action }}', window.pageName);"><img class="flag-24 img-responsive pull-right" src="{{flagAssetFromLanguage($localeCode, 24)}}">{{$properties['native']}} &nbsp&nbsp</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @if(isAuth())
                    <li class="profile"><a style="padding: 0;" href="" class="dropdown-toggle" data-toggle="dropdown"><img class="img-circle width-40" src="{{authUser()->profile_picture}}"></a>
                        <ul class="dropdown-menu exit-or-profile">

                            @if(authUser()->hasRole('admin'))
                            <li><a href="{{adminHomeURL()}}" class="personal">
                                <img src="{{url()}}/public/images/New-Layout/admin-menu.png" alt=""> {{trans('pages.page_admin')}}</a></li>
                            @endif

                            <li><a href="{{localizedURL('profile')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/profile-menu.png" alt=""> {{trans('new_label.menu_profile')}}</a></li>
                            <li><a href="{{localizedURL('yourcourses')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/course-menu.png" alt="" class="image-menu">{{trans('new_label.ycourse_label_yourcourse')}}</a></li>

                            <li><a href="{{localizedURL('auth/logout')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/logout-menu.png" alt=""> {{trans('form.action_logout')}}</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- End: Header for tutor profile -->

<!-- Start: Header for home -->
<div class="header-home navbar-fixed-top">
    <div class="left">
        <a href="{{homeURL()}}" class="logo float-left">
            <img src="{{url()}}/public/images/New-Layout/home-page.svg" class="img-responsive" alt="">
            <p class="home-text">{{trans('new_label.menu_headline')}}</p>
        </a>
        <div class="link float-left">
            <div class="item">
                <a class="item-link" href="{{localizedURL('teachers')}}">{{trans('new_label.menu_tutor')}}</a>
            </div>
            <div class="item dropdown-list">
                <a class="item-link" href="{{localizedURL('blog')}}">{{trans('pages.page_blog_title')}}</a>
                <ul class="dropdown-menu-list" style="text-align: left;">
                    <li>
                        <a class="menu-list-link" href="{{localizedURL('blog')}}">{{trans('new_label.menu_bloghome')}}</a>
                    </li>
                    @foreach($blog_categories as $category)
                    <li>
                        <a class="menu-list-link" href="{{ localizedURL('blog/category/view/{slug}-{id}', ['slug' => $category->slug, 'id'=>$category->id]) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="item">
                <a class="item-link" href="{{localizedURL('faq/view/{slug?}-{id}',['slug'=>'ve-chung-toi','id'=>3])}}">{{trans('new_label.footter_label_aboutantoree')}}</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    @if(!$is_auth)
    <div class="right">
        <ul class="list-inline">

            <li class="reg-log">
                <li class="reg-log">
                    <a style='background: #00AB6B;margin: 0;' class="learn-trial-btn" onclick="GA('Menu', 'ClickBecomATutorButton', window.pageName);" href="{{ localizedURL('auth/register') }}?selected_roles=teacher">{{trans('new_label.menu_becomeatutor')}}</a>
                    {{--
                    <a class="learn-trial-btn" onclick="GA('Menu', 'ClickRegisterClassButton', window.pageName);" href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}">{{trans('new_label.menu_registerclass')}}</a>
                    --}}
                   
                    <!-- <a style="border-right: 1px solid #576366;" href="{{ localizedURL('auth/register') }}" class="register">{{ trans('form.action_register') }}</a> -->
                    <a onclick="GA('Menu', 'ClickLoginButton', window.pageName);" href="" class="log-in" ng-click="showLogin()">{{ trans('form.action_login') }}</a>
                </li>

                <li class="vn-flag dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><img src="{{flagAssetFromLanguage(null, 24)}}"></a>
                    <ul class="dropdown-menu language">
                        @foreach (allSupportedLocales() as $localeCode => $properties)
                        <?php
                        $event_action = "";
                        if ($localeCode == "en") $event_action = "ClickChooseEnglishButton";
                        if ($localeCode == "vi") $event_action = "ClickChooseVietnameseButton";
                        ?>
                        <li class="{{$localeCode == currentLocale() ? 'active' : ''}}"><a class="a-flag" href="{{currentURL($localeCode)}}" onclick="GA('Menu', '{{ $event_action }}', window.pageName);"><img class="flag-24 img-responsive pull-right" src="{{flagAssetFromLanguage($localeCode, 24)}}">{{$properties['native']}} &nbsp&nbsp</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
        @endif

        @if($is_auth)
        <div class="float-right" style="margin-top: 10px;">
            <ul class="list-inline" style="height: 35px;">
                @if(!authUser()->hasRole('teacher'))
                <li>
                    <a style='background: #00AB6B; margin: 0 10px; color: white; padding: 10px; border-radius: 3px; position: relative; top: -10px;' class="learn-trial-btn" onclick="GA('Menu', 'ClickBecomATutorButton', window.pageName);" href="{{ localizedURL('become-a-tutor/step-1') }}">{{trans('new_label.menu_becomeatutor')}}
                    </a>
                </li>
                @endif
                <li class="vn-flag dropdown" style="top: -10px;"><a href="" class="dropdown-toggle" data-toggle="dropdown"><img src="{{flagAssetFromLanguage(null, 24)}}"></a>
                    <ul class="dropdown-menu language">

                        @foreach (allSupportedLocales() as $localeCode => $properties)
                        <li class="{{$localeCode == currentLocale() ? 'active' : ''}}">
                            <?php
                                $event_action = "";
                                if ($localeCode == "en") $event_action = "ClickChooseEnglishButton";
                                if ($localeCode == "vi") $event_action = "ClickChooseVietnameseButton";
                            ?>
                            <a class="a-flag" href="{{currentURL($localeCode)}}" onclick="GA('Menu', '{{ $event_action }}', window.pageName);">

                                <img class="flag-24 img-responsive pull-right" src="{{flagAssetFromLanguage($localeCode, 24)}}">
                                {{$properties['native']}} &nbsp&nbsp
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li class="profile display-iblock"><a href="" class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive img-circle width-40" src="{{authUser()->profile_picture}}"></a>
                    <ul class="dropdown-menu exit-or-profile">

                        @if(authUser()->hasRole('admin'))
                        <li><a href="{{adminHomeURL()}}" class="personal">
                            <img src="{{url()}}/public/images/New-Layout/admin-menu.png" alt=""> {{trans('pages.page_admin')}}</a></li>
                        @endif

                        <li><a href="{{localizedURL('profile')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/profile-menu.png" alt=""> {{trans('new_label.menu_profile')}}</a></li>
                        <li><a href="{{localizedURL('yourcourses')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/course-menu.png" alt="" class="image-menu">{{trans('new_label.ycourse_label_yourcourse')}}</a></li>

                        <li><a href="{{localizedURL('auth/logout')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/logout-menu.png" alt=""> {{trans('form.action_logout')}}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        @endif
        <div class="clearfix"></div>
    </div>
    <!-- End: Header for home -->
    <div class="header-post">
        <div class="container">
            <div class="left">
                <span class="title-blog">{{trans('new_label.menu_blog')}}</span><span title="post">{{trans('new_label.blog_button_postblog')}}</span>
            </div>
            <div class="right">
                <ul class="list-inline">
                    <li class="vn-flag dropdown"><a href="" class="dropdown-toggle" data-toggle="dropdown"><img src="{{flagAssetFromLanguage(null, 24)}}"></a>
                        <ul class="dropdown-menu language">
                            @foreach (allSupportedLocales() as $localeCode => $properties)
                            <?php
                            $event_action = "";
                            if ($localeCode == "en") $event_action = "ClickChooseEnglishButton";
                            if ($localeCode == "vi") $event_action = "ClickChooseVietnameseButton";
                            ?>
                            <li class="{{$localeCode == currentLocale() ? 'active' : ''}}"><a class="a-flag" href="{{currentURL($localeCode)}}" onclick="GA('Menu', '{{ $event_action }}', window.pageName);"><img class="flag-24 img-responsive pull-right" src="{{flagAssetFromLanguage($localeCode, 24)}}">{{$properties['native']}} &nbsp&nbsp</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @if(isAuth())
                    <li class="profile"><a style="padding: 0;" href="" class="dropdown-toggle" data-toggle="dropdown"><img class="img-circle width-40" src="{{authUser()->profile_picture}}"></a>
                        <ul class="dropdown-menu exit-or-profile">

                            @if(authUser()->hasRole('admin'))
                            <li><a href="{{adminHomeURL()}}" class="personal">
                                <img src="{{url()}}/public/images/New-Layout/admin-menu.png" alt=""> {{trans('pages.page_admin')}}</a></li>
                            @endif

                            <li><a href="{{localizedURL('profile')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/profile-menu.png" alt=""> {{trans('new_label.menu_profile')}}</a></li>
                            <li><a href="{{localizedURL('yourcourses')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/course-menu.png" alt="" class="image-menu">{{trans('new_label.ycourse_label_yourcourse')}}</a></li>

                            <li><a href="{{localizedURL('auth/logout')}}" class="personal"><img src="{{url()}}/public/images/New-Layout/logout-menu.png" alt=""> {{trans('form.action_logout')}}</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>