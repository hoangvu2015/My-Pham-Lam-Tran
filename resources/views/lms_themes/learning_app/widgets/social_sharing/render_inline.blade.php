<div id="{{ $html_id }}" class="widget-social-sharing">
    @if(!empty($name))
        <h4 class="text-headline text-h4">{{ $name }}</h4>
    @endif
    <ul class="list-inline">
        @foreach($buttons as $button)
            <li>{!! $button !!}</li>
        @endforeach
        @if($has_hidden_buttons)
            <li>
                <a role="button" class="btn btn-default share-more"><i class="fa fa-share-alt"></i>&nbsp; {{ trans('form.action_share_more') }}</a>
            </li>
        @endif
    </ul>
</div>