<?php

namespace Antoree\Console\Commands;

use Illuminate\Console\Command;
use Antoree\Models\Teacher;
use Antoree\Models\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChangeStatusTeacher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:status_teacher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Status Teacher.';

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
        $this->info('Start change status !!');

        $data = Teacher::where('teaching_status',null)->get();
        foreach ($data as $key => $value) {
            $value->teaching_status = 0;
            $value->save();
        }

        $data = Teacher::where('available_status',null)->get();
        foreach ($data as $key => $value) {
            $value->available_status = 0;
            $value->save();
        }
        
        $this->info('Done change status !!');
    }
}
