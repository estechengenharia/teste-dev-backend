<?php

namespace App\Console\Commands;

use App\Http\Controllers\DataCsvController;
use App\Models\DataCsv;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CsvImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:csvimport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importação do CSV de exemplo para o BD';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {

            $controller = new DataCsvController();

            $response = $controller->importCsv();

            print_r($response);

        } catch (\Throwable $th) {
            print_r($th->getMessage());   
        }
    }
}
