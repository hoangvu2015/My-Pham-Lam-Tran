@extends('widgets.default.admin')
@section('lib_styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
@endsection
@section('lib_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
@endsection
@section('extended_scripts')
    <script>
        {!! cdataOpen() !!}
        jQuery(document).ready(function () {
            jQuery('.select2').select2()
        });
        {!! cdataClose() !!}
    </script>
@endsection
@section('extended_widget_bottom')
    <div class="box">
        <div class="box-body">
            <div class="form-group">
                <label for="inputReviews">{{ trans('form.action_select') }} {{ trans_choice('label.review', 2) }}</label>
                <select id="inputReviews" class="form-control select2" name="review_ids[]" multiple="multiple" required style="width: 100%;"
                        data-placeholder="{{ trans('form.action_select') }} {{ trans_choice('label.review', 2) }}">
                    @foreach ($all_reviews as $review)
                        <option value="{{ $review->id }}" {{in_array($review->id, $review_ids) ? ' selected' : ''}}>
                            {{ $review->user->name  }} {{trans('label.reviewed')}}
                            @foreach($review->teachers as $teacher)
                                {{$teacher->userProfile->name}}
                            @endforeach
                             - {{escHtml($review->content)}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@endsection
