<?php

namespace App\Jobs;

use App\Models\TemperatureData;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessTemperatureData implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $filePath) {}

    public function handle()
    {
        Log::info('[ProcessTemperatureData] Iniciando processamento do arquivo: ' . $this->filePath);

        try {
            $fullPath = Storage::path($this->filePath);
            Log::debug('Caminho completo do arquivo: ' . $fullPath);

            if (!Storage::exists($this->filePath)) {
                throw new \Exception("Arquivo não encontrado em: " . $this->filePath);
            }

            $file = fopen($fullPath, 'r');
            $header = fgetcsv($file);
            Log::debug('Cabeçalho do CSV: ', $header);

            $lineCount = 0;
            while (($line = fgetcsv($file)) !== false) {
                $lineCount++;
                Log::debug("Linha {$lineCount}: ", $line);

                TemperatureData::create([
                    'recorded_at' => $line[0],
                    'temperature' => (float)$line[1]
                ]);
            }

            Log::info("Job concluído com sucesso. {$lineCount} registros processados.");
        } catch (\Exception $e) {
            Log::error("Falha no job: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            throw $e;
        } finally {
            if (isset($file) && is_resource($file)) {
                fclose($file);
            }
            Storage::delete($this->filePath);
        }
    }
}