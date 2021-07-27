<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lead;

class ChangeDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $date = date('Y-m-d');
        Lead::where('date', '<', $date)->update(['date' => $date]);
        echo 'Data updated successfully';
    }
}
