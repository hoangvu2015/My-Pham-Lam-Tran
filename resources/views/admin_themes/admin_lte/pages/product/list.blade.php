@extends('admin_themes.admin_lte.master.admin')
@section('page_title', 'Sản phẩm')
@section('page_description', 'Quản lý Sản phẩm')
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('product') }}">Sản phẩm</a></li>
    </ol>
@endsection
@section('extended_scripts')
    <script>
        {!! cdataOpen() !!}
        jQuery(document).ready(function(){
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
    <h1>SP</h1>
</div>
<!-- /.row -->
@endsection