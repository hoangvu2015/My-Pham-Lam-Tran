@extends('admin_themes.admin_lte.master.admin')
@section('page_title', 'Danh mục')
@section('page_description', 'Quản lý Danh mục')
@section('page_breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
    <li><a href="{{ localizedAdminURL('category-product') }}">Danh mục</a></li>
</ol>
@endsection
@section('lib_styles')
@endsection
@section('extended_styles')
@endsection
@section('lib_scripts')
@endsection
@section('page_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm danh mục</h3>
            </div>
            <form method="post">
                {!! csrf_field() !!}
                <div class="box-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input class="form-control" id="inputName" name="name" maxlength="255" placeholder="Tên Loại" type="text" required value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">code</label>
                        <input class="form-control" id="inputEmail" name="code" maxlength="255" placeholder="code" type="text" value="{{ old('code') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Mô tả</label>
                        <input class="form-control" id="inputEmail" name="des" maxlength="255" placeholder="Mô tả" type="text" value="{{ old('des') }}">
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary" type="submit">{{ trans('form.action_add') }}</button>
                    <button class="btn btn-default" type="reset">{{ trans('form.action_reset') }}</button>
                    <a role="button" class="btn btn-warning pull-right" href="{{ localizedAdminURL('category-product') }}">{{ trans('form.action_cancel') }}</a>
                </div>
            </form>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
@endsection