<!-- Custom Tabs -->

<div class="form-group">
    <label for="inputLogo" class="required">{{ trans('label.logo') }}</label>
    <input class="form-control image-from-documents" id="inputLogo" name="logo"
           placeholder="{{ trans('label.logo') }}" type="text"
           value="{{ $extension->getProperty('logo') }}">
</div>
<div class="form-group">
    <label for="inputEmail">{{ trans('label.email') }}</label>
    <input class="form-control" id="inputEmail" name="email"
           placeholder="{{ trans('label.email') }}" type="text"
           value="{{ $extension->getProperty('email') }}">
</div>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        @foreach(allSupportedLocales() as $locale => $properties)
            <li{!! $locale == $site_locale ? ' class="active"' : '' !!}>
                <a href="#tab_{{ $locale }}" data-toggle="tab">
                    {{ $properties['native'] }}
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach(allSupportedLocales() as $locale => $properties)
            <div class="tab-pane{{ $locale == $site_locale ? ' active' : '' }}" id="tab_{{ $locale }}">
                <div class="form-group">
                    <label for="inputName_{{ $locale }}" class="required">{{ trans('label.name') }}</label>
                    <input class="form-control" id="inputName_{{ $locale }}" name="name[{{ $locale }}]"
                           placeholder="{{ trans('label.name') }}" type="text"
                           value="{{ $extension->getProperty('name', $locale) }}">
                </div>
                <div class="form-group">
                    <label for="inputDescription_{{ $locale }}">{{ trans('label.description') }}</label>
                    <textarea rows="5" class="form-control" id="inputDescription_{{ $locale }}" name="description[{{ $locale }}]"
                              placeholder="{{ trans('label.description') }}">{{ $extension->getProperty('description', $locale) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="inputTagLine_{{ $locale }}">{{ trans('label.tag_line') }}</label>
                    <input class="form-control" id="inputTagLine_{{ $locale }}" name="tag_line[{{ $locale }}]"
                           placeholder="{{ trans('label.tag_line') }}" type="text"
                           value="{{ $extension->getProperty('tag_line', $locale) }}">
                </div>
                <div class="form-group">
                    <label for="inputSlogan_{{ $locale }}">{{ trans('label.slogan') }}</label>
                    <input class="form-control" id="inputSlogan_{{ $locale }}" name="slogan[{{ $locale }}]"
                           placeholder="{{ trans('label.slogan') }}" type="text"
                           value="{{ $extension->getProperty('slogan', $locale) }}">
                </div>
                <div class="form-group">
                    <label for="inputBrief_{{ $locale }}">{{ trans('label.brief') }}</label>
                    <textarea rows="5" class="form-control" id="inputBrief_{{ $locale }}" name="brief[{{ $locale }}]"
                              placeholder="{{ trans('label.brief') }}">{{ $extension->getProperty('brief', $locale) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="inputHeadOffice_{{ $locale }}">{{ trans('label.head_office') }}</label>
                    <input class="form-control" id="inputHeadOffice_{{ $locale }}" name="head_office[{{ $locale }}]"
                           placeholder="{{ trans('label.head_office') }}" type="text"
                           value="{{ $extension->getProperty('head_office', $locale) }}">
                </div>
                <div class="form-group">
                    <label for="inputBranchOffices_{{ $locale }}">{{ trans_choice('label.branch_office', 2) }}</label>
                    <textarea rows="5" class="form-control" id="inputBranchOffices_{{ $locale }}" name="branch_offices[{{ $locale }}]"
                              placeholder="{{ trans_choice('label.branch_office', 2) }}">{{ $extension->getProperty('branch_offices', $locale) }}</textarea>
                    <p class="help-block">{{ trans('label._single_line_typing', ['name' => trans_choice('label.branch_office_lc', 1)]) }}</p>
                </div>
            </div><!-- /.tab-pane -->
        @endforeach
    </div><!-- /.tab-content -->
</div><!-- nav-tabs-custom -->