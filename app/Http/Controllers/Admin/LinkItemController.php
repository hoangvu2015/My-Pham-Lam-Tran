<?php

namespace Antoree\Http\Controllers\Admin;

use Antoree\Models\BlogCategory;
use Antoree\Models\LinkItem;
use Illuminate\Http\Request;
use Antoree\Http\Requests;
use Antoree\Http\Controllers\Controller;
use Antoree\Http\Controllers\MultipleLocaleContentController;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\PaginationHelper;
use Antoree\Models\Helpers\QueryStringBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LinkItemController extends MultipleLocaleContentController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $link_items = LinkItem::orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE);

        $query = new QueryStringBuilder([
            'page' => $link_items->currentPage()
        ], localizedAdminURL('link/items'));
        return view($this->themePage('link_items.list'), [
            'link_items' => $link_items,
            'query' => $query,
            'page_helper' => new PaginationHelper($link_items->lastPage(), $link_items->currentPage(), $link_items->perPage()),
            'rdr_param' => rdrQueryParam($request->fullUrl()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->themePage('link_items.add'), [
            'link_items' => LinkItem::get(),
            'link_categories' => BlogCategory::where('type', BlogCategory::LINK)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $link_categories = $request->input('link_categories', []);
        $this->validateMultipleLocaleData($request, ['name', 'link', 'description'], [
            'name' => 'required',
            'link' => 'required',
            'image' => 'sometimes|url',
        ], $data, $successes, $fails, $old);

        $error_redirect = redirect(localizedAdminURL('link/items/add'))
            ->withInput(array_merge([
                'categories' => $link_categories,
                'image' => $request->input('image', ''),
            ], $old));

        if (count($successes) <= 0 && count($fails) > 0) {
            return $error_redirect->withErrors($fails[0]);
        }

        $validator = Validator::make($request->all(), [
            'link_categories' => 'required|exists:blog_categories,id,type,' . BlogCategory::LINK,
        ]);
        if ($validator->fails()) {
            return $error_redirect->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $link_items = new LinkItem();
            $link_items->image = $request->input('image', '');
            foreach ($successes as $locale) {
                $transData = $data[$locale];
                $trans = $link_items->translateOrNew($locale);
                $trans->name = $transData['name'];
                $trans->description = $transData['description'];
                $trans->link = $transData['link'];
            }
            $link_items->save();
            if (count($link_categories) > 0) {
                $link_items->link_categories()->attach($link_categories);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return $error_redirect->withErrors([trans('error.database_insert') . ' (' . $e->getMessage() . ')']);
        }

        return redirect(localizedAdminURL('link/items'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $current_link_item = LinkItem::findOrFail($id);

        return view($this->themePage('link_items.edit'), [
            'current_link_item' => $current_link_item,
            'current_link_category' => $current_link_item->link_categories,
            'link_categories' => BlogCategory::where('type', BlogCategory::LINK)->get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $current_link_items = LinkItem::findOrFail($request->input('id'));
        $link_categories = $request->input('link_categories', []);

        $redirect = redirect(localizedAdminURL('link/items/{id}/edit', ['id' => $current_link_items->id]));

        $this->validateMultipleLocaleData($request, ['name', 'link', 'description'], [
            'name' => 'required',
            'link' => 'required',
            'image' => 'sometimes|url',
        ], $data, $successes, $fails, $old);
        if (count($successes) <= 0 && count($fails) > 0) {
            return $redirect->withErrors($fails[0]);
        }

        $validator = Validator::make($request->all(), [
            'link_categories' => 'required|exists:blog_categories,id,type,' . BlogCategory::LINK,
        ]);
        if ($validator->fails()) {
            return $redirect->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $current_link_items->image = $request->input('image', '');
            foreach ($successes as $locale) {
                $transData = $data[$locale];
                $trans = $current_link_items->translateOrNew($locale);
                $trans->name = $transData['name'];
                $trans->description = $transData['description'];
                $trans->link = $transData['link'];
            }
            $current_link_items->save();
            if (count($link_categories) > 0) {
                $current_link_items->link_categories()->sync($link_categories);
            } else {
                $current_link_items->link_categories()->detach();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $redirect->withErrors([trans('error.database_insert') . ' (' . $e->getMessage() . ')']);
        }
        return $redirect;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $link_item = LinkItem::findOrFail($id);
        $redirect_url = localizedAdminURL('link/items');
        $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
        if (!empty($rdr)) {
            $redirect_url = $rdr;
        }
        return $link_item->delete() === true ? redirect($redirect_url) : redirect($redirect_url)->withErrors([trans('error.database_delete')]);
    }
}
