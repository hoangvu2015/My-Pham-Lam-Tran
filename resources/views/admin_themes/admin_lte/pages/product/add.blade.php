@extends('admin_themes.admin_lte.master.admin')
@section('page_title', 'Danh mục')
@section('page_description', 'Quản lý Sản phẩm')
@section('page_breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
    <li><a href="{{ localizedAdminURL('category-product') }}">Sản phẩm</a></li>
</ol>
@endsection
@section('lib_styles')
<link rel="stylesheet" href="{{ libraryAsset('select2/css/select2.min.css') }}">
@endsection
@section('extended_scripts')
@include('file_manager.open_documents_script')
<script>
    {!! cdataOpen() !!}
    jQuery(document).ready(function () {
        jQuery('.select2').select2();
        jQuery('.ck-editor').ckeditor({
            language : '{{ $site_locale }}',
            filebrowserBrowseUrl : '{{ localizedURL('documents/for/ckeditor') }}',
            filebrowserFlashBrowseUrl : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=flash',
            filebrowserFlashUploadUrl  : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=flash',
            filebrowserImageBrowseLinkUrl : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=images',
            filebrowserImageBrowseUrl : '{{ localizedURL('documents/for/ckeditor') }}?custom_type=images',
            customConfig : '{{ libraryAsset('ckeditor/config_article.js') }}'
        });
    });
    {!! cdataClose() !!}
</script>
@endsection
@section('lib_scripts')
<script src="{{ libraryAsset('select2/js/select2.min.js') }}"></script>
<script src="{{ libraryAsset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ libraryAsset('ckeditor/adapters/jquery.js') }}"></script>
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
                        <label for="inputName" class="required">Tên SP</label>
                        <input class="form-control" id="inputName" name="name" maxlength="255" placeholder="Tên Loại" type="text" required value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="required">Giá</label>
                        <input class="form-control" id="inputEmail" name="price" maxlength="255" placeholder="Giá" type="number" value="{{ old('price') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Disconut </label>
                        <input class="form-control" id="inputEmail" name="discount" maxlength="255" placeholder="Disconut" type="number" value="{{ old('discount') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Nơi SX</label>
                        <input class="form-control" id="inputEmail" name="brand" maxlength="255" placeholder="Nơi SX" type="text" value="{{ old('brand') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Xuất xứ</label>
                        <input class="form-control" id="inputEmail" name="origin" maxlength="255" placeholder="Xuất xứ" type="text" value="{{ old('origin') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputImage1" class="required">{{ trans('label.picture') }} 1</label>
                        <input class="form-control image-from-documents" id="inputImage1" name="image1" placeholder="{{ trans('label.picture') }}" type="text" value="{{ old('image1') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="inputImage2">{{ trans('label.picture') }} 2</label>
                        <input class="form-control image-from-documents" id="inputImage2" name="image2" placeholder="{{ trans('label.picture') }}" type="text" value="{{ old('image2') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputImage3">{{ trans('label.picture') }} 3</label>
                        <input class="form-control image-from-documents" id="inputImage3" name="image3" placeholder="{{ trans('label.picture') }}" type="text" value="{{ old('image3') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputImage4">{{ trans('label.picture') }} 4</label>
                        <input class="form-control image-from-documents" id="inputImage4" name="image4" placeholder="{{ trans('label.picture') }}" type="text" value="{{ old('image4') }}">
                    </div>
                    <div class="form-group">
                        <label for="inputContent">Mô tả</label>
                        <textarea rows="10" class="form-control ck-editor" id="inputContent" name="des" placeholder="{{ trans('label.description') }}">{{ old('des') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputContent">Nội dung</label>
                        <textarea rows="10" class="form-control ck-editor" id="inputContent" name="content" placeholder="{{ trans('label.content') }}">{{ old('content') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Trạng thái hiển thị</label>
                        <select id="inputCategories" class="form-control" name="status_show" required>
                            <option value="0"{{ old('status_show') == 0 ? ' selected' : '' }}>Không show</option>
                            <option value="1"{{ old('status_show') == 1 ? ' selected' : '' }}>Show</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Trạng thái mục SP</label>
                        <select id="inputCategories" class="form-control" name="status_type" required>
                            <option value="0">Chọn mục đặc biệt</option>
                            <option value="1"{{ old('status_type') == 1 ? ' selected' : '' }}>Sản phẩm mới</option>
                            <option value="2"{{ old('status_type') == 2 ? ' selected' : '' }}>Sản phẩm bán chạy</option>
                            <option value="3"{{ old('status_type') == 3 ? ' selected' : '' }}>Sản phẩm khuyến mãi</option>
                            <option value="4"{{ old('status_type') == 4 ? ' selected' : '' }}>Sản phẩm phổ biến</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputCategories" class="required">{{ trans_choice('label.category', 2) }}</label>
                        <select id="inputCategories" class="form-control select2" name="category_id" required data-placeholder="{{ trans('form.action_select') }} {{ trans_choice('label.category', 2) }}" style="width: 100%;">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"{{ old('category_id') == $category->id ? ' selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">View </label>
                        <input class="form-control" id="inputEmail" name="view" placeholder="view" type="number" value="{{ old('disconut') }}">
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary" type="submit">{{ trans('form.action_add') }}</button>
                    <button class="btn btn-default" type="reset">{{ trans('form.action_reset') }}</button>
                    <a role="button" class="btn btn-warning pull-right" href="{{ localizedAdminURL('product') }}">{{ trans('form.action_cancel') }}</a>
                </div>
            </form>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
@endsection