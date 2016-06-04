<div id="{{ $html_id }}" class="widget-base-links">
    @if(!empty($name))
    <h4 class="text-headline text-light">{{ $name }}</h4>
    @endif
    <ul class="list-unstyled">
        @foreach($items as $item)
            <li><a href="{{ $item->link }}">{{ $item->name }}</a></li>
        @endforeach
    </ul>
</div>