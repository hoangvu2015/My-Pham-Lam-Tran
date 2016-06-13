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
   <div class="row">
    <div class="row" style="margin-left: 0px;">
        <div class="col-md-12">
            <div class="margin-bottom" style="margin-left:10px;">
                <a class="btn btn-primary" href="{{ localizedAdminURL('product/add') }}">{{ trans('form.action_add') }} product</a>
            </div>
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('form.list_of', ['name' => 'products']) }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <br/>
                    @if($products->count()>0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="order-col-2">#</th>
                                <th>ID</th>
                                <th>Tên SP</th>
                                <th>Image1</th>
                                <!-- <th>content</th> -->
                                <th>CT</th>
                                <th>Xuất xứ</th>
                                <th>Giá</th>
                                <th>Giảm giá</th>
                                <th>view</th>
                                <th>Show</th>
                                <th>Special</th>
                                <th>Loại SP</th>
                                <th>{{ trans('form.action') }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="order-col-2">#</th>
                                <th>ID</th>
                                <th>Tên SP</th>
                                <th>Image1</th>
                                <!-- <th>content</th> -->
                                <th>CT</th>
                                <th>Xuất xứ</th>
                                <th>Giá</th>
                                <th>Giảm giá</th>
                                <th>view</th>
                                <th>Show</th>
                                <th>Special</th>
                                <th>Loại SP</th>
                                <th>{{ trans('form.action') }}</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td class="order-col-2">{{ ++$page_helper->startOrder }}</td>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td><img src="{{ $product->image1 }}" style="width:50px;height: 50px;" alt=""></td>
                                <!-- <td>{{ htmlShorten($product->content,100) }}</td> -->
                                <td>{{ $product->brand }}</td>
                                <td>{{ $product->origin }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->discount }}</td>
                                <td>{{ $product->view }}</td>
                                <td>{{ $product->status_show }}</td>
                                <td>{{ $product->status_type }}</td>
                                <td>{{ $product->categories->name }}</td>
                                <td>
                                    <a href="{{ localizedAdminURL('product/{id}/edit', ['id'=> $product->id]) }}">{{ trans('form.action_edit') }}</a>
                                    <a class="delete" href="{{ localizedAdminURL('product/{id}/delete', ['id'=> $product->id])}}?{{ $rdr_param }}">
                                        {{ trans('form.action_delete') }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li class="first">
                            <a href="{{ $products_query->prepare()->update('page', $page_helper->first)->toString() }}">&laquo;</a>
                        </li>
                        <li class="prev{{ $page_helper->atFirst ? ' disabled':'' }}">
                            <a href="{{ $products_query->prepare()->update('page', $page_helper->prev)->toString()}}">&lsaquo;</a>
                        </li>
                        @for($i=$page_helper->start;$i<=$page_helper->end;++$i)
                        <li{!! $i==$page_helper->current ? ' class="active"':'' !!}>
                        <a href="{{ $products_query->prepare()->update('page', $i)->toString() }}">{{ $i }}</a>
                    </li>
                    @endfor
                    <li class="next{{ $page_helper->atLast ? ' disabled':'' }}">
                        <a href="{{ $products_query->prepare()->update('page', $page_helper->next)->toString() }}">&rsaquo;</a>
                    </li>
                    <li class="last">
                        <a href="{{ $products_query->prepare()->update('page', $page_helper->last)->toString() }}">&raquo;</a>
                    </li>
                </ul>
            </div>
            @else
            <div class="box-body">
                {{ trans('label.list_empty') }}
            </div>
            @endif
        </div><!-- /.box -->
    </div>
</div>
</div>
<!-- /.row -->
</div>
<!-- /.row -->
@endsection