@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_homepage_options_title'))
@section('page_description', trans('pages.admin_homepage_options_desc'))
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('app-options') }}">{{ trans('pages.admin_app_options_title') }}</a></li>
    </ol>
@endsection
@section('extended_scripts')
    <script>
        {!! cdataOpen() !!}
        jQuery(document).ready(function(){
            jQuery('.input-slides.sortable').sortable({
                placeholder: 'sort-highlight',
                handle: 'h5',
                forcePlaceholderSize: true,
                connectWith: '.input-slides.sortable',
                zIndex: 999999
            });
            jQuery('[data-action="slide-remove"]').on('click', function () {
                jQuery(this).closest('.input-slide').remove();
            });
            jQuery('[data-action="slide-sort-up"]').on('click', function () {
                var $currentInputSlide = jQuery(this).closest('.input-slide');
                var $currentInputSlideIndex = $currentInputSlide.index();
                var $children = $currentInputSlide.parent().children();
                console.log($currentInputSlideIndex);
                if ($currentInputSlideIndex - 1 >= 0) {
                    $currentInputSlide.insertBefore($children.eq($currentInputSlideIndex - 1));
                }
            });
            jQuery('[data-action="slide-sort-down"]').on('click', function () {
                var $currentInputSlide = jQuery(this).closest('.input-slide');
                var $currentInputSlideIndex = $currentInputSlide.index();
                var $children = $currentInputSlide.parent().children();
                console.log($currentInputSlideIndex);
                if ($currentInputSlideIndex + 1 < $children.length) {
                    $currentInputSlide.insertAfter($children.eq($currentInputSlideIndex + 1));
                }
            });
            jQuery('.add-more-slide').on('click', function () {
                var $slides = jQuery('#homepage-slideshow > .tab-content > .active > .input-slides');
                var $slide = $slides.children().last();
                var $more = $slide.clone(true).insertAfter($slide);
                var $length = $slides.children().length;
                $more.find('h5').html('{{ trans('label.slide') }} ' + $length);
                $more.find('input,textarea').val('');
                $more.find('[id],[for]').each(function () {
                    var $this = jQuery(this);
                    var $id = $this.attr('id');
                    var $for = $this.attr('for');
                    if ($id) {
                        $this.attr('id', $id + '-' + $length);
                    }
                    if ($for) {
                        $this.attr('for', $for + '-' + $length);
                    }
                });
            });
        });
        {!! cdataClose() !!}
    </script>
