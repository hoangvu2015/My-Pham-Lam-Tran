@include('lms_themes.learning_app.new_master.common_modals')
@yield('modals')

<script>
    {!! cdataOpen() !!}
    var LANG = '{{currentLocale()}}';
    if(LANG == 'vi'){
        LANG = 'Vn'; 
    }else if(LANG == 'en'){
        LANG = 'En'; 
    }
    var THEME_PATH = '{{ LmsTheme::asset() }}/';
    var AJAX_REQUEST_TOKEN = '{{ csrf_token() }}';
    var ORTC_SERVER = '{{ appOrtcServer() }}';
    var ORTC_CLIENT_ID = '{{ $session_id }}';
    var ORTC_CLIENT_KEY = '{{ appOrtcClientKey() }}';
    var ORTC_CLIENT_SECRET = '{{ appOrtcClientSecrent() }}';
    var colors = {
        "danger-color": "#e74c3c",
        "success-color": "#81b53e",
        "warning-color": "#f0ad4e",
        "inverse-color": "#2c3e50",
        "info-color": "#2d7cb5",
        "default-color": "#6e7882",
        "default-light-color": "#cfd9db",
        "purple-color": "#9D8AC7",
        "mustard-color": "#d4d171",
        "lightred-color": "#e15258",
        "body-bg": "#f6f6f6"
    };
    var config = {
        theme: "html",
        skins: {
            "default": {
                "primary-color": "#42a5f5"
            }
        }
    };
    var COUNTRY = {!! json_encode(config('laravellocalization.nationality')) !!};
    window.facebookID = '{{env('FACEBOOK_CLIENT_ID')}}';
    window.googleID_JS = '{{env('GOOGLE_CLIENT_ID_JS')}}';
    window.url = '{{url()}}';
    window.URL_BECOME_TUTOR = '{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}';
    window.URL_TERMS_SERVICE = '{{localizedURL('faq/terms-of-service')}}';
    {!! cdataClose() !!}
</script>
<script src="{{ libraryAsset('common_libs/full_lms.min.js') }}?version={{versionJs()}}"></script>
<script src="{{ libraryAsset('time_ago/locales/jquery.timeago.'. $site_locale .'.js') }}?version={{versionJs()}}"></script>
<script src="{{ LmsTheme::jsAsset('vendor.js') }}?version={{versionJs()}}"></script>
<script src="{{ libraryAsset('isotope.pkgd.min.js') }}?version={{versionJs()}}"></script>
<script src="{{ LmsTheme::jsAsset('all.js') }}?version={{versionJs()}}"></script>
@yield('lib_scripts')
<script src="{{ LmsTheme::jsAsset('app.js') }}?version={{versionJs()}}"></script>
<script src="{{ LmsTheme::jsAsset('extra.js') }}?version={{versionJs()}}"></script>
<script src="{{ LmsTheme::jsAsset('variables.js') }}?version={{versionJs()}}"></script>
<script src="{{ LmsTheme::jsAsset('main.js') }}?version={{versionJs()}}"></script>
@yield('extended_scripts')

<!-- Angular Js -->
<script src="{{ libraryAsset('ui-bootstrap-tpls-1.1.0.min.js') }}"></script>
<script src="{{ libraryAsset('angular-sanitize/angular-sanitize.min.js') }}"></script>
<script src="{{ libraryAsset('angular-resource.js') }}"></script>
<script src="{{ libraryAsset('angular-translate/angular-translate.min.js') }}"></script>
<script src="{{ libraryAsset('angular-google-gapi/dist/angular-google-gapi.min.js') }}"></script>
@yield('lib_angular_scripts')
<script src="{{ LmsTheme::jsAsset('lang/en.js') }}?version={{versionJs()}}"></script>
<script src="{{ LmsTheme::jsAsset('lang/vi.js') }}?version={{versionJs()}}"></script>
<script src="{{ LmsTheme::jsAsset('angularApp.js') }}?version={{versionJs()}}"></script>
<script src="{{ LmsTheme::jsAsset('angular/share/appController.js') }}?version={{versionJs()}}"></script>
<script src="{{ LmsTheme::jsAsset('angular/share/appService.js') }}?version={{versionJs()}}"></script>
<script src="{{ LmsTheme::jsAsset('angular/menu/menuController.js') }}?version={{versionJs()}}"></script>
<script src="{{ LmsTheme::jsAsset('angular/menu/menuService.js') }}?version={{versionJs()}}"></script>
@yield('angular_scripts')
<!-- End Angular Js -->

{!! theme_footer() !!}

        <!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','//connect.facebook.net/en_US/fbevents.js');

    fbq('init', '1014567625274594');
    fbq('track', "PageView");
</script>
<noscript>
    <img alt="" height="1" width="1" style="display:none"
         src="https://www.facebook.com/tr?id=1014567625274594&ev=PageView&noscript=1"
    />
</noscript>
<!-- End Facebook Pixel Code -->

<!-- Hotjar Tracking Code for http://antoree.com/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:156782,hjsv:5};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
</script>

<!-- Intercom -->
<script>
    window.intercomSettings = {
        app_id: "aqxlr9mv"
    };
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/aqxlr9mv';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()
</script>

</body>
</html>