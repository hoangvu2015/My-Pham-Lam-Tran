@extends('lms_themes.learning_app.master.layout')
@section('layout_content')
    <?php
    $is_cover = isset($parallax_image) && !empty($parallax_image);
    ?>
    @if(!$is_cover)
        <div id="blog-header" class="parallax page-section @section('page_header_class'){{ 'bg-white' }}@show">
            <div class="container parallax-layer" data-opacity="true">
                <div class="media v-middle">
                    <div class="media-left">
                        @yield('page_header_left')
                    </div>
                    <div class="media-body">
                    @section('page_header_body')
                        <h1 class="text-display-2 margin-none">@yield('page_name')</h1>
                        <p class="text-light lead">@yield('page_desc')</p>
                    @show
                    </div>
                    <div class="media-right">
                        @yield('page_header_right')
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="parallax cover cover-black overlay height-300 height-500-lg height-320-xs">
            <img class="parallax-layer" src="{{ $parallax_image }}">
            <div class="parallax-layer overlay overlay-full" data-opacity="true">
                <div class="v-center">
                    <div class="container">
                        @yield('page_header_left')
                        @section('page_header_body')
                            <h1 class="text-display-1 overlay-bg-white-strong display-inline-block">@yield('page_name')</h1>
                            <p class="text-subhead overlay-bg-white-strong">@yield('page_desc')</p>
                        @show
                        @yield('page_header_right')
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="container">
        <div class="page-section">
            <div class="row">
                @yield('page_content')
            </div>
        </div>
    </div>
@endsection