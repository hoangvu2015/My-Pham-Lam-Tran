<?php

namespace Antoree\Http\Controllers\APIV1;

use Antoree\Models\Helpers\JsCropper;
use Antoree\Models\User;
use Illuminate\Http\Request;

use Antoree\Http\Requests;
use Antoree\Http\Controllers\Controller;

class JsCropperController extends Controller
{
    public function updateUserProfilePicture(Request $request, $id = null)
    {
        if($id){
            $user = User::findOrFail($id);
        }else{
            $user = $this->auth_user;
        }

        $avatar_basename = uniqid($user->id . '_');

        $success = false;
        $crop = new JsCropper();
        if ($crop->fromUploadFile($request->hasFile('avatar_file') ? $request->file('avatar_file') : null)) {
            $crop->setDataFromJson($request->input('avatar_data', null));
            $crop->setDestination(asset('storage/app/profile_pictures/' . $avatar_basename), storage_path('app/profile_pictures/' . $avatar_basename));
            if ($crop->doCrop()) {
                $user->profile_picture = $crop->getResult();
                $user->save();

                $success = true;
            }
        }

        if (!$success) {
            $response = [
                'success' => false,
                'message' => $crop->getMsg(),
            ];
        } else {
            $response = [
                'success' => true,
                'result' => $crop->getResult()
            ];
        }

        return response()->json($response);
    }
}
