@extends('lms_themes.learning_app.new_master.layout_auth_tutor')
@section('body_class', 'complete')
@section('lib_styles')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
@endsection
@section('extended_styles')
<style>
    select,input{color: #000;}
    .btn-submit{color: #fff !important;}
</style>
@endsection
@section('lib_scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
@endsection
@section('extended_scripts')
<script>
    {!! cdataOpen() !!}
    jQuery(function () {
        jQuery('.select2').select2();
    });
    function uploadAudio(element){
        $('#name-upload-audio').html(element.files[0].name);
    }
    {!! cdataClose() !!}
</script>
@endsection
@section('layout_content')
<div id="mod-step-2" class="become-tutor-commom">
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

            <div class="step-list">
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
                <div class="float-left step-list-arrow unactive images-active"></div>
                <div class="step step-final">
                    <div class="number">
                        3
                    </div>
                    <div class="info">
                        Confirmation
                    </div>

                </div>
                <div class="clearfix"></div>
            </div>
            
            <form enctype="multipart/form-data" method="post" action="{{ localizedURL('become-a-tutor/step-2') }}" id="register">
                {!! csrf_field() !!}
                <div class="subject">
                    <p class="head">
                        Tutoring subject
                    </p>
                    <p class="txt">
                        Please choose the topics that you're confident to teach. You can choose many topics.
                    </p>
                    <select class="form-control select2" id="select-english" name="topics[]" value="{{ old('topics[]') }}" required multiple="multiple" data-placeholder="{{ trans('form.action_select') }} {{ trans_choice('label.topic_lc', 2) }}" style="width: 100%;">

                        @if(authUser()->teacherProfile)

                        @foreach($topics as $topic)
                        <option value="{{ $topic->id }}"{{ authUser()->teacherProfile->topics->contains($topic->id) ? ' selected' : '' }}>
                            {{ $topic->name }}
                        </option>
                        @endforeach

                        @else

                        @foreach($topics as $topic)
                        <option value="{{ $topic->id }}">
                            {{ $topic->name }}
                        </option>
                        @endforeach

                        @endif
                        
                    </select>
                </div>

                <div class="about">
                    <p class="head">
                        About me
                        <img src="{{url()}}/public/images/tooltip-become-tutor.png" alt="" id="tooltip-1" class="tooltip-popup">
                        <div class="tooltip-text text-1">
                            <div class="head">
                                You should write a short yet informative introduction. For example:
                            </div>
                            <p>
                                <span class="head">
                                    - Background: 
                                </span>
                                Graduated from the Foreign Trade University in 2000 and Got 02 full scholarships to study IT in Germany and MBA in the Netherlands (IELTS required)
                            </p>
                            <p>
                                <span class="head">
                                    - Working experience: 
                                </span>
                                Working in a multi-culture, international environment for more than 14 years where English is heavily used for communication.
                            </p>
                            <p>
                                <span class="head">
                                    - Personality and hobby: 
                                </span>
                                I’m a very outgoing and friendly person. I love travelling, reading, playing music, watching American movies and taking photography and of course English, naturally. I’ve traveled to more than 20 countries in Asia, Europe and North America.
                            </p>
                            <p>
                                <span class="head">
                                    - Motivation to become a teacher: 
                                </span>
                                I love English and always want to share my love with everyone. When I see my students improve in English, I’m even happier than them. When they finish the course with me and gain good result, I feel like I have gained a big achievement!</p>
                            </div>
                        </p>

                        @if(authUser()->teacherProfile)
                        <textarea class="texarea default" id="comment" name="about_me" minlength="200" required>{{authUser()->teacherProfile->about_me }}</textarea>
                        @else
                        <textarea class="texarea default" id="comment" name="about_me" minlength="200" required>{{ old('about_me') }}</textarea>
                        @endif

                        <p id="alert-about">At least 200 characters</p>
                    </div>
                    <div class="experience">
                        <p class="head">
                            Teaching experience
                            <img src="{{url()}}/public/images/tooltip-become-tutor.png" alt="" id="tooltip-2" class="tooltip-popup">
                            <div class="tooltip-text text-2">
                                <div class="head">
                                    You should list out your teaching experience as a timeline and show your students’ improvement as a proof for your teaching ability. For example:
                                </div>
                                <p>
                                    - July 2013 – July 2014: be tutor for a student, helping him pass the university entrance exam with the English score: 8.5
                                </p>
                                <p>
                                    - Aug 2014 – now: be a teacher for some language centers and be a home-based tutor for some elementary students. The languages centers and the elementary students’ parents give me good comment about my teaching ability.
                                </p>
                            </div>
                        </p>

                        @if(authUser()->teacherProfile)
                        <textarea class="texarea default" id="experience-textarea" name="experience" minlength="100" required>{{authUser()->teacherProfile->experience }}</textarea>
                        @else
                        <textarea class="texarea default" id="experience-textarea" name="experience" minlength="100" required>{{ old('experience') }}</textarea>
                        @endif

                    </div>

                    <div class="method">
                        <p class="head">
                            Teaching method
                            <img src="{{url()}}/public/images/tooltip-become-tutor.png" alt="" id="tooltip-3" class="tooltip-popup">
                            <div class="tooltip-text text-3">
                                <div class="head">
                                    Write out your most preferable teaching method. For example:
                                </div>
                                <p>
                                    “ Natural aproach:
                                </p>
                                <p>
                                    I work with real materials (For example:Newspapers, radio, broadcasts, Interviews, ...) to bring up vocabulary and extract grammar issues to work.
                                </p>
                                <p>
                                    I ask my learners to use english 100 % of the time. This develops a better understanding of the language at work. Also, learners learn without actually feeling they are doing so, and see improvements much faster than with other methods.”
                                </p>
                            </div>
                        </p>

                        @if(authUser()->teacherProfile)
                        <textarea class="texarea default" id="method-textarea" name="methodology" minlength="100" required>{{authUser()->teacherProfile->methodology }}</textarea>
                        @else
                        <textarea class="texarea default" id="method-textarea" name="methodology" minlength="100" required>{{ old('methodology') }}</textarea>
                        @endif

                    </div>

                    <div class="certificates">
                        <p class="head">
                            Do you have any English certificates?
                        </p>
                        <p class="txt">
                            TOEIC, IELTS, TOEFL…
                        </p>
                        <div class="form-group padd default">

                            @if(authUser()->teacherProfile)
                            <input type="text" id="certificates-input" name="certificates"  maxlength="255" value="{{authUser()->teacherProfile->certificates }}">
                            @else
                            <input type="text" id="certificates-input" name="certificates"  maxlength="255" value="{{ old('certificates') }}">
                            @endif

                        </div>
                    </div>
                    <div class="voice">
                        <p class="head">
                            Voice record
                        </p>
                        <p class="txt">
                            Please give learners the warmest welcome and a friendly invitation to study with you. Our data points out that tutors with good voice record are 3 times higher in being chosen by learners
                        </p>
                        <p class="help-block txt">{{ trans('label.max_upload_file_size', ['size' => $max_size]) }}<br/><small>{{ trans('label.audio_support_help') }}</small></p>
                        <div class="file-upload">
                            <span>Upload voice record file</span>
                            <input onchange="uploadAudio(this)" style="width: 200px;" type="file" name="voice" accept="audio/*" class="upload">
                        </div>
                        <p id="name-upload-audio" style="margin-left: 210px;" class="help-block"></p>
                    </div>

                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                    <div class="next text-right">
                        <input onclick="GA('BecomeATutor', 'ClickContinueOnStep2', 'BecomeATutor');" type="submit" class="btn-submit" value="CONTINUE >">
                    </div>
                </form>

            </div>
        </div>
    </div>
    @endsection