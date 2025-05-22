<?php

namespace App\Console\Commands;

use App\Jobs\ProcessTemperatureData;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;

class ImportTemperatureCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-temperature {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description  = 'Importa um arquivo .csv de temperaturas ao longo do tempo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        
        if (!file_exists($filePath)) {
            $this->error("Arquivo não encontrado: {$filePath}");
            return;
        }

        $storedPath = Storage::putFileAs('imports', $filePath, 'temp_import.csv');

        ProcessTemperatureData::dispatch($storedPath);
        $this->info($storedPath);

        $this->info('Importação iniciada. Verifique os logs para progresso.');
    }
}
