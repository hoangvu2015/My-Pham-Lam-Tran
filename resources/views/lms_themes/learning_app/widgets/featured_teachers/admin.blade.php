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
                    jQuery('.select2').select2();
                });
        {!! cdataClose() !!}
    </script>
@endsection
@section('extended_widget_bottom')
    <div class="margin-bottom">
        <a class="btn btn-primary" href="{{ localizedAdminURL('teachers/add') }}">{{ trans('form.action_add') }} {{ trans_choice('label.teacher', 1) }}</a>
    </div>
    <div class="box">
        <div class="box-body">
            <div class="form-group">
                <label for="inputTeacherIds">{{ trans('form.action_select') }} {{ trans_choice('label.teacher_lc',2) }}</label>
                <select id="inputTeacherIds" class="form-control select2" name="teacher_ids[]" multiple="multiple" required  style="width: 100%;"
                        data-placeholder="{{ trans('form.action_select') }} {{ trans('label.teacher') }}">
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}"{{ in_array($teacher->id, $teacher_ids) ? ' selected' : '' }}>
                            {{ $teacher->userProfileAdmin->name }} - {{$teacher->userProfileAdmin->email}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@endsection


