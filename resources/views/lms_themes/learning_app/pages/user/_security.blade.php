<form method="post" class="form-horizontal" action="{{ localizedURL('user/update/security') }}">
    {{ csrf_field() }}
    @if (count($errors->security) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->security->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <div class="form-group">
        <label for="inputEmail" class="col-md-3 control-label">
            <span class="required">{{ trans('label.email') }}</span>
        </label>
        <div class="col-md-6">
            <div class="input-group">
                <input type="email" class="form-control" id="inputEmail" name="email" required placeholder="{{ trans('label.email') }}" value="{{ $auth_user->email }}">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label for="inputPassword" class="col-md-3 control-label">{{ trans('label.password') }}</label>
        <div class="col-md-6">
            <div class="input-group">
                <input type="password" class="form-control" id="inputPassword" name="password" placeholder="{{ trans('label.password') }}">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="inputConfirmPassword" class="col-md-3 control-label">{{ trans('label.password_retype') }}</label>
        <div class="col-md-6">
            <div class="input-group">
                <input type="password" class="form-control" id="inputConfirmPassword" name="password_confirmation" placeholder="{{ trans('label.password_retype') }}">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label for="inputCurrentPassword" class="col-md-3 control-label">
            <span class="required">{{ trans('label.password_current') }}</span>
        </label>
        <div class="col-md-6">
            <div class="input-group">
                <input type="password" class="form-control" id="inputCurrentPassword" name="current_password" required placeholder="{{ trans('label.password_current') }}">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated>{{ trans('form.action_save') }}</button>
        </div>
    </div>
</form>