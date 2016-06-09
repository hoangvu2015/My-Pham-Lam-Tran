@extends('theme_mypham.master.layout')

@section('theme_mp_css')
<link rel="stylesheet" href="{{MPasset('css/home2.css')}}">
@endsection

@section('extended_styles')

@endsection

@section('extended_scripts')
@endsection

@section('layout_content')
<div class="container">
	<div class="sixteen columns">

		<div id="slide_outer">
			<div class="mainslide">

				<div class="pagers center">
					<a class="prev slide_prev" href="#prev">Prev</a>
					<a class="nxt slide_nxt" href="#nxt">Next</a>
				</div>

				<ul class="cycle-slideshow clearfix" 
				data-cycle-fx="scrollHorz"
				data-cycle-timeout="2000"
				data-cycle-slides="> li"
				data-cycle-pause-on-hover="true"
				data-cycle-prev="div.pagers a.slide_prev"
				data-cycle-next="div.pagers a.slide_nxt"
				>
				<li class="clearfix">
					<div class="slide_img">
						<img src="{{url()}}/resources/assets/theme_mypham/images/icons/iphone_4_icon.png" alt="">
					</div>
					<div class="flex-caption">
						<h5>Now it's available<br><span>IPhone 4 is Released</span></h5>
						<p>
							Quisque pharetra neque at odio viverra pellentesque ultrices mi sodales. Nam accumsan lacus sed ipsum tempus mollis. Nulla vitae lorem libero, at porta enim. Aenean quis justo metus.
						</p>
						<p>
							Nam accumsan lacus sed ipsum tempus mollis. Nulla vitae lorem libero, at porta enim. Aenean quis justo metus.
						</p>
						<a href="#"><span>View Item</span><span class="shadow">$190.00</span></a>
					</div>
				</li>

				<li class="clearfix">
					<div class="slide_img">
						<img src="{{url()}}/resources/assets/theme_mypham/images/icons/iphone_4_icon2.png" alt="">
					</div>
					<div class="flex-caption">
						<h5>Now it's available<br><span>IPhone 4 is Released</span></h5>
						<p>
							Quisque pharetra neque at odio viverra pellentesque ultrices mi sodales. Nam accumsan lacus sed ipsum tempus mollis. Nulla vitae lorem libero, at porta enim. Aenean quis justo metus.
						</p>
						<p>
							Nam accumsan lacus sed ipsum tempus mollis. Nulla vitae lorem libero, at porta enim. Aenean quis justo metus.
						</p>
						<a href="#"><span>View Item</span><span class="shadow">$190.00</span></a>
					</div>
				</li>

				<li class="clearfix">
					<div class="slide_img">
						<img src="{{url()}}/resources/assets/theme_mypham/images/icons/camcorder.png" alt="">
					</div>
					<div class="flex-caption">
						<h5>New Entry this day<br><span>DV Camcorder</span></h5>
						<p>
							Quisque pharetra neque at odio viverra pellentesque ultrices mi sodales. Nam accumsan lacus sed ipsum tempus mollis. Nulla vitae lorem libero, at porta enim. Aenean quis justo metus.
						</p>
						<a href="#"><span>View Item</span><span class="shadow">$210.90</span></a>
					</div>
				</li>
			</ul>
		</div>
		<div class="shadow_left"></div>
		<div class="shadow_right"></div>
	</div>

</div>
</div><!-- container -->



<!-- strat the main content area -->

