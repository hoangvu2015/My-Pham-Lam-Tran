<form method="post" class="form-horizontal" action="{{ localizedURL('user/update') }}">
    {{ csrf_field() }}
    @if (count($errors->account) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->account->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <div class="form-group">
        <label for="inputProfilePicture" class="col-md-3 control-label">{{ trans('label.profile_picture') }}</label>
        <div class="col-md-6">
            <div class="media v-middle media-clearfix-xs">
                <div class="media-left">
                    <div class="avatar-view" title="{{ trans('form.action_change') }} {{ trans('label.profile_picture') }}">
                        <img src="{{ $user_profile->profile_picture }}" alt="{{ $user_profile->name }}">
                    </div>
                </div>
                <div class="media-body">
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label for="inputName" class="col-md-3 control-label">
            <span class="required">{{ trans('label.user_name') }}</span>
        </label>
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control" id="inputName" name="name" required placeholder="{{ trans('label.user_name') }}" value="{{ $user_profile->name }}">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="inputBirthday" class="col-md-3 control-label">{{ trans('label.birthday') }}</label>
        <div class="col-md-6">
            <div class="input-group">
                <input class="form-control date-picker" id="inputBirthday" type="text" name="date_of_birth" placeholder="{{ $date_js_format }}" value="{{ $user_profile->dateOfBirth }}">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="inputGender" class="col-md-3 control-label">{{ trans('label.gender') }}</label>
        <div class="col-md-6">
            <select id="inputGender" class="form-control selectpicker" name="gender" data-placeholder="{{ trans('form.action_select') }} {{ trans('label.gender_lc') }}">
                @foreach(allGenders() as $gender)
                    <option value="{{ $gender }}"{{ $gender == $user_profile->gender ? ' selected' : '' }}>
                        {{ trans('label.gender_'.$gender) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPhone" class="col-md-3 control-label">
            <span class="required">{{ trans('label.phone') }}</span>
        </label>
        <div class="col-md-2">
            <label for="inputPhoneCode" class="sr-only">{{ trans('label.phone_code') }}</label>
            <select id="inputPhoneCode" name="phone_code" class="form-control select2" data-placeholder="{{ trans('form.action_select') }} {{ trans('label.calling_code_lc') }}" style="width: 100%">
                {!! callingCodesAsOptions($user_profile->phone_code) !!}
            </select>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <input type="text" class="form-control" id="inputPhone" name="phone" required placeholder="{{ trans('label.phone') }}" value="{{ $user_profile->phone }}">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="inputSkype" class="col-md-3 control-label">{{ trans('label.skype') }}</label>
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control" id="inputSkype" name="skype" placeholder="{{ trans('label.skype') }}" value="{{ $user_profile->skype }}">
                <span class="input-group-addon"><i class="fa fa-skype"></i></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="inputFacebook" class="col-md-3 control-label">{{ trans('label.facebook') }}</label>
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control" id="inputFacebook" name="facebook" placeholder="{{ trans('label.facebook') }}" value="{{ $user_profile->facebook }}">
                <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label for="inputAddress" class="col-md-3 control-label">{{ trans('label.address') }}</label>
        <div class="col-md-6">
            <div class="input-group">
                <input class="form-control" id="inputAddress" name="address" placeholder="{{ trans('label.address') }}" type="text" value="{{ $user_profile->address }}">
                <span class="input-group-addon"><i class="fa fa-home"></i></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="inputCity" class="col-md-3 control-label">{{ trans('label.city') }}</label>
        <div class="col-md-6">
            <div class="input-group">
                <input class="form-control" id="inputCity" name="city" placeholder="{{ trans('label.city') }}" type="text" value="{{ $user_profile->city }}">
                <span class="input-group-addon"><i class="fa fa-building"></i></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="inputCountry" class="col-md-3 control-label">{{ trans('label.nationality') }}</label>
        <div class="col-md-6">
            <select id="inputCountry" class="form-control select2" name="country" style="width: 100%;">
                {!! countriesAsOptions($user_profile->country) !!}
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="language" class="col-md-3 control-label">{{ trans('label.main_language') }}</label>
        <div class="col-md-6">
            <select id="language" class="form-control selectpicker" name="language" data-placeholder="{{ trans('form.action_select') }} {{ trans('label.main_language_lc') }}">
                @foreach (allSupportedLocales() as $localeCode => $properties)
                    <option value="{{ $localeCode }}"{{ $localeCode == $user_profile->language ? ' selected' : '' }}>
                        {{ $properties['native'] }}
                    </option>
                @endforeach
            </select>
            <p class="help-block"><small>{{ trans('label.language_help') }}</small></p>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated>{{ trans('form.action_save') }}</button>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="{{ localizedURL('localization-settings') }}">
                {{ trans('pages.page_localization_settings_title') }} <i class="fa fa-question-circle"></i>
            </a>
        </div>
    </div>
</form>