@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_roles_title'))
@section('page_description', trans('pages.admin_roles_desc'))
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('roles') }}">{{ trans('pages.admin_roles_title') }}</a></li>
    </ol>
@endsection
@section('page_content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List of roles</h3>
            </div><!-- /.box-header -->
        @if($roles->count()>0)
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="order-col-1">#</th>
                            <th>{{ trans('label.name') }}</th>
                            <th>{{ trans('label.display_name') }}</th>
                            <th>{{ trans_choice('label.permission', 2) }}</th>
                            <th>{{ trans('label.description') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="order-col-1">#</th>
                            <th>{{ trans('label.name') }}</th>
                            <th>{{ trans('label.display_name') }}</th>
                            <th>{{ trans_choice('label.permission', 2) }}</th>
                            <th>{{ trans('label.description') }}</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td class="order-col-1">{{ ++$page_helper->startOrder }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->display_name }}</td>
                            <td>{{ $role->perms->implode('display_name', ', ') }}</td>
                            <td>{{ $role->description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
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
        </div><!-- /.box -->
    </div>
</div>
@endsection