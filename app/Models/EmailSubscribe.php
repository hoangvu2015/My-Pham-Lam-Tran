<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class EmailSubscribe extends Model
{
	protected $table = 'email_subscribe';
	protected $fillable = ['email','name','phone','user_id'];
	public function scopeFilter($query, $startDate, $endDate, $status, $searchNameEmailCc = "", $user_id = "")
	{
		if (!empty($user_id)) {
			$query = $query->where('user_id','=',$user_id);
		}

		if ($startDate !== false) {
			$query = $query->where('created_at', '>=', $startDate);
		}
		if ($endDate !== false) {
			$query = $query->where('created_at', '<=', $endDate);
		}
		if (!empty($status)) {
			$query = $query->where('status', $status);
		}
		if (!empty($searchNameEmailCc)) {
			$query = $query->where('name', 'like', '%'.$searchNameEmailCc.'%')
			->orWhere('email', 'like', '%'.$searchNameEmailCc.'%')
			->orWhere('phone', 'like', '%'.$searchNameEmailCc.'%')
			->orWhere('skype', 'like', '%'.$searchNameEmailCc.'%');
		}
		return $query;
	}
}
