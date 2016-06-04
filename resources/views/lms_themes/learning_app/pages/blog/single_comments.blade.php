<h5 class="text-subhead-2 text-light">
    {{ trans_choice('label.comment', 2) }}
    @if($count_reviews>0)
        <em>({{ $count_reviews }} {{  trans_choice('label.comment_lc', $count_reviews) }})</em>
    @endif
</h5>
@if(count($errors->review) > 0)
    <div class="alert alert-danger">
        @foreach ($errors->review->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
<form method="post" action="{{ localizedURL('blog/{id}/reviews/add', ['id' => $article->id]) }}">
    {!! csrf_field() !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <textarea class="form-control" id="review-content" name="review" rows="3" placeholder="{{ trans('label.article_review_welcome') }}" required>{{ old('review', '') }}</textarea>
            </div>
        </div>
    </div>
    @if($is_auth)
        <div class="media v-middle">
            <div class="media-left">
                <img src="{{ $auth_user->profile_picture }}" alt="People" class="img-circle width-40 height-40">
            </div>
            <div class="media-body">
                <p class="text-subhead margin-v-5-0">
                    <strong>{{ $auth_user->name }}</strong>
                </p>
                <p class="small">
                    <input type="hidden" name="rate" class="rating" value="{{ old('rate', 1) }}" data-filled="fa fa-fw fa-star text-yellow-800" data-empty="fa fa-fw fa-star-o text-yellow-800">
                </p>
            </div>
            <div class="media-right">
                <button class="btn btn-success" type="submit">{{ trans('form.action_add') }} {{ trans_choice('label.comment', 1) }}</button>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-control-material static required">
                    <input type="text" class="form-control" id="inputName" name="name" placeholder="{{ trans('label.user_name') }}" required value="{{ old('name', '') }}">
                    <label for="inputName">{{ trans('label.user_name') }}</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-control-material static required">
                    <input type="email" class="form-control" id="inputEmail" name="email" placeholder="{{ trans('label.email') }}" required value="{{ old('email', '') }}">
                    <label for="inputEmail">{{ trans('label.email') }}</label>
                </div>
            </div>
            {{--<div class="col-md-4">--}}
            {{--<div class="form-group form-control-material static">--}}
            {{--<input type="text" class="form-control" id="inputWebsite" name="website" placeholder="{{ trans('label.website') }}" value="{{ old('website', '') }}">--}}
            {{--<label for="inputWebsite">{{ trans('label.website') }}</label>--}}
            {{--</div>--}}
            {{--</div>--}}
        </div>
        <div class="media v-middle margin-top-none">
            <div class="media-body text-right">
                <span class="text-subhead">{{ trans('form.action_rate') }}</span>: &nbsp;
                        <span class="small">
                            <input type="hidden" name="rate" class="rating" value="{{ old('rate', 0) }}" data-filled="fa fa-fw fa-star text-yellow-800" data-empty="fa fa-fw fa-star-o text-yellow-800">
                        </span>
            </div>
            <div class="media-right">
                <button class="btn btn-success" type="submit">{{ trans('form.action_add') }} {{ trans_choice('label.comment', 1) }}</button>
            </div>
        </div>
    @endif
</form>
<br>
@foreach($reviews as $review)
    <div id="comment-{{ $review->id }}" {!! !$review->approved ? 'title="'.strip_tags(trans('label.be_private.')).'"' : '' !!}
    class="media s-container comment-item {{ $review->approved ? 'approved' : 'reject' }}">
        <a class="media-left" href="{{ $review->userUrl }}">
            <img class="media-object width-50 height-50 thumbnail" src="{{ $review->userProfilePicture }}" alt="people">
        </a>
        <div class="media-body">
            <div class="panel panel-default">
                <div class="panel-body">
                    <small class="text-grey-400 pull-right">
                        <span class="time-ago" title="{{ defaultTimeTZ($review->created_at) }}">{{ defaultTime($review->created_at) }}</span>
                        @if($is_auth && $auth_user->hasRole('blog-editor'))
                            | <a class="delete"
                                 href="{{ localizedURL('blog/{id}/reviews/{review_id}/delete', ['id' => $article->id, 'review_id' => $review->id]) }}">
                                {{ trans('form.action_delete') }}
                            </a>
                        @endif
                        @if($is_author)
                            @if($review->approved)
                                | <a class="reject"
                                     href="{{ localizedURL('blog/{id}/reviews/{review_id}/reject', ['id' => $article->id, 'review_id' => $review->id]) }}">
                                    {{ trans('form.action_hide') }}
                                </a>
                            @else
                                | <a class="approve"
                                     href="{{ localizedURL('blog/{id}/reviews/{review_id}/approve', ['id' => $article->id, 'review_id' => $review->id]) }}">
                                    {{ trans('form.action_display') }}
                                </a>
                            @endif
                        @endif
                    </small>
                    <h5 class="media-heading margin-v-0-15">
                        @if($review->isRegisteredUser())
                            <?php
                            $review_user = $review->user;
                            ?>
                            <a href="#" class="text-black" data-user="{{ $review_user->id }}">
                                <strong>{{ $review_user->name }}</strong>
                            </a>
                        @else
                            {{ $review->userName }}
                        @endif
                    </h5>
                    <div class="comment-text">
                        {!! $review->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach