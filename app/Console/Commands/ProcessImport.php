<?php

namespace App\Console\Commands;

use App\Imports\ImportData;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ProcessImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports csv file from the public directory';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Excel::import(new ImportData, public_path('example.csv'));
    }
}
