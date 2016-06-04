@extends('lms_themes.learning_app.new_master.layout_auth_tutor')
@section('body_class', 'complete')
@section('lib_styles')
@endsection
@section('extended_styles')
<style>
    a:hover{
        text-decoration: none !important;
    }
    .btn-submit{
        padding: 14px 0;
        float: right;
        text-align: center;
        display: block !important;
    }
</style>
@endsection
@section('lib_scripts')
@endsection
@section('extended_scripts')
@endsection
@section('layout_content')
<div id="mod-step-3" class="become-tutor-commom">
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

            <div class="step-list complete">
                <div class="step active">
                    <div class="number">
                        1
                    </div>
                    <div class="info">
                        Personal information
                    </div>
                </div>
                <div class="float-left step-list-arrow active images-active">
                </div>
                <div class="step active">
                    <div class="number">
                        2
                    </div>
                    <div class="info">
                        Teaching informations
                    </div>
                </div>
                <div class="float-left step-list-arrow active images-active"></div>
                <div class="step active step-final">
                    <div class="number">
                        3
                    </div>
                    <div class="info">
                        Confirmation
                    </div>
                    
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="text-confirm">
                <p class="head">
                    Confirmation email sent.
                </p>
                <div class="sended">
                    <p>
                        An confirmation email has been sent to your email address.
                    </p>
                    <p>
                        Please check your email and follow the instructions.
                    </p>
                </div>
                <div class="send-back">
                    <form method="post" action="{{ localizedURL('become-a-tutor/step-3') }}">
                        {!! csrf_field() !!}
                        <p>
                            If you do not receive an email? Try to check the spam mailbox or click 
                            <button onclick="GA('BecomeATutor', 'ClickResendEmail', 'BecomeATutor');" class="green-2" type="submit" style="border: none;background: #fff;">Resend email</button>
                        </p>
                    </form>
                </div>
            </div>
            <div class="next text-right">
                <!-- <button class="btn-submit">
                    COMPLETE
                </button> -->
                <a onclick="GA('BecomeATutor', 'ClickCompleteOnStep3', 'BecomeATutor');" href="{{localizedURL('profile')}}" class="btn-submit">COMPLETE</a>
            </div>
        </div>
    </div>
</div>
@endsection