@endsection
@section('page_content')
    <div class="row">
        <div class="col-xs-12">
            <form method="post" action="{{ currentURL() }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <h4 class="box-title">{{ trans('form.action_edit') }} {{ trans('pages.page_home_title') }} @ {{ trans('label.cover_picture') }}</h4>
                <div id="homepage-cover" class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        @foreach(allSupportedLocales() as $locale => $properties)
                            <li{!! $locale == $site_locale ? ' class="active"' : '' !!}>
                                <a href="#homepage-cover-tab-{{ $locale }}" data-toggle="tab">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                    @foreach(allSupportedLocales() as $locale => $properties)
                        <div class="tab-pane{{ $locale == $site_locale ? ' active' : '' }}" id="homepage-cover-tab-{{ $locale }}">
                            <input type="hidden" name="cover_picture_old[{{ $locale }}]" value="{{ $cover_picture[$locale] }}">
                            <div class="form-group">
                                <label for="inputCoverPicture">{{ trans('label.picture') }}</label>
                                <input id="inputCoverPicture" name="cover_picture[{{ $locale }}]" type="file">
                                <p class="help-block">{{ trans('label.max_upload_file_size', ['size' => $max_size]) }}</p>
                                @if(!empty($cover_picture[$locale]))
                                    <p><a href="{{ $cover_picture[$locale] }}">{{ $cover_picture[$locale] }}</a></p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="inputHeading-{{ $locale }}">{{ trans('label.heading') }}</label>
                                <input id="inputHeading-{{ $locale }}" class="form-control" name="cover_heading[{{ $locale }}]"
                                       type="text" value="{{ $cover_heading[$locale] }}">
                            </div>
                            <div class="form-group">
                                <label for="inputSubHeading-{{ $locale }}">{{ trans('label.subheading') }}</label>
                                <input id="inputSubHeading-{{ $locale }}" class="form-control" name="cover_subheading[{{ $locale }}]"
                                       type="text"  value="{{ $cover_subheading[$locale] }}">
                            </div>
                        </div>
                    @endforeach
                    </div><!-- /.tab-content -->
                </div><!-- nav-tabs-custom -->
                <div class="margin-bottom">
                    <button class="btn btn-primary" type="submit" name="pages" value="pages">{{ trans('form.action_save') }}</button>
                    <button class="btn btn-default" type="reset">{{ trans('form.action_reset') }}</button>
                    <a role="button" class="btn btn-warning pull-right" href="{{ localizedAdminURL('app-options') }}">{{ trans('form.action_cancel') }}</a>
                </div>
            </form>
            <form method="post" action="{{ currentURL() }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <h4 class="box-title">{{ trans('form.action_edit') }} {{ trans('pages.page_home_title') }} @ {{ trans('label.slideshow') }}</h4>
                <div id="homepage-slideshow" class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        @foreach(allSupportedLocales() as $locale => $properties)
                            <li{!! $locale == $site_locale ? ' class="active"' : '' !!}>
                                <a href="#homepage-slideshow-tab-{{ $locale }}" data-toggle="tab">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach(allSupportedLocales() as $locale => $properties)
                            <div class="tab-pane{{ $locale == $site_locale ? ' active' : '' }}" id="homepage-slideshow-tab-{{ $locale }}">
                                <h4>{{ trans('label.slideshow') }}</h4>
                                <div class="input-slides sortable">
                                @for($i = 0 ; $i < $max_slides[$locale] ; ++$i)
                                    <?php
                                    $picture = !empty($slide_picture[$locale][$i]) ? $slide_picture[$locale][$i] : '';
                                    $content = !empty($slide_content[$locale][$i]) ? $slide_content[$locale][$i] : '';
                                    ?>
                                    <div class="input-slide">
                                        <input type="hidden" name="slide_picture_old[{{ $locale }}][]" value="{{ $picture }}">
                                        <div>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-action="slide-remove"><i class="fa fa-close"></i></button>
                                                <button type="button" class="btn btn-box-tool" data-action="slide-sort-down"><i class="fa fa-chevron-down"></i></button>
                                                <button type="button" class="btn btn-box-tool" data-action="slide-sort-up"><i class="fa fa-chevron-up"></i></button>
                                            </div>
                                            <h5>{{ trans_choice('label.slide', 1) }} {{ $i+1 }}</h5>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputSlidePicture_{{ $locale }}_{{ $i }}">{{ trans('label.picture') }}</label>
                                            <input id="inputSlidePicture_{{ $locale }}_{{ $i }}" name="slide_picture[{{ $locale }}][]" type="file">
                                            <p class="help-block">{{ trans('label.max_upload_file_size', ['size' => $max_size]) }}</p>
                                            @if(!empty($picture))
                                                <p class="extra"><a href="{{ $picture }}">{{ $picture }}</a></p>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="inputSlideContent_{{ $locale }}_{{ $i }}">{{ trans('label.content') }}</label>
                                            <textarea id="inputSlideContent_{{ $locale }}_{{ $i }}" rows="5" class="form-control code-editor" name="slide_content[{{ $locale }}][]">{!! $content !!}</textarea>
                                        </div>
                                    </div>
                                @endfor
                                    <div class="input-slide">
                                        <input type="hidden" name="slide_picture_old[{{ $locale }}][]" value="">
                                        <div>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-action="sort-down"><i class="fa fa-chevron-down"></i></button>
                                                <button type="button" class="btn btn-box-tool" data-action="sort-up"><i class="fa fa-chevron-up"></i></button>
                                            </div>
                                            <h5>{{ trans_choice('label.slide', 1) }} {{ $max_slides[$locale]+1 }}</h5>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputSlidePicture-{{ $locale }}">{{ trans('label.picture') }}</label>
                                            <input id="inputSlidePicture-{{ $locale }}" name="slide_picture[{{ $locale }}][]" type="file">
                                            <p class="help-block">{{ trans('label.max_upload_file_size', ['size' => $max_size]) }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputSlideContent-{{ $locale }}">{{ trans('label.content') }}</label>
                                            <textarea id="inputSlideContent-{{ $locale }}" rows="5" class="form-control code-editor" name="slide_content[{{ $locale }}][]"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.tab-pane -->
                        @endforeach
                    </div><!-- /.tab-content -->
                </div><!-- nav-tabs-custom -->
                <div class="margin-bottom">
                    <button class="btn btn-primary" type="submit" name="trial" value="trial">{{ trans('form.action_save') }}</button>
                    <button class="btn btn-success add-more-slide" type="button">{{ trans('form.action_add_more') }}</button>
                    <button class="btn btn-default" type="reset">{{ trans('form.action_reset') }}</button>
                    <a role="button" class="btn btn-warning pull-right" href="{{ localizedAdminURL('app-options') }}">{{ trans('form.action_cancel') }}</a>
                </div>
            </form>
        </div>
        <!-- /.col -->
    </div>
@endsection