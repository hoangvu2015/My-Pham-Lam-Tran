<?php

use Illuminate\Database\Seeder;
use Antoree\Models\PaymentType;

class PaymentTypeTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	if(count(PaymentType::where('name','Bank account')->get()) == 0){
    		PaymentType::create(['name'=>'Bank account', 'code' => 'BA']);
    	}
    	if(count(PaymentType::where('name','PayPal')->get()) == 0){
    		PaymentType::create(['name'=>'PayPal', 'code' => 'PP']);
    	}
    	if(count(PaymentType::where('name','Skrill')->get()) == 0){
    		PaymentType::create(['name'=>'Skrill', 'code' => 'SK']);
    	}
    	if(count(PaymentType::where('name','Payoneer')->get()) == 0){
    		PaymentType::create(['name'=>'Payoneer', 'code' => 'PO']);
    	}
    	if(count(PaymentType::where('name','Other payment methods')->get()) == 0){
    		PaymentType::create(['name'=>'Other payment methods', 'code' => 'OPM']);
    	}
    }
}
