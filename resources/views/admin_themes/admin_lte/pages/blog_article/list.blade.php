@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_blog_articles_title'))
@section('page_description', trans('pages.admin_blog_articles_desc'))
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i>
         {{ trans('pages.page_home_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('blog/articles') }}">
        {{ trans('pages.admin_blog_articles_title') }}</a></li>
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
            <a class="btn btn-primary" href="{{ localizedAdminURL('blog/articles/add') }}">
            {{ trans('form.action_add') }} {{ trans_choice('label.blog_article_lc', 1) }}</a>
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
                <h3 class="box-title">{{ trans('form.list_of',['name'=>trans('pages.admin_blog_articles_title')]) }}</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <form method="get">
                    <input type="hidden" name="page" value="{{ $page_helper->current }}">
                    <div class="row">
                        <div class="col-sm-4 col-md-3">
                            <div class="form-group">
                                <label for="inputStatus">{{ trans('label.status') }}</label>
                                <select id="inputStatus" class="form-control" name="filtered_status">
                                    <option value=""></option>
                                    <option value="{{ $status_published }}"{{ $filtered_status == (string)$status_published ? ' selected' : '' }}>
                                        {{ trans('label.status_published') }}
                                    </option>
                                    <option value="{{ $status_requested }}"{{ $filtered_status == (string)$status_requested ? ' selected' : '' }}>
                                        {{ trans('label.status_requested') }}
                                    </option>
                                    <option value="{{ $status_draft }}"{{ $filtered_status == (string)$status_draft ? ' selected' : '' }}>
                                        {{ trans('label.status_draft') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label><br>
                                <button type="submit" class="btn btn-flat btn-primary">{{ trans('form.action_filter') }}</button>
                                <a role="button" class="btn btn-flat btn-warning" href="{{ $query->prepare()->update('filtered_status', null)->toString() }}">
                                    {{ trans('form.action_filter_clear') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @if($blog_articles->count()>0)
            <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="order-col-2">#</th>
                        <th class="order-col-1"></th>
                        <th class="order-col-1"></th>
                        <th>{{ trans('label.title') }}</th>
                        <th>{{ trans('label.category') }}</th>
                        <th>{{ trans('label.author') }}</th>
                        <th>{{ trans('label.status') }}</th>
                        <th>{{ trans('form.action') }}</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="order-col-2">#</th>
                        <th class="order-col-1"></th>
                        <th class="order-col-1"></th>
                        <th>{{ trans('label.title') }}</th>
                        <th>{{ trans('label.category') }}</th>
                        <th>{{ trans('label.author') }}</th>
                        <th>{{ trans('label.status') }}</th>
                        <th>{{ trans('form.action') }}</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($blog_articles as $blog_article)
                        <?php
                        $trans = $blog_article->translate($international_locale);
                        $author = $blog_article->author;
                        $is_author = $auth_user->id == $author->id;
                        $status_text = '';
                        switch ($blog_article->status) {
                            case $status_draft:
                                $status_text = '<span class="label label-default">'. trans('label.status_draft') . '</span>';
                                break;
                            case $status_requested:
                                $status_text = '<span class="label label-warning">'.trans('label.status_requested'). '</span>';
                                break;
                            case $status_rejected:
                                $status_text = '<span class="label label-danger">'.trans('label.status_rejected'). '</span>';
                                break;
                            case $status_published:
                                $status_text = '<span class="label label-success">'. trans('label.status_published') . '</span>';
                                break;
                        }
                        ?>
                        <tr>
                            <td class="order-col-2">{{ ++$page_helper->startOrder }}</td>
                            <td class="order-col-1">
                                <a title="{{ trans_choice('label.link', 1) }} - ID" href="{{ localizedURL('blog/{id}', ['id' => $blog_article->id]) }}">
                                    <i class="fa fa-external-link"></i>
                                </a>
                            </td>
                            <td class="order-col-1">
                                <a title="{{ trans_choice('label.link', 1) }} - {{ trans('label.slug') }}" href="{{ localizedURL('blog/view/{id}-{slug}', ['id' => $trans->id,'slug' => $trans->slug]) }}">
                                    <i class="fa fa-external-link"></i>
                                </a>
                            </td>
                            <td>
                                {{ $trans->title }}
                            </td>
                            <td>
                                {{ $blog_article->categories->implode('name', ', ') }}
                            </td>
                            <td>
                                {{ $blog_article->author->name }}
                            </td>
                            <td>{!! $status_text !!}</td>
                            <td>
                                <a href="{{ localizedAdminURL('blog/articles/{id}/edit', ['id'=> $blog_article->id]) }}">
                                    {{ trans('form.action_edit') }}
                                </a>
                                @if($is_author)
                                    <a class="delete" href="{{ localizedAdminURL('blog/articles/{id}/delete', ['id'=> $blog_article->id]) }}?{{ $rdr_param }}">
                                        {{ trans('form.action_delete') }}
                                    </a>
                                @endif
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