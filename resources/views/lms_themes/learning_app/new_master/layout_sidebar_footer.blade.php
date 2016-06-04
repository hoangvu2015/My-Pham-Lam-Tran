@section('sidebar_footer')
<div id="mod-footer" class="@yield('footer_class')" ng-controller="menuCtrl">

	<div class="content footer-general">
		<div class="container">
			<div class="top">

				<div class="col-1 float-left">
					<a href="">
						<img src="{{url()}}/public/images/New-Layout/home.png" alt="" class="logo">
					</a>
					<p>
						{{trans('new_label.footter_label_antoreecaption')}}
					</p>
					<p>
						Email: <a onclick="GA('Footter', 'ClickEmail', window.pageName);" href="" class="link green">hello@antoree.com</a>
					</p>
					<p>
						Hotline: <a onclick="GA('Footter', 'ClickHotline', window.pageName);" href="" class="link green">(+84) 969 765 955</a>
					</p>
				</div>

				<div class="col-2 float-left">
					<div class="col float-left">
						<p class="head">
							{{trans('new_label.footter_label_tutor')}}
						</p>
						<p><a href="{{localizedURL('teachers')}}">
							{{trans('new_label.footter_label_tutorlist')}}
						</a></p>
						<p><a onclick="GA('Footter', 'ClickBecomATutorButton', window.pageName);" href="{{ localizedURL('auth/register-tutor') }}">
							{{trans('new_label.footter_label_becomeatutor')}}
						</a></p>
						<p><a href="{{localizedURL('faq/view/{slug?}-{id}',['slug'=>'cach-thuc-day','id'=>11])}}">
							{{trans('new_label.footter_label_howtoteach')}}
						</a></p>
					</div>
					<div class="col float-left">
						<p class="head">
							{{trans('new_label.footter_label_learner')}}
						</p>
						<p><a onclick="GA('Footter', 'ClickRegisterClassButton', window.pageName);" href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}">
							{{trans('new_label.footter_label_registerclass')}}
						</a></p>
						<p><a href="{{localizedURL('blog')}}">
							Blog
						</a></p>
						<p><a href="{{localizedURL('faq/view/{slug?}-{id}',['slug'=>'thong-tin-co-ban','id'=>287])}}">
							{{trans('new_label.footter_label_howtolearn')}}
						</a></p>
					</div>
					<div class="col float-left">
						<p class="head">
							{{trans('new_label.footter_label_aboutantoreecap')}}
						</p>
						<p><a href="{{localizedURL('faq/view/{slug?}-{id}',['slug'=>'ve-chung-toi','id'=>3])}}">
							{{trans('new_label.footter_label_aboutantoree')}}
						</a></p>
						<p><a href="{{localizedURL('faq/view/{slug?}-{id}',['slug'=>'cach-thuc-hoat-dong','id'=>5])}}">
							{{trans('new_label.footter_label_howitworks')}}
						</a></p>
						<p><a href="{{localizedURL('faq/terms-of-service')}}">
							{{trans('new_label.footter_label_term')}}
						</a></p>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="col-3 text-center float-left">
					<div class="button">
						<a style="background: #00AB6B;" onclick="GA('Footter', 'ClickBecomeATutorButton', window.pageName);" href="{{ localizedURL('auth/register-tutor') }}" class="teacher-btn">
							{{trans('new_label.menu_becomeatutor')}}
						</a>
					</div>
					
					@if(!$is_auth)
					<div class="submit">
						{{trans('new_label.footter_label_or')}} 
						<a onclick="GA('Footter', 'ClickLoginButton', window.pageName);" href="" class="register" ng-click="showLogin()">{{trans('new_label.menu_login')}}</a>
					</div>
					@endif
					<div class="images">
						<a onclick="GA('Footter', 'ClickFacebook', window.pageName);" href="https://www.facebook.com/antoree.global" target="_blank">
							<img src="{{url()}}/public/images/New-Layout/facebook.png" alt="">
						</a>
						<a onclick="GA('Footter', 'ClickInstagram', window.pageName);" href="https://www.instagram.com/antoree.cc/" target="_blank">
							<img src="{{url()}}/public/images/New-Layout/instagram.png" alt="">
						</a>
						<a onclick="GA('Footter', 'ClickSkype', window.pageName);" href="skype:antoree.cc8?chat">
							<img src="{{url()}}/public/images/New-Layout/skype.png" alt="">
						</a>
					</div>
					
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="bottom">
			<div class="container">
				<div class="copy">
					<p class="text">©2015 Antoree.</p>
					<p class="text">{!!trans('new_label.footter_label_company')!!}</p>
				</div>
			</div>
		</div>
	</div>

	<div class="footer-home"></div>

	<div class="footer-test">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-9 left">
					<div class="row">
						<div class="col-xs-12 col-sm-4">
							<span class="tag">Made with love by <a class="link" href="{{url()}}">Antoree.com</a></span>
						</div>
						<div class="col-xs-12 col-sm-4">
							<span>Hotline:</span><span class="phone-and-email"><a onclick="GA('Footter', 'ClickHotline', window.pageName);" class="link green" href="">(+84) 972 842 112</a></span>
						</div>
						<div class="col-xs-12 col-sm-4">
							<span>Email:</span><span class="phone-and-email"><a onclick="GA('Footter', 'ClickEmail', window.pageName);" class="link green" href="mailto:hello@antoree.com">hello@antoree.com</a></span>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-3 right">
					<ul class="list-inline social">
						<li><a onclick="GA('Footter', 'ClickFacebook', window.pageName);" href="https://www.facebook.com/antoree.global?fref=ts"><img src="{{url()}}/public/images/facebook.png" class="img-responsive img-fb img"></a></li>
						<li><a onclick="GA('Footter', 'ClickSkype', window.pageName);" href="skype:antoree.cc4?chat"><img src="{{url()}}/public/images/skype.png" class="img-responsive img img-fb"></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@show