<?php

namespace Antoree\Http\Controllers\APIV1;

use Antoree\Models\Conversation;
use Antoree\Models\LearningRequest;
use Antoree\Models\RealtimeChannel;
use Antoree\Models\User;
use Antoree\Models\UserNotification;
use Illuminate\Http\Request;

use Antoree\Http\Requests;
use Antoree\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LightRealtimeController extends Controller
{
    public function sendLRConversation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lr_id' => 'required|integer|exists:learning_request,id',
            'from' => 'required|integer|exists:users,id',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false]);
        }
        $learning_request = LearningRequest::find($request->input('lr_id'));
        $channel = RealtimeChannel::findOrFail($learning_request->channel_id);
        $student = User::findOrFail($learning_request->student_id);
        $teacher = User::findOrFail($learning_request->teacher_id);
        $is_student = $request->input('from') == $learning_request->student_id;

        $message = $request->input('message');
        $conversation = Conversation::create([
            'channel_id' => $channel->id,
            'user_id' => $request->input('from'),
            'client_ip' => $request->ip(),
            'message' => $message,
        ]);
        if ($conversation) {
            $notification = UserNotification::create([
                'user_id' => $is_student ? $teacher->id : $student->id,
                'url_index' => ($is_student ? 'teacher' : 'student') . '/learning-request/{id}',
                'url_params' => json_encode(['id' => $learning_request->id]),
                'message_index' => 'learning_request_message_new',
                'message_params' => '{}'
            ]);

            return response()->json([
                'success' => true,
                'notification' => $notification->toPushArray()
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function sendSPConversationFromVisitor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'channel_id' => 'required|integer|exists:realtime_channels,id',
            'from' => 'sometimes|integer|exists:users,id',
            'to' => 'required|integer|exists:users,id',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false]);
        }

        $channel = RealtimeChannel::find($request->input('channel_id'));
        $fromUser = User::find($request->input('from'));
        $toUser = User::find($request->input('to'));
        $message = $request->input('message');
        $conversation = Conversation::create([
            'channel_id' => $channel->id,
            'user_id' => $fromUser ? $fromUser->id : null,
            'client_ip' => $request->ip(),
            'message' => $message,
        ]);
        if ($conversation) {
            $notification = UserNotification::create([
                'user_id' => $toUser->id,
                'url_index' => 'support-channel/{id?}',
                'url_params' => json_encode(['id' => $channel->id]),
                'message_index' => 'support_channel_message_new',
                'message_params' => '{}'
            ]);

            return response()->json([
                'success' => true,
                'notification' => $notification->toPushArray()
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function sendSPConversationFromSupporter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'channel_id' => 'required|integer|exists:realtime_channels,id',
            'from' => 'required|integer|exists:users,id',
            'to' => 'sometimes|integer|exists:users,id',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false]);
        }

        $channel = RealtimeChannel::findOrFail($request->input('channel_id'));
        $fromUser = User::findOrFail($request->input('from'));
        $toUser = User::find($request->input('to'));
        $message = $request->input('message');
        $conversation = Conversation::create([
            'channel_id' => $channel->id,
            'user_id' => $fromUser->id,
            'client_ip' => $request->ip(),
            'message' => $message,
        ]);
        if ($conversation) {
            if ($toUser) {
                $notification = UserNotification::create([
                    'user_id' => $toUser->id,
                    'url_index' => 'supporter/{id?}',
                    'url_params' => json_encode(['id' => $fromUser->id]),
                    'message_index' => 'supporter_message_new',
                    'message_params' => '{}'
                ]);
                return response()->json([
                    'success' => true,
                    'notification' => $notification->toPushArray()
                ]);
            }
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
