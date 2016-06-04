<?php

namespace Antoree\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Antoree\Models\User;

class CopyCountryToNationlity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:nationality';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy contry to nationality';

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
        $this->info('Start copy contry to nationality!!!');
        DB::update('update users set nationality=country');
        $this->info('Done copy contry to nationality!!!');
    }
}
