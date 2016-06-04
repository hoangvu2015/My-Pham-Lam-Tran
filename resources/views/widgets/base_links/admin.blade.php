@extends('widgets.default.admin')
@section('lib_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
@endsection
@section('lib_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
@endsection
@section('extended_scripts')
    <script>
        {!! cdataOpen() !!}
        jQuery(document).ready(function () {
            jQuery('.select2').select2();
        });
        {!! cdataClose() !!}
    </script>
@endsection
@section('extended_widget_top')
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="inputLinkCategory">{{ trans_choice('label.link_category', 1) }}</label>
                <select id="inputLinkCategory" class="form-control select2" name="link_category_id" style="width: 100%;">
                    <option value="0">[{{ trans('label.not_set') }}]</option>
                    @foreach($widget->link_categories() as $id => $text)
                        <option value="{{ $id }}"{{ $widget->link_category_id()==$id ? ' selected' : '' }}>
                            {{ $text }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@endsection
