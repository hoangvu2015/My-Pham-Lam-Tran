@extends('lms_themes.learning_app.new_master.layout_auth_tutor')
@section('body_class', 'complete')
@section('lib_styles')
@endsection
@section('extended_styles')
<style>
.bg-input input{color:#000 !important;}
</style>
@endsection
@section('lib_scripts')
@endsection
@section('extended_scripts')
@endsection
@section('layout_content')
<div id="mod-become-tutor">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <div class="content">
                    <h1 class="header h3Title">Become an antoree tutor</h1>
                    <div class="detail">
                        <p class="text-infomate">Antoree's online teachers are not only acting as teachers, but also as learners' friends. That is the key point to the love of studying English with Antoree's tutors. So we are looking for enthusiastic tutors who can help people all over the world improve their English.</p>
                        <div class="steps">
                            <div class="step row">
                                <div class="step-number col-xs-1">
                                    <p>
                                        1
                                    </p>
                                </div>
                                <div class="text col-xs-11">
                                    <span>
                                        <strong>
                                            Register an account
                                        </strong>
                                        You need to register an account in the beside form to build your teaching profile.
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="step row">
                                <div class="step-number col-xs-1">
                                    <p>
                                        2
                                    </p>
                                </div>
                                <div class="text col-xs-11">
                                    <span>
                                        <strong>
                                            Test and training process
                                        </strong>
                                        To ensure the teaching quality, every new teachers have to take the Antoree test and training.
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="step row">
                                <div class="step-number col-xs-1">
                                    <p>
                                        3
                                    </p>
                                </div>
                                <div class="text col-xs-11">
                                    <span>
                                        <strong>
                                            Build a great profile
                                        </strong>
                                        New learners at Antoree will look at teachers' profiles to choose the teacher that is the best for them.
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="step row">
                                <div class="step-number col-xs-1">
                                    <p>
                                        4
                                    </p>
                                </div>
                                <div class="text col-xs-11">
                                    <span>
                                        <strong>
                                            Take the trial lesson
                                        </strong>
                                        We have trial lessons every day. You can take them and drive the learners to register an official course with you.
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="step row">
                                <div class="step-number col-xs-1">
                                    <p>
                                        5
                                    </p>
                                </div>
                                <div class="text col-xs-11">
                                    <span>
                                        <strong>
                                            Teach official classes & Get paid every month
                                        </strong>
                                        After the learners register official courses with you, you will get paid from then on for each official teaching hour.
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <p class="contacts"><strong>
                            If you have any question, feel free to contact us or checkout 
                            <span class="greenColor"><a class="greenColor" href="http://antoree.com/en/help/faqs-by-teachers-12" target="_blank">FAQ page</a></span>
                        </strong></p>
                        <p>Skype:<a href="skype:antoree.cc9?chat" class="greenColor">antoree.cc9 (Ms. Sally)</a></p>
                        <p>Hotline:<a href="tell:01233289680" class="greenColor">(+84) 1233 289 680</a></p>
                        <p>Email:<a href="mailto:tutors@antoree.com" class="greenColor">tutors@antoree.com</a></p>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-4">
                <form id="registerForm" method="post" action="{{ localizedURL('auth/register-tutor') }}">
                    {!! csrf_field() !!}
                    <h4 class="h4Title text-justify">Apply form</h4>
                    <p>Teaching english online one-on-one class</p>
                    <div class="information">
                        <div class="bg-input">
                            <input id="name" type="text" placeholder="Full name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="bg-input">
                            <input id="email" type="email" placeholder="Email" name="email" required value="{{ old('email') }}">
                        </div>
                        <div class="bg-input">
                            <input type="password" id="password" placeholder="Password" required name="password">
                        </div>
                        <div class="bg-input">
                            <input type="password" id="password" placeholder="Confirm password" required name="password_confirmation">
                        </div>
                    </div>

                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif

                    <input onclick="GA('BecomeATutor', 'ClickSubmitApplyForm', 'BecomeATutor');" type="submit" value="SUBMIT" class="btn">
                    <p ng-controller="menuCtrl" style="margin-top: 30px;text-align: center;"> Already have an account? <a ng-click="showLogin('tutor')" href="" class="green">Log In</a></p>
                </form>
            </div>
            <div class="clearfix"></div>
        </div>
        
    </div>
</div>
@endsection