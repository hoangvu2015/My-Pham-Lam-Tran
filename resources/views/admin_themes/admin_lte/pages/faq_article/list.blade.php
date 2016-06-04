@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_faq_articles_title'))
@section('page_description', trans('pages.admin_faq_articles_desc'))
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i>
         {{ trans('pages.page_home_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('faq/articles') }}">
        {{ trans('pages.admin_faq_articles_title') }}</a></li>
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
            <a class="btn btn-primary" href="{{ localizedAdminURL('faq/articles/add') }}">
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
                <h3 class="box-title">{{ trans('form.list_of',['name'=>trans('pages.admin_faq_articles_title')]) }}</h3>
            </div><!-- /.box-header -->

        @if($faq_articles->count()>0)
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
                        <th>{{ trans('form.action') }}</th>
                    </tr>
                </tfoot>
                <tbody>
                @foreach($faq_articles as $faq_article)
                    <tr>
                        <td class="order-col-2">{{ ++$page_helper->startOrder }}</td>
                        <td class="order-col-1">
                            <a title="{{ trans_choice('label.link', 1) }} - ID" href="{{ localizedURL('faq/{id?}', ['id' => $faq_article->id]) }}">
                                <i class="fa fa-external-link"></i>
                            </a>
                        </td>
                        <td class="order-col-1">
                            <a title="{{ trans_choice('label.link', 1) }} - {{ trans('label.slug') }}" href="{{ localizedURL('faq/view/{slug?}', ['slug' => $faq_article->slug]) }}">
                                <i class="fa fa-external-link"></i>
                            </a>
                        </td>
                        <td>
                            {{ $faq_article->title }}
                        </td>
                        <td>
                            {{ $faq_article->categories->implode('name', ', ') }}
                        </td>
                        <td>
                            {{ $faq_article->author->name }}
                        </td>
                        <td>
                            <a href="{{ localizedAdminURL('faq/articles/{id}/edit', ['id'=> $faq_article->id]) }}">
                                {{ trans('form.action_edit') }}
                            </a>
                            <a class="delete" href="{{ localizedAdminURL('faq/articles/{id}/delete', ['id'=> $faq_article->id]) }}?{{ $rdr_param }}">
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