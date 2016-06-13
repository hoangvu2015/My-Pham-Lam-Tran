<?php

namespace Antoree\Http\Controllers\Admin;

use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\QueryStringBuilder;
use Antoree\Models\Helpers\PaginationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Antoree\Http\Controllers\MultipleLocaleContentController;

use Antoree\Models\CategoryProduct;

class ProductCategoryController extends MultipleLocaleContentController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category_pro = CategoryProduct::orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE); // Helper::DEFAULT_ITEMS_PER_PAGE items per page
        $category_pro_query = new QueryStringBuilder([
            'page' => $category_pro->currentPage()
            ], localizedAdminURL('category-product'));

        return view($this->themePage('product_category.list'), [
            'category_pro' => $category_pro,
            'category_pro_query' => $category_pro_query,
            'page_helper' => new PaginationHelper($category_pro->lastPage(), $category_pro->currentPage(), $category_pro->perPage()),
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
        return view($this->themePage('product_category.add'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            ]);

        if ($validator->fails()) {
            return redirect(localizedAdminURL('category-product/add'))
            ->withInput()
            ->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $category = array(
                'name' => $request->input('name'),
                'des' => $request->input('des'),
                'code' => $request->input('code')
                );
            $category = CategoryProduct::create($category);
            $category->save();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect(localizedAdminURL('category-product/add'))
            ->withInput()
            ->withErrors([trans('error.database_insert') . ' (' . $ex->getMessage() . ')']);
        }

        return redirect(localizedAdminURL('category-product'));
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
        $category = CategoryProduct::findOrFail($id);

        return view($this->themePage('product_category.edit'), [
            'category' => $category,
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
        $category = CategoryProduct::findOrFail($request->input('id'));
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            ]);
        if ($validator->fails()) {
            return redirect(localizedAdminURL('category-product/{id}/edit', ['id' => $category->id]))
            ->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $category->name = $request->input('name');
            $category->code = $request->input('code');
            $category->des = $request->input('des');
            $category->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(localizedAdminURL('category-product/{id}/edit', ['id' => $category->id]))
            ->withInput()
            ->withErrors([trans('error.database_update') . ' (' . $e->getMessage() . ')']);
        }

        return redirect(localizedAdminURL('category-product/{id}/edit', ['id' => $category->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $category = CategoryProduct::findOrFail($id);

        $redirect_url = localizedAdminURL('category-product');
        $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
        if (!empty($rdr)) {
            $redirect_url = $rdr;
        }

        return $category->delete() === true ? redirect($redirect_url) : redirect($redirect_url)->withErrors([trans('error.database_delete')]);
    }
}
