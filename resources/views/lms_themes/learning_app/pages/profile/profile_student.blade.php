@extends('lms_themes.learning_app.new_master.profile')
@section('body_class', 'tutor tutor-profile')
@section('lib_scripts')
<script src="{{ libraryAsset('select2/js/select2.min.js') }}"></script>
<script src="{{ libraryAsset('cropper-0.11.1/dist/cropper.min.js') }}"></script>
<script src="{{ LmsTheme::jsAsset('crop-avatar.js') }}"></script>
<script src="{{ libraryAsset('bootstrap-select/js/bootstrap-select.min.js') }}"></script>
<script src="{{ libraryAsset('bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ libraryAsset('bootstrap-datepicker/locales/bootstrap-datepicker.' . $site_locale . '.min.js') }}"></script>
@endsection
@section('extended_scripts')
@include('file_manager.open_documents_script')
<script>
    {!! cdataOpen() !!}
    jQuery(document).ready(function () {
        jQuery('.select2').select2();
        jQuery('.select-picker').selectpicker();
        jQuery('.date-picker').datepicker({
            language : '{{ $site_locale }}',
            format : '{{ $date_js_format }}',
            enableOnReadonly : false
        });
    });

    window.pageName = 'Profile';
    window.url = '{{url()}}';
    window.user_profile = {!! json_encode($user_profile) !!};
    window.max_size = {!! json_encode($max_size) !!};
    window.max_size_byte = {!! json_encode($max_size_byte) !!};
    window.ngModule = [
    'ui.select2',
    ];
    window.facebookID = '{{env('FACEBOOK_CLIENT_ID')}}';
    function reloadDatePicker() {
        console.log('popo');
        jQuery('.date-picker').datepicker({
            language : '{{ $site_locale }}',
            format : '{{ $date_js_format }}',
            enableOnReadonly : false
        });
    }
    {!! cdataClose() !!}
</script>
@endsection

<!-- Angular JS -->
@section('lib_angular_scripts')
<script src="{{ libraryAsset('bootstrap-rating.min.js') }}"></script>
<script src="{{ libraryAsset('ui-select2/src/select2.js') }}"></script>
<script src="{{ libraryAsset('ng-file-upload/dist/ng-file-upload-shim.min.js') }}"></script>
<script src="{{ libraryAsset('ng-file-upload/dist/ng-file-upload.min.js') }}"></script>
<script src="{{ libraryAsset('angular-ckeditor/angular-ckeditor.js') }}"></script>
@endsection

@section('angular_scripts')
<script src="{{ LmsTheme::jsAsset('angular/profile/service.js') }}?version={{versionJs()}}"></script>
<script src="{{ LmsTheme::jsAsset('angular/profile/studentController.js') }}?version={{versionJs()}}"></script>
@endsection
<!-- End Angular JS -->

