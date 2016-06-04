@if($teachers->count()>0)
    <div id="{{ $html_id }}" class="page-section widget-featured-teachers">
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
            <div class="row" data-toggle="isotope">
                @foreach($teachers as $teacher)
                    <?php
                    $userProfile = $teacher->userProfile;
                    $teacher_url = localizedURL('teacher/{id?}', ['id' => $teacher->id]);
                    ?>
                    <div class="item col-xs-12 col-sm-6 col-md-4">
                        <div class="panel panel-default paper-shadow" data-z="0.5">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="view-teacher-profile teacher-link-1-{{ $teacher->id }}" data-id="{{ $teacher->id }}" href="{{ $teacher_url }}">
                                        {{ $userProfile->name }}
                                    </a>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="media">
                                    <div class="media-left">
                                        <a class="view-teacher-profile teacher-link-2-{{ $teacher->id }}" data-id="{{ $teacher->id }}" href="{{ $teacher_url }}">
                                            <img class="width-120 height-120" src="{{ $userProfile->profile_picture }}"
                                                 alt="people">
                                        </a>

                                        <p class="small margin-v-10-0 text-center">
                                            <?php
                                            $averageRate = $teacher->averageRate;
                                            ?>
                                            <span class="hidden">{{ $averageRate }}</span>
                                            @for($i=0;$i<$max_rate;++$i)
                                                <span class="fa fa-fw {{ $i<$averageRate ? 'fa-star':'fa-star-o' }} text-yellow-800"></span>
                                            @endfor
                                        </p>
                                    </div>
                                    <div class="media-body">
                                        <p>
                                            {{ $teacher->short_description }}
                                            <a href="{{ $teacher_url }}#about-me">
                                                <small>{{ trans('form.action_see_more') }}</small>
                                            </a>
                                        </p>
                                        {{--<span class="label label-default">{{ trans_choice('label._classroom', $teacher->classrooms()->count(), ['count' => $teacher->classrooms()->count()]) }}</span>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="media v-middle">
                                    <div class="media-left">
                                        <a class="btn btn-sm btn-warning teacher-link-3-{{ $teacher->id }}" data-id="{{ $teacher->id }}" href="{{ $teacher_url }}">
                                            {{ trans('form.action_view') }} {{ trans('label.profile_lc') }}
                                        </a>
                                    </div>
                                    <div class="media-body">
                                    </div>
                                    <div class="media-right">
                                        <a class="btn btn-sm btn-success"
                                           href="{{ localizedURL('external-learning-request/teacher/{id}', ['id' => $teacher->id]) }}">
                                            {{ trans('label.register_trial_class') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center" style="margin-top: 12px">
                <a onclick="ga('send', {
						  hitType: 'event',
						  eventCategory: 'HomePage',
						  eventAction: 'ClickSeeAllTutor',
						  eventLabel: '{{ trans('label.homepage') }}'
						});" role="button" class="btn btn-lg btn-primary" href="{{ localizedURL('teachers') }}">{{ trans('form.action_view_all') }} {{ trans_choice('label.teacher_lc', 2) }}</a>
            </div>
        </div>
    </div>
@endif