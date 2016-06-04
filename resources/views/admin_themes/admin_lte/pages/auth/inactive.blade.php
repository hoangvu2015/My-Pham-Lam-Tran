@extends('lms_themes.learning_app.new_master.layout') <!-- apply layout -->
@section('footer_class','hidden')
@section('body_class', 'verify')
@section('layout_content')
<div id="mod-email-confirm">
    <div class="container">
        <div class="content">
            <form id="formEmail" action="{{ localizedURL('auth/inactive') }}" method="post">
                {!! csrf_field() !!}
                @if(isset($user))
                <input type="hidden" name="id" value="{{$user->id}}">
                @endif
                <div class="row">
                    <!-- <div class="col-xs-1">
                    </div> --><!-- /.col -->
                    <div class="col-xs-2">
                        <img src="{{url()}}/public/images/New-Layout/complete.png" alt="">
                    </div>
                    <div class="col-xs-10">
                        @if($resend)
                        <h3>{!!trans('auth.popup_confirmemail_headline')!!}</h3><br/>

                        <p>
                            @if(isset($user))
                            {!!trans('auth.popup_confirmemail_content',['email'=>$user->email])!!} <a href="javascript:void()" style="color:#009A5F;" onclick="document.getElementById('formEmail').submit();">{!!trans('auth.act_resent')!!}</a>.
                            @endif
                        </p>
                        @else
                        <h3>{!!trans('auth.popup_confirmemail_headline2')!!}</h3><br/>
                        <p>
                            @if(isset($user))
                            {!!trans('auth.popup_confirmemail_content2',['email'=>$user->email])!!} <a href="javascript:void()" onclick="document.getElementById('formEmail').submit();">{!!trans('auth.act_resent')!!}</a>.
                            @endif
                        </p>

                        @endif
                    </div><!-- /.col -->
                    <div class="col-xs-1">
                    </div><!-- /.col -->
                </div>

            </form>
        </div>
        <a href="{{url()}}" class="btn">{{trans('new_label.go_to_home')}}</a>
    </div>
</div>
@endsection
