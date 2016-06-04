<?php

namespace Antoree\Http\Controllers\Pages;

use Antoree\Http\Controllers\ViewController;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\UserNotification;
use Illuminate\Http\Request;

use Antoree\Http\Requests;
use Illuminate\Support\Facades\Auth;


class NotificationController extends ViewController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // get all topic
        $notifications = UserNotification::ofUser($this->auth_user->id)->orderBy('created_at', 'desc')->take(AppHelper::DEFAULT_ITEMS_PER_PAGE)->get();
        return view($this->themePage('notification'), [
            'notifications' => $notifications,
            'last_notification' => $notifications->last()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function confirm(Request $request, $id)
    {
        $notification = UserNotification::findOrFail($id);
        if ($notification->user_id != $this->auth_user->id) {
            abort(404);
        }
        $notification->read = true;
        $notification->save();

        return redirect($notification->rawUrl);
    }
}
