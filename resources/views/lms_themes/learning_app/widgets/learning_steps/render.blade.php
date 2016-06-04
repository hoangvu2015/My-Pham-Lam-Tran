@if($items->count()>0)
    <div id="{{ $html_id }}" class="page-section has-bg bg-white widget-learning-steps">
        <div class="container">
            @if(!empty($name))
                <div class="text-center">
                    <h3 class="text-display-1">{{ $name }}</h3>
                    @if(!empty($description))
                        <p class="lead text-muted">{{ $description }}</p>
                    @endif
                </div>
                <br>
            @endif
            @while($items->count()>0 && $splice_items = $items->splice(0, 6))
                <div class="row">
                    <?php
                    $step = 0;
                    $count_items = $splice_items->count();
                    ?>
                    @if($count_items<6)
                        <div class="col-xs-12 col-sm-6 col-md-{{ (12-2*$count_items)/2 }} text-center no-padding hidden-sm">
                        </div>
                    @endif
                    @foreach($splice_items as $item)
                        <div class="col-xs-12 col-sm-6 col-md-2 text-center no-padding margin-v-5">
                            <img class="width-80 height-80 margin-v-0-15" src="{{ $item->image }}">
                            <p class="learning-step">{{ trans('label._step', ['step' => ++$step]) }}</p>
                            <hr>
                            <p class="learning-step learning-dot">
                                <i class="fa fa-circle"></i>
                            </p>
                            <p class="learning-step">{{ $item->name }}</p>
                        </div>
                    @endforeach
                    @if($count_items<6)
                        <div class="col-xs-12 col-sm-6 col-md-{{ (12-2*$count_items)/2 }} text-center no-padding hidden-sm">
                        </div>
                    @endif
                </div>
            @endwhile
        </div>
    </div>
@endif