@if($items->count()>0)
    <div id="{{ $html_id }}" class="page-section widget-client-links">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-4"></div>
                <div class="col-xs-12 col-sm-4">
                    <hr>
                </div>
            </div>
            @if(!empty($name))
                <div class="text-center">
                    <h3 class="text-display-1">{{$name}}</h3>
                    @if(!empty($description))
                        <p class="lead text-muted">{{ $description }}</p>
                    @endif
                </div>
                <br>
            @endif
            <ul class="list-inline text-center">
                @foreach($items as $item)
                    <li class="margin-v-10">
                        <div class="table-item">
                             <a href="{{ $item->link }}" target="_blank"
                               title="{{ trans('label._our', ['name' => trans_choice('label.client', 1)]) }} - {{ $item->name }}">
                                <img class="height-40" src="{{ $item->image }}">
                            </a>
                        </div>
                       
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif