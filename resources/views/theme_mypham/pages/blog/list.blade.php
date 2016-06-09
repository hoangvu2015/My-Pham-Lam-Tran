@extends('theme_mypham.master.pages')

@section('theme_mp_css')
<link rel="stylesheet" href="{{MPasset('css/blog.css')}}">
@endsection

@section('extended_styles')

@endsection

@section('extended_scripts')
@endsection

@section('page_content')
<div class="container">
	<div class="sixteen columns">

		<div id="pageName">
			<div class="name_tag">
				<p>
					You're Here :: <a href="#">home</a> :: Blog
				</p>
				<div class="shapLeft"></div>
				<div class="shapRight"></div>
			</div>
		</div><!--end pageName-->

	</div>
</div><!-- container -->



<!-- strat the main content area -->

<div class="container">

	<div class="eleven columns">
		<article>
			<div class="blogImg">

				<div class="pagers center">
					<a class="prev blog_slide_prev" href="#prev">Prev</a>
					<a class="nxt blog_slide_nxt" href="#nxt">Next</a>
				</div>

				<ul class="cycle-slideshow"
				data-cycle-fx="tileBlind"
				data-cycle-timeout=0
				data-cycle-slides="> li"
				data-cycle-prev="div.pagers a.blog_slide_prev"
				data-cycle-next="div.pagers a.blog_slide_nxt"
				>

				<li><a href="#"><img src="{{url()}}/resources/assets/theme_mypham/images/photos/blog_img.jpg" alt="blog image"></a></li>
				<li><a href="#"><img src="{{url()}}/resources/assets/theme_mypham/images/photos/blog_img2.jpg" alt="blog image"></a></li>

			</ul>
		</div><!--end blogImg-->

		<div class="blogDesc clearfix">
			<div class="blogLeft clearfix">
				<h6><span>28</span><br>JUN, 2012</h6>
				<ul>
					<li>Comments: <a href="#">25</a></li>
					<li>Favorites: <a href="#">13</a></li>
					<li>Author: <a href="#">John Doe</a></li>
					<li>Views: <a href="#">113 Times</a></li>
				</ul>
			</div><!--end blog left-->

			<div class="blogRight">
				<h5>
					<a href="#">This is ablog title to go here</a>
				</h5>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu risus lorem, ut placerat nisl. Integer sit amet dolor eros, vitae eleifend nisl. Suspendisse vel ante eget neque consequat suscipit sit amet vitae arcu. Donec rutrum turpis iaculis quam molestie quis dictum mauris mollis. Lorem ipsum dolor sit amet...<a href="#">Read More</a>
				</p>
			</div><!--end blogText-->
		</div><!--end blogDesc-->

	</article><!--end article-->

	<article>
		<div class="blogImg">
			<ul>
				<li><a href="#"><img src="{{url()}}/resources/assets/theme_mypham/images/photos/blog_img2.jpg" alt="blog image"></a></li>
			</ul>
		</div><!--end blogImg-->

		<div class="blogDesc clearfix">
			<div class="blogLeft clearfix">
				<h6><span>28</span><br>JUN, 2012</h6>
				<ul>
					<li>Comments: <a href="#">25</a></li>
					<li>Favorites: <a href="#">13</a></li>
					<li>Author: <a href="#">John Doe</a></li>
					<li>Views: <a href="#">113 Times</a></li>
				</ul>
			</div><!--end blog left-->

			<div class="blogRight">
				<h5>
					<a href="#">This is ablog title to go here</a>
				</h5>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu risus lorem, ut placerat nisl. Integer sit amet dolor eros, vitae eleifend nisl. Suspendisse vel ante eget neque consequat suscipit sit amet vitae arcu. Donec rutrum turpis iaculis quam molestie quis dictum mauris mollis. Lorem ipsum dolor sit amet...<a href="#">Read More</a>
				</p>
			</div><!--end blogText-->
		</div><!--end blogDesc-->

	</article><!--end article-->

	<article>
		<div class="blogImg">
			<ul>
				<li><a href="#"><img src="{{url()}}/resources/assets/theme_mypham/images/photos/blog_img.jpg" alt="blog image"></a></li>
			</ul>
		</div><!--end blogImg-->

		<div class="blogDesc clearfix">
			<div class="blogLeft clearfix">
				<h6><span>28</span><br>JUN, 2012</h6>
				<ul>
					<li>Comments: <a href="#">25</a></li>
					<li>Favorites: <a href="#">13</a></li>
					<li>Author: <a href="#">John Doe</a></li>
					<li>Views: <a href="#">113 Times</a></li>
				</ul>
			</div><!--end blog left-->

			<div class="blogRight">
				<h5>
					<a href="#">This is ablog title to go here</a>
				</h5>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu risus lorem, ut placerat nisl. Integer sit amet dolor eros, vitae eleifend nisl. Suspendisse vel ante eget neque consequat suscipit sit amet vitae arcu. Donec rutrum turpis iaculis quam molestie quis dictum mauris mollis. Lorem ipsum dolor sit amet...<a href="#">Read More</a>
				</p>
			</div><!--end blogText-->
		</div><!--end blogDesc-->

	</article><!--end article-->

	<div class="pagination">
		<a class="text">Page 1 Of 15</a>
		<a href="#">
			<img src="{{url()}}/resources/assets/theme_mypham/images/icons/left_white_icon.png" alt="" width="7" height="8">
		</a>
		<a href="#">1</a>
		<a class="activePage" href="#">2</a>
		<a href="#">3</a>
		<a href="#">4</a>
		<a class="text">...</a>
		<a href="#">13</a>
		<a href="#">14</a>
		<a href="#">15</a>
		<a href="#">
			<img src="{{url()}}/resources/assets/theme_mypham/images/icons/right_white_icon.png" alt="" width="7" height="8">
		</a>
	</div><!--end pagination-->
