<?php

namespace Antoree\Http\Controllers\APIV1;

use Antoree\Models\Themes\LmsThemeFacade;
use Antoree\Models\Themes\ThemeWidget;
use Illuminate\Http\Request;
use Antoree\Http\Requests;
use Antoree\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WidgetController extends Controller
{
    public function updateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'placeholder' => 'required|in:' . implode(',', array_keys(LmsThemeFacade::placeholders())),
            'widgets' => 'required|array|exists:theme_widgets,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'msg' => $validator->errors()->all()
            ]);
        }

        $order = 0;
        foreach ($request->input('widgets') as $id) {
            ThemeWidget::where('id', $id)->update([
                'placeholder' => $request->input('placeholder'),
                'order' => ++$order,
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
