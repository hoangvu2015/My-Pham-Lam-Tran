@extends('lms_themes.learning_app.master.user_board')
@section('sidebar-footer')
@endsection
@section('lib_styles')
    <link rel="stylesheet" href="{{ libraryAsset('select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ libraryAsset('bootstrap-select/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ libraryAsset('bootstrap-datepicker/css/bootstrap-datepicker3.standalone.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/0.11.1/cropper.min.css">
    <link rel="stylesheet" href="{{ LmsTheme::cssAsset('crop-avatar.css') }}">
@endsection
@section('extended_styles')
    <style>
        .select2-dropdown {
            min-width: 320px;
        }
    </style>
@endsection
@section('lib_scripts')
    <script src="{{ libraryAsset('select2/js/select2.min.js') }}"></script>
    <script src="{{ libraryAsset('bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ libraryAsset('bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ libraryAsset('bootstrap-datepicker/locales/bootstrap-datepicker.' . $site_locale . '.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/0.11.1/cropper.min.js"></script>
    <script src="{{ LmsTheme::jsAsset('crop-avatar.js') }}"></script>
@endsection
@section('extended_scripts')
    @include('file_manager.open_documents_script')
    <script>
        {!! cdataOpen() !!}
        function addMore(fresh) {
            fresh.append(fresh.children().get(0).outerHTML);
            var children = fresh.children();
            var last = children.last();
            last.find('[id]').each(function () {
                var $this = jQuery(this);
                $this.attr('id', $this.attr('id') + '-' + children.length);
            });
            last.find('[for]').each(function () {
                var $this = jQuery(this);
                $this.attr('for', $this.attr('for') + '-' + children.length);
            });
            last.find('.date-picker').datepicker({
                language : '{{ $site_locale }}',
                format : '{{ $date_js_format }}',
                enableOnReadonly : false
            });
            last.find('.image-from-documents').on('click', function () {
                openMyDocuments(jQuery(this).attr('id'), 'images');
            });
        }
        jQuery(function () {
            jQuery('.select2').select2();
            jQuery('.select-picker').selectpicker();
            jQuery('.date-picker').datepicker({
                language : '{{ $site_locale }}',
                format : '{{ $date_js_format }}',
                enableOnReadonly : false
            });
            jQuery('.company-more').on('click', function () {
                addMore(jQuery('#fresh-companies'));
            });
            jQuery('.education-more').on('click', function () {
                addMore(jQuery('#fresh-educations'));
            });
            jQuery('.certificate-more').on('click', function () {
                addMore(jQuery('#fresh-certificates'));
            });
            jQuery('.audio-from-documents').on('keydown', function () {
                return false;
            }).on('click', function () {
                openMyDocuments(jQuery(this).attr('id'), 'audio');
            });
            jQuery('.image-from-documents').on('click', function () {
                openMyDocuments(jQuery(this).attr('id'), 'images');
            });

            jQuery('[data-toggle="popover"]').popover({html: true});
        });
        {!! cdataClose() !!}
    </script>
@endsection
@section('modals')
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
                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" style="width: 25%">
                                            <i class="fa fa-rotate-left"></i> 90&deg;
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15" style="width: 25%">
                                            <i class="fa fa-rotate-left"></i> 15&deg;
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-30" style="width: 25%">
                                            <i class="fa fa-rotate-left"></i> 30&deg;
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" style="width: 25%">
                                            <i class="fa fa-rotate-left"></i> 45&deg;
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-4 col-buttons">
                                    <div class="btn-group" style="width: 100%">
                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" style="width: 25%">
                                            <i class="fa fa-rotate-right"></i> 45&deg;
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="30" style="width: 25%">
                                            <i class="fa fa-rotate-right"></i> 30&deg;
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="15" style="width: 25%">
                                            <i class="fa fa-rotate-right"></i> 15&deg;
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" style="width: 25%">
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
@endsection
@section('page_content')
    <div class="page-section padding-top-none">
        <div class="media v-middle">
            <div class="media-body">
                <h1 class="text-display-1 margin-none">{{ trans('pages.edit_my_profile') }}</h1>
            </div>
        </div>
    </div>
    <div class="tabbable relative" data-z="0.5">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#account" data-toggle="tab">
                    <i class="fa fa-fw fa-table"></i>
                    <span class="hidden-sm hidden-xs">{{ trans('label.personal_details') }}</span>
                </a>
            </li>
            <li>
                <a href="#work-and-education" data-toggle="tab">
                    <i class="fa fa-fw fa-map-signs"></i>
                    <span class="hidden-sm hidden-xs">{{ trans('label.work') }} &amp; {{ trans('label.education') }}</span>
                </a>
            </li>
            <li>
                <a href="#certificates" data-toggle="tab">
                    <i class="fa fa-fw fa-graduation-cap"></i>
                    <span class="hidden-sm hidden-xs">{{ trans_choice('label.certificate', 2) }}</span>
                </a>
            </li>
            <li>
                <a href="#secure" data-toggle="tab">
                    <i class="fa fa-fw fa-lock"></i>
                    <span class="hidden-sm hidden-xs">{{ trans('label.security') }}</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="account" class="tab-pane active">
                @include('lms_themes.learning_app.pages.user._account')
            </div>
            <div id="work-and-education" class="tab-pane">
                @include('lms_themes.learning_app.pages.user._work_and_education')
            </div>
            <div id="certificates" class="tab-pane">
                @include('lms_themes.learning_app.pages.user._certificates')
            </div>
            <div id="secure" class="tab-pane">
                @include('lms_themes.learning_app.pages.user._security')
            </div>
        </div>
        <!-- // END Panes -->
    </div>
@endsection