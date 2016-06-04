<?php

namespace Antoree\Console\Commands;

use Illuminate\Console\Command;
use Antoree\Models\Student;
use Antoree\Models\Role;
use Antoree\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:student';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Thêm các learner cũ';

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
        $this->info("Start command");
        $students = Student::all();
        $this->info("Running command...");
        foreach ($students as $key => $value) {
            $id = $value->user_id;
            $user = User::where("id",$id)->first();
            if($user != null && !$user->hasRole('student')){
                $user->attachRole(6);
            }
            // if($user->deleted_at == null){
            //     if(!$user->hasRole("student")){
            //         $this->info("User id :".$id);
            //     }
            // }
        }
        $this->info("End command");
    }
}
