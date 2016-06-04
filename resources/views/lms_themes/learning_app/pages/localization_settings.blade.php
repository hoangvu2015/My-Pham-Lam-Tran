@extends('lms_themes.learning_app.master.pages')
@section('page_name', trans('pages.page_localization_settings_title'))
@section('page_desc', trans('pages.page_localization_settings_desc'))
@section('sidebar_footer')
@endsection
@section('lib_styles')
    <link rel="stylesheet" href="{{ libraryAsset('select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ libraryAsset('bootstrap-select/css/bootstrap-select.min.css') }}">
@endsection
@section('lib_scripts')
    <script src="{{ libraryAsset('select2/js/select2.min.js') }}"></script>
    <script src="{{ libraryAsset('bootstrap-select/js/bootstrap-select.min.js') }}"></script>
@endsection
@section('extended_scripts')
    <script>
        {!! cdataOpen() !!}
        jQuery(document).ready(function () {
                    jQuery('.select2').select2();
                    jQuery('.select-picker').selectpicker();
                });
        {!! cdataClose() !!}
    </script>
@endsection
@section('page_content')
    <div class="col-md-12">
        <div class="panel panel-default">
            <form method="post">
                {!! csrf_field() !!}
                <div class="panel-body">
                    <div class="form-group">
                        <label for="inputNationality">{{ trans('label.nationality') }}:</label>
                        <select id="inputNationality" class="select2" name="country" style="width: 100%;">
                            {!! countriesAsOptions(session('localization.country')) !!}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputLanguage">{{ trans('label.language') }}:</label>
                        <select id="inputLanguage" class="select-picker form-control" name="language">
                        @foreach (allSupportedLocales() as $localeCode => $properties)
                            <option value="{{ $localeCode }}"{{ $localeCode==$site_locale ? ' selected':'' }}>
                                {{ $properties['native'] }}
                            </option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputTimeZone">{{ trans('label.timezone') }}:</label>
                        <select id="inputTimeZone" class="select2" name="timezone" style="width: 100%;">
                            {!!  timeZoneListAsOptions(session('localization.timezone')) !!}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputFDOW">{{ trans('label.first_day_of_week') }}:</label>
                        <select id="inputFDOW" class="select-picker form-control" name="first_day_of_week">
                        {!! daysOfWeekAsOptions(session('localization.first_day_of_week')) !!}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputLDF">{{ trans('label.long_date_format') }}:</label>
                        <select id="inputLDF" class="select-picker form-control" name="long_date_format">
                            {!! longDateFormatsAsOptions(session('localization.long_date_format')) !!}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputSDF">{{ trans('label.short_date_format') }}:</label>
                        <select id="inputSDF" class="select-picker form-control" name="short_date_format">
                            {!! shortDateFormatsAsOptions(session('localization.short_date_format')) !!}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputLTF">{{ trans('label.long_time_format') }}:</label>
                        <select id="inputLTF" class="select-picker form-control" name="long_time_format">
                            {!! longTimeFormatsAsOptions(session('localization.long_time_format')) !!}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputSTF">{{ trans('label.short_time_format') }}:</label>
                        <select id="inputSTF" class="select-picker form-control" name="short_time_format">
                            {!! shortTimeFormatsAsOptions(session('localization.short_time_format')) !!}
                        </select>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-primary" type="submit">{{ trans('form.action_save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection