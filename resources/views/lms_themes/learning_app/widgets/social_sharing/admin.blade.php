@extends('widgets.default.admin')
@section('lib_styles')
    <link rel="stylesheet" href="{{ libraryAsset('iCheck/square/blue.css') }}">
@endsection
@section('lib_scripts')
    <script src="{{ libraryAsset('iCheck/icheck.min.js') }}"></script>
@endsection
@section('extended_scripts')
    <script>
        jQuery(document).ready(function () {
            jQuery('[type=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
            jQuery('.sortable').sortable({
                placeholder: 'sort-highlight',
                handle: '.handle',
                forcePlaceholderSize: true,
                zIndex: 999999
            });
        });
    </script>
@endsection
@section('extended_widget_top')
    <?php
    $items = $widget->getSharingButtonsForAdmin();
    ?>
    <div class="box">
        <div class="box-body">
            <div class="form-group">
                <label>{{ trans('social_sharing.shown_buttons') }}</label>
                <ul class="todo-list sortable">
                    @foreach($items as $key => $item)
                        <li>
                            <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                            </span>
                            <input id="input{{ ucfirst($key) }}" name="sharing[]" type="checkbox" value="{{ $key }}"{{ $item['active'] ? ' checked' : '' }}>
                            <label for="input{{ ucfirst($key) }}" class="text">{{ $item['name'] }}</label>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label for="inputMaxShownButtons">{!! trans('social_sharing.max_shown_buttons') !!}</label>
                        <input id="inputMaxShownButtons" class="form-control" type="number" name="max_buttons" value="{{ $widget->getMaxButtons() }}">
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label for="inputEnableCount">{!! trans('social_sharing.enable_count') !!}
                        <div class="checkbox">
                            <input id="inputEnableCount" type="checkbox"
                                   name="enable_count" value="1"{{ $widget->getEnableCount() ? ' checked' : '' }}></label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label for="inputStyle">{!! trans('social_sharing.style') !!}</label>
                        <select id="inputStyle" class="form-control" name="style">
                            @foreach($widget->getAllowedStyles() as $style)
                                <option value="{{ $style }}"{{ $style == $widget->getStyle() ? ' selected' : '' }}>
                                    {{ trans('social_sharing.style_'.$style) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection