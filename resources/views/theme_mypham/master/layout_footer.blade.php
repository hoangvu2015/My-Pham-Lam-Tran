<!-- @include('lms_themes.learning_app.new_master.common_modals') -->
@yield('modals')

<!-- JS Theme
    ================================================== -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <!-- jQuery.dropKick plug-in -->
    <link rel="stylesheet" href="{{MPasset('js/dropKick/dropkick.css')}}?version={{versionJs()}}">
    <script src="{{MPasset('js/dropKick/jquery.dropkick-1.0.0.js')}}?version={{versionJs()}}"></script>
    <!-- jQuery.nicescroll plug-in -->
    <script src="{{MPasset('js/jquery.nicescroll.js')}}?version={{versionJs()}}"></script>
    <!-- jQuery.tweet plug-in -->
    <script src="{{MPasset('js/jquery.tweet.js')}}?version={{versionJs()}}"></script>
    <!-- jQuery.cycle2 plug-in -->
    <script src="{{MPasset('js/jquery.cycle2.min.js')}}?version={{versionJs()}}"></script>
    <script src="{{MPasset('js/jquery.cycle2.tile.min.js')}}?version={{versionJs()}}"></script>
    <!-- jQuery.jcarousellite plug-in -->
    <script src="{{MPasset('js/jcarousellite_1.0.1.min.js')}}?version={{versionJs()}}"></script>
    <!-- jQuery.fancybox plug-in -->
    <link rel="stylesheet" href="{{MPasset('js/fancybox/jquery.fancybox-1.3.4.css')}}?version={{versionJs()}}">
    <script src="{{MPasset('js/fancybox/jquery.fancybox-1.3.4.pack.js')}}?version={{versionJs()}}"></script>
    <!-- jQuery.etalage plug-in -->
    <script src="{{MPasset('js/jquery.etalage.min.js')}}?version={{versionJs()}}"></script>
    <!-- jQuery.cookie plug-in -->
    <script src="{{MPasset('js/jquery.cookie.js')}}?version={{versionJs()}}"></script>
    <!--my custom code-->   
    <script src="{{MPasset('js/main.js')}}?version={{versionJs()}}"></script>
<!-- End Document
    ================================================== -->

    @yield('lib_scripts')
    @yield('extended_scripts')

</body>
</html>