<div class="container">


	<div class="featured">
		<div class="box_head">
			<h3>Featured Items</h3>
			<div class="pagers center">
				<a class="prev featuredPrev" href="#prev">Prev</a>
				<a class="nxt featuredNxt" href="#nxt">Next</a>
			</div>
		</div><!--end box_head -->
		

		<div class="cycle-slideshow" 
		data-cycle-fx="scrollHorz"
		data-cycle-timeout=0
		data-cycle-slides="> ul"
		data-cycle-prev="div.pagers a.featuredPrev"
		data-cycle-next="div.pagers a.featuredNxt"
		>
		<ul class="product_show">
			<li class="column">
				<div class="img">
					<div class="hover_over">
						<a class="link" href="#">link</a>
						<a class="cart" href="#">cart</a>
					</div>
					<a href="#">
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column3.jpg" alt="product">
					</a>
				</div>
				<h6><a href="#">Product Name Here</a></h6>
				<h5>$130.90</h5>
			</li>
			<li class="column">
				<div class="img">
					<div class="offer_icon"></div>
					<div class="hover_over">
						<a class="link" href="#">link</a>
						<a class="cart" href="#">cart</a>
					</div>
					<a href="#">
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column4.jpg" alt="product">
					</a>
				</div>
				<h6><a href="#">Product Name Here</a></h6>
				<h5><span class="sale_offer">$330.00</span>&nbsp;&nbsp;&nbsp;&nbsp;$130.00</h5>
			</li>
			<li class="column">
				<div class="img">
					<div class="offer_icon"></div>
					<div class="hover_over">
						<a class="link" href="#">link</a>
						<a class="cart" href="#">cart</a>
					</div>
					<a href="#">
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column5.jpg" alt="product">
					</a>
				</div>
				<h6><a href="#">Product Name Here</a></h6>
				<h5><span class="sale_offer">$210.00</span>&nbsp;&nbsp;&nbsp;&nbsp;$194.90</h5>
			</li>
			<li class="column">
				<div class="img">
					<div class="hover_over">
						<a class="link" href="#">link</a>
						<a class="cart" href="#">cart</a>
					</div>
					<a href="#">
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column2.jpg" alt="product">
					</a>
				</div>
				<h6><a href="#">Product Name Here</a></h6>
				<h5>$130.90</h5>
			</li>
		</ul>
		<ul class="product_show">
			<li class="column">
				<div class="img">
					<div class="hover_over">
						<a class="link" href="#">link</a>
						<a class="cart" href="#">cart</a>
					</div>
					<a href="#">
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column3.jpg" alt="product">
					</a>
				</div>
				<h6><a href="#">Product Name Here</a></h6>
				<h5>$130.90</h5>
			</li>
			<li class="column">
				<div class="img">
					<div class="offer_icon"></div>
					<div class="hover_over">
						<a class="link" href="#">link</a>
						<a class="cart" href="#">cart</a>
					</div>
					<a href="#">
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column4.jpg" alt="product">
					</a>
				</div>
				<h6><a href="#">Product Name Here</a></h6>
				<h5><span class="sale_offer">$330.00</span>&nbsp;&nbsp;&nbsp;&nbsp;$130.00</h5>
			</li>
			<li class="column">
				<div class="img">
					<div class="offer_icon"></div>
					<div class="hover_over">
						<a class="link" href="#">link</a>
						<a class="cart" href="#">cart</a>
					</div>
					<a href="#">
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column5.jpg" alt="product">
					</a>
				</div>
				<h6><a href="#">Product Name Here</a></h6>
				<h5><span class="sale_offer">$210.00</span>&nbsp;&nbsp;&nbsp;&nbsp;$194.90</h5>
			</li>
			<li class="column">
				<div class="img">
					<div class="hover_over">
						<a class="link" href="#">link</a>
						<a class="cart" href="#">cart</a>
					</div>
					<a href="#">
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column2.jpg" alt="product">
					</a>
				</div>
				<h6><a href="#">Product Name Here</a></h6>
				<h5>$130.90</h5>
			</li>
		</ul>
	</div>
</div><!--end featured-->


