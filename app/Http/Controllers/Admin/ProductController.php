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
use Antoree\Models\Product;

class ProductController extends MultipleLocaleContentController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE); // Helper::DEFAULT_ITEMS_PER_PAGE items per page
        $products_query = new QueryStringBuilder([
            'page' => $products->currentPage()
            ], localizedAdminURL('product'));

        return view($this->themePage('product.list'), [
            'products' => $products,
            'products_query' => $products_query,
            'page_helper' => new PaginationHelper($products->lastPage(), $products->currentPage(), $products->perPage()),
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
        return view($this->themePage('product.add'),[
            'categories' => CategoryProduct::all()
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|max:255',
            'category_id' => 'required|exists:category_product,id',
            ]);

        if ($validator->fails()) {
            return redirect(localizedAdminURL('product/add'))
            ->withInput()
            ->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $product = array(
                'name' => $request->input('name'),
                'des' => $request->input('des'),
                'price' => $request->input('price'),
                'content' => $request->input('content'),
                'brand' => $request->input('brand'),
                'origin' => $request->input('origin'),
                'view' => $request->input('view'),
                'discount' => $request->input('discount'),
                'image1' => $request->input('image1'),
                'image2' => $request->input('image2'),
                'image3' => $request->input('image3'),
                'image4' => $request->input('image4'),
                'status_show' => $request->input('status_show'),
                'status_type' => $request->input('status_type'),
                'category_id' => intval($request->input('category_id')),
                );
            $product = Product::create($product);
            $product->save();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect(localizedAdminURL('product/add'))
            ->withInput()
            ->withErrors([trans('error.database_insert') . ' (' . $ex->getMessage() . ')']);
        }

        return redirect(localizedAdminURL('product'));
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
        $product = Product::findOrFail($id);

        return view($this->themePage('product.edit'), [
            'product' => $product,
            'categories' => CategoryProduct::all()
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
        $product = Product::findOrFail($request->input('id'));
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|max:255',
            'category_id' => 'required|exists:category_product,id',
            ]);
        if ($validator->fails()) {
            return redirect(localizedAdminURL('product/{id}/edit', ['id' => $product->id]))
            ->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->content = $request->input('content');
            $product->des = $request->input('des');
            $product->brand = $request->input('brand');
            $product->origin = $request->input('origin');
            $product->discount = $request->input('discount');
            $product->view = $request->input('view');
            $product->image1 = $request->input('image1');
            $product->image2 = $request->input('image2');
            $product->image3 = $request->input('image3');
            $product->image4 = $request->input('image4');
            $product->status_show = $request->input('status_show');
            $product->status_type = $request->input('status_type');
            $product->category_id = intval($request->input('category_id'));
            $product->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(localizedAdminURL('product/{id}/edit', ['id' => $product->id]))
            ->withInput()
            ->withErrors([trans('error.database_update') . ' (' . $e->getMessage() . ')']);
        }

        return redirect(localizedAdminURL('product/{id}/edit', ['id' => $product->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $category = Product::findOrFail($id);

        $redirect_url = localizedAdminURL('product');
        $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
        if (!empty($rdr)) {
            $redirect_url = $rdr;
        }

        return $category->delete() === true ? redirect($redirect_url) : redirect($redirect_url)->withErrors([trans('error.database_delete')]);
    }
}
