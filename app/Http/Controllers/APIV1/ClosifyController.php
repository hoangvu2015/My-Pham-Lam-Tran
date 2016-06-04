<?php

namespace Antoree\Http\Controllers\APIV1;

use Antoree\Http\Controllers\Controller;
use Antoree\Models\Helpers\ClosifyPhoto;
use Illuminate\Http\Request;

use Antoree\Http\Requests;
use Illuminate\Support\Facades\Validator;

class ClosifyController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->has('action')) {
            if ($request->input('action') == 'itech_closify_submission') {
                return $this->forPermanentlySave($request);
            } elseif ($request->input('action') == 'itech_closify_delete') {
                return $this->forRemoving($request);
            }
        }

        return $this->forPreview($request);
    }

    private function forPreview(Request $request)
    {
        $imageInput = $request->input('ImageName', '');
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'w' => 'required|integer',
            'h' => 'required|integer',
            'quality' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Fields was not validated: ' . print_r($request->all(), true)
            ]);
        }

        $photo = new ClosifyPhoto();
        if ($photo->fromUploadedFile($request->file($imageInput), $request->input('quality'))) {
            $photo->resize($request->input('w'), $request->input('h'));
        }

        return response()->json($photo->getCurrentResult());
    }

    public function forPermanentlySave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'top' => 'required|string',
            'left' => 'required|string',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'quality' => 'required|integer',
            'src' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Fields was not validated: ' . print_r($request->all(), true)
            ]);
        }

        $topOffset = abs(intval($request->input('top')));
        $leftOffset = abs(intval($request->input('left')));

        $photo = new ClosifyPhoto();
        if ($photo->fromFile($request->input('src'), $request->input('quality'))) {
            $photo->crop($request->input('width'), $request->input('height'), $leftOffset, $topOffset);
        }

        return response()->json($photo->getCurrentResult());
    }

    public function forRemoving(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'img' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Fields was not validated: ' . print_r($request->all(), true)
            ]);
        }

        $result = ClosifyPhoto::removeImage($request->input('img'));

        return response()->json(['success' => $result]);
    }
}
