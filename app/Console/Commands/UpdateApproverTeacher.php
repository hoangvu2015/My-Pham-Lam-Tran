<?php

namespace Antoree\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Antoree\Models\Teacher;
use Antoree\Models\User;

class UpdateApproverTeacher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status_approver';

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
        $this->info('Start update status approver!!!');
        $teacherAll = Teacher::
        where('teaching_status', '<>', 0)
        ->orWhere('available_status', '<>', 0)
        ->orWhere('publish_status', '<>', 0)
        ->get();

        foreach ($teacherAll as $key => $value) {
            $value->approver_status = 1;
            $value->save();
        }
        $this->info('Done update status approver!!!');
    }
}
