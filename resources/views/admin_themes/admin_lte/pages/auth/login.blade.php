@extends('admin_themes.admin_lte.master.auth')
@section('site_description', trans('pages.page_login_desc'))
@section('auth_type','login')
@section('box_message', trans('pages.page_login_desc'))
@section('auth_form')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form action="{{ localizedURL('auth/login') }}" method="post">
        {!! csrf_field() !!}
        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="{{ trans('auth.log_email') }}" required name="email" value="{{ old('email') }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="{{ trans('auth.log_password') }}" required name="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label for="inputRemember">
                        <input id="inputRemember" type="checkbox" name="remember">
                        &nbsp; {{ trans('auth.log_remember') }}
                    </label>
                </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('form.action_login') }}</button>
            </div><!-- /.col -->
        </div>
    </form>

    <div class="social-auth-links text-center">
        <p>- {{ trans('auth.log_or') }} -</p>
        <a href="{{ localizedURL('auth/social/{provider}', array('provider' => 'facebook')) }}" class="btn btn-block btn-social btn-facebook btn-flat">
            <i class="fa fa-facebook"></i> {{ trans('label.sign_in_with_facebook') }}
        </a>
        <a href="{{ localizedURL('auth/social/{provider}', array('provider' => 'google')) }}" class="btn btn-block btn-social btn-google btn-flat">
            <i class="fa fa-google-plus"></i> {{ trans('label.sign_in_with_google') }}
        </a>
    </div><!-- /.social-auth-links -->

    <a href="{{ localizedURL('password/email') }}" class="text-center">{{ trans('auth.log_forgot') }}</a><br>
    <a href="{{ localizedURL('auth/register') }}" class="text-center">{{ trans('auth.log_reg') }}</a><br>
    <a href="{{ homeURL() }}" class="text-center">{{ trans('auth.log_home') }}</a>
@endsection