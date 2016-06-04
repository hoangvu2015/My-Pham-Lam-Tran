<h4>{{ trans('label.work') }}</h4>
@foreach($user_works as $work)
    <form method="post" class="form-horizontal" action="{{ localizedURL('user/update/work') }}">
        {{ csrf_field() }}
        @if (count($errors->{'work_'.$work->id}) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->{'work_'.$work->id}->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <input type="hidden" name="id" value="{{ $work->id }}">
        <div class="form-group">
            <label for="inputWorkCompany-{{ $work->id }}" class="col-md-3 control-label">
                <span class="required">{{ trans('label.company') }}</span>
            </label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="inputWorkCompany-{{ $work->id }}" name="company" required placeholder="{{ trans('label.company') }}" value="{{ $work->company }}">
                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputWorkPosition-{{ $work->id }}" class="col-md-3 control-label">{{ trans('label.position') }}</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="inputWorkPosition-{{ $work->id }}" name="position" placeholder="{{ trans('label.position') }}" value="{{ $work->position }}">
                    <span class="input-group-addon"><i class="fa fa-shield"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputWorkDescription-{{ $work->id }}" class="col-md-3 control-label">{{ trans('label.description') }}</label>
            <div class="col-md-6">
                <textarea id="inputWorkDescription-{{ $work->id }}" class="form-control" name="description" rows="5" placeholder="{{ trans('label.description') }}">{{ $work->description }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputWorkStart-{{ $work->id }}" class="col-md-3 control-label">{{ trans('label.date_start') }}</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control date-picker" id="inputWorkStart-{{ $work->id }}" name="start" placeholder="{{ trans('label.date_start') }}" value="{{ $work->start }}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputWorkEnd-{{ $work->id }}" class="col-md-3 control-label">{{ trans('label.date_end') }}</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control date-picker" id="inputWorkEnd-{{ $work->id }}" name="end" placeholder="{{ trans('label.date_end') }}" value="{{ $work->end }}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                <div class="checkbox checkbox-inline">
                    <input id="inputWorkCurrent-{{ $work->id }}" type="checkbox" name="current" value="1"{{ $work->current ? ' checked' : '' }}>
                    <label for="inputWorkCurrent-{{ $work->id }}">{{ trans('label.current') }}</label>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated>{{ trans('form.action_save') }}</button>
            </div>
        </div>
    </form>
    <hr>
@endforeach
<div id="fresh-companies">
    <div class="fresh-company">
        <form method="post" class="form-horizontal" action="{{ localizedURL('user/update/work') }}">
            {{ csrf_field() }}
            @if (count($errors->work) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->work->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="form-group">
                <label for="inputFreshWorkCompany" class="col-md-3 control-label">
                    <span class="required">{{ trans('label.company') }}</span>
                </label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputFreshWorkCompany" name="fresh_company" required placeholder="{{ trans('label.company') }}" value="{{ old('fresh_company') }}">
                        <span class="input-group-addon"><i class="fa fa-building"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputFreshWorkPosition" class="col-md-3 control-label">{{ trans('label.position') }}</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputFreshWorkPosition" name="fresh_position" placeholder="{{ trans('label.position') }}" value="{{ old('fresh_position') }}">
                        <span class="input-group-addon"><i class="fa fa-shield"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputFreshWorkDescription" class="col-md-3 control-label">{{ trans('label.description') }}</label>
                <div class="col-md-6">
                    <textarea id="inputFreshWorkDescription" class="form-control" name="fresh_description" rows="5" placeholder="{{ trans('label.description') }}">{{ old('fresh_description') }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="inputFreshWorkStart" class="col-md-3 control-label">{{ trans('label.date_start') }}</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control date-picker" id="inputFreshWorkStart" name="fresh_start" placeholder="{{ trans('label.date_start') }}" value="{{ old('fresh_start') }}">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputFreshWorkEnd" class="col-md-3 control-label">{{ trans('label.date_end') }}</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control date-picker" id="inputFreshWorkEnd" name="fresh_end" placeholder="{{ trans('label.date_end') }}" value="{{ old('fresh_end') }}">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                    <div class="checkbox checkbox-inline">
                        <input id="inputFreshWorkCurrent" type="checkbox" name="fresh_current" value="1">
                        <label for="inputFreshWorkCurrent">{{ trans('label.current') }}</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated>{{ trans('form.action_save') }}</button>
                </div>
            </div>
        </form>
        <hr>
    </div>
</div>
<div class="form-horizontal">
    <div class="form-group">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <button type="button" class="btn btn-danger paper-shadow relative company-more" data-z="0.5" data-hover-z="1" data-animated>{{ trans('form.action_add_more') }}</button>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
<hr>
<h4>{{ trans('label.education') }}</h4>
@foreach($user_educations as $education)
    <form method="post" class="form-horizontal" action="{{ localizedURL('user/update/education') }}">
        {{ csrf_field() }}
        @if (count($errors->{'education_'.$education->id}) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->{'education_'.$education->id}->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <input type="hidden" name="id" value="{{ $education->id }}">
        <div class="form-group">
            <label for="inputEducationSchool-{{ $education->id }}" class="col-md-3 control-label">
                <span class="required">{{ trans('label.school') }}</span>
            </label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="inputEducationSchool-{{ $education->id }}" name="school" required placeholder="{{ trans('label.school') }}" value="{{ $education->school }}">
                    <span class="input-group-addon"><i class="fa fa-university"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEducationField-{{ $education->id }}" class="col-md-3 control-label">{{ trans('label.field') }}</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="inputEducationField-{{ $education->id }}" name="field" placeholder="{{ trans('label.field') }}" value="{{ $education->field }}">
                    <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEducationDescription-{{ $education->id }}" class="col-md-3 control-label">{{ trans('label.description') }}</label>
            <div class="col-md-6">
                <textarea id="inputEducationDescription-{{ $education->id }}" class="form-control" name="description" rows="5" placeholder="{{ trans('label.description') }}">{{ $education->description }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEducationStart-{{ $education->id }}" class="col-md-3 control-label">{{ trans('label.date_start') }}</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control date-picker" id="inputEducationStart-{{ $education->id }}" name="start" placeholder="{{ trans('label.date_start') }}" value="{{ $education->start }}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEducationEnd-{{ $education->id }}" class="col-md-3 control-label">{{ trans('label.date_end') }}</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control date-picker" id="inputEducationEnd-{{ $education->id }}" name="end" placeholder="{{ trans('label.date_end') }}" value="{{ $education->end }}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                <div class="checkbox checkbox-inline">
                    <input id="inputEducationCurrent-{{ $education->id }}" type="checkbox" name="current" value="1"{{ $education->current ? ' checked' : '' }}>
                    <label for="inputEducationCurrent-{{ $education->id }}">{{ trans('label.current') }}</label>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated>{{ trans('form.action_save') }}</button>
            </div>
        </div>
    </form>
    <hr>
@endforeach
<div id="fresh-educations">
    <div class="fresh-education">
        <form method="post" class="form-horizontal" action="{{ localizedURL('user/update/education') }}">
            {{ csrf_field() }}
            @if (count($errors->education) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->education->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="form-group">
                <label for="inputFreshEducationSchool" class="col-md-3 control-label">
                    <span class="required">{{ trans('label.school') }}</span>
                </label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputFreshEducationSchool" name="fresh_school" required placeholder="{{ trans('label.school') }}" value="{{ old('fresh_school') }}">
                        <span class="input-group-addon"><i class="fa fa-university"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputFreshEducationField" class="col-md-3 control-label">{{ trans('label.field') }}</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputFreshEducationField" name="fresh_field" placeholder="{{ trans('label.field') }}" value="{{ old('fresh_field') }}">
                        <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputFreshEducationDescription" class="col-md-3 control-label">{{ trans('label.description') }}</label>
                <div class="col-md-6">
                    <textarea id="inputFreshEducationDescription" class="form-control" name="fresh_description" rows="5" placeholder="{{ trans('label.description') }}">{{ old('fresh_description') }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="inputFreshEducationStart" class="col-md-3 control-label">{{ trans('label.date_start') }}</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control date-picker" id="inputFreshEducationStart" name="fresh_start" placeholder="{{ trans('label.date_start') }}" value="{{ old('fresh_start') }}">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputFreshEducationEnd" class="col-md-3 control-label">{{ trans('label.date_end') }}</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control date-picker" id="inputFreshEducationEnd" name="fresh_end" placeholder="{{ trans('label.date_end') }}" value="{{ old('fresh_end') }}">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                    <div class="checkbox checkbox-primary">
                        <input id="inputFreshEducationCurrent" type="checkbox" name="fresh_current" value="1">
                        <label for="inputFreshEducationCurrent">{{ trans('label.current') }}</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated>{{ trans('form.action_save') }}</button>
                </div>
            </div>
        </form>
        <hr>
    </div>
</div>
<div class="form-horizontal">
    <div class="form-group">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <button type="button" class="btn btn-danger paper-shadow relative education-more" data-z="0.5" data-hover-z="1" data-animated>{{ trans('form.action_add_more') }}</button>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>