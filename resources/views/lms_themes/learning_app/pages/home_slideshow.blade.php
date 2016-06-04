@extends('lms_themes.learning_app.master.layout')
@section('extended_styles')
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('animate.css') }}">
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('homepage_slideshow.css') }}">
@endsection
@section('layout_content')
    <?php
    $count_slides = count($slides);
    ?>
    @if($count_slides>0)
        <div id="homepage-slideshow" class="custom-home carousel slide carousel-fade" data-ride="carousel"
             data-interval="8000">
            @if($count_slides>1)
                <ol class="carousel-indicators">
                    @for($i=0;$i<$count_slides;++$i)
                        <li {!! $i==0 ? 'class="active" ' : '' !!}data-target="#homepage-slideshow"
                            data-slide-to="{{ $i }}"></li>
                    @endfor
                </ol>
            @endif
            <div class="carousel-inner" role="listbox">
                @for($i=0;$i<$count_slides;++$i)
                    <div class="item{{ $i==0 ? ' active' : '' }}">
                        <div class="fill" style="background-image:url('{{ $slides[$i]['picture'] }}')"></div>
                        <div class="carousel-caption">
                            {!! $slides[$i]['content'] !!}
                        </div>
                    </div>
                @endfor
            </div>
            @if($count_slides>1)
                <a class="item-prev" href="#homepage-slideshow" role="button" data-slide="prev">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                    <span class="sr-only">{{ trans('label.previous') }}</span>
                </a>
                <a class="item-next" href="#homepage-slideshow" role="button" data-slide="next">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                    <span class="sr-only">{{ trans('label.next') }}</span>
                </a>
            @endif
        </div>
    @endif

    <div id="homepage-widgets">
        {!! widget('bottom_homepage') !!}
    </div>

    <div id="mod-home" class="module" style="background: #212121; width: 100%; padding-top:70px;padding-bottom: 80px;border-bottom: 1px solid #38414c;">
        <div id="register">
            <div class="content">
                <div class="container" style="margin:0 auto;display:block; max-width:700px;">
                    <h1 class="h1Title" style="color:#FFFFFF;text-align: center; margin-bottom: 45px;">{{ trans('label.message_homepage_bottom') }}</h1>
                    <a style="    display: block;
    font-family: OpenSans-Semibold;
    font-size: 18px;
    color: #4A6B91;
    font-weight: 400;
    font-style: normal;background: #FFFFFF;margin:0 auto;min-width:325px; max-width: 391px; border:none;" onclick="ga('send', {
						  hitType: 'event',
						  eventCategory: 'HomePage',
						  eventAction: 'ClickTrialRegisterButton',
						  eventLabel: '{{ trans('label.homepage') }}'
						});" href="http://antoree.com/vi/gui-yeu-cau-hoc/buoc-1" target="_blank"
                       class="btn btn-info register2" id="btDangKyODuoi">{{ trans('label.button_label_homepage_bottom') }}</a>
                </div>
            </div>
        </div>


    </div>
@endsection