@extends('admin_themes.admin_lte.master.admin')
@section('page_title', 'Danh mục')
@section('page_description', 'Quản lý Danh mục')
@section('page_breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
    <li><a href="{{ localizedAdminURL('category-product') }}">Danh mục</a></li>
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
        <div class="col-md-12">
            <div class="margin-bottom" style="margin-left:10px;">
                <a class="btn btn-primary" href="{{ localizedAdminURL('category-product/add') }}">{{ trans('form.action_add') }} category</a>
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
                    <h3 class="box-title">{{ trans('form.list_of', ['name' => trans_choice('label.user_lc', 2)]) }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <br/>
                    @if($category_pro->count()>0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="order-col-2">#</th>
                                <th>ID</th>
                                <th>name</th>
                                <th>code</th>
                                <th>created_at</th>
                                <th>updated_at</th>
                                <th>{{ trans('form.action') }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="order-col-2">#</th>
                                <th>ID</th>
                                <th>name</th>
                                <th>code</th>
                                <th>created_at</th>
                                <th>updated_at</th>
                                <th>{{ trans('form.action') }}</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($category_pro as $category)
                            <tr>
                                <td class="order-col-2">{{ ++$page_helper->startOrder }}</td>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->code }}</td>
                                <td>{{ $category->created_at }}</td>
                                <td>{{ $category->updated_at }}</td>
                                <td>
                                    <a href="{{ localizedAdminURL('category-product/{id}/edit', ['id'=> $category->id]) }}">{{ trans('form.action_edit') }}</a>
                                    <a class="delete" href="{{ localizedAdminURL('category-product/{id}/delete', ['id'=> $category->id])}}?{{ $rdr_param }}">
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
                            <a href="{{ $category_pro_query->prepare()->update('page', $page_helper->first)->toString() }}">&laquo;</a>
                        </li>
                        <li class="prev{{ $page_helper->atFirst ? ' disabled':'' }}">
                            <a href="{{ $category_pro_query->prepare()->update('page', $page_helper->prev)->toString()}}">&lsaquo;</a>
                        </li>
                        @for($i=$page_helper->start;$i<=$page_helper->end;++$i)
                        <li{!! $i==$page_helper->current ? ' class="active"':'' !!}>
                        <a href="{{ $category_pro_query->prepare()->update('page', $i)->toString() }}">{{ $i }}</a>
                    </li>
                    @endfor
                    <li class="next{{ $page_helper->atLast ? ' disabled':'' }}">
                        <a href="{{ $category_pro_query->prepare()->update('page', $page_helper->next)->toString() }}">&rsaquo;</a>
                    </li>
                    <li class="last">
                        <a href="{{ $category_pro_query->prepare()->update('page', $page_helper->last)->toString() }}">&raquo;</a>
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
@endsection