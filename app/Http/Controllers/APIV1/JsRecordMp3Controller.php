<?php

namespace Antoree\Http\Controllers\APIV1;

use Antoree\Models\Helpers\StoredAudio;
use Illuminate\Http\Request;
use Antoree\Http\Requests;
use Antoree\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class JsRecordMp3Controller extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'msg' => $validator->errors()->all()
            ]);
        }

        $storedAudio = new StoredAudio();
        $storedAudio->fromUploadedData($request->input('data'));

        return response()->json([
            'success' => true,
            'filename' => $storedAudio->targetFileAsset,
        ]);
    }
}
