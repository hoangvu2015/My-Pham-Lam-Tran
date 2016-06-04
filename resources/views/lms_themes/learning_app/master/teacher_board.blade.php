@extends('lms_themes.learning_app.master.layout')
@section('layout_content')
    <!-- <div class="parallax overflow-hidden bg-blue-400 page-section third">
        <div class="container parallax-layer" data-opacity="true">
            <div class="media v-middle">
                <div class="media-left text-center">
                    <a href="{{ localizedURL('teacher/{id?}', ['id' => $teacher_profile->id]) }}">
                        <img src="{{ $user_profile->profile_picture }}" alt="people" class="img-circle width-120 height-120 auto-profile-picture">
                    </a>
                </div>
                <div class="media-body">
                    <h1 class="text-white text-display-1 margin-v-0">{{ $user_profile->name }}</h1>
                    <p class="text-subhead">
                        @section('public_profile_link')
                            <a class="text-white text-underline" href="{{ localizedURL('teacher/{id?}', ['id' => null]) }}">{{ trans('form.action_view') }} {{ trans('pages.my_public_profile') }}</a>
                        @show
                    </p>
                </div>
                <div class="media-right">
                    <span class="label bg-blue-500">{{ trans('roles.teacher') }}</span>
                </div>
            </div>
        </div>
    </div> -->
    <div class="container">
        <div class="page-section">
            <div class="row">
                <div class="@section('main_column_class'){{ 'col-md-9' }}@show">
                    @yield('page_content')
                </div>
                <div class="@section('right_column_class'){{ 'col-md-3' }}@show">
                    @yield('before_teacher_menu')
                @if($is_owner)
                    <div class="panel panel-default" data-toggle="panel-collapse" data-open="true">
                        <div class="panel-heading panel-collapse-trigger">
                            <h4 class="panel-title">{{ trans('label.my_account') }}</h4>
                        </div>
                        <div class="panel-body list-group">
                            {!! $teacher_menu !!}
                        </div>
                    </div>
                @endif
                    @yield('after_teacher_menu')
                </div>
            </div>
        </div>
    </div>
@endsection