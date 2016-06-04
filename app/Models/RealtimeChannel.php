<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;

class RealtimeChannel extends Model
{
    const NOTIFICATION = 'notification';
    const MESSAGE = 'message';
    const MODULE = 'module';

    protected $table = 'realtime_channels';
    protected $fillable = ['secret', 'name', 'type'];

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'realtime_subscribers', 'channel_id', 'user_id');
    }

    public static function generateKey($prefix)
    {
        return uniqid($prefix, true);
    }
}
