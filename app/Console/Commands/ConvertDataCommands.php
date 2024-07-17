<?php

namespace App\Console\Commands;

use App\Jobs\ConvertDataJobs;
use App\Services\ConvertData\ConvertDataInterface;
use Illuminate\Console\Command;

class ConvertDataCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:data';
    protected $convertDataInterface;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert data from trong_tre_pro to vuon_uom_app';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ConvertDataInterface $convertDataInterface)
    {
        parent::__construct();        
        $this->convertDataInterface = $convertDataInterface;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch(new ConvertDataJobs($this->convertDataInterface));
    }
}
