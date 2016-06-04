@extends('admin_themes.admin_lte.master.admin')
@section('page_title', 'Danh sách email đăng ký')
@section('page_description', '')
@section('page_breadcrumb')
<ol class="breadcrumb">
	<li><a href="{{ adminHomeURL() }}">
		<i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}
	</a></li>
	<li><a href="">Email đăng ký</a></li>
</ol>
@endsection
@section('extended_scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.11/daterangepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="{{ libraryAsset('momentjs/locale/'.$site_locale.'.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.11/daterangepicker.min.js"></script>
<script>
	jQuery(document).ready(function () {
		jQuery('.datetimerangepicker').daterangepicker({
			timePicker: true,
			timePickerIncrement: 30,
			locale: {
				format: '{{ $datetime_js_format }}'
			},
			startDate: '{{ $start_date }}',
			endDate: '{{ $end_date }}'
		});

		jQuery('#email-subscribe-modal').on('hidden.bs.modal', function (e) {
			jQuery('#email-subscribe-holder')
			.html('<img src="{{ AdminTheme::imageAsset('ajax-loader.gif') }}">');
		});
	});
</script>
@endsection
@section('modals')
<div class="modal fade" id="email-subscribe-modal" tabindex="-1" role="dialog" aria-labelledby="request-modal-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="request-modal-label">{{ trans('pages.admin_external_learning_requests_title') }}</h4>
			</div>
			<div id="email-subscribe-holder" class="modal-body">
				<img src="{{ AdminTheme::imageAsset('ajax-loader.gif') }}">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('form.action_close') }}</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="export-modal" tabindex="-1" role="dialog" aria-labelledby="export-modal-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
				</button>
				<h4 class="modal-title" id="export-modal-label">
					{{ trans('form.action_export_to') }} Excel
				</h4>
			</div>
			<div class="modal-body">
				<form method="get" action="{{ $query->prepare()->update('advanced_export_excel', 1)->toString() }}">
					<input type="hidden" name="current_url" value="{{ $query->prepare()->toString() }}">
					<input type="hidden" name="advanced_export_excel" value="2">
					<div class="form-group">
						<label for="inputExportByDateRange">{{ trans('label.duration') }}</label>
						<input id="inputExportByDateRange" name="export_datetime_range" class="form-control datetimerangepicker" type="text">
					</div>
					<div class="form-group">
						<button class="btn btn-flat btn-success" type="submit">
							{{ trans('form.action_export') }} {{ trans('label.by_date_range') }}
						</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('form.action_close') }}</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('lib_styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.11/daterangepicker.min.css">
@endsection
@section('lib_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="{{ libraryAsset('momentjs/locale/'.$site_locale.'.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.11/daterangepicker.min.js"></script>
<script src="{{ libraryAsset('angular-daterangepicker.min.js') }}"></script>
@endsection
@section('page_content')
<div class="angular" ng-app="App">
	<div id="mod-subscribe">
		<!-- <div id="mod-subscribe" ng-controller="subscribeCtrl"> -->
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">
							Danh sách email đăng ký
						</h3>
						<div class="box-tools">
							<a role="button" class="btn btn-flat btn-success btn-sm" href="#" data-toggle="modal" data-target="#export-modal">
								{{ trans('form.action_export_to') }} Excel
							</a>
						</div>
					</div>
					<!-- <div class="box-body">
						<div class="row">
							<form method="get">
								<input type="hidden" name="page" value="{{ $page_helper->current }}">
								<div class="col-xs-3">
									<label for="inputDateTimeRange" class="sr-only">{{ trans('label.duration') }}</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
										<input id="inputDateTimeRange" name="datetime_range" class="form-control pull-right datetimerangepicker" type="text">
									</div>
								</div>
								<div class="col-xs-6"></div>
								<div class="col-xs-3">
									<button type="submit" class="btn btn-flat btn-primary">{{ trans('form.action_filter') }}</button>
									<a role="button" class="btn btn-flat btn-warning" href="{{ localizedAdminURL('subscribe') }}">
										{{ trans('form.action_filter_clear') }}
									</a>
								</div>
							</form>
						</div>
					</div> -->
					@if($email_subscribe_list->count()>0)
					<div class="box-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="order-col-2 text-center">#</th>
									<th class="order-col-1">ID</th>
									<th>Email</th>
									<th>Tên</th>
									<th>Số điện thoại</th>
									<th>User Id</th>
									<th>Được gửi</th>
								</tr>
							</thead>
							<tbody>
								<?php $count = 1; ?>
								@foreach($email_subscribe_list as $email_subscribe)
								<tr>
									<td class="text-center">
										<?php echo $count; $count++; ?>
									</td>
									<td>{{ $email_subscribe->id }}</td>
									<td>{{ $email_subscribe->email }}</td>
									<td>{{ $email_subscribe->name }}</td>
									<td>{{ $email_subscribe->phone }}</td>
									<td>{{ $email_subscribe->user_id }}</td>
									<td>{{ $email_subscribe->created_at }}</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th class="order-col-2 text-center">#</th>
									<th>ID</th>
									<th>Email</th>
									<th>Tên</th>
									<th>Số điện thoại</th>
									<th>User Id</th>
									<th>Được gửi</th>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="box-footer clearfix">
						<ul class="pagination pagination-sm no-margin pull-right">
							<li class="first">
								<a href="{{ $query->prepare()->update('page', $page_helper->first)->toString() }}">&laquo;</a>
							</li>
							<li class="prev{{ $page_helper->atFirst ? ' disabled':'' }}">
								<a href="{{ $query->prepare()->update('page', $page_helper->prev)->toString() }}">&lsaquo;</a>
							</li>
							@for($i=$page_helper->start;$i<=$page_helper->end;++$i)
							<li {!! $i==$page_helper->current ? ' class="active"':'' !!}>
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
					@endif
				</div>

			</div>
		</div>
	</div>
</div>


@endsection