<div class="latest">

	<div class="box_head">
		<h3>Latest Items</h3>
		<div class="pagers center">
			<a class="prev latest_prev" href="#prev">Prev</a>
			<a class="nxt latest_nxt" href="#nxt">Next</a>
		</div>
	</div><!--end box_head -->

	<div class="cycle-slideshow" 
	data-cycle-fx="scrollHorz"
	data-cycle-timeout=0
	data-cycle-slides="> ul"
	data-cycle-prev="div.pagers a.latest_prev"
	data-cycle-next="div.pagers a.latest_nxt"
	>

	<ul class="product_show">
		<li class="column">
			<div class="img">
				<div class="hover_over">
					<a class="link" href="#">link</a>
					<a class="cart" href="#">cart</a>
				</div>
				<a href="#">
					<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column1.jpg" alt="product">
				</a>
			</div>
			<h6><a href="#">Product Name Here</a></h6>
			<h5>$40.90</h5>
		</li>
		<li class="column">
			<div class="img">
				<div class="hover_over">
					<a class="link" href="#">link</a>
					<a class="cart" href="#">cart</a>
				</div>
				<a href="#">
					<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column2.jpg" alt="product">
				</a>
			</div>
			<h6><a href="#">Product Name Here</a></h6>
			<h5>$130.90</h5>
		</li>
		<li class="column">
			<div class="img">
				<div class="hover_over">
					<a class="link" href="#">link</a>
					<a class="cart" href="#">cart</a>
				</div>
				<a href="#">
					<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column3.jpg" alt="product">
				</a>
			</div>
			<h6><a href="#">Product Name Here</a></h6>
			<h5>$200.00</h5>
		</li>
		<li class="column">
			<div class="img">
				<div class="hover_over">
					<a class="link" href="#">link</a>
					<a class="cart" href="#">cart</a>
				</div>
				<a href="#">
					<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column4.jpg" alt="product">
				</a>
			</div>
			<h6><a href="#">Product Name Here</a></h6>
			<h5>$358.00</h5>
		</li>
	</ul>
	<ul class="product_show">
		<li class="column">
			<div class="img">
				<div class="hover_over">
					<a class="link" href="#">link</a>
					<a class="cart" href="#">cart</a>
				</div>
				<a href="#">
					<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column1.jpg" alt="product">
				</a>
			</div>
			<h6><a href="#">Product Name Here</a></h6>
			<h5>$40.90</h5>
		</li>
		<li class="column">
			<div class="img">
				<div class="hover_over">
					<a class="link" href="#">link</a>
					<a class="cart" href="#">cart</a>
				</div>
				<a href="#">
					<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column2.jpg" alt="product">
				</a>
			</div>
			<h6><a href="#">Product Name Here</a></h6>
			<h5>$130.90</h5>
		</li>
		<li class="column">
			<div class="img">
				<div class="hover_over">
					<a class="link" href="#">link</a>
					<a class="cart" href="#">cart</a>
				</div>
				<a href="#">
					<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column3.jpg" alt="product">
				</a>
			</div>
			<h6><a href="#">Product Name Here</a></h6>
			<h5>$200.00</h5>
		</li>
		<li class="column">
			<div class="img">
				<div class="hover_over">
					<a class="link" href="#">link</a>
					<a class="cart" href="#">cart</a>
				</div>
				<a href="#">
					<img src="{{url()}}/resources/assets/theme_mypham/images/photos/four_column4.jpg" alt="product">
				</a>
			</div>
			<h6><a href="#">Product Name Here</a></h6>
			<h5>$358.00</h5>
		</li>
	</ul>

</div>
</div><!--end latest-->



