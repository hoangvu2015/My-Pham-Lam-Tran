<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="avatar-form" action="{{ url('api/v1/upload/js-cropper/profile-picture') }}" enctype="multipart/form-data" method="post">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="avatar-modal-label">{{ trans('form.action_save') }} {{ trans('label.profile_picture') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="avatar-body">

                        <!-- Upload image and data -->
                        <div class="avatar-upload">
                            <input type="hidden" class="avatar-src" name="avatar_src">
                            <input type="hidden" class="avatar-data" name="avatar_data">
                            <label for="avatarInput">{{ trans('form.action_upload') }}:</label>
                            <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                        </div>
                        <div class="help-block">{{ trans('label.max_upload_file_size', ['size' => asKb($max_upload_filesize)]) }}</div>

                        <!-- Crop and preview -->
                        <div class="row">
                            <div class="col-md-9">
                                <div class="avatar-wrapper"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="avatar-preview preview-lg"></div>
                                <div class="avatar-preview preview-md"></div>
                                <div class="avatar-preview preview-sm"></div>
                            </div>
                        </div>

                        <div class="row avatar-buttons">
                            <div class="col-md-4 col-buttons">
                                <div class="btn-group" style="width: 100%">
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="-90" style="width: 25%">
                                        <i class="fa fa-rotate-left"></i> 90&deg;
                                    </button>
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="-15" style="width: 25%">
                                        <i class="fa fa-rotate-left"></i> 15&deg;
                                    </button>
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="-30" style="width: 25%">
                                        <i class="fa fa-rotate-left"></i> 30&deg;
                                    </button>
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="-45" style="width: 25%">
                                        <i class="fa fa-rotate-left"></i> 45&deg;
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-4 col-buttons">
                                <div class="btn-group" style="width: 100%">
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="45" style="width: 25%">
                                        <i class="fa fa-rotate-right"></i> 45&deg;
                                    </button>
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="30" style="width: 25%">
                                        <i class="fa fa-rotate-right"></i> 30&deg;
                                    </button>
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="15" style="width: 25%">
                                        <i class="fa fa-rotate-right"></i> 15&deg;
                                    </button>
                                    <button type="button" class="btn btn-primary avatar-btns" data-method="rotate" data-option="90" style="width: 25%">
                                        <i class="fa fa-rotate-right"></i> 90&deg;
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-buttons">
                                <button type="submit" class="btn btn-danger btn-block avatar-save">{{ trans('form.action_save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('form.action_close') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>