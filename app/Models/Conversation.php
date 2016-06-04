<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversations';
    protected $fillable = ['channel_id', 'user_id', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function channel()
    {
        return $this->belongsTo(RealtimeChannel::class, 'channel_id', 'id');
    }
}
