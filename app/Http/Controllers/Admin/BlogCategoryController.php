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
use Antoree\Models\Helpers\DateTimeHelper;

class BlogCategoryController extends MultipleLocaleContentController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = BlogCategory::where('type', BlogCategory::BLOG)->orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE);

        $query = new QueryStringBuilder([
            'page' => $categories->currentPage()
        ], localizedAdminURL('blog/categories'));
        return view($this->themePage('blog_category.list'), [
            'categories' => $categories,
            'query' => $query,
            'page_helper' => new PaginationHelper($categories->lastPage(), $categories->currentPage(), $categories->perPage()),
            'rdr_param' => rdrQueryParam($request->fullUrl()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * Method nay de goi duoc giao dien Add
     * @return Response
     */
    public function create()
    {
        return view($this->themePage('blog_category.add'), [
            'categories' => BlogCategory::where('type', BlogCategory::BLOG)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * Method nay de luu vao database khi ta add moi data cua cac Field trong Bang
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $parent_id = intval($request->input('parent'), 0);

        $this->validateMultipleLocaleData($request, ['name', 'slug', 'desc'], [
            'name' => 'required',
            'slug' => 'required|unique:blog_category_translations,slug',
        ], $data, $successes, $fails, $old);

        $error_redirect = redirect(localizedAdminURL('blog/categories/add'))
            ->withInput(array_merge([
                'parent' => $parent_id
            ], $old));

        if (count($successes) <= 0 && count($fails) > 0) {
            return $error_redirect->withErrors($fails[0]);
        }

        if ($parent_id != 0) {
            $validator = Validator::make($request->all(), [
                'parent' => 'sometimes|exists:blog_categories,id,type,' . BlogCategory::BLOG,
            ]);
            if ($validator->fails()) {
                return $error_redirect->withErrors($validator);
            }
        }

        $category = new BlogCategory();
        $category->type = BlogCategory::BLOG;

        if ($parent_id != 0) {
            $category->parent_id = $parent_id; //add Parent id to Blog Category
        }
        foreach ($successes as $locale) {
            $transData = $data[$locale];
            $trans = $category->translateOrNew($locale);
            $trans->name = $transData['name'];
            $trans->slug = $transData['slug'];
            $trans->description = $transData['desc'];
        }
        if ($category->save() === false) {
            return $error_redirect->withErrors([trans('error.database_insert')]);
        }

        return redirect(localizedAdminURL('blog/categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $current_category = BlogCategory::findOrFail($id);
        if ($current_category->type != BlogCategory::BLOG) {
            abort(404);
        }
        return view($this->themePage('blog_category.edit'), [
            'current_category' => $current_category,
            'categories' => BlogCategory::where('type', BlogCategory::BLOG)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $current_category = BlogCategory::findOrFail($request->input('id'));
        if ($current_category->type != BlogCategory::BLOG) {
            abort(404);
        }

        $redirect = redirect(localizedAdminURL('blog/categories/{id}/edit', ['id' => $current_category->id]));

        $parent_id = intval($request->input('parent'), 0);

        $this->validateMultipleLocaleData($request, ['name', 'slug', 'desc'], [
            'name' => 'required',
            'slug' => 'required|unique:blog_category_translations,slug,' . $current_category->id . ',cat_id',
        ], $data, $successes, $fails, $old);

        if (count($successes) <= 0 && count($fails) > 0) {
            return $redirect->withErrors($fails[0]);
        }

        if ($parent_id != 0) {
            $validator = Validator::make($request->all(), [
                'parent' => 'sometimes|exists:blog_categories,id,type,' . BlogCategory::BLOG
            ]);
            if ($validator->fails()) {
                return $redirect->withErrors($validator);
            }
        }

        $current_category->parent_id = $parent_id != 0 && $parent_id !== $current_category->parent_id ? $parent_id : null; //edit Parent id to Blog Category

        foreach ($successes as $locale) {
            $transData = $data[$locale];
            $trans = $current_category->translateOrNew($locale);
            $trans->name = $transData['name'];
            $trans->slug = $transData['slug'];
            $trans->description = $transData['desc'];
        }
        if ($current_category->save() === false) {
            return $redirect->withErrors([trans('error.database_update')]);
        }

        return $redirect;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $current_category = BlogCategory::findOrFail($id);
        if ($current_category->type != BlogCategory::BLOG) {
            abort(404);
        }

        $redirect_url = localizedAdminURL('blog/categories');
        $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
        if (!empty($rdr)) {
            $redirect_url = $rdr;
        }

        $success = true;
        DB::beginTransaction();
        try {
            BlogCategory::where('parent_id', $id)->update(['parent_id' => null]);
            $current_category->delete();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            $success = false;
        }

        return $success ? redirect($redirect_url) : redirect($redirect_url)->withErrors([trans('error.database_delete')]);
    }

}
