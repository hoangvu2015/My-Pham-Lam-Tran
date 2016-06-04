<div id="{{ $html_id }}" class="widget-social-links">
    @if(!empty($name))
    <h4 class="text-headline text-light">{{ $name }}</h4>
    @endif
    <p>
    @foreach($items as $item)
        <a href="{{ $item->link }}" class="btn btn-{{ $color_func($item->name) }}-500 btn-circle">{!! $item->name !!}</a>
    @endforeach
    </p>
</div>