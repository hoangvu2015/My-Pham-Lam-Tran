<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    /**
     * @var string
     */
    public $table = 'sessions';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Returns all the guest users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGuests($query)
    {
        return $query->whereNull('user_id');
    }

    /**
     * Returns all the registered users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRegistered($query)
    {
        return $query->whereNotNull('user_id')->with('user');
    }

    /**
     * Updates the session of the current user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpdateCurrent($query, $session_id, $user_id, $status, $support_key, $client_ip)
    {
        return $query->where('id', $session_id)->update(array(
            'user_id' => $user_id,
            'status' => $status,
            'support_key' => $support_key,
            'client_ip' => $client_ip,
        ));
    }

    /**
     * Returns the user that belongs to this entry.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
