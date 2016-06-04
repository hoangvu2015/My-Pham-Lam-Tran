@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_dashboard_title'))
@section('page_description', trans('pages.admin_dashboard_desc'))
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
    </ol>
@endsection
@section('page_content')
    <div>
        <ul class="list-inline">
            @if($auth_user->hasRole('learning-manager'))
                <li>
                    <div class="small-box bg-black">
                        <ul class="inner list-inline text-center">
                            <li class="label label-default">
                                <p>{{ trans('label.status_newly') }}</p>
                                <h3>{{ $newly_external_lrs }}</h3>
                            </li>
                            <li class="label label-success">
                                <p>{{ trans('label.status_processed') }}</p>
                                <h3>{{ $processed_external_lrs }}</h3>
                            </li>
                        </ul>
                        <a href="{{ localizedAdminURL('external-learning-requests')}}" class="small-box-footer">
                            {{ trans('pages.admin_external_learning_requests_title') }}
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </li>
                <li>
                    <div class="small-box bg-black">
                        <ul class="inner list-inline text-center">
                            <li class="label label-default">
                                <p>{{ trans('label.status_created') }}</p>
                                <h3>{{ $newly_teachers }}</h3>
                            </li>
                            <li class="label label-warning">
                                <p>{{ trans('label.status_requested') }}</p>
                                <h3>{{ $becoming_teachers }}</h3>
                            </li>
                            <li class="label label-success">
                                <p>{{ trans('label.status_approved') }}</p>
                                <h3>{{ $approved_teachers }}</h3>
                            </li>
                            <li class="label label-info">
                                <p>{{ trans('label.status_verified') }}</p>
                                <h3>{{ $verified_teachers }}</h3>
                            </li>
                            <li class="label label-danger">
                                <p>{{ trans('label.status_rejected') }}</p>
                                <h3>{{ $rejected_teachers }}</h3>
                            </li>
                        </ul>
                        <a href="{{ localizedAdminURL('teachers')}}" class="small-box-footer">
                            {{ trans('pages.admin_teachers_title') }}
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </li>
            @endif
            @if($auth_user->hasRole('learning-editor'))
                <li>
                    <div class="small-box bg-black">
                        <ul class="inner list-inline text-center">
                            <li class="label label-success">
                                <p>{{ trans('label.quantity') }}</p>
                                <h3>{{ $topics }}</h3>
                            </li>
                        </ul>
                        <a href="{{ localizedAdminURL('topics')}}" class="small-box-footer">
                            {{ trans('pages.admin_topics_title') }}
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </li>
            @endif
            @if($auth_user->hasRole('blog-editor'))
                <li>
                    <div class="small-box bg-black">
                        <ul class="inner list-inline text-center">
                            <li class="label label-success">
                                <p>{{ trans('label.status_published') }}</p>
                                <h3>{{ $published_blog_articles }}</h3>
                            </li>
                            <li class="label label-warning">
                                <p>{{ trans('label.status_requested') }}</p>
                                <h3>{{ $requested_blog_articles }}</h3>
                            </li>
                        </ul>
                        <a href="{{ localizedAdminURL('blog/articles')}}" class="small-box-footer">
                            {{ trans('pages.admin_blog_articles_title') }}
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </li>
            @endif
        </ul>
    </div>
@endsection