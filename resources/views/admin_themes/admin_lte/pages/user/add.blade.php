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
    <link rel="stylesheet" href="{{ libraryAsset('iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ libraryAsset('bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
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
    <script src="{{ libraryAsset('iCheck/icheck.min.js') }}"></script>
    <script src="{{ libraryAsset('bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ libraryAsset('bootstrap-datepicker/locales/bootstrap-datepicker.'.$site_locale.'.min.js') }}"></script>
@endsection
@section('extended_scripts')
    <script>
        {!! cdataOpen() !!}
                jQuery(document).ready(function () {
                    jQuery('.select2').select2();
                    jQuery('[type=checkbox]').iCheck({
                        checkboxClass: 'icheckbox_square-blue',
                        radioClass: 'iradio_square-blue',
                        increaseArea: '20%' // optional
                    });
                    jQuery('.date-picker').datepicker({
                        format: '{{ $date_js_format }}',
                        language: '{{ $site_locale }}',
                        enableOnReadonly : false
                    });
                });
        {!! cdataClose() !!}
    </script>
@endsection
@section('page_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('label.user_information') }}</h3>
            </div>
            <form method="post">
                {!! csrf_field() !!}
                <div class="box-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="inputName">{{ trans('label.user_name') }}</label>
                        <input class="form-control" id="inputName" name="name" maxlength="255" placeholder="{{ trans('label.user_name') }}" type="text" required value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputBirthday">{{ trans('label.birthday') }}</label>
                        <input class="form-control date-picker" id="inputBirthday" type="text" name="date_of_birth" placeholder="{{ $date_js_format }}" value="{{ old('date_of_birth') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputGender">{{ trans('label.gender') }}</label>
                        <select id="inputGender" class="form-control" name="gender">
                            @foreach(allGenders() as $gender)
                                <option value="{{ $gender }}"{{ $gender == old('gender') ? ' selected' : '' }}>
                                    {{ trans('label.gender_'.$gender) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">{{ trans('label.email') }}</label>
                        <input class="form-control" id="inputEmail" name="email" maxlength="255" placeholder="{{ trans('label.email') }}" type="email" required value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">{{ trans('label.password') }}</label>
                        <input class="form-control" id="inputPassword" name="password" placeholder="{{ trans('label.password') }}" type="text" required value="{{ old('password') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputPhone">{{ trans('label.phone') }}</label>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="inputPhoneCode" class="sr-only">{{ trans('label.phone_code') }}</label>
                                <select id="inputPhoneCode" name="phone_code" class="form-control select2" data-placeholder="{{ trans('form.action_select') }} {{ trans('label.calling_code_lc') }}" style="width: 100%">
                                    {!! callingCodesAsOptions(old('phone_code', 'US')) !!}
                                </select>
                            </div>
                            <div class="col-md-9">
                                <input class="form-control" id="inputPhone" name="phone" placeholder="{{ trans('label.phone') }}" type="tel" required value="{{ old('phone') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSkype">{{ trans('label.skype') }}</label>
                        <input class="form-control" id="inputSkype" name="skype" placeholder="{{ trans('label.skype') }}" type="text" value="{{ old('skype') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">{{ trans('label.address') }}</label>
                        <input class="form-control" id="inputAddress" name="address" placeholder="{{ trans('label.address') }}" type="text" value="{{ old('address') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputCity">{{ trans('label.city') }}</label>
                        <input class="form-control" id="inputCity" name="city" placeholder="{{ trans('label.city') }}" type="text" value="{{ old('city') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputCountry">{{ trans('label.nationality') }}</label>
                        <select id="inputCountry" class="form-control select2" name="country" style="width: 100%;">
                            {!! countriesAsOptions(old('country', '--')) !!}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputLanguage">{{ trans('label.main_language') }}</label>
                        <select id="inputLanguage" class="form-control" name="language">
                            @foreach (allSupportedLocales() as $localeCode => $properties)
                                <option value="{{ $localeCode }}"{{ $localeCode == old('language') ? ' selected' : '' }}>
                                    {{ $properties['native'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputRoles">{{ trans_choice('label.role', 2) }}</label>
                        <select id="inputRoles" class="form-control select2" name="roles[]" multiple="multiple" data-placeholder="{{ trans_choice('label.role', 2) }}">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input id="inputSendMail" name="send_welcomed_mail" type="checkbox" value="1"{{ !empty(old('send_mail')) ? ' checked' : '' }}> &nbsp;
                        <label for="inputSendMail">{{ trans('label.send_welcome_mail') }}</label>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary" type="submit">{{ trans('form.action_add') }}</button>
                    <button class="btn btn-default" type="reset">{{ trans('form.action_reset') }}</button>
                    <a role="button" class="btn btn-warning pull-right" href="{{ localizedAdminURL('users') }}">{{ trans('form.action_cancel') }}</a>
                </div>
            </form>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
@endsection