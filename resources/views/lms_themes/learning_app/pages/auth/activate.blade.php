@extends('lms_themes.learning_app.new_master.layout')
@section('footer_class','hidden')
@section('body_class', 'verify')
@section('extended_styles')
<style>
	a{color:#00AB6B;}
</style>
@endsection
@section('layout_content')
@if($active)
<div id="mod-verify">
	<div class="content">
	<img src="{{url()}}/public/images/New-Layout/complete.png" alt="" class="float-left image-complete">
		<div class="text-complete">
			<p>
				<strong>
					Confirmation success!
				</strong>
			</p>
			<p>Thank you for applying to Antoree tutor community. Please be online on skype and check your email regularly so that we can contact you for interview and class offer.</p><br/>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="button text-center">
		<a href="{{ localizedURL('profile') }}" class="btn-to-home">
			GO TO YOUR PROFILE
		</a>
	</div>
</div>
@else
{{trans('auth.act_failed')}}
@endif
@endsection
