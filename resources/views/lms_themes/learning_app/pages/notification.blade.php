@extends('lms_themes.learning_app.master.pages')
@section('page_name', trans('pages.page_notification_title'))
@section('page_desc', trans('pages.page_notification_desc'))
@section('sidebar_footer')
@endsection
@section('extended_scripts')
    <script id="full-notification-template" type="text/x-handlebars-template">
        <li id="notification-@{{ id }}" class="list-group-item media v-middle notification-item @{{ read }}">
            <div class="media-left">
                <div class="bg-grey-300">
                    #@{{ id }}
                </div>
            </div>
            <div class="media-body">
                <h4 class="text-subhead margin-none">
                    <a href="@{{ url }}">
                        @{{{ message }}}
                    </a>
                </h4>
                <div class="text-light text-caption">
                    <i class="fa fa-clock-o fa-fw"></i>
                    <abbr class="time-ago" title="@{{ time_tz }}">
                        @{{ time }}
                    </abbr>
                </div>
            </div>
            <div class="media-right">
                <a href="@{{ url }}">
                    <span class="label label-@{{ label_type }}">@{{ status }}</span>
                </a>
            </div>
        </li>
    </script>
    <script>
        {!! cdataOpen() !!}
        var full_notification = {
            tpl: null,
            render: function (data) {
                if (this.tpl) {
                    jQuery('#full-notification-holder')
                            .append(this.tpl(data))
                            .children(':last').find('.time-ago').timeago();
                }
            },
            render_new: function (data) {
                if (this.tpl) {
                    jQuery('#full-notification-holder')
                            .prepend(this.tpl(data))
                            .children(':first').find('.time-ago').timeago();
                }
            },
            id: '{{ $last_notification->id }}',
            date: '{{ $last_notification->created_at }}'
        };
        jQuery(document).ready(function () {
            full_notification.tpl = Handlebars.compile(jQuery("#full-notification-template").html());
            jQuery('#full-notification-more').on('click', function (e) {
                var $this = jQuery(this);
                e.preventDefault();

                jQuery.get('{{ url('api/v1/notification/for-full') }}', {
                    date: full_notification.date,
                    id: full_notification.id
                }).done(function (resultData) {
                    if (resultData.success) {
                        if (resultData.list.length == 0) {
                            $this.closest('.list-group').remove();
                            return;
                        }
                        for (var index in resultData.list) {
                            var notification = resultData.list[index];
                            full_notification.render(notification);
                            full_notification.id = notification.id;
                            full_notification.date = notification.created_at;
                        }
                    }
                }).fail(function (resultData) {

                });

                return false;
            });
            jQuery('body').on('notification_raised', function (e, data) {
                data.label_type = 'warning';
                data.status = '{{ trans('label.status_unread') }}';
                full_notification.render_new(data);
            });
        });
        {!! cdataClose() !!}
    </script>
@endsection
@section('page_content')
    <div class="col-md-12">
        <div class="panel panel-default paper-shadow" data-z="0.5">
            <ul id="full-notification-holder" class="list-group">
            @foreach($notifications as $notification)
                <li id="notification-{{ $notification->id }}" class="list-group-item media v-middle notification-item {{ $notification->read ? ' read': ' unread' }}">
                    <div class="media-left">
                        <div class="bg-grey-300">
                            #{{ $notification->id }}
                        </div>
                    </div>
                    <div class="media-body">
                        <h4 class="text-subhead margin-none">
                            <a href="{{ $notification->url }}">
                                {!! $notification->message !!}
                            </a>
                        </h4>
                        <div class="text-light text-caption">
                            <i class="fa fa-clock-o fa-fw"></i>
                            <abbr class="time-ago" title="{{ $notification->time }}">
                                {{ $notification->timeTz }}
                            </abbr>
                        </div>
                    </div>
                    <div class="media-right">
                        <a href="{{ $notification->url }}">
                        @if($notification->read)
                            <span class="label label-success">{{ trans('label.status_read') }}</span>
                        @else
                            <span class="label label-warning">{{ trans('label.status_unread') }}</span>
                        @endif
                        </a>
                    </div>
                </li>
            @endforeach
            </ul>
            <ul class="list-group">
                <li class="list-group-item media v-middle text-center border-top-none">
                    <div class="media-body">
                        <strong><a id="full-notification-more" href="#">{{ trans('form.action_show_more') }}</a></strong>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection
