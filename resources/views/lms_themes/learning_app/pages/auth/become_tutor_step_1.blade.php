@extends('lms_themes.learning_app.new_master.layout_auth_tutor')
@section('body_class', 'complete')
@section('lib_styles')
<link rel="stylesheet" href="{{ libraryAsset('bootstrap-datepicker/css/bootstrap-datepicker3.standalone.min.css') }}">
<link rel="stylesheet" href="{{ libraryAsset('cropper-0.11.1/dist/cropper.min.css') }}">
<link rel="stylesheet" href="{{ LmsTheme::cssAsset('crop-avatar.css') }}">
@endsection
@section('extended_styles')
<style>
    select,input{color: #000 !important;}
    .btn-submit{color: #fff !important;}
    #mod-step-1 .s2 {padding-right: 20px;}
</style>
@endsection
@section('lib_scripts')
<script src="{{ libraryAsset('cropper-0.11.1/dist/cropper.min.js') }}"></script>
<script src="{{ LmsTheme::jsAsset('crop-avatar.js') }}"></script>
<script src="{{ libraryAsset('bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ libraryAsset('bootstrap-datepicker/locales/bootstrap-datepicker.' . $site_locale . '.min.js') }}"></script>
@endsection
@section('extended_scripts')
<script>
    {!! cdataOpen() !!}
    jQuery('.date-picker').datepicker({
        language : '{{ $site_locale }}',
        format : '{{ $date_js_format }}',
        enableOnReadonly : false
    });
    {!! cdataClose() !!}
</script>
@endsection
@section('modals')
@include('lms_themes.learning_app.popup.popup_upload_avatar')
@endsection
@section('layout_content')
<div id="mod-step-1" class="become-tutor-commom">
    <div class="container">
        <div class="content">

            <div class="header">
                <h2 class="h2Title">
                    Become an antoree tutor
                </h2>
                <p >
                    Perform the followings steps to get an online tutor position in Antoree community
                </p>
            </div>

            <div class="step-list">
                <div class="step active">
                    <div class="number">
                        1
                    </div>
                    <div class="info">
                        Personal information
                    </div>
                </div>
                <div class="float-left step-list-arrow unactive images-active">
                </div>
                <div class="step">
                    <div class="number">
                        2
                    </div>
                    <div class="info">
                        Teaching informations
                    </div>

                </div>
                <div class="float-left step-list-arrow images-active"></div>
                <div class="step step-final">
                    <div class="number">
                        3
                    </div>
                    <div class="info">
                        Confirmation
                    </div>

                </div>
                <div class="clearfix"></div>
            </div>
            
            <form method="post" action="{{ localizedURL('become-a-tutor/step-1') }}" id="register">
                {!! csrf_field() !!}
                <div class="avatar row">
                    <div class="col-sm-4 images avatar-view">
                        @if(last(explode('/', authUser()->profile_picture)) == 'default.png')
                        <img src="{{url()}}/public/images/avatar-become-tutor.png" class="avatar-new-src" alt="">
                        @else
                        <img src="{{authUser()->profile_picture}}" class="avatar-new-src" alt="">
                        @endif
                    </div>
                    <div class="col-sm-8 text">
                        <p>
                            Please choose your best photo. First impression is very important in making learners choose you as their tutors
                        </p>
                        <div class="file-upload">
                            <span class="avatar-view" style="width: 165px;height: auto;">Upload an avatar</span>
                        </div>
                        @if(isset($errorAvatar))
                        <p id="avatar-alert" style="display: block;">
                            You must upload an avatar
                        </p>
                        @endif
                    </div>
                </div>

                <div class="infomations-group row">
                    <div class="info col-sm-8">
                        <p class="head">
                            {{ trans('label.birthday') }}
                        </p>
                        <div class="form-group">
                            <input type="text" placeholder="{{ $date_js_format }}" value="{{ authUser()->dateOfBirth }}" class="birthday date-picker" name="date_of_birth" id="birthdayTxt" required>
                        </div>
                    </div>
                    <div class="info col-sm-4">
                        <p class="head">
                            {{ trans('label.gender') }}
                        </p>
                        <select id="inputGender" class="select form-group s1 select-picker" name="gender" required>
                            @foreach(allGenders() as $gender)
                            <option value="{{ $gender }}"{{ $gender == authUser()->gender ? ' selected' : '' }}>
                                {{ trans('label.gender_'.$gender) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="info col-sm-8">
                        <p class="head">
                            Phone number
                        </p>
                        <div class="form-group">
                            <select id="inputPhoneCode" name="phone_code" class="select s2" id="nation-select" required>
                                <option value="" disabled selected style="display: none;">Nationality</option>
                                {!! callingCodesAsOptions(old('phone_code', 'VN')) !!}
                            </select>
                            <span class="stick"></span>
                            <input type="number" placeholder="Phone number" class="phone-number" id="phonenumberTxt" name="phone" value="{{ authUser()->phone }}" required>
                        </div>
                    </div>
                    <div class="info col-sm-4">
                        <p class="head">
                            {{ trans('label.nationality') }}
                        </p>
                        <select id="inputNationality" id="nation-select2" class="select form-group s1 select2" name="nationality" style="width: 100%;" required>
                            {!! nationalityAsOptions(authUser()->nationality,true) !!}
                        </select>
                    </div>
                    <div class="clearfix"></div>
                    <div class="info col-sm-4">
                        <p class="head">
                            {{ trans('label.city') }}
                        </p>
                        <input type="text" placeholder="City" class="form-group" id="phonenumberTxt" name="city" value="{{ authUser()->city }}" required>
                    </div>
                    <div class="info col-sm-4">
                        <p class="head">
                            {{ trans('label.national') }}
                        </p>
                        <select id="inputCountry" id="nation-select2" class="select form-group s1 select2" name="country" style="width: 100%;" required>
                            {!! countriesAsOptions(authUser()->country,true) !!}
                        </select>
                    </div>
                    <div class="info col-sm-8">
                        <p class="head">
                            {{ trans('label.skype') }}
                            <small class="help-block" style="display: inline-block;"><a href="https://support.skype.com/en/faq/FA12413/how-do-i-create-a-skype-account" target="_blank" style="color:#00AB6B;">Don't have a skype account?</a></small>
                        </p>
                        <div class="form-group">
                            <input type="text" class="birthday" placeholder="{{ trans('label.skype') }}" id="birthdayTxt" name="skype" value="{{ authUser()->skype }}" required>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="facebook">
                    <p class="head">
                        Your Facebook URL
                    </p>
                    <div class="form-group">
                        <input type="url" id="facebookTxt" placeholder="{{ trans('label.facebook') }}" name="facebook" value="{{ authUser()->facebook }}" required>
                    </div>
                </div>
                <!-- <div class="about">
                    <p class="head">
                        About me
                        <img src="{{url()}}/public/images/tooltip-become-tutor.png" alt="" id="tooltip-1" class="tooltip-popup">
                    </p>
                    <textarea id="comment"></textarea>
                    <p id="alert-about">At least 200 characters</p>
                </div> -->
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <div class="next text-right">
                    <input onclick="GA('BecomeATutor', 'ClickContinueOnStep1', 'BecomeATutor');" type="submit" class="btn-submit" value="CONTINUE >">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection