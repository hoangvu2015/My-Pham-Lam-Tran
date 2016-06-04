<?php

namespace Antoree\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Antoree\Models\TmpLearningRequest;
use Antoree\Models\Student;
use Antoree\Models\User;

class StudentTmp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user_student_from_tmp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        $cc = 0;
        $err =0;
        $this->info('Start Task 1 ... !!');
        $learning_requests = TmpLearningRequest::where('email','<>','')->get();

        foreach ($learning_requests as $key => $value) {
            $user = DB::table('users')->where('email', $value->email)->first();
            if(!$user){

                $new_user = $this->createUser($value);

                if($new_user){
                    $cc +=1;
                }else{
                    $err +=1;
                }

            }
        }

        $this->info('Done Task 1 with success: '.$cc.' and error: '.$err.' !!');

        $this->info('Start Task 2 ... !!');
        $cc = 0;
        $err =0;
        
        foreach ($learning_requests as $key => $value) {
            $user = DB::table('users')->where('email', $value->email)->first();//User::where('email', '=', $value->email)->first();
            
            if($user){

                $value->user_id = $user->id;
                $value->save();
                $cc +=1;
            }
        }

        $this->info('Done Task 2 with success: '.$cc.' and error: '.$err.' !!');

        $this->info('Start Task 3 ... !!');
        $cc = 0;
        $err =0;
        
        foreach ($learning_requests as $key => $value) {

            if(!empty($value->user_id)){
                
                $student = Student::where('user_id', '=', $value->user_id)->first();

                if($student){
                    $err +=1;
                }else{
                    $student = new Student();
                    $student->create(['user_id'=>$value->user_id]);
                    $cc +=1;
                }
            }
        }

        $this->info('Done Task 3 with success: '.$cc.' and error: '.$err.' !!');
    }

    public function createUser($value)
    {
        $user = false;
        $data = [
        'email'=>$value->email,
        'name'=>$value->name,
        'phone'=>$value->phone,
        'skype'=>$value->skype,
        'auto_create'=>1
        ];

        $validator = Validator::make($data,[
            'email' => 'required|email|max:255|unique:users'
            ]);

        if ($validator->fails()){
            $this->info('Error11 id:'.$value->id.' !!');
        }else{
            $user = User::advancedCreate($data);
            if($user){
                $user->slug = empty($user->name) ? $user->id : toSlug($user->name).'-'.$user->id;
                $user->save();
            }
        }

        return $user;
    }
}
