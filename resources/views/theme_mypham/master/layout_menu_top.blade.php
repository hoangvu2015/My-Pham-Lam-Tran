<style>
    #topHeader ul#topNav li a {font-size: 15px;}
    @media only screen and (max-width: 767px){
        #mainNav nav > ul {width: 200px;}
    }
</style>
<!--start header-->
<header>

    <div id="topHeader">
        <div class="container">
            <div class="sixteen columns">
                <ul id="currency" style="color: #fff;margin-top: 15px;font-size: 18px;">
                    Hotline: 0165.273.3639
                    <!-- <li class="active_currency"><a href="#">$</a></li>
                    <li><a href="#">£</a></li>
                    <li><a href="#">€</a></li> -->
                </ul>
                <ul id="lang" style="color: #fff;margin-top: 15px;font-size: 18px;">
                    Email: phlam53ta3@gmail.com
                    <!-- <li class="active_lang"><a href="#">en</a></li>
                    <li><a href="#">es</a></li>
                    <li><a href="#">fr</a></li> -->
                </ul>

                <ul id="topNav">
                    <li><a href="user_log.html">Zalo:0165.273.3639</a></li>
                    <li><a target="_blank" href="https://www.facebook.com/profile.php?id=100007408094672">Facebook: Trần Lam</a></li>
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
                            <a href="#">Trang Chủ</a>
                        </li>
                        <li>
                            <a class="desktop hasdropdown" href="#">Sản Phẩm</a>
                            <ul class="submenu">
                                @foreach($pro_categories as $category)
                                <li><a href="#">{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li>
                            <a class="componients hasdropdown" href="#">Tin Tức</a>
                            <ul class="submenu">
                                <li><a href="#">Mic &amp; Trackballs</a></li>
                                <li><a href="#">Mointors</a></li>
                                <li><a href="#">Printers</a></li>
                                <li><a href="#">Scanners</a></li>
                                <li><a href="#">Web Cameras</a></li>
                            </ul>
                        </li>
                        <li><a class="labtops" href="#">Giới Thiệu</a></li>
                        <li><a class="tablets" href="#">Hướng Dẫn Mua Hàng</a></li>
                        <li><a class="software" href="#">Liên Hệ</a></li>
                        <!-- <li>
                            <a class="watches hasdropdown" href="#">Watches</a>
                            <ul class="submenu">
                                <li><a href="#">Test one</a></li>
                                <li><a href="#">Test Two</a></li>
                                <li><a href="#">Test Three</a></li>
                                <li><a href="#">Test Four</a></li>
                                <li><a href="#">Test Five</a></li>
                            </ul>
                        </li> -->
                    </ul>

                </nav><!--end nav-->
            </div><!--end main-->
        </div><!--end sixteen-->
    </div><!--end container-->

</header>
<!--end header-->