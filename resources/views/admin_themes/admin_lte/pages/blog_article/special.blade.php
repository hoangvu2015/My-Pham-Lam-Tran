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
                                @foreach($blog_articles as $blog_article)
                                    <?php
                                    $author = $blog_article->author;
                                    $is_author = $auth_user->id == $author->id;
                                    ?>
                                    <tr>
                                        <td class="order-col-2">{{ $blog_article->id }}</td>
                                        <td class="order-col-1">
                                            <a title="{{ trans_choice('label.link', 1) }} - ID" href="{{ localizedURL('blog/{id}', ['id' => $blog_article->id]) }}">
                                                <i class="fa fa-external-link"></i>
                                            </a>
                                        </td>
                                        <td class="order-col-1">
                                            <a title="{{ trans_choice('label.link', 1) }} - {{ trans('label.slug') }}" href="{{ localizedURL('blog/view/{slug}', ['slug' => $blog_article->slug]) }}">
                                                <i class="fa fa-external-link"></i>
                                            </a>
                                        </td>
                                        <td>
                                            {{ $blog_article->title }}
                                            ({{ $blog_article->translations->implode('locale', ', ') }})
                                        </td>
                                        <td>
                                            {{ $blog_article->categories->implode('name', ', ') }}
                                        </td>
                                        <td>
                                            {{ $blog_article->author->name }}
                                        </td>
                                        <td>
                                            <a href="{{ localizedAdminURL('blog/articles/{id}/edit', ['id'=> $blog_article->id]) }}">
                                                {{ trans('form.action_edit') }}
                                            </a>
                                            <a href="{{ localizedAdminURL('blog/articles') }}?special=true&remove=en&id={{ $blog_article->id }}">
                                                {{ trans('form.action_delete') }} EN
                                            </a>
                                            <a href="{{ localizedAdminURL('blog/articles') }}?special=true&remove=vi&id={{ $blog_article->id }}">
                                                {{ trans('form.action_delete') }} VI
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection