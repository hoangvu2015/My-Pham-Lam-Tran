@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_link_categories_title'))
@section('page_description', trans('pages.admin_link_categories_desc'))
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminHomeURL() }}"><i class="fa fa-dashboard"></i> {{ trans('pages.page_home_title') }}</a></li>
        <li><a href="{{ localizedAdminURL('link/categories') }}">{{ trans('pages.admin_link_categories_title') }}</a></li>
    </ol>
@endsection
@section('extended_scripts')
    <script>
        {!! cdataOpen() !!}
                jQuery(document).ready(function(){
                    jQuery('.sortable').sortable({
                        placeholder: 'sort-highlight',
                        handle: '.handle',
                        forcePlaceholderSize: true,
                        zIndex: 999999,
                        update: function (e, ui) {
                            var items = [];
                            var self = jQuery(this);
                            self.children().each(function () {
                                items.push(jQuery(this).attr('data-item'));
                            });
                            jQuery.post('{{ url('api/v1/link/items/updateOrder') }}', {
                                _token: '{{ csrf_token() }}',
                                category: self.attr('data-category'),
                                items: items
                            }).done(function (data) {
                                if (data.success) {
                                    console.log('success');
                                }
                                else {
                                    console.log('fail');
                                }
                            }).fail(function () {
                                console.log('fail');
                            });
                        }
                    });
                    jQuery('a.delete').off('click').on('click', function (e) {
                        e.preventDefault();

                        var $this = $(this);

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
        <div class="col-md-6">
            <div class="margin-bottom">
                <a class="btn btn-primary" href="{{ localizedAdminURL('link/categories/add') }}">
                    {{ trans('form.action_add') }} {{ trans_choice('label.link_category_lc', 1) }}
                </a>
                <a class="btn btn-warning delete" href="{{ localizedAdminURL('link/categories/{id}/delete', ['id'=> $category->id]) }}">
                    {{ trans('form.action_delete') }}
                </a>
                <a class="btn btn-primary" href="{{ localizedAdminURL('link/categories/{id}/edit', ['id'=> $category->id]) }}">
                    {{ trans('form.action_edit') }}
                </a>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('form.action_sort') }} {{ trans_choice('label.link_category_lc', 1) }} - <em>{{ $category->name }}</em></h3>
                </div>
                <div class="box-body">
                    <ul class="todo-list sortable" data-category="{{ $category->id }}">
                    @foreach($items as $item)
                        <li data-item="{{ $item->id }}">
                            <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                            </span>
                            <span class="text"><a href="{{ $item->link }}">{{ $item->name }}</a></span>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection