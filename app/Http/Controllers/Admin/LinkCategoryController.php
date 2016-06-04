<?php

namespace Antoree\Http\Controllers\Admin;

use Antoree\Models\BlogCategory;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\QueryStringBuilder;
use Antoree\Models\Helpers\PaginationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Antoree\Http\Controllers\MultipleLocaleContentController;


class LinkCategoryController extends MultipleLocaleContentController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = BlogCategory::where('type', BlogCategory::LINK)->orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE);

        $query = new QueryStringBuilder([
            'page' => $categories->currentPage()
        ], localizedAdminURL('link/categories'));
        return view($this->themePage('link_categories.list'), [
            'categories' => $categories,
            'query' => $query,
            'page_helper' => new PaginationHelper($categories->lastPage(), $categories->currentPage(), $categories->perPage()),
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
        return view($this->themePage('link_categories.add'), [
            'categories' => BlogCategory::where('type', BlogCategory::LINK)->get()
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
        $parent_id = intval($request->input('parent'), 0);

        $this->validateMultipleLocaleData($request, ['name', 'slug'], [
            'name' => 'required',
            'slug' => 'required|unique:blog_category_translations,slug',
        ], $data, $successes, $fails, $old);

        $error_redirect = redirect(localizedAdminURL('link/categories/add'))
            ->withInput(array_merge([], $old));

        if (count($successes) <= 0 && count($fails) > 0) {
            return $error_redirect->withErrors($fails[0]);
        }

        if ($parent_id != 0) {
            $validator = Validator::make($request->all(), [
                'parent' => 'sometimes|exists:blog_categories,id,type,' . BlogCategory::LINK,
            ]);
            if ($validator->fails()) {
                return $error_redirect->withErrors($validator);
            }
        }

        $category = new BlogCategory();
        $category->type = BlogCategory::LINK;

        if ($parent_id != 0) {
            $category->parent_id = $parent_id; //add Parent id to Blog Category
        }

        foreach ($successes as $locale) {
            $transData = $data[$locale];
            $trans = $category->translateOrNew($locale);
            $trans->name = $transData['name'];
            $trans->slug = $transData['slug'];
        }
        if ($category->save() === false) {
            return $error_redirect->withErrors([trans('error.database_insert')]);
        }

        return redirect(localizedAdminURL('link/categories'));
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
        $current_link_category = BlogCategory::findOrFail($id);

        if ($current_link_category->type != BlogCategory::LINK) {
            abort(404);
        }
        return view($this->themePage('link_categories.edit'), [
            'current_link_category' => $current_link_category,
            'categories' => BlogCategory::where('type', BlogCategory::LINK)->get(),
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
        $current_link_category = BlogCategory::findOrFail($request->input('id'));
        if ($current_link_category->type != BlogCategory::LINK) {
            abort(404);
        }

        $redirect = redirect(localizedAdminURL('link/categories/{id}/edit', ['id' => $current_link_category->id]));

        $this->validateMultipleLocaleData($request, ['name', 'slug'], [
            'name' => 'required',
            'slug' => 'required|unique:blog_category_translations,slug,' . $current_link_category->id . ',cat_id',
        ], $data, $successes, $fails, $old);

        if (count($successes) <= 0 && count($fails) > 0) {
            return $redirect->withErrors($fails[0]);
        }

        $parent_id = intval($request->input('parent'), 0);

        if ($parent_id != 0) {
            $validator = Validator::make($request->all(), [
                'parent' => 'sometimes|exists:blog_categories,id,type,' . BlogCategory::LINK
            ]);
            if ($validator->fails()) {
                return $redirect->withErrors($validator);
            }
        }

        $current_link_category->parent_id = $parent_id != 0 && $parent_id !== $current_link_category->parent_id ? $parent_id : null; //edit Parent id to Link Category


        foreach ($successes as $locale) {
            $transData = $data[$locale];
            $trans = $current_link_category->translateOrNew($locale);
            $trans->name = $transData['name'];
            $trans->slug = $transData['slug'];
        }
        if ($current_link_category->save() === false) {
            return $redirect->withErrors([trans('error.database_update')]);
        }

        return redirect(localizedAdminURL('link/categories'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $current_link_category = BlogCategory::where('type', BlogCategory::LINK)->where('id', $id)->firstOrFail();

        $redirect_url = localizedAdminURL('link/categories');
        $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
        if (!empty($rdr)) {
            $redirect_url = $rdr;
        }

        if ($current_link_category->type != BlogCategory::LINK) {
            return redirect($redirect_url);
        }

        $success = true;
        DB::beginTransaction();
        try {
            BlogCategory::where('parent_id', $id)->update(['parent_id' => null]);
            $current_link_category->delete();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            $success = false;
        }

        return $success ? redirect($redirect_url) : redirect($redirect_url)->withErrors([trans('error.database_delete')]);
    }

    public function layoutSort(Request $request, $id)
    {
        $category = BlogCategory::where('type', BlogCategory::LINK)->where('id', $id)->firstOrFail();

        return view($this->themePage('link_categories.sort'), [
            'category' => $category,
            'items' => $category->items()->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get(),
        ]);
    }
}
