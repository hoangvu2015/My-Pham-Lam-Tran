{{-- <footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 text-left">
                {!! trans('label.copyright', ['name' => $site_name, 'version' => $site_version, 'year' => date('Y')]) !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                <div class="hidden-xs">
                    <strong>{{ trans('label.language') }}</strong>:
                    <a href="{{ localizedURL('localization-settings') }}">{{ currentLocaleNativeReading() }}</a>.
                    <strong>{{ trans('label.timezone') }}</strong>:
                    <a href="{{ localizedURL('localization-settings') }}">{{ currentTimeZone() }}</a>.
                </div>
                <div class="hidden-sm">
                    {!! $footer_menu !!}
                </div>
            </div>
        </div>
    </div>
</footer> --}}
@yield('modals')
<div id="notification-alert-holder"></div>
<script id="notification-template" type="text/x-handlebars-template">
    <li id="notification-@{{ id }}" class="notification-item unread">
        <a href="@{{ url }}">
            <span>@{{{ message }}}</span><br>
            <small class="text-light">
                <span class="time-ago" title="@{{ time_tz }}">
                    @{{ time }}
                </span>
            </small>
        </a>
    </li>
</script>
<script>
    {!! cdataOpen() !!}
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
    {!! cdataClose() !!}
</script>
<script src="{{ libraryAsset('common_libs/full.min.js') }}"></script>
<script src="{{ libraryAsset('time_ago/locales/jquery.timeago.'. $site_locale .'.js') }}"></script>
<script src="{{ libraryAsset('isotope.pkgd.min.js') }}"></script>
<script src="{{ LmsTheme::jsAsset('all.js') }}"></script>
@yield('lib_scripts')
<script src="{{ LmsTheme::jsAsset('app.js') }}"></script>
<script src="{{ LmsTheme::jsAsset('extra.js') }}"></script>
@if($is_auth)
    <script>
        {!! cdataOpen() !!}
                jQuery(document).ready(function () {
                    var notification = new NotificationCenter(
                            Handlebars.compile(jQuery("#notification-template").html()),
                            new NotificationCount({{ $auth_user->notifications()->unread()->count() }}),
                            8
                    );
                    push_client.subscribe('{{ $auth_user->notificationChannel->secret }}', function (theClient, channel, msg) {
                        var data = jQuery.parseJSON(msg);
                        notification.render(data);
                        jQuery('body').trigger(jQuery.Event('notification_raised'), [data]);
                    });
                });
        {!! cdataClose() !!}
    </script>
@endif
@yield('extended_scripts')
{!! theme_footer() !!}
@if(!isMobileClient())
    <script>
        {!! cdataOpen() !!}
        jQuery(document).ready(function(){
            new AjaxPopover(
                    'user-popover',
                    jQuery('[data-user]'),
                    '{{ url('api/v1/user/badge') }}',
                    function(target) {
                        return {
                            html: true,
                            id: target.attr('data-user')
                        };
                    },
                    function(data) {
                        return data;
                    },
                    function() {
                        return null;
                    }
            ).register();
        });
        {!! cdataClose() !!}
    </script>
@endif
<script>
    {!! cdataOpen() !!}
    jQuery(document).ready(function () {
        if (window.location.hash.length > 0) {
            jQuery('.tabbable a[href="' + window.location.hash + '"]').tab('show');
        }
        jQuery('.time-ago').timeago();
        jQuery('.custom-affix').each(function () {
            var $this = jQuery(this);
            $this.width($this.parent().width());
        });
        jQuery('a.page-scroll').on('click', function(e) {
            var $anchor = jQuery(this);
            jQuery('html, body').stop().animate({
                scrollTop: jQuery($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            e.preventDefault();
        });
        jQuery('#notification-holder').niceScroll({
            cursorcolor:'#333',
            cursorborder:'none'
        });
        push_client.register();
    });
    {!! cdataClose() !!}
</script>
<!-- Google Code dành cho Thẻ tiếp thị lại -->
<!--------------------------------------------------
Không thể liên kết thẻ tiếp thị lại với thông tin nhận dạng cá nhân hay đặt thẻ tiếp thị lại trên các trang có liên quan đến danh mục nhạy cảm. Xem thêm thông tin và hướng dẫn về cách thiết lập thẻ trên: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 936472461;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/936472461/?value=0&amp;guid=ON&amp;script=0"/>
    </div>
</noscript>
</body>
</html>