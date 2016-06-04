<?php

namespace Antoree\Http\Controllers\Admin;

use Antoree\Http\Controllers\ViewController;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\QueryStringBuilder;
use Antoree\Models\Role;
use Antoree\Models\Helpers\PaginationHelper;
use Illuminate\Http\Request;

use Antoree\Http\Requests;

class RoleController extends ViewController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roles = Role::orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE); // 2 items per page
        $query = new QueryStringBuilder([
            'page' => $roles->currentPage()
        ], localizedAdminURL('roles'));
        return view($this->themePage('role.list'), [
            'roles' => $roles,
            'query' => $query,
            'page_helper' => new PaginationHelper($roles->lastPage(), $roles->currentPage(), $roles->perPage())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
