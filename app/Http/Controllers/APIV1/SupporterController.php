<?php

namespace Antoree\Http\Controllers\APIV1;

use Antoree\Models\Role;
use Illuminate\Http\Request;

use Antoree\Http\Requests;
use Antoree\Http\Controllers\Controller;

class SupporterController extends Controller
{
    public function jsonList(Request $request)
    {
        $data = array();
        $supporters = Role::where('name', 'supporter')->first()->users()->get();
        foreach ($supporters as $supporter) {
            $data[] = [
                'active' => $supporter->id == $request->input('current_supporter_id', ''),
                'url' => localizedURL('supporter/{id?}', ['id' => $supporter->id]),
                'picture' => $supporter->profile_picture,
                'name' => $supporter->name,
                'phone' => $supporter->phone,
                'skype' => $supporter->skype,
                'online' => $supporter->isOnline(),
                'idle' => $supporter->isIdle()
            ];
        }
        return response()->json($data);
    }
}
