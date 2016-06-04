<div id="{{ $html_id }}" class="widget-register-trial-class" data-spy="affix" data-offset-top="500" data-offset-bottom="400">
    <div class="panel panel-default">
        @if(!empty($name))
            <div class="panel-heading">
                <h4 class="panel-title">{{ $name }}</h4>
            </div>
        @endif
        <form method="get" action="{{ localizedURL('external-learning-request/step-{step}', ['step' => 1]) }}">
            <div class="panel-body">
                @if(!empty($description))
                    <p class="help-block margin-top-none">{!! $description !!}</p>
                @endif
                {{--<div class="form-group">--}}
                    {{--<label for="inputRegisteredName">{{ trans('label.user_name') }}</label>--}}
                    {{--<input type="text" class="form-control" name="name" required placeholder="{{ trans('label.user_name') }}">--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<label for="inputRegisteredPhone">{{ trans('label.phone') }}</label>--}}
                    {{--<input type="tel" class="form-control" name="phone" required placeholder="{{ trans('label.phone') }}">--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<label for="inputRegisteredEmail">{{ trans('label.email') }}</label>--}}
                    {{--<input name="email" required class="form-control" type="email" maxlength="255" id="inputRegisteredEmail" placeholder="{{ trans('label.email') }}">--}}
                {{--</div>--}}
                {{--<p class="help-block margin-bottom-none"><small>{{ trans('label.personal_details_help') }}</small></p>--}}
            </div>
            <div class="panel-footer text-center">
                <!-- <button type="submit" class="btn btn-primary" onclick="ga('send', {
                                                                         hitType: 'event',
                                                                         eventCategory: 'Blog Right Button',
                                                                         eventAction: 'click',
                                                                         eventLabel: '{{currentURL()}}'
                                                                       });" >{{ trans('form.action_register') }}</button> -->
                <?php $count = explode('/', currentURL());?>
                @if(sizeof($count) == 5)
                <a href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}" style="background-color: #E2422D;border-color: #E2422D;" class="btn btn-primary" onclick="ga('send', {
                                                                         hitType: 'event',
                                                                         eventCategory: 'BlogListPost',
                                                                         eventAction: 'click',
                                                                         eventLabel: 'ClickTrialRegisterButtonOnRightSlidebar'
                                                                       });" >{{ trans('form.action_register') }}</a>
               
                @else
                <a href="{{localizedURL('external-learning-request/step-{step}', ['step' => 1])}}" style="background-color: #E2422D;border-color: #E2422D;" class="btn btn-primary" onclick="ga('send', {
                                                                         hitType: 'event',
                                                                         eventCategory: 'BlogDetailPost',
                                                                         eventAction: 'click',
                                                                         eventLabel: 'ClickTrialRegisterButtonOnRightSlidebar'
                                                                       });" >{{ trans('form.action_register') }}</a>
               
                @endif
            </div>
        </form>
    </div>
</div>