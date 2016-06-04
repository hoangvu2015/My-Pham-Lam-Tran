@extends('lms_themes.learning_app.master.pages')
@section('page_name', 'Chat to Supporters')
@section('page_desc', 'Have conversation with our supporters in order to choose best learning courses.')
@section('sidebar_footer')
@endsection
@if($current_supporter_existed)
    @section('extended_scripts')
        <script id="conversation-template" type="text/x-handlebars-template">
            <div class="panel panel-default paper-shadow" data-z="0.5" data-hover-z="1" data-animated>
                <div class="panel-body">
                    <div class="media v-middle">
                        <div class="media-left">
                            <img alt="person" class="media-object img-circle width-50"
                                 src="@{{ picture }}">
                        </div>
                        <div class="media-body message">
                            <h4 class="text-subhead margin-none"><a href="#">@{{ name }}</a>
                            </h4>

                            <p class="text-caption text-light">
                                <i class="fa fa-clock-o"></i>
                                <abbr class="time-ago" title="@{{ time_tz }}">
                                    @{{ time }}
                                </abbr>
                            </p>
                        </div>
                    </div>
                    <br>
                    <p>@{{ message }}</p>
                </div>
            </div>
        </script>
        <script id="supporter-template" type="text/x-handlebars-template">
            @{{#if active}}
            <li class="list-group-item active">
            @{{else}}
            <li class="list-group-item">
                @{{/if}}
                <a href="@{{ url }}">
                    <div class="media v-middle">
                        <div class="media-left">
                            <img src="@{{ picture }}" width="50" alt=""
                                 class="media-object"/>
                        </div>
                        <div class="media-body">
                            <span class="user">@{{ name }}</span>
                            @{{#if phone}}
                            <div class="text-light">@{{ phone }}</div>
                            @{{/if}}
                        </div>
                        <div class="media-right media-padding">
                            @{{#if online}}
                            @{{#if idle}}
                            <div title="Idle"
                                 style="width: 7px;height: 7px;background: transparent url('{{ LmsTheme::imageAsset('circle_states.png') }}') 0 -7px no-repeat"></div>
                            @{{else}}
                            <div title="Online"
                                 style="width: 7px;height: 7px;background: transparent url('{{ LmsTheme::imageAsset('circle_states.png') }}') 0 0 no-repeat"></div>
                            @{{/if}}
                            @{{/if}}
                        </div>
                    </div>
                </a>
            </li>
        </script>
        <script>
            {!! cdataOpen() !!}
            var conversation = {
                tpl: null,
                render: function (data) {
                    if (this.tpl) {
                        if (data.name == '') {
                            data.name = 'You';
                        }
                        jQuery('#conversation-holder')
                                .prepend(this.tpl(data))
                                .children(':first').find('.time-ago').timeago();
                    }
                }
            };

            jQuery(document).ready(function () {
                var realtimeMessage = new RealtimeMessage();
                realtimeMessage.type = 'message';
                realtimeMessage.name = '{{ $is_auth ? $auth_user->name : '' }}';
                realtimeMessage.picture = '{{ $is_auth ? $auth_user->profile_picture : appDefaultUserProfilePicture() }}';
                var realtimeNotification = new RealtimeNotification();

                new ApiForm(
                        jQuery('form.api'),
                        function (formData) {
                            if (formData.message.trim() == '') {
                                return '<span class="text-danger">The message is empty</span>';
                            }
                        },
                        function (formData, resultData) {
                            realtimeMessage.message = formData.message;
                            realtimeMessage.send('{{ $support_channel->secret }}');

                            realtimeNotification.id = resultData.notification.id;
                            realtimeNotification.url = resultData.notification.url;
                            realtimeNotification.message = resultData.notification.message;
                            realtimeNotification.send('{{ $current_supporter_existed ? $current_supporter->notificationChannel->secret : '' }}');
                        },
                        function (formData, resultData) {
                            jQuery('[name="message"]').val(formData.message);
                        },
                        jQuery('#user-response'),
                        '<span class="text-info">Conversation between you and the supporter</span>',
                        '<span class="text-success">Message was sent</span>',
                        '<span class="text-danger">Fail to send message</span>',
                        2,
                        {message:''},
                        null
                ).register();

                new AutoUpdateList(
                    jQuery('#supporter-holder'),
                    Handlebars.compile(jQuery("#supporter-template").html()),
                    '{{ url('api/v1/supporters') }}',
                    {
                        'current_supporter_id': jQuery('[name="current_supporter_id"]').val()
                    },
                    30
                ).register();

                conversation.tpl = Handlebars.compile(jQuery("#conversation-template").html());
                push_client.subscribe('{{ $support_channel->secret }}', function (theClient, channel, msg) {
                    conversation.render(jQuery.parseJSON(msg));
                });
            });
            {!! cdataClose() !!}
        </script>
    @endsection
@else
    @section('extended_scripts')
        <script id="supporter-template" type="text/x-handlebars-template">
            @{{#if active}}
            <li class="list-group-item active">
            @{{else}}
            <li class="list-group-item">
                @{{/if}}
                <a href="@{{ url }}">
                    <div class="media v-middle">
                        <div class="media-left">
                            <img src="@{{ picture }}" width="50" alt=""
                                 class="media-object"/>
                        </div>
                        <div class="media-body">
                            <span class="user">@{{ name }}</span>
                            @{{#if phone}}
                            <div class="text-light">@{{ phone }}</div>
                            @{{/if}}
                        </div>
                        <div class="media-right media-padding">
                            @{{#if online}}
                            @{{#if idle}}
                            <div title="Idle"
                                 style="width: 7px;height: 7px;background: transparent url('{{ LmsTheme::imageAsset('circle_states.png') }}') 0 -7px no-repeat"></div>
                            @{{else}}
                            <div title="Online"
                                 style="width: 7px;height: 7px;background: transparent url('{{ LmsTheme::imageAsset('circle_states.png') }}') 0 0 no-repeat"></div>
                            @{{/if}}
                            @{{/if}}
                        </div>
                    </div>
                </a>
            </li>
        </script>
        <script>
            {!! cdataOpen() !!}
            jQuery(document).ready(function () {
                new AutoUpdateList(
                    jQuery('#supporter-holder'),
                    Handlebars.compile(jQuery("#supporter-template").html()),
                    '{{ url('api/v1/supporters') }}',
                    {
                        'current_supporter_id': jQuery('[name="current_supporter_id"]').val()
                    },
                    30
                ).register();
            });
            {!! cdataClose() !!}
        </script>
    @endsection
@endif
@section('page_content')
    <div class="col-md-9">
        <div class="media messages-container media-clearfix-xs-min media-grid">
            <div class="media-left">
                <div class="messages-list">
                    <div class="panel panel-default paper-shadow" data-z="0.5" data-scrollable-h>
                        <input type="hidden" name="current_supporter_id" value="{{ $current_supporter_existed ? $current_supporter->id : '' }}">
                        <ul id="supporter-holder" class="list-group">
                    @foreach($supporters as $supporter)
                        @if($current_supporter_existed)
                            <li class="list-group-item{{ $current_supporter->id==$supporter->id ? ' active':'' }}">
                        @else
                            <li class="list-group-item">
                        @endif
                                <a href="{{ localizedURL('supporter/{id?}', ['id'=>$supporter->id]) }}">
                                    <div class="media v-middle">
                                        <div class="media-left">
                                            <img src="{{ $supporter->profile_picture }}" width="50" alt=""
                                                 class="media-object"/>
                                        </div>
                                        <div class="media-body">
                                            <span class="user">{{ $supporter->name }}</span>
                                        @if(isset($supporter->phone))
                                            <div class="text-light">{{ $supporter->phone }}</div>
                                        @endif
                                        </div>
                                        <div class="media-right media-padding">
                                    @if($supporter->isOnline())
                                        @if(!$supporter->isIdle())
                                            <div title="Online"
                                                 style="width: 7px;height: 7px;background: transparent url('{{ LmsTheme::imageAsset('circle_states.png') }}') 0 0 no-repeat"></div>
                                        @else
                                            <div title="Idle"
                                                 style="width: 7px;height: 7px;background: transparent url('{{ LmsTheme::imageAsset('circle_states.png') }}') 0 -7px no-repeat"></div>
                                        @endif
                                    @endif
                                        </div>
                                    </div>
                                </a>
                            </li>
                    @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="media-body">
            @if($current_supporter_existed)
                <div class="panel panel-default paper-shadow" data-z="0.5" data-hover-z="1" data-animated>
                    <div class="panel-body">
                        <div id="user-response" class="text-center">
                            <span class="text-info">Conversation between you and the supporter</span>
                        </div>
                    </div>
                </div>
                <form class="api" method="post" action="{{ url('api/v1/realtime/send/light/sp-conversation/visitor') }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="channel_id" value="{{ $support_channel->id }}">
                    <input type="hidden" name="from" value="{{ $is_auth ? $auth_user->id : '' }}">
                    <input type="hidden" name="to" value="{{ $current_supporter->id }}">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-envelope"></i> Send
                                </button>
                            </div>
                            <!-- /btn-group -->
                            <input class="form-control share-text" type="text" name="message"
                                   placeholder="Write message..." value="{{ $init_message }}">
                        </div>
                        <!-- /input-group -->
                    </div>
                </form>
                <div id="conversation-holder">
                    @foreach($conversations as $conversation)
                        <div class="panel panel-default paper-shadow" data-z="0.5" data-hover-z="1" data-animated>
                            <div class="panel-body">
                                <div class="media v-middle">
                                    <div class="media-left">
                                        <img alt="person" class="media-object img-circle width-50"
                                             src="{{ $conversation->user ? $conversation->user->profile_picture : appDefaultUserProfilePicture() }}">
                                    </div>
                                    <div class="media-body message">
                                        <h4 class="text-subhead margin-none">
                                            <a>{{ $conversation->user ? $conversation->user->name : 'You' }}</a>
                                        </h4>

                                        <p class="text-caption text-light">
                                            <i class="fa fa-clock-o"></i>
                                            <abbr class="time-ago"
                                                  title="{{ defaultTimeTZ($conversation->created_at) }}">
                                                {{ defaultTime($conversation->created_at) }}
                                            </abbr>
                                        </p>
                                    </div>
                                </div>
                                <br>

                                <p>{{ $conversation->message }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            </div>
        </div>
        <br/>
        <br/>
    </div>
    <div class="col-md-3">
    </div>
@endsection