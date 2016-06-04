@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_blog_categories_title'))
@section('page_description', trans('pages.admin_blog_categories_desc'))
@section('page_breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
    <li><a href="{{ localizedAdminURL('blog/categories') }}">{{ trans('pages.admin_blog_categories_title') }}</a></li>
</ol>
@endsection
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
                    jQuery('[name^="name"]').each(function () {
                        var $this = jQuery(this);
                        $this.registerSlugTo($this.closest('.tab-pane').find('[name^="slug"]'));
                    });
                    var $slug = jQuery('.slug');
                    $slug.registerSlug();
                    jQuery('form.check-slug').on('submit', function () {
                        var vals = [];
                        var unique = true;
                        $slug.each(function () {
                            var val = $(this).val();
                            if (vals.indexOf(val) != -1) {
                                unique = false;
                            }
                            else {
                                vals.push(val);
                            }
                        });
                        if (!unique) {
                            x_alert('{{ trans('validation.unique', ['attribute' => 'slug']) }}');
                            return false;
                        }
                    });
                    jQuery('a.delete').off('click').on('click', function (e) {
                        e.preventDefault();

                        var $this = jQuery(this);

                        x_confirm('{{ trans('form.action_delete') }}', '{{ trans('label.wanna_delete', ['name' => '']) }}', function () {
                            window.location.href = $this.attr('href');
                        });

                        return false;
                    });
                });
        {!! cdataClose() !!}
    </script>
@endsection
@section('modals')
    @include('admin_themes.admin_lte.master.common_modals')
@endsection
@section('page_content')
<div class="row">
    <form class="check-slug" method="post" action="{{ localizedAdminURL('blog/categories/update')}}">
        {!! csrf_field() !!}
        <input type="hidden" name="id" value="{{ $current_category->id }}">
        <div class="col-xs-12">
            <div class="margin-bottom">
                <a class="btn btn-primary" href="{{ localizedAdminURL('blog/categories/add') }}">
                    {{ trans('form.action_add') }} {{ trans_choice('label.category_lc', 1) }}
                </a>
                <a class="btn btn-warning delete" href="{{ localizedAdminURL('blog/categories/{id}/delete', ['id'=> $current_category->id]) }}">
                    {{ trans('form.action_delete') }}
                </a>
            </div>
            <h4 class="box-title">{{ trans('form.action_edit') }} {{ trans_choice('label.category_lc', 1) }}</h4>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label for="inputParentId">{{ trans('label.category_parent') }}</label>
                        <select id="inputParentId" class="form-control select2" name="parent" style="width: 100%;"
                                data-placeholder="{{ trans('form.action_select') }} {{ trans('label.category_parent') }}">
                            <option value="0">[{{ trans('label.not_set') }}]</option>
                        @foreach($categories as $category)
                            @if($category->id!=$current_category->id)
                                <option value="{{ $category->id }}"{{ $category->id==$current_category->parent_id ? ' selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endif
                        @endforeach
                        </select>
                    </div>
                </div>
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
                        <?php
                        $trans = $current_category->translate($locale);
                        $name = $trans ? $trans->name : '';
                        $slug = $trans ? $trans->slug : '';
                        $desc = $trans ? $trans->description : '';
                        ?>
                        <div class="tab-pane{{ $locale == $site_locale ? ' active' : '' }}" id="tab_{{ $locale }}">
                            <div class="form-group">
                                <label for="inputName_{{ $locale }}">{{ trans('label.name') }}</label>
                                <input class="form-control" id="inputName_{{ $locale }}" name="name[{{ $locale }}]" placeholder="{{ trans('label.name') }}" type="text" value="{{ $name }}">
                            </div>
                            <div class="form-group">
                                <label for="inputSlug_{{ $locale }}">{{ trans('label.slug') }}</label>
                                <input class="form-control slug" id="inputSlug_{{ $locale }}" name="slug[{{ $locale }}]" placeholder="{{ trans('label.slug') }}" type="text" value="{{ $slug }}">
                            </div>
                            <div class="form-group">
                                <label for="inputDesc_{{ $locale }}">{{ trans('label.description') }}</label>
                                <input class="form-control desc" id="inputDesc_{{ $locale }}" name="desc[{{ $locale }}]"
                                placeholder="{{ trans('label.description') }}" type="text" value="{{$desc}}">
                            </div>
                        </div><!-- /.tab-pane -->
                    @endforeach
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
            <div>
                <button class="btn btn-primary" type="submit">{{ trans('form.action_save') }}</button>
                <button class="btn btn-default" type="reset">{{ trans('form.action_reset') }}</button>
                <a role="button" class="btn btn-warning pull-right" href="{{ localizedAdminURL('blog/categories') }}">{{ trans('form.action_cancel') }}</a>
            </div>
        </div>
    </form>
</div>
@endsection