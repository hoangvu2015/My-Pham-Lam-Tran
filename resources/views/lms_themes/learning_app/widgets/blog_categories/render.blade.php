@if($categories->count()>0)
    <div id="{{ $html_id }}" class="widget-blog-categories">
        <div class="panel panel-default" data-toggle="panel-collapse" data-open="true">
            @if(!empty($name))
                <div class="panel-heading panel-collapse-trigger">
                    <h4 class="panel-title">{{ $name }}</h4>
                </div>
            @endif
            <div class="panel-body list-group">
                <ul class="list-group list-group-menu">
                    @foreach($categories as $category)
                        <li class="list-group-item">
                            <a href="{{ localizedURL('blog/category/view/{slug}', ['slug' => $category->slug]) }}">
                                <i class="fa fa-chevron-right fa-fw"></i>
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif