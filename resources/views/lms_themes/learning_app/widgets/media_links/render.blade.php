@if($items->count()>0)
    <div id="{{ $html_id }}" class="page-section widget-media-links">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-4"></div>
                <div class="col-xs-12 col-sm-4">
                    <hr>
                </div>
            </div>
            @if(!empty($name))
                <div class="text-center">
                    <h3 class="text-display-1">{{ $name }}</h3>
                    @if(!empty($description))
                        <p class="lead text-muted">{{ $description }}</p>
                    @endif
                </div>
                <br>
            @endif
            <div class="row" data-toggle="gridalicious">
                @foreach($items as $item)
                    <div class="media">
                        <div class="media-body">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="h4">
                                        <a target="_blank"  href="{{ $item->link }}">
                                            {{ $item->name }}
                                        </a>
                                    </div>
                                    <p>{{ $item->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif