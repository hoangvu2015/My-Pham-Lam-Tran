<?php

namespace Antoree\Models;

use Antoree\Models\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Antoree\Models\User;
use Antoree\Models\PaymentType ;

class PaymentInfo extends Model
{
	protected $table = 'payments_info';
	protected $fillable = [
	'name_account','email','country','phone','address','city','bank_name','bank_code',
	'local_code','bank_number','orther_info','orther_pay_method','type_pay_id','user_id',
	'national', 'bank_city', 'bank_branch', 'postal_code', 'local_phone', 'account_owner', 'group'
	];

	protected function getPayOfUser($user_id,$type,$group = null)
	{
		$type_pay = PaymentType::where('code',$type)->first();
		
		if($group){
			$pay = self::where('type_pay_id',$type_pay->id)->where('user_id',$user_id)->where('group',$group);
		}else{
			$pay = self::where('type_pay_id',$type_pay->id)->where('user_id',$user_id);
		}
		
		return $pay;
	}
}
