@extends('lms_themes.learning_app.master.layout')
@section('layout_content')
    <div class="parallax cover overlay cover-image-full home">
        <img class="parallax-layer" src="{{ $cover_picture }}" alt="Learning Cover">
        <div class="parallax-layer overlay overlay-full overlay-bg-white bg-transparent" data-speed="8" data-opacity="true">
            <div class="v-center v-middle">
                <div class="page-section overlay-bg-white-strong relative paper-shadow" data-z="1">
                    <h1 class="text-display-2 margin-v-0-15 display-inline-block">{{ $cover_heading }}</h1>
                    <p class="text-subhead">{{ $cover_subheading }}</p>
                    <a class="btn btn-green-500 btn-lg paper-shadow" data-hover-z="2" data-animated
                       href="{{ localizedURL('external-learning-request/step-{step}', ['step' => 1]) }}">
                        {{ trans('label.register_trial_class') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="homepage-widgets">
        {!! widget('bottom_homepage') !!}
    </div>
@endsection