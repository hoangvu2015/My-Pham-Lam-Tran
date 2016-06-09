<!--start header-->
<header>

    <div id="topHeader">
        <div class="container">
            <div class="sixteen columns">
                <ul id="currency">
                    <li class="active_currency"><a href="#">$</a></li>
                    <li><a href="#">£</a></li>
                    <li><a href="#">€</a></li>
                </ul>
                <ul id="lang">
                    <li class="active_lang"><a href="#">en</a></li>
                    <li><a href="#">es</a></li>
                    <li><a href="#">fr</a></li>
                </ul>

                <ul id="topNav">
                    <li><a href="user_log.html">User Log</a></li>
                    <li><a href="wish_list.html">Wish List (5)</a></li>
                    <li><a href="account.html">My Account</a></li>
                    <li><a href="cart.html">Shopping Cart</a></li>
                    <li><a href="checkout.html">Checkout</a></li>
                </ul>
            </div><!--end sixteen-->
        </div><!--end container-->
    </div><!--end topHeader-->


    <div id="middleHeader">
        <div class="container">
            <div class="sixteen columns">
                <div id="logo">
                    <h1><a href="index.html">logo</a></h1>
                </div><!--end logo-->

                <form action="#" method="post" accept-charset="utf-8">
                    <label>
                        <input type="text" name="search" placeholder="Search in Product" value="">
                    </label>
                    <label>
                        <select name="search_category" class="default" tabindex="1">
                            <option value="">Category</option>
                            <option value="amazed">Amazed</option>
                            <option value="bored">Bored</option>
                            <option value="surprised">Surprised</option>
                            <option value="amazed">Amazed</option>
                            <option value="bored">Bored</option>
                            <option value="surprised">Surprised</option>
                            <option value="amazed">Amazed</option>
                            <option value="bored">Bored</option>
                            <option value="surprised">Surprised</option>
                            <option value="amazed">Amazed</option>
                        </select>
                    </label>
                    <div class="submit">
                        <input type="submit" name="submit">
                    </div>
                </form><!--end form-->

            </div><!--end sixteen-->
        </div><!--end container-->
    </div><!--end middleHeader-->

    <div class="container">
        <div class="sixteen columns">
            <div id="mainNav" class="clearfix">
                <nav>
                    <ul>
                        <li>
                            <a class="hasdropdown" href="#">Pages</a>
                            <ul class="submenu">
                                <li><a href="index.html">Home</a></li>
                                <li><a href="index2.html">Home 2</a></li>
                                <li><a href="about.html">About</a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="blog_post.html">Blog Post</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="desktop hasdropdown" href="#">Desktop</a>
                            <ul class="submenu">
                                <li><a href="#">PC</a></li>
                                <li><a href="#">Mac</a></li>
                                <li><a href="#">Luinx</a></li>
                            </ul>
                        </li>
                        <li><a class="labtops" href="#">Laptops</a></li>
                        <li>
                            <a class="componients hasdropdown" href="#">Componients</a>
                            <ul class="submenu">
                                <li><a href="#">Mic &amp; Trackballs</a></li>
                                <li><a href="#">Mointors</a></li>
                                <li><a href="#">Printers</a></li>
                                <li><a href="#">Scanners</a></li>
                                <li><a href="#">Web Cameras</a></li>
                            </ul>
                        </li>
                        <li><a class="tablets" href="#">Tablets</a></li>
                        <li><a class="software" href="#">Software</a></li>
                        <li>
                            <a class="watches hasdropdown" href="#">Watches</a>
                            <ul class="submenu">
                                <li><a href="#">Test one</a></li>
                                <li><a href="#">Test Two</a></li>
                                <li><a href="#">Test Three</a></li>
                                <li><a href="#">Test Four</a></li>
                                <li><a href="#">Test Five</a></li>
                            </ul>
                        </li>
                    </ul>

                </nav><!--end nav-->

                <div id="cart">
                    <a class="cart_dropdown" href="javascript:void(0);"><img src="{{url()}}/resources/assets/theme_mypham/images/icons/cart_icon.png" alt=""> 3 items<span>: $320.00<span></a>
                    <div class="cart_content">
                        <b class="cart_content_arrow"></b>
                        <ul>
                            <li class="clearfix">
                                <div class="cart_product_name">
                                    <img src="{{url()}}/resources/assets/theme_mypham/images/photos/dropdown_cart_image.jpg" alt="product image">
                                    <span>
                                        <strong><a href="#">product Name Here and long</a></strong><br>
                                        Color: black<br>
                                        Size: 36
                                    </span>
                                </div>
                                <div class="cart_product_price">
                                    <span>
                                        <strong>2x - $130.00</strong><br>
                                        <a class="remove_item" href="#">Remove</a>
                                    </span>
                                </div>
                                <div class="clear"></div>
                            </li>
                            <li class="clearfix">
                                <div class="cart_product_name">
                                    <img src="{{url()}}/resources/assets/theme_mypham/images/photos/dropdown_cart_image.jpg" alt="product image">
                                    <span>
                                        <strong><a href="#">product Name Here and long</a></strong><br>
                                        Color: black<br>
                                        Size: 36
                                    </span>
                                </div>
                                <div class="cart_product_price">
                                    <span>
                                        <strong>2x - $130.00</strong><br>
                                        <a class="remove_item" href="#">Remove</a>
                                    </span>
                                </div>
                            </li>
                        </ul><!--end ul-->

                        <div class="dropdown_cart_info clearfix">
                            <div class="cart_buttons">
                                <a class="gray_btn" href="#">View Cart</a><br>
                                <a class="red_btn" href="#">Checkout</a>
                            </div><!--end cart buttons-->

                            <div class="cart_total_price">
                                <span>
                                    Sub Total : $820.00<br>
                                    VAT 16% : $390.00<br>
                                    <strong>TOTAL : $1,598.30</strong>
                                </span>
                            </div><!--end cart buttons-->
                        </div><!--end dropdown_cart_info-->

                    </div><!--end cart_content-->
                </div><!--end cart-->

            </div><!--end main-->
        </div><!--end sixteen-->
    </div><!--end container-->

</header>
<!--end header-->