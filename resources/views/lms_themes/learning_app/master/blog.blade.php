<?php
$is_cover = isset($parallax_image) && !empty($parallax_image);
?>
@extends('lms_themes.learning_app.master.pages')
@section('page_header_class', 'bg-grey-500')
{{--@if(!$is_cover)--}}
    {{--@section('page_header_left')--}}
        {{--<span class="icon-block half bg-cyan-500">--}}
            {{--<a class="text-white" href="{{ localizedURL('blog') }}">--}}
                {{--<i class="fa fa-file-text-o"></i>--}}
            {{--</a>--}}
        {{--</span>--}}
    {{--@endsection--}}
{{--@endif--}}
@section('page_header_body')
    {{--<h1 class="{{ !$is_cover ? 'text-display-2 margin-none' : 'display-inline-block text-display-1 text-uppercase text-overlay bg-cyan-500' }}">--}}
        {{--<a class="text-white" href="{{ localizedURL('blog') }}">--}}
            {{--Antoree--}}
        {{--</a>--}}
    {{--</h1>--}}
    <p class="text-white text-subhead text-center blog-header">{{ trans('pages.page_blog_desc') }}</p>
    <div id="blog-register-button">
    <!-- <a href="{{localizedURL('external-learning-request/step-{step}',['step'=>1])}}" class="btn btn-red-trial btn-lg" onclick="ga('send', {
                                                                                  hitType: 'event',
                                                                                  eventCategory: 'Trial Register Button',
                                                                                  eventAction: 'click',
                                                                                  eventLabel: '{{currentURL()}}'
                                                                                });">{{trans('pages.page_blog_register_button')}} </a> -->
    
    <?php $count = explode('/', currentURL());?>
    @if(sizeof($count) == 5)
        <a href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}" class="btn btn-red-trial btn-lg" onclick="ga('send', {
                                                                                  hitType: 'event',
                                                                                  eventCategory: 'BlogListPost',
                                                                                  eventAction: 'click',
                                                                                  eventLabel: 'ClickTrialRegisterButtonOnBanner'
                                                                                });">{{trans('pages.page_blog_register_button')}} </a>
    
    @else
        <a href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}" class="btn btn-red-trial btn-lg" onclick="ga('send', {
                                                                                  hitType: 'event',
                                                                                  eventCategory: 'BlogDetailPost',
                                                                                  eventAction: 'click',
                                                                                  eventLabel: 'ClickTrialRegisterButtonOnBanner'
                                                                                });">{{trans('pages.page_blog_register_button')}}</a>
    
    @endif
    
    </div>
@endsection
@section('page_content')
        <div class="col-sm-8 col-md-8 col-lg-9">
            @yield('blog_content_top')
            @if($not_found)
                <div class="panel panel-default paper-shadow" data-z="0.5">
                    <div class="panel-body">
                        <p>{{ trans('label.content_empty') }}</p>
                    </div>
                </div>
            @else
                @yield('blog_content')
            @endif
            @yield('blog_content_bottom')
        </div>
        <div id="blog-widgets" class="col-sm-4 col-md-4 col-lg-3">
            {!! widget('blog_widgets') !!}
        </div>
@endsection