@section('lib_styles')
<link rel="stylesheet" href="{{ libraryAsset('select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ libraryAsset('bootstrap-select/css/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ libraryAsset('bootstrap-datepicker/css/bootstrap-datepicker3.standalone.min.css') }}">
<link rel="stylesheet" href="{{ libraryAsset('cropper-0.11.1/dist/cropper.min.css') }}">
<link rel="stylesheet" href="{{ LmsTheme::cssAsset('crop-avatar.css') }}">
@endsection
@section('extended_styles')
<style>
    .avatar-view {width: auto;}
    .select2-container {width: 100% !important;}
    .select2-container--default .select2-selection--multiple {min-height: 50px; border-radius:0;}
    .input-line{width: 79.5%;border: none;border-bottom: 1px solid #bdbdbd;padding: 10px 0;color: #384047;font-weight: 600;font-style: normal;}
    #mod-tutor-profile #society .child-society {margin-top: 40px;}
</style>
@endsection
@section('modals')
@include('lms_themes.learning_app.popup.popup_upload_avatar')
@endsection
@section('profile_content')
<div id="mod-tutor-profile" class="module hidden" ng-controller="studentProCtrl">
    <div class="container">
        <div class="content-profile">
            <div class="avatar-tutor">
                <div class="">
                    <div class="avatar avatar-view">
                        <img style="width:180px;height:180px;" src="@{{user_profile.profile_picture}}" alt="@{{user_profile.name}}" class="img-responsive avatar-new-src">
                        <a onclick="GA('Profile', 'CLickChangeAvatarButton', 'Profile');" href="" class="avatar-view bz-btn edit-avatar paper-shadow relative" style="text-decoration:none;">Upload Avatar</a>
                    </div>
                    <div class="text-imfomation">
                        <a href="mailto:@{{user_profile.email}}" class="mail">@{{user_profile.email}}</a></br>
                        <a onclick="GA('Profile', 'ClickChangePasswordButton', 'Profile');" href="" class="lock" ng-click="changePass()">{{trans('new_label.profile_label_changepassword')}}</a>
                    </div>
                </div>
            </div>
            <div class="list-detail-tutor">
                <ul class="list-inline list-tab nav-tabs" id="list-tab">
                    <li style="width: 50%;" class="active" role="presentation"><a data-toggle="tab" role="tab" aria-controls="imfomation-individual" href="#imfomation-individual" aria-expanded="true" onclick="GA('Profile', 'ClickTabPersonalInfo', 'Profile');">{{trans('new_label.profile_label_personalinfo')}}</a></li>
                    <li style="width: 50%;" role="presentation"><a data-toggle="tab" role="tab" aria-controls="your-post" href="#your-post" aria-expanded="false" onclick="GA('Profile', 'ClickTabBlogPost', 'Profile');">{{trans('new_label.profile_label_blogpost')}}</a></li>
                </ul>
                <div class="clearfix"></div>
                <div class="tab-content">
                    <div id="imfomation-individual" class="tab-pane fade in active" role="tabpanel">
                        <div id="imfomation-account" class="margin-top">
                            <h3 class="title-green">{{trans('new_label.profile_label_accountinfor')}}</h3>
                            <form name="formUserInfo" ng-submit="submitInfo(formUserInfo.$valid)">
                                <label>{{ trans('label.user_name') }}</label>
                                <input ng-change="changeSM('user-info')" ng-model="userInfo.name" id="inputName" type="text" name="name" placeholder="{{ trans('label.user_name') }}"/></br>

                                <label>{{ trans('label.birthday') }}</label>
                                <input ng-change="changeSM('user-info')" ng-model="userInfo.date_of_birth" class="date-picker" id="inputBirthday" type="text" name="date_of_birth" placeholder="{{ $date_js_format }}" required/></br>

                                <label>{{ trans('label.gender') }}</label>
                                <select ng-change="changeSM('user-info')" ng-model="userInfo.gender" id="inputGender" name="gender" data-placeholder="{{ trans('form.action_select') }} {{ trans('label.gender_lc') }}">
                                    @foreach(allGenders() as $gender)
                                    <option value="{{ $gender }}"{{ $gender == $user_profile->gender ? ' selected' : '' }}>
                                        {{ trans('label.gender_'.$gender) }}
                                    </option>
                                    @endforeach
                                </select>

                                <label>{{ trans('label.nationality') }}</label>
                                <select ng-change="changeSM('user-info')" ng-model="userInfo.nationality" id="inputNationality" name="nationality">
                                    {!! nationalityAsOptions($user_profile->nationality) !!}
                                </select>

                                <label>{{trans('label.calling_code')}}</label>
                                <select ng-change="changeSM('user-info')" ng-model="userInfo.phone_code" id="inputPhoneCode" name="phone_code" data-placeholder="{{ trans('form.action_select') }} {{ trans('label.calling_code_lc') }}">
                                    {!! callingCodesAsOptions($user_profile->phone_code) !!}
                                </select>

                                <label>{{ trans('label.phone') }}</label>
                                <input ng-change="changeSM('user-info')" type="number"required ng-model="userInfo.phone"/></br>

                                <label>{{ trans('label.address') }}</label>
                                <input ng-change="changeSM('user-info')" ng-model="userInfo.address" type="text" required/></br>

                                <label>{{ trans('label.city') }}</label>
                                <input ng-change="changeSM('user-info')" ng-model="userInfo.city" type="text" required/></br>

                                <label>{{ trans('label.national') }}</label>
                                <select ng-change="changeSM('user-info')" ng-model="userInfo.country" id="inputCountry" name="country">
                                    {!! countriesAsOptions($user_profile->country) !!}
                                </select>

                                <div class="alert alert-danger" ng-if="errors" style="margin-top:10px;">
                                    <p ng-repeat="item in errors"> 
                                        @{{item}}
                                    </p>
                                </div>

                                <input onclick="GA('Profile', 'ClickSaveUserInfoButton', 'Profile');" id="sm-user-info" ng-click="clickSM('user-info')" type="submit" disabled class="submit" value="{{trans('new_label.profile_button_save')}}" />
                            </form>
                            <div class="clearfix"></div>
                        </div>
                        <div id="society" class="margin-top">
                            <h3 class="title-green">{{trans('new_label.profile_label_connectsocial')}}</h3>
                            <div class="row child-society">
                                <div class="col-xs-1 icon-social">
                                    <img src="{{url()}}/public/images/skype.png">
                                </div>
                                <div class="col-xs-9 bettwen">
                                    <input type="text" ng-change="changeSM('skype')" ng-model="skype.skype" class="input-line" />
                                </div>
                                <div class="col-xs-2">
                                    <form name="formSkype" ng-submit="submitSkype(formSkype.$valid)">
                                        <input id="sm-skype" ng-click="clickSM('skype')" type="submit" disabled class="submit skype" value="{{trans('new_label.profile_button_save')}}" />
                                    </form>
                                </div>
                            </div>
                            <div class="row child-society">
                                <div class="col-xs-1 icon-social">
                                    <img src="{{url()}}/public/images/facebook.png">
                                </div>
                                <div class="col-xs-9 bettwen">
                                    <p style="margin-top: 10px;"><span class="title-cn" ng-if="!user_profile.conn_facebook_id">{{trans('social_sharing.is_disconnect')}}</span><span class="title-cn" ng-if="user_profile.conn_facebook_id">{{trans('social_sharing.is_connect')}}</span></p>
                                </div>
                                <div class="col-xs-2">
                                    <input ng-if="!user_profile.conn_facebook_id" type="submit" class="submit facebook" value="{{trans('social_sharing.connect')}}" ng-click="connetFacebook()"/>
                                    <input style="background: #e53935;" ng-if="user_profile.conn_facebook_id" type="submit" class="submit facebook" value="{{trans('social_sharing.disconnect')}}" ng-click="disconnetFacebook()"/>
                                </div>
                            </div>
                        </div>
                    </div><!--imfomation-individual-->
                    <div class="clearfix"></div>
                    <div id="your-post" class="tab-pane fade" role="tabpanel">
                        <div class="title-and-post">
                            <h3 class="title-green" style="">{{trans('new_label.profile_label_yourpost')}}</h3>
                            {{--@if($can_add_blog)--}}
                            <a onclick="GA('Profile', 'ClickPostBlogButton', 'Profile');" href="{{ localizedURL('blog/add') }}" target="_blank" class="post" style=""><img src="{{url()}}/public/images/New-Layout/cross.png">{{trans('new_label.profile_button_newpost')}}</a>
                            {{--@endif--}}
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        @foreach($user_articles as $article)
                        <?php
                        $trans_article = $article->translate($international_locale);
                        $article_url = localizedURL('blog/{slug}-{id}', ['id'=>$trans_article->id,'slug' => $trans_article->slug]);
                        $article_edit = localizedURL('blog/{id}/edit', ['id'=>$article->id]);
                        ?>
                        <div class="content-blog-post" style="position: relative;">
                            <div class="image-blog">
                                <a href="{{$article_url}}" target="_blank"><img style="width: 150px;height: 85px;display: block;" src="{{$article->featured_image}}" ></a>
                            </div>
                            <div class="text-coment" style="text-align: justify;">
                                <a href="{{$article_url}}" target="_blank"><span class="name-certificate">{{ $trans_article->title }}</span></a><br/>
                                {{ htmlShorten($trans_article->content, 150) }}
                            </div>
                            <!-- <div style="position: relative;"> -->
                            <a onclick="GA('Profile', 'ClickEditPostButton', 'Profile');" href="{{$article_edit}}" target="_blank" class="edit-post float-right">
                                {{trans('new_label.profile_button_edit')}}
                            </a>
                            <!-- </div> -->
                            
                        </div>
                        <div class="clearfix"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