</div><!--end eleven-->


<aside class="five columns">

	<div class="blogSearch clearfix">
		<form method="get" action="#">
			<label>
				<input class="input_tool_tip" type="text" name="search" placeholder="Search In Blog">
			</label>
			<div class="submit">
				<input type="submit" name="submit">
			</div>
		</form>
	</div><!--end blogSearch-->

	<div class="blog_category clearfix">
		<div class="box_head">
			<h3>Category</h3>
		</div><!--end box_head -->
		<ul>
			<li><a href="#">December</a></li>
			<li><a href="#">Noveber</a></li>
			<li><a href="#">October</a></li>
			<li><a href="#">July</a></li>
			<li><a href="#">June</a></li>
		</ul>
		<ul>
			<li><a href="#">May</a></li>
			<li><a href="#">September</a></li>
			<li><a href="#">January</a></li>
			<li><a href="#">December</a></li>
			<li><a href="#">Noveber</a></li>
		</ul>
	</div><!--end blogArchive-->


	<div class="blogTab">
		<div id="tabs">

			<ul class="tabNav">
				<li><a class="currentTab" href="#recent">Recent</a></li>
				<li><a href="#puplar">Puplar</a></li>
				<li><a href="#comment">Comments</a></li>
				<div class="clear"></div>
			</ul>

			<div id="tabContentOuter">

				<div id="recent" class="tabContent">
					<div>
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/thumbnail.jpg" alt="">
						<div>
							<a href="#">
								<p>consectetur adipiscing elit. Curabitur eu risus lorem</p>
							</a>
							<span>16 October, 2012</span>
						</div>
					</div>

					<div>
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/thumbnail.jpg" alt="">
						<div>
							<a href="#">
								<p>consectetur adipiscing elit. Curabitur eu risus lorem</p>
							</a>
							<span>16 October, 2012</span>
						</div>
					</div>

					<div>
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/thumbnail.jpg" alt="">
						<div>
							<a href="#">
								<p>consectetur adipiscing elit. Curabitur eu risus lorem</p>
							</a>
							<span>16 October, 2012</span>
						</div>
					</div>
					<div class="clear"></div>
				</div><!--end recent-->


				<div id="puplar" class="tabContent">
					<div>
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/thumbnail.jpg" alt="">
						<div>
							<a href="#">
								<p>consectetur adipiscing elit. Curabitur eu risus lorem</p>
							</a>
							<span>8 September, 2012</span>
						</div>
					</div>

					<div>
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/thumbnail.jpg" alt="">
						<div>
							<a href="#">
								<p>consectetur adipiscing elit. Curabitur eu risus lorem</p>
							</a>
							<span>18 September, 2012</span>
						</div>
					</div>

					<div>
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/thumbnail.jpg" alt="">
						<div>
							<a href="#">
								<p>consectetur adipiscing elit. Curabitur eu risus lorem</p>
							</a>
							<span>16 September, 2012</span>
						</div>
					</div>
					<div class="clear"></div>
				</div><!--end puplar-->


				<div id="comment" class="tabContent">
					<div>
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/thumbnail.jpg" alt="">
						<div>
							<a href="#">
								<p>consectetur adipiscing elit. Curabitur eu risus lorem</p>
							</a>
							<span>15 May, 2012</span>
						</div>
					</div>

					<div>
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/thumbnail.jpg" alt="">
						<div>
							<a href="#">
								<p>consectetur adipiscing elit. Curabitur eu risus lorem</p>
							</a>
							<span>9 Januury, 2012</span>
						</div>
					</div>

					<div>
						<img src="{{url()}}/resources/assets/theme_mypham/images/photos/thumbnail.jpg" alt="">
						<div>
							<a href="#">
								<p>consectetur adipiscing elit. Curabitur eu risus lorem</p>
							</a>
							<span>11 June, 2012</span>
						</div>
					</div>
					<div class="clear"></div>
				</div><!--end comment-->

			</div><!--end tabContentOuter-->

		</div><!--end tabs-->
	</div><!--end blogTab-->

	<div class="blogArchive">
		<div class="box_head">
			<h3>Archive</h3>
		</div><!--end box_head -->
		<ul>
			<li><a href="#">December...<span>13</span></a></li>
			<li><a href="#">Noveber...<span>22</span></a></li>
			<li><a href="#">October...<span>20</span></a></li>
			<li><a href="#">July...<span>5</span></a></li>
			<li><a href="#">June...<span>9</span></a></li>
			<li><a href="#">May...<span>16</span></a></li>
			<li><a href="#">September...<span>18</span></a></li>
			<li><a href="#">January...<span>18</span></a></li>
		</ul>
	</div><!--end blogArchive-->


	<div class="ads">
		<h6>Addvertise Here</h6>
	</div><!--end ads-->

</aside><!--end aside five-->


</div><!--end container-->
<!-- end the main content area -->
@endsection


