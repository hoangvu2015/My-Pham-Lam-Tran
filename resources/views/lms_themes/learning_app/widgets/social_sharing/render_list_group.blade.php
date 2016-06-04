<div id="{{ $html_id }}" class="widget-social-sharing">
    @if(!empty($name))
        <h4 class="text-headline text-h4">{{ $name }}</h4>
    @endif
    <ul class="list-group">
        @foreach($buttons as $button)
            <li class="list-group-item">{!! $button !!}</li>
        @endforeach
        @if($has_hidden_buttons)
            <li class="list-group-item">
                <a class="text-light share-more" href="#"><i class="fa fa-share-alt"></i>&nbsp; {{ trans('form.action_share_more') }}</a>
            </li>
        @endif
    </ul>
</div>