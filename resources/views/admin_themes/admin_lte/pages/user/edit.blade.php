@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_users_title'))
@section('page_description', trans('pages.admin_users_desc'))
@section('page_breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
    <li><a href="{{ localizedAdminURL('users') }}">{{ trans('pages.admin_users_title') }}</a></li>
</ol>
@endsection
@section('lib_styles')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="{{ libraryAsset('bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/0.11.1/cropper.min.css">
<link rel="stylesheet" href="{{ LmsTheme::cssAsset('crop-avatar.css') }}">
@endsection
@section('extended_styles')
<style>
    .select2-dropdown {
        min-width: 320px;
    }
</style>
@endsection
@section('lib_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script src="{{ libraryAsset('bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ libraryAsset('bootstrap-datepicker/locales/bootstrap-datepicker.'.$site_locale.'.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/0.11.1/cropper.min.js"></script>
<script src="{{ LmsTheme::jsAsset('crop-avatar.js') }}"></script>
@endsection
@section('extended_scripts')
<script>
    {!! cdataOpen() !!}
    jQuery(document).ready(function () {
        jQuery('.select2').select2();
        jQuery('.date-picker').datepicker({
            format: '{{ $date_js_format }}',
            language: '{{ $site_locale }}',
            enableOnReadonly : false
        });
        jQuery('a.delete').off('click').on('click', function (e) {
            e.preventDefault();

            var $this = $(this);

            x_confirm('{{ trans('form.action_delete') }}', '{{ trans('label.wanna_delete', ['name' => '']) }}', function () {
                window.location.href = $this.attr('href');
            });

            return false;
        });
    });
    {!! cdataClose() !!}
</script>
@endsection
@section('modals')
@include('admin_themes.admin_lte.master.common_modals')
<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="avatar-form" action="{{ url('api/v1/upload/js-cropper/profile-picture/cms', ['id'=>$user->id]) }}" enctype="multipart/form-data" method="post">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="avatar-modal-label">{{ trans('form.action_save') }} {{ trans('label.profile_picture') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="avatar-body">

                        <!-- Upload image and data -->
                        <div class="avatar-upload">
                            <input type="hidden" class="avatar-src" name="avatar_src">
                            <input type="hidden" class="avatar-data" name="avatar_data">
                            <label for="avatarInput">{{ trans('form.action_upload') }}:</label>
                            <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                        </div>
                        <div class="help-block">{{ trans('label.max_upload_file_size', ['size' => asKb($max_upload_filesize)]) }}</div>

                        <!-- Crop and preview -->
                        <div class="row">
                            <div class="col-md-9">
                                <div class="avatar-wrapper"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="avatar-preview preview-lg"></div>
                                <div class="avatar-preview preview-md"></div>
                                <div class="avatar-preview preview-sm"></div>
                            </div>
                        </div>

                        <div class="row avatar-buttons">
                            <div class="col-md-4 col-buttons">
                                <div class="btn-group" style="width: 100%">
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="-90" style="width: 25%">
                                        <i class="fa fa-rotate-left"></i> 90&deg;
                                    </button>
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="-15" style="width: 25%">
                                        <i class="fa fa-rotate-left"></i> 15&deg;
                                    </button>
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="-30" style="width: 25%">
                                        <i class="fa fa-rotate-left"></i> 30&deg;
                                    </button>
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="-45" style="width: 25%">
                                        <i class="fa fa-rotate-left"></i> 45&deg;
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-4 col-buttons">
                                <div class="btn-group" style="width: 100%">
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="45" style="width: 25%">
                                        <i class="fa fa-rotate-right"></i> 45&deg;
                                    </button>
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="30" style="width: 25%">
                                        <i class="fa fa-rotate-right"></i> 30&deg;
                                    </button>
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="15" style="width: 25%">
                                        <i class="fa fa-rotate-right"></i> 15&deg;
                                    </button>
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="90" style="width: 25%">
                                        <i class="fa fa-rotate-right"></i> 90&deg;
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-buttons">
                                <button type="submit" class="btn btn-danger btn-block avatar-save">{{ trans('form.action_save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('form.action_close') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
@endsection
@section('page_content')
<div class="row">
    <div class="col-xs-12">
        <div class="margin-bottom">
            <a class="btn btn-primary" href="{{ localizedAdminURL('users/add') }}">{{ trans('form.action_add') }} {{ trans_choice('label.user_lc', 1) }}</a>
            <a class="btn btn-warning delete" href="{{ localizedAdminURL('users/{id}/delete', ['id'=> $user->id])}}">
                {{ trans('form.action_delete') }}
            </a>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    {{ trans('label.user_information') }}
                </h3>
            </div>
            <form action="{{ localizedAdminURL('users/update') }}" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="box-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="inputProfilePicture">{{ trans('label.profile_picture') }}</label>
                        {{-- <div class="col-md-6"> --}}
                        <div class="media v-middle media-clearfix-xs">
                            <div class="media-left">
                                <div class="avatar-view" title="{{ trans('form.action_change') }} {{ trans('label.profile_picture') }}">
                                    <img src="{{ $user->profile_picture }}" alt="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="media-body">
                                {{-- <p class="help-block text-justify"><small>{{ trans('label.teacher_profile_picture_help') }}</small></p> --}}
                            </div>
                        </div>
                        {{-- </div> --}}
                    </div>
                    <hr>

                    <div class="form-group">
                        <label for="inputName">{{ trans('label.user_name') }}</label>
                        <input class="form-control" id="inputName" name="name" maxlength="255" placeholder="{{ trans('label.user_name') }}" type="text" required value="{{ $user->name }}">
                        <div class="help-block">{{ trans('label.slug') }}: <em>{{ $user->slug }}</em></div>
                    </div>
                    <div class="form-group">
                        <label for="inputBirthday">{{ trans('label.birthday') }}</label>
                        <input class="form-control date-picker" id="inputBirthday" type="text" name="date_of_birth" placeholder="{{ $date_js_format }}" value="{{ $user->dateOfBirth }}">
                    </div>
                    <div class="form-group">
                        <label for="inputGender">{{ trans('label.gender') }}</label>
                        <select id="inputGender" class="form-control" name="gender" data-placeholder="{{ trans('form.action_select') }} {{ trans('label.gender_lc') }}">
                            @foreach(allGenders() as $gender)
                            <option value="{{ $gender }}"{{ $gender == $user->gender ? ' selected' : '' }}>
                                {{ trans('label.gender_'.$gender) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">{{ trans('label.email') }}</label>
                        <input class="form-control" id="inputEmail" name="email" maxlength="255" placeholder="{{ trans('label.email') }}" type="email" required value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">{{ trans('label.password') }}</label>
                        <input class="form-control" id="inputPassword" name="password" placeholder="{{ trans('label.password') }}" type="text">
                    </div>
                    <div class="form-group">
                        <label for="inputPhone">{{ trans('label.phone') }}</label>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="inputPhoneCode" class="sr-only">{{ trans('label.phone_code') }}</label>
                                <select id="inputPhoneCode" name="phone_code" class="form-control select2" data-placeholder="{{ trans('form.action_select') }} {{ trans('label.calling_code_lc') }}" style="width: 100%">
                                    {!! callingCodesAsOptions($user->phone_code) !!}
                                </select>
                            </div>
                            <div class="col-md-9">
                                <input class="form-control" id="inputPhone" name="phone" placeholder="{{ trans('label.phone') }}" type="tel" required value="{{ $user->phone }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSkype">{{ trans('label.skype') }}</label>
                        <input class="form-control" id="inputSkype" name="skype" placeholder="{{ trans('label.skype') }}" type="text" value="{{ $user->skype }}">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">{{ trans('label.address') }}</label>
                        <input class="form-control" id="inputAddress" name="address" placeholder="{{ trans('label.address') }}" type="text" value="{{ $user->address }}">
                    </div>
                    <div class="form-group">
                        <label for="inputCity">{{ trans('label.city') }}</label>
                        <input class="form-control" id="inputCity" name="city" placeholder="{{ trans('label.city') }}" type="text" value="{{ $user->city }}">
                    </div>
                    <div class="form-group">
                        <label for="inputCountry">{{ trans('label.nationality') }}</label>
                        <select id="inputCountry" class="form-control select2" name="country" style="width: 100%;">
                            {!! countriesAsOptions($user->country) !!}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputLanguage">{{ trans('label.main_language') }}</label>
                        <select id="inputLanguage" class="form-control" name="language" data-placeholder="{{ trans('form.action_select') }} {{ trans('label.main_language_lc') }}">
                            @foreach (allSupportedLocales() as $localeCode => $properties)
                            <option value="{{ $localeCode }}"{{ $localeCode == $user->language ? ' selected' : '' }}>
                                {{ $properties['native'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputRoles">{{ trans_choice('label.role', 2) }}</label>
                        <select id="inputRoles" class="form-control select2" name="roles[]" multiple="multiple" data-placeholder="{{ trans_choice('label.role', 2) }}">
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}"{{ $user_roles->contains('id', $role->id) ? ' selected' : '' }}>{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputActive">Active</label>
                        <select name="active" id="inputActive" class="form-control">
                            <option value="0" {{ $user->active == 0 ? "selected" : "" }}>Chưa Active</option>
                            <option value="1" {{ $user->active == 1 ? "selected" : "" }}>Active</option>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary" type="submit">{{ trans('form.action_save') }}</button>
                    <button class="btn btn-default" type="reset">{{ trans('form.action_reset') }}</button>
                    <a role="button" class="btn btn-default pull-right" href="{{ localizedAdminURL('users') }}">{{ trans('form.action_cancel') }}</a>
                </div>
            </form>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
@endsection