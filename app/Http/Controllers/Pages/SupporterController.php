<?php

namespace Antoree\Http\Controllers\Pages;

use Antoree\Http\Controllers\ViewController;
use Antoree\Models\Conversation;
use Antoree\Models\RealtimeChannel;
use Antoree\Models\Role;
use Antoree\Models\User;
use Illuminate\Http\Request;

use Antoree\Http\Requests;

class SupporterController extends ViewController
{

    public function layoutSupportChannels(Request $request, $id = null)
    {
        $supportChannels = $this->auth_user->channels()->orderBy('created_at', 'desc')->get();
        if ($supportChannels->search(function ($item, $key) use ($id) {
                return $item->id == $id;
            }) !== false
        ) {
            $currentSupportChannel = RealtimeChannel::find($id);
            $conversations = Conversation::where('channel_id', $currentSupportChannel->id)->orderBy('created_at', 'desc')->get();
            return view($this->themePage('support_channels'), [
                'current_support_channel_existed' => true,
                'support_channels' => $supportChannels,
                'current_support_channel' => $currentSupportChannel,
                'conversations' => $conversations
            ]);
        }

        return view($this->themePage('support_channels'), [
            'current_support_channel_existed' => false,
            'support_channels' => $supportChannels
        ]);
    }

    public function layoutContactSupporters(Request $request, $id = null)
    {
        $supporters = Role::where('name', 'supporter')->first()->users()->get();
        if ($supporters->search(function ($item, $key) use ($id) {
                return $item->id == $id;
            }) !== false
        ) {
            $init_message = '';
            if ($request->has('visitor_info')) {
                $init_message .= 'Information: ' . $request->input('visitor_info') . '. ';
            }
            if ($request->has('visitor_phone')) {
                $init_message .= 'Phone: ' . $request->input('visitor_phone') . '.';
            }

            $supportKey = supportKey($id);
            if ($supportChannel = RealtimeChannel::where('secret', $supportKey)->first()) {
                if (!$supportChannel->subscribers()->get()->contains('id', $id)) {
                    $supportChannel->subscribers()->attach($id);
                }
            } else {
                $supportChannel = RealtimeChannel::create([
                    'secret' => $supportKey,
                    'type' => RealtimeChannel::MODULE
                ]);
                $supportChannel->subscribers()->attach($id);
            }
            $conversations = Conversation::where('channel_id', $supportChannel->id)->orderBy('created_at', 'desc')->get();
            return view($this->themePage('supporters'), [
                'current_supporter_existed' => true,
                'supporters' => $supporters,
                'current_supporter' => User::findOrFail($id),
                'support_channel' => $supportChannel,
                'conversations' => $conversations,
                'init_message' => $init_message
            ]);
        }
        return view($this->themePage('supporters'), [
            'current_supporter_existed' => false,
            'supporters' => $supporters,
        ]);
    }
}
