<?php

namespace Antoree\Models;

use Antoree\Models\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Antoree\Models\User;

class PaymentType extends Model
{
	const BANK_ACCOUNT = 'BA';
	const PAYPAL = 'PP';
	const PAYONEER = 'PO';
	const SKRILL = 'SK';
	const OTHER = 'OPM';

    protected $table = 'payments_type';
    protected $fillable = ['name','code'];

    protected function getIdPayType($string, $group = null)
	{
		return self::where("code",$string)->get()->id;
	}

	protected function getPayTypeCode($string)
	{
		return self::where("id",$string)->first();
	}
}
