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
            <label for="inputFacebookAppId">Facebook App ID</label>
            <input id="inputFacebookAppId" type="text" class="form-control" name="facebook_app_id" value="{{ $facebook_app_id }}">
        </div>
        <div class="form-group">
            <div class="checkbox icheck">
                <label for="inputFacebookCommentEnable">
                    <input id="inputFacebookCommentEnable" type="checkbox" name="facebook_comment_enable"
                           value="1"{{ $facebook_comment_enable ? ' checked' : '' }}>
                    &nbsp; {{ trans('facebook_integration.comment_enable') }}
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="inputFacebookCommentColorScheme">{{ trans('facebook_integration.comment_color_scheme') }}</label>
                    <select id="inputFacebookCommentColorScheme" name="facebook_comment_color_scheme"
                            class="form-control enabled-by-comment">
                        @foreach($facebook_comment_color_scheme_values as $comment_color_scheme_value)
                            <option value="{{ $comment_color_scheme_value }}"{{ $comment_color_scheme_value == $facebook_comment_color_scheme ? ' selected' : '' }}>
                                {{ trans('facebook_integration.comment_color_scheme_'.$comment_color_scheme_value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="inputFacebookCommentNumPosts">{{ trans('facebook_integration.comment_num_posts') }}</label>
                    <input id="inputFacebookCommentNumPosts" type="number" min="1" class="form-control enabled-by-comment"
                           name="facebook_comment_num_posts" value="{{ $facebook_comment_num_posts }}">
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <label for="inputFacebookCommentOrderBy">{{ trans('facebook_integration.comment_order_by') }}</label>
                    <select id="inputFacebookCommentOrderBy" name="facebook_comment_order_by" class="form-control enabled-by-comment">
                        @foreach($facebook_comment_order_by_values as $comment_order_by_value)
                            <option value="{{ $comment_order_by_value }}"{{ $comment_order_by_value == $facebook_comment_order_by ? ' selected' : '' }}>
                                {{ trans('facebook_integration.comment_order_by_'.$comment_order_by_value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>