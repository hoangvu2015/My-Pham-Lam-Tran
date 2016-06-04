<div id="notification-alert-holder"></div>
<script id="notification-template" type="text/x-handlebars-template">
    <li id="notification-@{{ id }}" class="unread">
        <a href="@{{ url }}">
            <h4>@{{{ message }}}</h4>

            <p>
                <small>
                    <i class="fa fa-clock-o"></i>
                    <span class="time-ago" title="@{{ time_tz }}">
                        @{{ time }}
                    </span>
                </small>
            </p>
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
    {!! cdataClose() !!}
</script>
<script src="{{ libraryAsset('common_libs/full.min.js') }}"></script>
<script src="{{ libraryAsset('time_ago/locales/jquery.timeago.'. $site_locale .'.js') }}"></script>
<script src="{{ libraryAsset('angular.min.js') }}"></script>
<script src="{{ AdminTheme::jsAsset('app.min.js') }}"></script>
@yield('lib_scripts')
<script src="{{ AdminTheme::jsAsset('extra.js') }}"></script>
<!--Angular-->
<script src="{{ libraryAsset('ng-table/dist/ng-table.min.js') }}"></script>
<script src="{{ libraryAsset('ui-bootstrap-tpls-1.1.0.min.js') }}"></script>
<!-- <script src="{{ libraryAsset('ng-table/dist/ng-table.min.js.map') }}"></script> -->
<script src="{{ AdminTheme::jsAsset('angularApp.js') }}"></script>
<!--End angular-->
<script>
    {!! cdataOpen() !!}
    function openMyDocuments(fromInputId, documentType) {
        window.open(
            '{{ localizedURL('documents/for/popup/{input_id}', ['input_id' => '{input_id}']) }}'.replace('{input_id}', fromInputId) + '?custom_type=' + documentType,
            '{{ trans('pages.my_documents_title') }}',
            'width=900,height=480'
            );
    }
    function processSelectedFile(file_url, input_id) {
        jQuery('#' + input_id).val(file_url);
    }
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
        jQuery('.image-from-documents').on('click', function () {
            openMyDocuments(jQuery(this).attr('id'), 'images');
        });
    });
    {!! cdataClose() !!}
</script>
@yield('extended_scripts')
{!! theme_footer() !!}
<script>
    {!! cdataOpen() !!}
    jQuery(document).ready(function () {
        jQuery('.time-ago').timeago();
        push_client.register();
    });
    {!! cdataClose() !!}
</script>