<div class="sixteen columns clearfix">
	<div class="ten columns alpha">
		<div class="welcome">
			<div class="clearfix">
				<h2>Welcome To Shoploop</h2>
				<p>
					Shooploop is your source for millions of products from the leading automotive aftermarket brands. We carry all part numbers for every product we sell - if they make it, we have it. We get the newest part numbers faster, so you can get them on your vehicle sooner, so you can get them on your vehicle sooner.
				</p>
				<p>
					World-Class, US-Based Customer Service and Product Support is just a toll-free phone call away. Product Knowledge at Your Fingertips - Impartial Customer Reviews, Videos, Research Guides, Articles and More.
				</p>
				<h4>Our payment methods:</h4>
				<ul>
					<li><a class="bank" href="#">text</a></li>
					<li><a class="card" href="#">text</a></li>
					<li><a class="order" href="#">text</a></li>
					<li><a class="paypal" href="#">text</a></li>
					<li><a class="discover" href="#">text</a></li>
				</ul>
			</div>
		</div><!--end welcome-->
	</div><!--end ten-->

	<div class="six columns omega">
		<div class="home_news">
			<h3>Now, Get Your Free Shopping</h3>
			<div class="acc">
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi malesuada, ante at feugiat tincidunt, enim massa gravida metus, commodo lacinia massa diam vel eros. Proin eget urna. Nunc fringilla neque vitae odio. Vivamus vitae ligula.</p>
			</div>

			<h3>Super easy to customize anything</h3>
			<div class="acc">
				<p>
					Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi malesuada, ante at feugiat tincidunt, enim massa gravida metus, commodo lacinia massa diam vel eros. Proin eget urna. Nunc fringilla neque vitae odio. Vivamus vitae ligula.
				</p>
			</div>

			<h3>Now, Get Our newslatter</h3>
			<div class="acc">
				<p>
					Morbi cursus urna at massa dictum ac venenatis lectus accumsan. Etiam vitae arcu ac ante elementum mollis. Nunc convallis tristique aliquet. Ut justo leo.
				</p>
				<form method="get" action="#" class="clearfix">
					<label>
						<input type="text" name="newslatter" placeholder="Enter your E-Mail here" value="">
					</label>
					<label>
						<input class="gray_btn" type="submit" name="submit" value="Subscribe">
					</label>
				</form>
			</div>

			<h3>Signup and save your money</h3>
			<div class="acc">
				<p>
					Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi malesuada, ante at feugiat tincidunt, enim massa gravida metus, commodo lacinia massa diam vel eros. Proin eget urna. Nunc fringilla neque vitae odio. Vivamus vitae ligula.
				</p>
			</div>
		</div><!--end home_news-->
	</div><!--end six-->
</div><!--end sixteen-->


<div class="sixteen columns">
	<div class="brands">

		<div class="box_head">
			<h3>brands</h3>
			<div class="pagers center">
				<a class="prev brand_prev" href="#prev">Prev</a>
				<a class="nxt brand_nxt" href="#nxt">Next</a>
			</div>
		</div><!--end box_head -->

		<div class="brandOuter">
			<ul>
				<li>
					<a href="#">
						<img src="{{url()}}/resources/assets/theme_mypham/images/brands/logo_adidas-130x130.jpg" alt="brand">
					</a></li>
					<li>
						<a href="#">
							<img src="{{url()}}/resources/assets/theme_mypham/images/brands/logo_asics-130x130.jpg" alt="brand">
						</a>
					</li>
					<li>
						<a href="#">
							<img src="{{url()}}/resources/assets/theme_mypham/images/brands/logo_conv-130x130.jpg" alt="brand">
						</a>
					</li>
					<li>
						<a href="#">
							<img src="{{url()}}/resources/assets/theme_mypham/images/brands/logo_nike-130x130.jpg" alt="brand">
						</a>
					</li>
					<li>
						<a href="#">
							<img src="{{url()}}/resources/assets/theme_mypham/images/brands/logo_puma-130x130.jpg" alt="brand">
						</a>
					</li>
					<li>
						<a href="#">
							<img src="{{url()}}/resources/assets/theme_mypham/images/brands/logo_rbk-130x130.jpg" alt="brand">
						</a>
					</li>
					<li>
						<a href="#">
							<img src="{{url()}}/resources/assets/theme_mypham/images/brands/logo_nike-130x130.jpg" alt="brand">
						</a>
					</li>
					<li>
						<a href="#">
							<img src="{{url()}}/resources/assets/theme_mypham/images/brands/logo_asics-130x130.jpg" alt="brand">
						</a>
					</li>
				</ul>
			</div>
		</div><!--end brands-->
	</div><!--end sixteen-->

</div><!--end container-->
<!-- end the main content area -->

@endsection


