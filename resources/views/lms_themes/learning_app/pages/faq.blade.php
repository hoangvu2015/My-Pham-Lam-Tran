@extends('lms_themes.learning_app.new_master.pages')
@section('body_class', 'help')
@section('active_help', 'active')
@section('lib_scripts')
@endsection
@section('extended_scripts')
@endsection
@section('lib_styles')
@endsection
@section('extended_styles')
<style>
    .active{color:#00AB6B !important;}
</style>
@endsection
@section('page_content')
<div id="mod-help">
    <div class="header">
        <div class="container">
            <div class="col-xs-2 col-sm-1 col-md-1"><img src="{{url()}}/public/images/question-icon.png" alt=""></div>
            <div class="col-xs-10 col-sm-8 col-md-8">
                <h3>{{ trans('new_label.help_label_headline') }}</h3>
                <!-- <p>{{ trans('pages.page_faq_desc') }}</p> -->
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12 padding0">
            <div class="col-sm-12 col-md-4">
                <div class="listLink">
                    @foreach($faq_menu as $item)
                    <?php
                    $children=$item['children'];
                    ?>
                    <div class="rowLink">
                        <p class="borderBottom">{{ $item['name'] }}</p>
                        @foreach($children as $child)
                        <p><a href="{{ $child['link'] }}" class="{{ $child['active'] ? 'active' : '' }}">{{ $child['name'] }}</a></p>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-sm-12 col-md-8">
                <div class="text">
                    <h1 class="h3Title">{{ $faq_article->title }}</h1>
                    {!! $faq_article->content !!}
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endsection