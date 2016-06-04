@section('lib_styles')
    <link rel="stylesheet" href="{{ libraryAsset('iCheck/square/blue.css') }}">
@endsection
@section('lib_scripts')
    <script src="{{ libraryAsset('iCheck/icheck.min.js') }}"></script>
@endsection
@section('extended_scripts')
    <script>
        {!! cdataOpen() !!}
        jQuery(document).ready(function () {
            jQuery('[type=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            jQuery('#inputCommentEnable').on('ifChanged', function () {
                jQuery('.enabled-by-comment').prop('disabled', !jQuery(this).is(':checked'))
            }).trigger('ifChanged');
        });
        {!! cdataClose() !!}
    </script>
@endsection

<div class="box">
    <div class="box-body">
        <div class="form-group">
            <label for="inputAppId">Facebook App ID</label>
            <input id="inputAppId" type="text" class="form-control" name="app_id" value="{{ $app_id }}">
        </div>
        <div class="form-group">
            <div class="checkbox icheck">
                <label for="inputCommentEnable">
                    <input id="inputCommentEnable" type="checkbox" name="comment_enable"
                           value="1"{{ $comment_enable ? ' checked' : '' }}>
                    &nbsp; {{ trans('facebook_integration.comment_enable') }}
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="inputCommentColorScheme">{{ trans('facebook_integration.comment_color_scheme') }}</label>
                    <select id="inputCommentColorScheme" name="comment_color_scheme"
                            class="form-control enabled-by-comment">
                        @foreach($comment_color_scheme_values as $comment_color_scheme_value)
                            <option value="{{ $comment_color_scheme_value }}"{{ $comment_color_scheme_value == $comment_color_scheme ? ' selected' : '' }}>
                                {{ trans('facebook_integration.comment_color_scheme_'.$comment_color_scheme_value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="inputCommentNumPosts">{{ trans('facebook_integration.comment_num_posts') }}</label>
                    <input id="inputCommentNumPosts" type="number" min="1" class="form-control enabled-by-comment"
                           name="comment_num_posts" value="{{ $comment_num_posts }}">
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="inputCommentOrderBy">{{ trans('facebook_integration.comment_order_by') }}</label>
                    <select id="inputCommentOrderBy" name="comment_order_by" class="form-control enabled-by-comment">
                        @foreach($comment_order_by_values as $comment_order_by_value)
                            <option value="{{ $comment_order_by_value }}"{{ $comment_order_by_value == $comment_order_by ? ' selected' : '' }}>
                                {{ trans('facebook_integration.comment_order_by_'.$comment_order_by_value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>