@foreach($user_certificates as $certificate)
    <form method="post" class="form-horizontal" action="{{ localizedURL('user/update/certificate') }}">
        {{ csrf_field() }}
        @if (count($errors->{'certificate_'.$certificate->id}) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->{'certificate_'.$certificate->id}->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <input type="hidden" name="id" value="{{ $certificate->id }}">
        <div class="form-group">
            <label for="inputCertificateName-{{ $certificate->id }}" class="col-md-3 control-label">
                <span class="required">{{ trans('label.name') }}</span>
            </label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="inputCertificateName-{{ $certificate->id }}" name="name" required placeholder="{{ trans('label.name') }}" value="{{ $certificate->name }}">
                    <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCertificateDescription-{{ $certificate->id }}" class="col-md-3 control-label">{{ trans('label.description') }}</label>
            <div class="col-md-6">
                <textarea id="inputCertificateDescription-{{ $certificate->id }}" class="form-control" name="description" rows="5" placeholder="{{ trans('label.description') }}">{{ $certificate->description }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCertificateRecordedAt-{{ $certificate->id }}" class="col-md-3 control-label">{{ trans('label.certificated_on') }}</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control date-picker" id="inputCertificateRecordedAt-{{ $certificate->id }}" name="recorded_at" placeholder="{{ trans('label.certificated_on') }}" value="{{ $certificate->recordedAt }}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCertificateOrganization" class="col-md-3 control-label">{{ trans('label.organization') }}</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="inputCertificateOrganization" name="organization" placeholder="{{ trans('label.organization') }}" value="{{ $certificate->organization }}">
                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCertificateSource" class="col-md-3 control-label">{{ trans('label.source_url') }}</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="inputCertificateSource" name="source" placeholder="{{ trans('label.source_url') }}" value="{{ $certificate->source }}">
                    <span class="input-group-addon"><i class="fa fa-share-alt"></i></span>
                </div>
                @if(!empty($certificate->source))
                <p class="help-block">
                    <a href="{{ $certificate->source }}">{{ $certificate->source }}</a>
                </p>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="inputCertificateImage-{{ $certificate->id }}" class="col-md-3 control-label">{{ trans('label.picture') }}</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control image-from-documents" id="inputCertificateImage-{{ $certificate->id }}" name="image" placeholder="{{ trans('label.picture') }}" value="{{ $certificate->image }}">
                    <span class="input-group-addon"><i class="fa fa-photo"></i></span>
                </div>
                @if(!empty($certificate->image))
                <p class="help-block">
                    <a href="{{ $certificate->image }}">{{ $certificate->image }}</a>
                </p>
                @endif
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated>{{ trans('form.action_save') }}</button>
            </div>
        </div>
        @if($certificate->status==$record_status_not_verified || $certificate->status==$record_status_rejected)
            <div class="form-group">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="alert alert-{{ $certificate->status==$record_status_not_verified ? 'info' : 'danger' }} margin-bottom-none">
                        {{ trans('label.'.($certificate->status==$record_status_not_verified ? 'status_not_verified' : 'status_rejected')) }}. {{ trans('label.certificate_not_verified_help') }}.
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputCertificateVerifiedImage1-{{ $certificate->id }}" class="col-md-3 control-label">
                    <span class="required">{{ trans('label.picture') }} 1</span>
                </label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control image-from-documents" id="inputCertificateVerifiedImage1-{{ $certificate->id }}" name="verified_image_1" required placeholder="{{ trans('label.picture') }} 1" value="{{ $certificate->verified_image_1 }}">
                        <span class="input-group-addon"><i class="fa fa-photo"></i></span>
                    </div>
                    <p class="help-block">
                        @if(!empty($certificate->verified_image_1))
                            <a href="{{ $certificate->verified_image_1 }}">{{ $certificate->verified_image_1 }}</a>
                        @endif
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label for="inputCertificateVerifiedImage2-{{ $certificate->id }}" class="col-md-3 control-label">{{ trans('label.picture') }} 2</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control image-from-documents" id="inputCertificateVerifiedImage2-{{ $certificate->id }}" name="verified_image_2" placeholder="{{ trans('label.picture') }} 2" value="{{ $certificate->verified_image_2 }}">
                        <span class="input-group-addon"><i class="fa fa-photo"></i></span>
                    </div>
                    <p class="help-block">
                        @if(!empty($certificate->verified_image_2))
                            <a href="{{ $certificate->verified_image_2 }}">{{ $certificate->verified_image_2 }}</a>
                        @endif
                    </p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success paper-shadow relative" name="acquire" value="1" data-z="0.5" data-hover-z="1" data-animated>
                        {{ trans('form.action_acquire_verification') }}
                    </button>
                </div>
            </div>
        @else
            <div class="form-group">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="alert alert-{{ $certificate->status==$record_status_verified ? 'success' : 'info' }} margin-bottom-none">
                        {{ trans('label.'.($certificate->status==$record_status_verified ? 'status_verified' : 'verification_acquired')) }}
                    </div>
                </div>
            </div>
        @endif
    </form>
    <hr>
@endforeach
<div id="fresh-certificates">
    <div class="fresh-certificate">
        <form method="post" class="form-horizontal" action="{{ localizedURL('user/update/certificate') }}">
            {{ csrf_field() }}
            @if (count($errors->certificate) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->certificate->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="form-group">
                <label for="inputFreshCertificateName" class="col-md-3 control-label">
                    <span class="required">{{ trans('label.name') }}</span>
                </label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputFreshCertificateName" name="fresh_name" required placeholder="{{ trans('label.name') }}" value="{{ old('fresh_name') }}">
                        <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputFreshCertificateDescription" class="col-md-3 control-label">{{ trans('label.description') }}</label>
                <div class="col-md-6">
                    <textarea id="inputFreshCertificateDescription" class="form-control" name="fresh_description" rows="5" placeholder="{{ trans('label.description') }}">{{ old('fresh_description') }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="inputFreshCertificateRecordedAt" class="col-md-3 control-label">{{ trans('label.certificated_on') }}</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control date-picker" id="inputFreshCertificateRecordedAt" name="fresh_recorded_at" placeholder="{{ trans('label.certificated_on') }}" value="{{ old('fresh_recorded_at') }}">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputFreshCertificateOrganization" class="col-md-3 control-label">{{ trans('label.organization') }}</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputFreshCertificateOrganization" name="fresh_organization" placeholder="{{ trans('label.organization') }}" value="{{ old('fresh_organization') }}">
                        <span class="input-group-addon"><i class="fa fa-building"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputFreshCertificateSource" class="col-md-3 control-label">{{ trans('label.source_url') }}</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputFreshCertificateSource" name="fresh_source" placeholder="{{ trans('label.source_url') }}" value="{{ old('fresh_source') }}">
                        <span class="input-group-addon"><i class="fa fa-share-alt"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputFreshCertificateImage" class="col-md-3 control-label">{{ trans('label.picture') }}</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control image-from-documents" id="inputFreshCertificateImage" name="fresh_image" placeholder="{{ trans('label.picture') }}" value="{{ old('fresh_image') }}">
                        <span class="input-group-addon"><i class="fa fa-photo"></i></span>
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
            <button type="button" class="btn btn-danger paper-shadow relative certificate-more" data-z="0.5" data-hover-z="1" data-animated>{{ trans('form.action_add_more') }}</button>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>