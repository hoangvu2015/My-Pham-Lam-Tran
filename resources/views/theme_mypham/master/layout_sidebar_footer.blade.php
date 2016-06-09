@section('sidebar_footer')


<!-- start the footer area-->
<footer>
	<div class="container">
		<div class="three columns">
			<div id="info">
				<h3>Informations</h3>
				<ul>
					<li><a href="#">About Us</a></li>
					<li><a href="#">Delivery Informations</a></li>
					<li><a href="#">privecy Policey</a></li>
					<li><a href="#">Terms &amp; Condations</a></li>
				</ul>
			</div>
		</div><!--end three-->

		<div class="three columns">
			<div id="customer_serices">
				<h3>Customer Servies</h3>
				<ul>
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">Returns</a></li>
					<li><a href="#">Site map</a></li>
					<li><a href="#">addation Link</a></li>
				</ul>
			</div>
		</div><!--end three-->

		<div class="three columns">
			<div id="extra">
				<h3>Extra Stuff</h3>
				<ul>
					<li><a href="#">Brands</a></li>
					<li><a href="#">Gift Vouchers</a></li>
					<li><a href="#">Affiliates</a></li>
					<li><a href="#">Specials</a></li>
				</ul>
			</div>
		</div><!--end three-->

		<div class="three columns">
			<div id="my_account">
				<h3>My Account</h3>
				<ul>
					<li><a href="#">Login Area</a></li>
					<li><a href="#">Order History</a></li>
					<li><a href="#">Wish List</a></li>
					<li><a href="#">newsLatter</a></li>
				</ul>
			</div>
		</div><!--end three-->

		<div class="four columns">
			<div id="delivery" class="clearfix">
				<h3>Delivery Info</h3>
				<ul>
					<li class="f_call">Call Us On: 555-555-555</li>
					<li class="f_call">Call Us On: 666-666-666</li>
					<li class="f_mail">example@example.com</li>
					<li class="f_mail">shoploop@shoploop.com</li>
				</ul>
			</div>
		</div><!--end four-->

	</div><!--end container-->


	<div class="tweets">
		<div class="container">
			<div class="sixteen columns">

				<div class="tweet">
					<!-- tweets will generate automaticlly here-->
				</div><!--end tweet-->

					<!-- <div class="pagers">
						<button class="prev tweet_prev">Prev</button>
						<button class="nxt  tweet_nxt">Next</button>
					</div> -->
				</div>
			</div>
		</div><!--end tweets-->


		<div class="container">
			<div class="sixteen">
				<p class="copyright">
					Copyright 2012 for <a href="#">ShoppingLoop.com</a><br>
					Powered By: <a href="#">opencart.</a>
				</p>
				<ul class="socials">
					<li><a class="twitter" href="#">twitter</a></li>
					<li><a class="facebook" href="#">face</a></li>
					<li><a class="googlep" href="#">google+</a></li>
					<li><a class="vimeo" href="#">vimeo</a></li>
					<li><a class="skype" href="#">skype</a></li>
					<li><a class="linked" href="#">linked</a></li>
				</ul>
			</div><!--end sixteen-->
		</div><!--end container-->

	</footer>
	<!--end the footer area -->
	<!-- Sidebar Widget================================================== -->
	<div id="sideWidget" class="@yield('footer_class')">
		<div class="bgPatterns">
			<h4>Solid Colors</h4>
			<a href="#" style="background:#fff">white</a>
			<a href="#" style="background:#fafafa">light_gray</a>
			<a href="#" style="background:#f7f7f7">gray</a>
			<br><br>

			<h4>Body Patterns</h4>
			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/white_carbon.png) repeat">white_carbon</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/circles.png) repeat">circles</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/cubes.png) repeat">cubes</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/exclusive_paper.png) repeat">exclusive_paper</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/gplaypattern.png) repeat">gplaypattern</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/large_leather.png) repeat">large_leather</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/lghtmesh.png) repeat">lghtmesh</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/light_wool.png) repeat">light_wool</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/lil_fiber.png) repeat">lil_fiber</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/snow.png) repeat">snow</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/soft_wallpaper.png) repeat">soft_wallpaper</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/weave.png) repeat">weave</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/white_brick_wall.png) repeat">white_brick_wall</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/white_paperboard.png) repeat">white_paperboard</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/white_tiles.png) repeat">white_tiles</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/wall4.png) repeat">wall4</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/furley_bg.png) repeat">furley_bg</a>

			<a href="#" style="background:url({{url()}}/resources/assets/theme_mypham/images/bg/extra_clean_paper.png) repeat">extra_clean_paper</a>

		</div>
		<a class="WidgetLink" href="#open">+</a>
	</div>
	<!-- End Sidebar Widget-->

	@show