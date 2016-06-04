<?php

namespace Antoree\Http\Controllers\APIV1;

use Antoree\Models\BlogCategory;
use Antoree\Models\LinkItem;
use Illuminate\Http\Request;
use Antoree\Http\Requests;
use Antoree\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LinkItemController extends Controller
{
    public function updateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:blog_categories,id,type,' . BlogCategory::LINK,
            'items' => 'required|array|exists:link_items,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'msg' => $validator->errors()->all()
            ]);
        }

        $order = 0;
        foreach ($request->input('items') as $id) {
            LinkItem::where('id', $id)->update([
                'order' => ++$order,
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
