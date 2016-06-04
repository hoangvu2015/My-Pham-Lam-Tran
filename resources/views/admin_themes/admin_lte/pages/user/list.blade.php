@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_users_title'))
@section('page_description', trans('pages.admin_users_desc'))
@section('page_breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
    <li><a href="{{ localizedAdminURL('users') }}">{{ trans('pages.admin_users_title') }}</a></li>
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
    <div class="col-md-12">
        <div class="margin-bottom">
            <a class="btn btn-primary" href="{{ localizedAdminURL('users/add') }}">{{ trans('form.action_add') }} {{ trans_choice('label.user_lc', 1) }}</a>
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
                <div class="row">
                    <form method="get">
                        <input type="hidden" name="page" value="{{ $page_helper->current }}">
                        <div class="col-xs-3">
                            <label for="searchNameEmailCc" class="sr-only">{{ trans('label.duration') }}</label>
                            <input id="searchNameEmailCc" name="searchNameEmailCc" placeholder="Search (Name,Email,Phone)" class="form-control pull-right" type="text" value="{{$searchNameEmailCc}}">
                        </div>
                        
                        <div class="col-xs-3">
                            <button type="submit" class="btn btn-flat btn-primary">{{ trans('form.action_filter') }}</button>
                            <a role="button" class="btn btn-flat btn-warning" href="{{ $users_query->prepare()->toString() }}">
                                {{ trans('form.action_filter_clear') }}
                            </a>
                        </div>
                    </form>
                </div>
                <br/>
                @if($users->count()>0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="order-col-2">#</th>
                            <th>ID</th>
                            <th>{{ trans('label.user_name') }}</th>
                            <th>{{ trans('label.phone') }}</th>
                            <th>{{ trans('label.email') }}</th>
                            <th>{{ trans('label.skype') }}</th>
                            <th>{{ trans_choice('label.role', 2) }}</th>
                            <th>{{ trans('form.action') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="order-col-2">#</th>
                            <th>ID</th>
                            <th>{{ trans('label.user_name') }}</th>
                            <th>{{ trans('label.phone') }}</th>
                            <th>{{ trans('label.email') }}</th>
                            <th>{{ trans('label.skype') }}</th>
                            <th>{{ trans_choice('label.role', 2) }}</th>
                            <th>{{ trans('form.action') }}</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="order-col-2">{{ ++$page_helper->startOrder }}</td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->skype }}</td>
                            <td>
                                {{ $user->roles->implode('display_name', ', ') }}
                            </td>
                            <td>
                                <a href="{{ localizedAdminURL('users/{id}/edit', ['id'=> $user->id]) }}">{{ trans('form.action_edit') }}</a>
                                <a class="delete" href="{{ localizedAdminURL('users/{id}/delete', ['id'=> $user->id])}}?{{ $rdr_param }}">
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
                        <a href="{{ $users_query->prepare()->update('page', $page_helper->first)->toString() }}">&laquo;</a>
                    </li>
                    <li class="prev{{ $page_helper->atFirst ? ' disabled':'' }}">
                        <a href="{{ $users_query->prepare()->update('page', $page_helper->prev)->toString()}}">&lsaquo;</a>
                    </li>
                    @for($i=$page_helper->start;$i<=$page_helper->end;++$i)
                    <li{!! $i==$page_helper->current ? ' class="active"':'' !!}>
                    <a href="{{ $users_query->prepare()->update('page', $i)->toString() }}">{{ $i }}</a>
                </li>
                @endfor
                <li class="next{{ $page_helper->atLast ? ' disabled':'' }}">
                    <a href="{{ $users_query->prepare()->update('page', $page_helper->next)->toString() }}">&rsaquo;</a>
                </li>
                <li class="last">
                    <a href="{{ $users_query->prepare()->update('page', $page_helper->last)->toString() }}">&raquo;</a>
                </li>
            </ul>
        </div>
        @else
        <div class="box-body">
            {{ trans('label.list_empty') }}
        </div>
        @endif
    </div><!-- /.box -->
    <div class="margin-bottom">
        <a class="btn btn-success" href="{{ localizedAdminURL('users/verifying-certificates') }}">
            {{ trans('pages.admin_verifying_certificates_title') }}
        </a>
    </div>
</div>
</div>
@endsection