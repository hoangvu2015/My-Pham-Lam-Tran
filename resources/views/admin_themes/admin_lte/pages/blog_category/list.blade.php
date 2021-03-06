@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_blog_categories_title'))
@section('page_description', trans('pages.admin_blog_categories_desc'))
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('blog/categories') }}">{{ trans('pages.admin_blog_categories_title') }}</a></li>
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
    <div class="col-xs-12">
        <div class="margin-bottom">
            <a class="btn btn-primary" href="{{ localizedAdminURL('blog/categories/add') }}">
                {{ trans('form.action_add') }} {{ trans_choice('label.category_lc', 1) }}
            </a>
        </div>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('form.list_of',['name'=>trans('pages.admin_blog_categories_title')]) }}</h3>
            </div><!-- /.box-header -->
        @if($categories->count()>0)
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="order-col-2">#</th>
                            <th class="order-col-1"></th>
                            <th class="order-col-1"></th>
                            <th>{{ trans('label.name') }}</th>
                            <th>{{ trans('label.slug') }}</th>
                            <th>{{ trans('label.category_parent') }}</th>
                            <th>{{ trans('form.action') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="order-col-2">#</th>
                            <th class="order-col-1"></th>
                            <th class="order-col-1"></th>
                            <th>{{ trans('label.name') }}</th>
                            <th>{{ trans('label.slug') }}</th>
                            <th>{{ trans('label.category_parent') }}</th>
                            <th>{{ trans('form.action') }}</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach($categories as $category)
                        <?php
                        $parent=$category->parent;
                        ?>
                        <tr>
                            <td class="order-col-2">{{ ++$page_helper->startOrder }}</td>
                            <td class="order-col-1">
                                <a title="{{ trans_choice('label.link', 1) }} - ID" href="{{ localizedURL('blog/category/{id}', ['id' => $category->id]) }}">
                                    <i class="fa fa-external-link"></i>
                                </a>
                            </td>
                            <td class="order-col-1">
                                <a title="{{ trans_choice('label.link', 1) }} - {{ trans('label.slug') }}" href="{{ localizedURL('blog/category/view/{slug}', ['slug' => $category->slug]) }}">
                                    <i class="fa fa-external-link"></i>
                                </a>
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ empty($parent) ? '' : $parent->name }}</td>
                            <td>
                                <a href="{{ localizedAdminURL('blog/categories/{id}/edit', ['id'=> $category->id]) }}">
                                    {{ trans('form.action_edit') }}
                                </a>
                                <a class="delete" href="{{ localizedAdminURL('blog/categories/{id}/delete', ['id'=> $category->id]) }}?{{ $rdr_param }}">
                                    {{ trans('form.action_delete') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                     </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <ul class="pagination pagination-sm no-margin pull-right">
                    <li class="first">
                        <a href="{{ $query->prepare()->update('page', $page_helper->first)->toString() }}">&laquo;</a>
                    </li>
                    <li class="prev{{ $page_helper->atFirst ? ' disabled':'' }}">
                        <a href="{{ $query->prepare()->update('page', $page_helper->prev)->toString() }}">&lsaquo;</a>
                    </li>
                    @for($i=$page_helper->start;$i<=$page_helper->end;++$i)
                        <li{!! $i==$page_helper->current ? ' class="active"':'' !!}>
                            <a href="{{ $query->prepare()->update('page', $i)->toString() }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="next{{ $page_helper->atLast ? ' disabled':'' }}">
                        <a href="{{ $query->prepare()->update('page', $page_helper->next)->toString() }}">&rsaquo;</a>
                    </li>
                    <li class="last">
                        <a href="{{ $query->prepare()->update('page', $page_helper->last)->toString() }}">&raquo;</a>
                    </li>
                </ul>
            </div>
        @else
            <div class="box-body">
                {{ trans('label.list_empty') }}
            </div>
        @endif
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection