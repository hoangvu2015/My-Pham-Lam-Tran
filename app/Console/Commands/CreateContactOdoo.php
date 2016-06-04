<?php

namespace Antoree\Console\Commands;

use Illuminate\Console\Command;
use Antoree\Models\User;
use Antoree\Models\TmpLearningRequest;
use Illuminate\Support\Facades\DB;

use Ripcord\Ripcord;

class CreateContactOdoo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:contact-odoo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create contact tnp to odoo.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start create contact odoo!!!');
        $learn_request = DB::table('tmp_learning_requests')
        ->select('id','name','email','phone','skype','facebook','user_id','about_me','kid')
        ->get();

        $url = env('URL_ODOO');
        $db = env('DB_ODOO');
        $username = env('USER_ODOO');
        $password = env('PASSWORD_ODOO');

        $common = Ripcord::client("$url/xmlrpc/2/common");
        $common->version();
        $uid = $common->authenticate($db, $username, $password, array());

        $models = Ripcord::client("$url/xmlrpc/2/object");

        $i = 0;
        foreach ($learn_request as $key => $value) {
            if($value->email){
                $id = $models->execute_kw($db, $uid, $password,
                    'res.partner',
                    'search', 
                    array(array(array('email', '=', $value->email),array('customer', '=', true)))
                    );
                if(!$id){
                    $new = $models->execute_kw($db, $uid, $password,
                        'res.partner', 'create',
                        array(
                            array(
                                'name'=>$value->name,
                                'phone'=>$value->phone,
                                'email'=>$value->email,
                                'x_skype'=>$value->skype,
                                'x_learner_id'=>$value->user_id,
                                'x_facebook'=>$value->facebook,
                                'customer'=>true
                                )
                            )
                        );
                    $i +=1;
                }
            }
        }
        $this->info('Done create contact odoo, add '.$i.' contact!!!');
    }
}
