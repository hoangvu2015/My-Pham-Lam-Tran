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
        });
        {!! cdataClose() !!}
    </script>
@endsection

<div class="box">
    <div class="box-body">
        <div class="form-group">
            <label for="inputWebPropertyId">Web Property ID</label>
            <input id="inputWebPropertyId" type="text" class="form-control" name="web_property_id" value="{{ $web_property_id }}">
        </div>
        <div class="form-group">
            <div class="checkbox icheck">
                <label for="inputAsync">
                    <input id="inputAsync" type="checkbox" name="async_script" value="1"{{ $async_script ? ' checked' : '' }}>
                    &nbsp; Async?
                </label>
            </div>
        </div>
    </div>
</div>