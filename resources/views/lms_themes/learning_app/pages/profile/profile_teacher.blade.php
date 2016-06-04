@extends('lms_themes.learning_app.new_master.profile')
@section('body_class', 'tutor tutor-profile')
@section('lib_scripts')
<script src="{{ libraryAsset('select2/js/select2.min.js') }}"></script>
<script src="{{ libraryAsset('cropper-0.11.1/dist/cropper.min.js') }}"></script>
<script src="{{ LmsTheme::jsAsset('crop-avatar.js') }}"></script>
<script src="{{ libraryAsset('bootstrap-select/js/bootstrap-select.min.js') }}"></script>
<script src="{{ libraryAsset('bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ libraryAsset('bootstrap-datepicker/locales/bootstrap-datepicker.' . $site_locale . '.min.js') }}"></script>
<script src="{{ libraryAsset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ libraryAsset('ckeditor/adapters/jquery.js') }}"></script>
@endsection
@section('extended_scripts')
@include('file_manager.open_documents_script')
<script>
    {!! cdataOpen() !!}
    jQuery(document).ready(function () {
        jQuery('.select2').select2();
        jQuery('input.rating').rating({
            stop: '{{ $max_rate }}'
        });
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
    window.teacher_profile = {!! json_encode($teacher_profile) !!};
    window.user_works = {!! json_encode($user_works) !!};
    window.user_educations = {!! json_encode($user_educations) !!};
    window.user_certificates = {!! json_encode($user_certificates) !!};
    window.topics = {!! json_encode($topics) !!};
    window.fields = {!! json_encode($fields) !!};
    window.max_size = {!! json_encode($max_size) !!};
    window.max_size_byte = {!! json_encode($max_size_byte) !!};
    window.array_payment = {!! json_encode($array_payment) !!};
    window.national = {!! json_encode(allCountries()) !!};
    window.ngModule = [
    'ui.select2',
    'ngFileUpload',
    'ckeditor'
    ];
    window.optionCkEditor = {
        language : '{{ $site_locale }}',
        filebrowserBrowseUrl : '{{ localizedURL('documents/for/ckeditor') }}',
        filebrowserFlashBrowseUrl : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=flash',
        filebrowserFlashUploadUrl  : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=flash',
        filebrowserImageBrowseLinkUrl : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=images',
        filebrowserImageBrowseUrl : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=images',
        customConfig : '{{ libraryAsset('ckeditor/config_article.js') }}'
    };
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
<script src="{{ LmsTheme::jsAsset('angular/profile/teacherController.js') }}?version={{versionJs()}}"></script>
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
    .progress{width: 300px;}
    .avatar-view {width: auto;}
    .select2-container {width: 100% !important;}
    .select2-container--default .select2-selection--multiple {min-height: 50px; border-radius:0;}

    #mod-tutor-profile #your-post .content-blog-post .text-coment {max-width: 450px;}
    #mod-tutor-profile #your-post .edit-post {position: absolute;top: 0;right: 0;}
    #mod-tutor-profile .tab-content .delete {cursor: pointer;}
    .input-line{width: 79.5%;border: none;border-bottom: 1px solid #bdbdbd;padding: 10px 0;color: #384047;font-weight: 600;font-style: normal;}
    #mod-tutor-profile .tab-content .margin-top {margin-top: 70px;}
    #mod-tutor-profile #society .child-society {margin-top: 40px;}
    .popover {max-width:500px;padding: 10px;}
    .popover p{font-size: 12px;}
    .popover .head {font-size: 14px;color: #444;font-weight: 700;font-style: normal;line-height: 20px;margin-bottom: 10px;}
</style>
@endsection

@section('extended_scripts')
<script>

</script>

@endsection

@section('modals')
@include('lms_themes.learning_app.popup.popup_upload_avatar')
@endsection
@section('profile_content')
<div id="mod-tutor-profile" class="module hidden" ng-controller="teacherProCtrl">
    <div class="container">
        <div class="content-profile">
            <div ng-if="teacher_profile.close_noti == {{\Antoree\Models\Teacher::CLOSE_NO}}" class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" ng-click="closeNoti()"><span aria-hidden="true">&times;</span></button>
                {!!trans('new_label.profile_label_hellotutor',['name'=>$user_profile->name])!!}
            </div>
            <div class="avatar-tutor">
                <div class="">
                    <div class="avatar avatar-view">
                        <img style="width:180px;height:180px;" src="@{{user_profile.profile_picture}}" alt="@{{user_profile.name}}" class="img-responsive avatar-new-src">
                        <a onclick="GA('Profile', 'CLickChangeAvatarButton', 'Profile');" href="" class="avatar-view bz-btn edit-avatar paper-shadow relative" style="text-decoration:none;">Upload Avatar</a>
                    </div>
                    <div class="text-imfomation">
                        <div style="margin-bottom: 10px;">
                            <a href="mailto:@{{user_profile.email}}" class="mail">@{{user_profile.email}}</a>
                        </div>
                        <a onclick="GA('Profile', 'ClickChangePasswordButton', 'Profile');" href="" class="lock" ng-click="changePass()">{{trans('new_label.profile_label_changepassword')}}</a>
                        <a href="{{ localizedURL('tutor-payment-information/submit') }}" class="payment-infor" target="_blank">Your payment information</a>
                        <!-- ng-click="editPayment()" -->
                        <!-- <a href="" class="lock" id="edit-password">Đổi mật khẩu</a> -->
                        @if($teacher_profile->approver_status != \Antoree\Models\Teacher::STATUS_DENY)
                        <p class="create">@{{teacher_profile.tagline}} <span ng-if="teacher_profile.tagline == ''">Edit Tagline</span><a href="" onclick="GA('Profile', 'ClickEditTagLineButton', 'Profile');" ng-click="changeTagline()"><img src="{{url()}}/public/images/ic_create.png"></a></p>
                        <!-- <p class="timer"><span class="number-time">80+ </span>giờ dạy</p> -->
                        <ul class="list-inline list-star">
                            <input type="hidden" name="rate" class="rating" value="@{{ teacher_profile.average }}" data-readonly/>
                            <span class="num-review">(@{{teacher_profile.total_review}} {{trans('new_label.profile_label_review')}})</span>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
            <div class="list-detail-tutor">
                <ul class="list-inline list-tab nav-tabs" id="list-tab">
                    <li class="active" role="presentation"><a data-toggle="tab" role="tab" aria-controls="imfomation-individual" href="#imfomation-individual" aria-expanded="true" onclick="GA('Profile', 'ClickTabPersonalInfo', 'Profile');">{{trans('new_label.profile_label_personalinfo')}}</a></li>
                    <style>#mod-tutor-profile .list-detail-tutor .list-tab li {width: 50%;}</style>
                    @if($teacher_profile->approver_status != \Antoree\Models\Teacher::STATUS_DENY)
                    <style>#mod-tutor-profile .list-detail-tutor .list-tab li {width: 25%;}</style>
                    <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="education-and-job" href="#education-and-job" aria-expanded="false" onclick="GA('Profile', 'ClickTabCareer', 'Profile');">{{trans('new_label.profile_label_career')}}</a></li>
                    <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="teaching-imfomation" href="#teaching-imfomation" aria-expanded="false" onclick="GA('Profile', 'ClickTabTeachingInfo', 'Profile');">{{trans('new_label.profile_label_teaching')}}</a></li>
                    @endif
                    <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="your-post" href="#your-post" aria-expanded="false" onclick="GA('Profile', 'ClickTabBlogPost', 'Profile');">{{trans('new_label.profile_label_blogpost')}}</a></li>
                </ul>
                <div class="clearfix"></div>
                <div class="tab-content">
                    <div id="imfomation-individual" class="tab-pane fade in active" role="tabpanel">
                        <div id="imfomation-account" class="margin-top">
                            <h3 class="title-green">{{trans('new_label.profile_label_accountinfor')}}</h3>
                            <form name="formUserInfo" ng-submit="submitInfo(formUserInfo.$valid)">
                                <label>{{ trans('label.user_name') }}</label>
                                <input ng-change="changeSM('user-info')" type="text"  ng-model="userInfo.name" id="inputName" name="name" placeholder="{{ trans('label.user_name') }}"/></br>

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
                                <select ng-change="changeSM('user-info')" ng-model="userInfo.nationality" id="inputNationality" name="nationality" required>
                                    {!! nationalityAsOptions($user_profile->nationality,true) !!}
                                </select>

                                <label>{{trans('label.calling_code')}}</label>
                                <select ng-change="changeSM('user-info')" ng-model="userInfo.phone_code" id="inputPhoneCode" name="phone_code" data-placeholder="{{ trans('form.action_select') }} {{ trans('label.calling_code_lc') }}" required>
                                    {!! callingCodesAsOptions($user_profile->phone_code) !!}
                                </select>

                                <label>{{ trans('label.phone') }}</label>
                                <input ng-change="changeSM('user-info')" ng-model="userInfo.phone" type="number" required/></br>

                                <label>{{ trans('label.address') }}</label>
                                <input ng-change="changeSM('user-info')" ng-model="userInfo.address" type="text" required/></br>

                                <label>{{ trans('label.city') }}</label>
                                <input ng-change="changeSM('user-info')" ng-model="userInfo.city" type="text" required/></br>

                                <label>{{ trans('label.national') }}</label>
                                <select ng-change="changeSM('user-info')" ng-model="userInfo.country" id="inputCountry" name="country" required>
                                    {!! countriesAsOptions($user_profile->country,true) !!}
                                </select>

                                <div class="alert alert-danger" ng-if="errors" style="margin-top:10px;">
                                    <p ng-repeat="item in errors"> 
                                        @{{item}}
                                    </p>
                                </div>

                                <input onclick="GA('Profile', 'ClickSaveUserInfoButton', 'Profile');" id="sm-user-info" ng-click="clickSM('user-info')" type="submit" disabled class="submit" value="{{trans('new_label.profile_button_savechange')}}" />
                            </form>
                            <div class="clearfix"></div>
                        </div>
                        <div id="for-you" class="margin-top">
                            <h3 class="title-green">{{trans('new_label.profile_label_aboutme')}}</h3>
                            <form name="formAboutMe" ng-submit="submitAboutMe(formAboutMe.$valid)">
                                <label class="label-of-textarea">{{trans('new_label.profile_label_inroduceyourself')}}</label>
                                <textarea ng-change="changeSM('about-me')" ng-model="aboutMe.about_me" rows="10" required></textarea></br>
                                <input onclick="GA('Profile', 'ClickSaveAboutButton', 'Profile');" id="sm-about-me" ng-click="clickSM('about-me')" type="submit" disabled class="submit" value="{{trans('new_label.profile_button_save')}}" />
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

                    <div id="education-and-job" class="tab-pane fade" role="tabpanel">
                        <div id="specialized-and-skilled" class="margin-top">
                            <h3 class="title-green">{{trans('new_label.profile_label_workingfield')}}</h3>
                            <form name="formFields" ng-submit="submitFields(formFields.$valid)">
                                <label>{{trans('new_label.profile_label_workingfield')}}</label>
                                <select ui-select2 multiple ng-change="changeSM('fields')" ng-model="teacherInfo.fields" data-placeholder="{{ trans('form.action_select') }} {{ trans_choice('label.field_lc', 2) }}" required>
                                    <option ng-repeat="item in fields" value="@{{item.id}}">@{{item.name}}</option>
                                </select>
                                <input id="sm-fields" onclick="GA('Profile', 'ClickSaveWorkingFieldButton', 'Profile');" ng-click="clickSM('fields')" type="submit" disabled class="submit" value="{{trans('new_label.profile_button_save')}}" />
                            </form>
                        </div>

                        <div id="history-work" class="margin-top">
                            <h3 class="title-green">{{ trans('label.work') }}</h3>
                            <div id="companies-@{{key}}" ng-repeat="(key, userWork) in user_works">
                                <form name="formUW" ng-submit="submitEditUW(formUW.$valid,userWork,key)">
                                    <label>{{ trans('label.company') }}</label>
                                    <input ng-change="changeSM('work-update@{{key}}')" type="text"  ng-model="userWork.company" required/></br>
                                    <label>{{ trans('label.position') }}</label>
                                    <input ng-change="changeSM('work-update@{{key}}')" type="text"  ng-model="userWork.position" required/></br>
                                    <!-- <label>Nơi làm việc</label>
                                    <input/></br> -->
                                    <div class="row day">
                                        <div class="col-xs-6">
                                            <label class="day-work">{{ trans('label.date_start') }}</label>
                                            <input ng-change="changeSM('work-update@{{key}}')" type="text"  ng-model="userWork.start" class="date-picker" placeholder="{{ $date_js_format }}" required/></br>
                                        </div>
                                        <div class="col-xs-6">
                                            <label class="day-work">{{ trans('label.date_end') }}</label>
                                            <input ng-change="changeSM('work-update@{{key}}')" type="text"  ng-model="userWork.end" class="date-picker" placeholder="{{ $date_js_format }}"/></br>
                                        </div>
                                    </div>
                                    <label class="label-of-textarea">{{ trans('label.description') }}</label>
                                    <textarea ng-change="changeSM('work-update@{{key}}')" ng-model="userWork.description" rows="4"></textarea>

                                    <a onclick="GA('Profile', 'ClickRemoveCompanyButton', 'Profile');" ng-click="deleteUW(userWork)" class="delete" style="float: left;"><img src="{{url()}}/public/images/New-Layout/ic_control_point_delete.png" /> {{trans('form.action_delete')}}</a>

                                    <input onclick="GA('Profile', 'ClickSaveWorkHistoryButton', 'Profile');" id="sm-work-update@{{key}}" ng-click="clickSM('work-update'+key)" class="submit" type="submit" disabled value="{{trans('new_label.profile_button_save')}}" />
                                </form>
                                <div class="clearfix"></div>  
                                <hr/>
                            </div>

                            <div id="fresh-companies" class="hidden">
                                <form name="formUW" ng-submit="submitAddUW(formUW.$valid,tmpUW)">
                                    <label>{{ trans('label.company') }}</label>
                                    <input ng-change="changeSM('work-add')" type="text"  ng-model="tmpUW.company" required/></br>
                                    <label>{{ trans('label.position') }}</label>
                                    <input ng-change="changeSM('work-add')" type="text"  ng-model="tmpUW.position" required/></br>
                                    <!-- <label>Nơi làm việc</label>
                                    <input/></br> -->
                                    <div class="row day">
                                        <div class="col-xs-6">
                                            <label class="day-work">{{ trans('label.date_start') }}</label>
                                            <input ng-change="changeSM('work-add')" type="text"  ng-model="tmpUW.start" class="date-picker" placeholder="{{ $date_js_format }}" required/></br>
                                        </div>
                                        <div class="col-xs-6">
                                            <label class="day-work">{{ trans('label.date_end') }}</label>
                                            <input ng-change="changeSM('work-add')" type="text"  ng-model="tmpUW.end" class="date-picker" placeholder="{{ $date_js_format }}"/></br>
                                        </div>
                                    </div>
                                    <label class="label-of-textarea">{{ trans('label.description') }}</label>
                                    <textarea ng-change="changeSM('work-add')" ng-model="tmpUW.description" rows="4"></textarea>

                                    <input onclick="GA('Profile', 'ClickSaveWorkHistoryButton', 'Profile');" id="sm-work-add" ng-click="clickSM('work-add')" class="submit" type="submit" disabled value="{{trans('new_label.profile_button_save')}}" />
                                </form>
                                <div class="clearfix"></div>
                            </div>
                            <a href="" onclick="GA('Profile', 'ClickAddCompanyButton', 'Profile');" class="add company-more" ng-click="moreUserWork()"><img src="{{url()}}/public/images/New-Layout/ic_control_point.png" /> {{trans('new_label.profile_button_addcompany')}}</a>
                        </div>
                        <div class="clearfix"></div>

                        <div id="education" class="margin-top">
                            <h3 class="title-green">{{ trans('label.education') }}</h3>
                            <div id="education-@{{key}}" ng-repeat="(key, userEdu) in user_educations">
                                <form name="formUE" ng-submit="submitEditUE(formUE.$valid, userEdu, key)">
                                    <label>{{ trans('label.school') }}</label>
                                    <input ng-change="changeSM('edu-update@{{key}}')" type="text" ng-model="userEdu.school" required/></br>
                                    <label>{{ trans('new_label.profile_label_course') }}</label>
                                    <input ng-change="changeSM('edu-update@{{key}}')" type="text" ng-model="userEdu.field" required/></br>
                                    <!-- <label>Nơi làm việc</label>
                                    <input/></br> -->
                                    <div class="row day">
                                        <div class="col-xs-6">
                                            <label class="day-work">{{ trans('label.date_start') }}</label>
                                            <input ng-change="changeSM('edu-update@{{key}}')" type="text" ng-model="userEdu.start" class="date-picker" placeholder="{{ $date_js_format }}" required/></br>
                                        </div>
                                        <div class="col-xs-6">
                                            <label class="day-work">{{ trans('label.date_end') }}</label>
                                            <input ng-change="changeSM('edu-update@{{key}}')" type="text" ng-model="userEdu.end" class="date-picker" placeholder="{{ $date_js_format }}"/></br>
                                        </div>
                                    </div>
                                    <label class="label-of-textarea">{{ trans('label.description') }}</label>
                                    <textarea ng-change="changeSM('edu-update@{{key}}')" ng-model="userEdu.description" rows="4"></textarea>

                                    <a onclick="GA('Profile', 'ClickRemoveEducationButton', 'Profile');" ng-click="deleteUE(userEdu)" class="delete" style="float: left;"><img src="{{url()}}/public/images/New-Layout/ic_control_point_delete.png" /> {{trans('form.action_delete')}}</a>

                                    <input onclick="GA('Profile', 'ClickSaveEducationButton', 'Profile');" id="sm-edu-update@{{key}}" ng-click="clickSM('edu-update'+key)" class="submit" type="submit" disabled value="{{trans('new_label.profile_button_save')}}" />
                                </form>
                                <div class="clearfix"></div>  
                                <hr/>
                            </div>

                            <div id="fresh-edu" class="hidden">
                                <form name="formUE" ng-submit="submitAddUE(formUE.$valid,tmpUE)">
                                    <label>{{ trans('label.school') }}</label>
                                    <input ng-change="changeSM('edu-add')" type="text" ng-model="tmpUE.school" required/></br>
                                    <label>{{ trans('new_label.profile_label_course') }}</label>
                                    <input ng-change="changeSM('edu-add')" type="text" ng-model="tmpUE.field" required/></br>
                                    <!-- <label>Nơi làm việc</label>
                                    <input/></br> -->
                                    <div class="row day">
                                        <div class="col-xs-6">
                                            <label class="day-work">{{ trans('label.date_start') }}</label>
                                            <input ng-change="changeSM('edu-add')" type="text" ng-model="tmpUE.start" class="date-picker" placeholder="{{ $date_js_format }}" required/></br>
                                        </div>
                                        <div class="col-xs-6">
                                            <label class="day-work">{{ trans('label.date_end') }}</label>
                                            <input ng-change="changeSM('edu-add')" type="text" ng-model="tmpUE.end" class="date-picker" placeholder="{{ $date_js_format }}"/></br>
                                        </div>
                                    </div>
                                    <label class="label-of-textarea">{{ trans('label.description') }}</label>
                                    <textarea ng-change="changeSM('edu-add')" ng-model="tmpUE.description" rows="4"></textarea>

                                    <input onclick="GA('Profile', 'ClickSaveEducationButton', 'Profile');" id="sm-edu-add" ng-click="clickSM('edu-add')" class="submit" type="submit" disabled value="{{trans('new_label.profile_button_save')}}" />
                                </form>
                                <div class="clearfix"></div>
                            </div>

                            <a href="" onclick="GA('Profile', 'ClickAddEducationButton', 'Profile');" class="add" ng-click="moreEdu()"><img src="{{url()}}/public/images/New-Layout/ic_control_point.png" /> {{trans('new_label.profile_button_addeducation')}}</a>

                        </div>
                        <div class="clearfix"></div>

                        <div id="certificate-and-diploma" class="margin-top">
                            <h3 class="title-green">{{ trans('label.certificate') }}</h3>
                            <div id="certificate-@{{key}}" ng-repeat="(key, userCer) in user_certificates">
                                <form name="formUC" ng-submit="submitEditUC(formUC.$valid, userCer, key)">
                                    <label>{{ trans('label.name') }}</label>
                                    <input ng-change="changeSM('cer-update@{{key}}')" type="text" ng-model="userCer.name" required/></br>
                                    <label>{{ trans('label.organization') }}</label>
                                    <input ng-change="changeSM('cer-update@{{key}}')" type="text" ng-model="userCer.organization" required/></br>
                                    <!-- <label>Nơi làm việc</label>
                                    <input/></br> -->
                                    <div class="row day">
                                        <div class="col-xs-6">
                                            <label class="day-work">{{ trans('label.certificated_on') }}</label>
                                            <input ng-change="changeSM('cer-update@{{key}}')" type="text" ng-model="userCer.recorded_at" class="date-picker" placeholder="{{ $date_js_format }}" required/></br>
                                        </div>
                                    </div>
                                    <label class="label-of-textarea">{{ trans('label.description') }}</label>
                                    <textarea ng-change="changeSM('cer-update@{{key}}')" ng-model="userCer.description" rows="4"></textarea>

                                    <a onclick="GA('Profile', 'ClickRemoveCertificateButton', 'Profile');" ng-click="deleteUC(userCer)" class="delete" style="float: left;"><img src="{{url()}}/public/images/New-Layout/ic_control_point_delete.png" /> {{trans('form.action_delete')}}</a>

                                    <input onclick="GA('Profile', 'ClickSaveCertificateButton', 'Profile');" id="sm-cer-update@{{key}}" ng-click="clickSM('cer-update'+key)" class="submit" type="submit" disabled value="{{trans('new_label.profile_button_save')}}" />
                                </form>
                                <div class="clearfix"></div>  
                                <hr/>
                            </div>

                            <div id="fresh-cer" class="hidden">
                                <form name="formUC" ng-submit="submitAddUC(formUC.$valid,tmpUC)">
                                    <label>{{ trans('label.name') }}</label>
                                    <input ng-change="changeSM('cer-add')" type="text" ng-model="tmpUC.name" required/></br>
                                    <label>{{ trans('label.organization') }}</label>
                                    <input ng-change="changeSM('cer-add')" type="text" ng-model="tmpUC.organization" required/></br>
                                    <!-- <label>Nơi làm việc</label>
                                    <input/></br> -->
                                    <div class="row day">
                                        <div class="col-xs-6">
                                            <label class="day-work">{{ trans('label.certificated_on') }}</label>
                                            <input ng-change="changeSM('cer-add')" type="text" ng-model="tmpUC.recorded_at" class="date-picker" placeholder="{{ $date_js_format }}" required/></br>
                                        </div>
                                    </div>
                                    <label class="label-of-textarea">{{ trans('label.description') }}</label>
                                    <textarea ng-change="changeSM('cer-add')" ng-model="tmpUC.description" rows="4"></textarea>
                                    <input onclick="GA('Profile', 'ClickAddCertificateButton', 'Profile');" id="sm-cer-add" ng-click="clickSM('cer-add')" class="submit" type="submit" disabled value="{{trans('new_label.profile_button_save')}}" />
                                </form>
                                <div class="clearfix"></div>
                            </div>

                            <a href="" onclick="GA('Profile', 'ClickAddCertificateButton', 'Profile');" class="add" ng-click="moreCer()"><img src="{{url()}}/public/images/New-Layout/ic_control_point.png" /> {{trans('new_label.profile_button_addcertificate')}}</a>

                        </div>
                    </div><!--specialized-and-skilled-->
                    <div class="clearfix"></div>
                    <div id="teaching-imfomation" class="tab-pane fade" role="tabpanel">
                        <div id="audio" class="margin-top">
                            <h3 class="title-green">{{trans('new_label.profile_label_audio')}}</h3>
                            <div class="row child-audio">
                                <div class="col-xs-9 audio-bar" ng-if="user_profile.voice">
                                    <audio preload id="audio1" controls="controls" src="@{{user_profile.voice}}">Your browser does not support HTML5 Audio!</audio>
                                </div>
                                <div class="col-xs-3 button">
                                    <button onclick="GA('Profile', 'ClickUploadAudioButton', 'Profile');" type="file" ngf-select ng-model="audioFile" name="file" accept="audio/*" ngf-change="uploadAudio($files)" class="upload-save" />Upload file</button>
                                </div>

                            </div>
                            <uib-progressbar max="100" ng-if="progressPercentage" value="progressPercentage"><span style="color:white; white-space:nowrap;">@{{progressPercentage}}% / 100%</span></uib-progressbar>
                            <p class="help-block">{{ trans('label.max_upload_file_size', ['size' => $max_size]) }}</p>
                            <p class="help-block"><small>{{ trans('label.audio_support_help') }}</small></p>
                        </div>

                        <div id="video" class="margin-top">
                            <form name="formVideo" ng-submit="submitVideo(formVideo.$valid)">
                                <h3 class="title-green">{{trans('new_label.profile_label_video')}}</h3>
                                <label>Youtube link</label>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-10">
                                        <input ng-change="changeSM('youtube')" type="url" ng-model="teacherInfo.youtube" class="input-have-border" />
                                    </div>
                                    <div class="col-xs-12 col-sm-2 button-save">
                                        <input onclick="GA('Profile', 'ClickSaveVideoButton', 'Profile');" id="sm-youtube" ng-click="clickSM('youtube')" class="upload-save" type="submit" disabled value="{{trans('new_label.profile_button_save')}}" />
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div id="subjects-and-theme" class="margin-top">
                            <h3 class="title-green">{{trans('new_label.profile_label_tutoringsubject')}}</h3>
                            <form name="formSubjectTopics" ng-submit="submitSubject(formSubjectTopics.$valid)">
                                <label>{{trans('new_label.profile_label_subject')}}</label>
                                <select ui-select2 multiple ng-change="changeSM('subject')" ng-model="teacherInfo.topics" data-placeholder="{{ trans('form.action_select') }} {{ trans_choice('label.topic_lc', 2) }}" required>
                                    <option ng-repeat="item in topics" value="@{{item.id}}">@{{item.name}}</option>
                                </select>

                                <label class="label-of-textarea">{{trans('new_label.profile_label_teachingexperience')}}</label>
                                <textarea ng-change="changeSM('subject')" ng-model="teacherInfo.experience" rows="10" required></textarea></br>
                                <!-- <textarea ckeditor="optionsCkEditor" ng-change="changeSM('subject')" ng-model="teacherInfo.experience" rows="10"></textarea></br> -->
                                
                                <label class="label-of-textarea">{{trans('new_label.profile_label_teachingmethod')}}</label>
                                <textarea ng-change="changeSM('subject')" ng-model="teacherInfo.methodology" rows="10" required></textarea>
                                <!-- <textarea ckeditor="optionsCkEditor" ng-change="changeSM('subject')" ng-model="teacherInfo.methodology" rows="10"></textarea> -->

                                <input onclick="GA('Profile', 'ClickSaveSubjectButton', 'Profile');" id="sm-subject" ng-click="clickSM('subject')" style="width:110px;" class="submit" type="submit" disabled value="{{trans('new_label.profile_button_save')}}" />
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="your-post" class="tab-pane fade" role="tabpanel">
                        <div class="title-and-post">
                            <h3 class="title-green" style="">{{trans('new_label.profile_label_yourpost')}}</h3>
                            <a onclick="GA('Profile', 'ClickPostBlogButton', 'Profile');" href="{{ localizedURL('blog/add') }}" target="_blank" class="post" style=""><img src="{{url()}}/public/images/New-Layout/cross.png">{{trans('new_label.profile_button_newpost')}}</a>
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
