<?php

namespace Antoree\Http\Controllers\APIV1;

use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\UserNotification;
use Illuminate\Http\Request;

use Antoree\Http\Requests;
use Antoree\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function jsonListForFull(Request $request)
    {
        $notifications = UserNotification::ofUser($this->auth_user->id)
            ->where('created_at', '<', $request->input('date'))
            ->orderBy('created_at', 'desc')
            ->take(AppHelper::DEFAULT_ITEMS_PER_PAGE)
            ->get();
        $data = [];
        foreach ($notifications as $notification) {
            $item = $notification->toPushArray();
            $item['label_type'] = $notification->read ? 'success' : 'warning';
            $item['status'] = trans('label.status_' . ($notification->read ? 'read' : 'unread'), [], '', $this->locale);
            $item['created_at'] = defaultTime($notification->created_at);
            $data[] = $item;
        }

        return response()->json([
            'success' => true,
            'list' => $data,
        ]);
    }
}
