<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'user_notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'url_index', 'url_params',
        'message_index', 'message_params'
    ];

    public function getUrlParamsAttribute()
    {
        if (empty($this->attributes['url_params'])) return [];
        $params = json_decode($this->attributes['url_params'], true);
        return $params === false ? [] : $params;
    }

    public function getMessageParamsAttribute()
    {
        if (empty($this->message_params)) return [];
        $params = json_decode($this->message_params, true);
        return $params === false ? [] : $params;
    }

    public function scopeOfUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getPushRawUrlAttribute()
    {
        return localizedURL($this->url_index, $this->urlParams, $this->user->language);
    }

    public function getPushUrlAttribute()
    {
        return localizedURL('notification/confirm/{id}', ['id' => $this->id], $this->user->language);
    }

    public function getPushMessageAttribute()
    {
        return trans('notification.' . $this->message_index, $this->messageParams, '', $this->user->language);
    }

    public function getRawUrlAttribute()
    {
        return localizedURL($this->url_index, $this->urlParams);
    }

    public function getUrlAttribute()
    {
        return localizedURL('notification/confirm/{id}', ['id' => $this->id]);
    }

    public function getMessageAttribute()
    {
        return trans('notification.' . $this->message_index, $this->messageParams);
    }

    public function getTimeAttribute()
    {
        return defaultTime($this->created_at);
    }

    public function getTimeTzAttribute()
    {
        return defaultTimeTZ($this->created_at);
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'message' => $this->message,
            'read' => $this->read ? 'read' : 'unread',
            'time' => $this->time,
            'time_tz' => $this->timeTz,
            'secret' => $this->user->notificationChannel->secret
        ];
    }

    public function toPushArray()
    {
        return [
            'id' => $this->id,
            'url' => $this->pushUrl,
            'message' => $this->pushMessage,
            'read' => $this->read ? 'read' : 'unread',
            'time' => $this->time,
            'time_tz' => $this->timeTz,
            'secret' => $this->user->notificationChannel->secret
        ];
    }

    public static function createAndPushToUser(User $user, $url_index, $message_index, array $url_params = [], array $message_params = [], $pushing = true)
    {
        $notification = self::create([
            'user_id' => $user->id,
            'url_index' => $url_index,
            'url_params' => escObject($url_params, $type),
            'message_index' => $message_index,
            'message_params' => escObject($message_params, $type),
        ]);

        if ($notification && $pushing) {
            pushMessage($user->notificationChannel->secret, [
                'id' => $notification->id,
                'url' => $notification->pushUrl,
                'message' => $notification->message,
                'time' => $notification->time,
                'time_tz' => $notification->timeTz
            ]);
        }

        return $notification;
    }
}
