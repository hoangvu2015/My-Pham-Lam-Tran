<?php

namespace Antoree\Http\Controllers\APIV1;

use Illuminate\Http\Request;

use Antoree\Http\Requests;
use Antoree\Http\Controllers\Controller;

class SupportChannelController extends Controller
{
    public function jsonList(Request $request)
    {
        $data = array();
        $supportChannels = $this->auth_user->channels()->orderBy('created_at', 'desc')->get();
        foreach ($supportChannels as $supportChannel) {
            $data[] = [
                'active' => $supportChannel->id == $request->input('current_support_channel_id', ''),
                'id' => $supportChannel->id,
                'url' => localizedURL('support-channel/{id?}', ['id?' => $supportChannel->id]),
                'picture' => appDefaultUserProfilePicture()
            ];
        }
        return response()->json($data);
    }
}
