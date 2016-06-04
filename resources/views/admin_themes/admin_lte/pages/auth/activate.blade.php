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
					{!!trans('auth.user_headline_confirmsuccess')!!}
				</strong>
			</p>
			<p>{!!trans('auth.user_content_confirmsuccess')!!}</p><br/>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="button text-center">
		<a href="{{ localizedURL('profile') }}" class="btn-to-home">
			{!!trans('auth.user_button_goto_profile')!!}
		</a>
	</div>
</div>
@else
{{trans('auth.act_failed')}}
@endif
@endsection
