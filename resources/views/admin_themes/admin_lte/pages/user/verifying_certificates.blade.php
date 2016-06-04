@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_verifying_certificates_title'))
@section('page_description', trans('pages.admin_verifying_certificates_desc'))
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('users') }}">{{ trans('pages.admin_users_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('users/verifying-certificates') }}">{{ trans('pages.admin_verifying_certificates_title') }}</a></li>
    </ol>
@endsection
@section('extended_scripts')
    <script>
        jQuery(document).ready(function(){
            jQuery('a.verify').off('click').on('click', function (e) {
                e.preventDefault();

                var $this = jQuery(this);

                x_confirm('{{ trans('form.action_verify') }}', '{{ trans('label.wanna_verify', ['name' => '']) }}', function () {
                    window.location.href = $this.attr('href');
                });

                return false;
            });
        })
    </script>
@endsection
@section('modals')
    @include('admin_themes.admin_lte.master.common_modals')
@endsection
@section('page_content')
    <div class="row">
        <div class="col-md-12">
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
                @if($certificates->count()>0)
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="order-col-2">#</th>
                                <th>{{ trans('label.user_name') }}</th>
                                <th>{{ trans('label.name') }}</th>
                                <th>{{ trans('label.source_url') }}</th>
                                <th>{{ trans('label.picture') }} 1</th>
                                <th>{{ trans('label.picture') }} 2</th>
                                <th>{{ trans('form.action') }}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th class="order-col-2">#</th>
                                <th>{{ trans('label.user_name') }}</th>
                                <th>{{ trans('label.name') }}</th>
                                <th>{{ trans('label.source_url') }}</th>
                                <th>{{ trans('label.picture') }} 1</th>
                                <th>{{ trans('label.picture') }} 2</th>
                                <th>{{ trans('form.action') }}</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($certificates as $certificate)
                                <?php
                                $user=$certificate->user;
                                ?>
                                <tr>
                                    <td class="order-col-2">{{ ++$page_helper->startOrder }}</td>
                                @if($user->hasRole('teacher'))
                                    <td>
                                        <a href="{{ localizedURL('teacher/{id?}', ['id' => $user->teacherProfile->id]) }}">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                @else
                                    <td>{{ $user->name }}</td>
                                @endif
                                    <td>{{ $certificate->name }}</td>
                                @if(empty($certificate->source))
                                    <td></td>
                                @else
                                    <td>
                                        <a href="{{ $certificate->source }}"><i class="fa fa-external-link"></i></a>
                                    </td>
                                @endif
                                    <td>
                                        <a href="{{ $certificate->verified_image_1 }}"><i class="fa fa-photo"></i></a>
                                    </td>
                                @if(empty($certificate->verified_image_2))
                                    <td></td>
                                @else
                                    <td>
                                        <a href="{{ $certificate->verified_image_2 }}"><i class="fa fa-photo"></i></a>
                                    </td>
                                @endif
                                    <td>
                                        <a class="verify" href="{{ localizedAdminURL('users/verifying-certificates/{id}/verify', ['id'=> $certificate->id])}}?{{ $rdr_param }}">
                                            {{ trans('form.action_verify') }}
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
                                <a href="{{ $query->prepare()->update('page', $page_helper->first)->toString() }}">&laquo;</a>
                            </li>
                            <li class="prev{{ $page_helper->atFirst ? ' disabled':'' }}">
                                <a href="{{ $query->prepare()->update('page', $page_helper->prev)->toString()}}">&lsaquo;</a>
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