<?php

namespace App\Http\Controllers;

use App\Models\DataCsv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DataCsvController extends Controller
{

    public function importCsv()
    {

        try {

            if (DataCsv::exists()) {
               return response()->json([
                    'error' => true,
                    'message' => "O Arquivo já foi importado!"
                ],200);
            }

            DB::beginTransaction();

            $count = 0;

            if (($open = fopen(storage_path() . "/example.csv", "r")) !== FALSE) {
    
                while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                    if($count!=0){
                        $dataCsv = new DataCsv([
                            'data' => $data[0],
                            'temperatura' =>  $data[1],
                        ]);
                        $dataCsv->save();
                    }
                    $count++;
                }
    
                fclose($open);
            }

            DB::commit();

            return "$count linhas importadas com sucesso!";

        } catch (\Throwable $th) {
            DB::rollback();
            return $th->getMessage();
        }
    }

    public function index()
    {
        try {
           
            if (!DataCsv::exists()) {
                return response()->json([
                     'error' => true,
                     'message' => "O Arquivo CSV ainda foi importado! Não existem dados."
                ],200);
            }

            $datacsv = Cache::remember('datacsv', now()->addMinutes(60),function (){
                return DataCsv::all()->groupBy('data');
            });
            
            $response = [];

            foreach ($datacsv as $key => $data) {
                $moreThan10 = count($data->where('temperatura', '>', 10));
                $lessThanNegative10 = count($data->where('temperatura', '<', -10));
                $between10AndNegative10 = count($data->whereBetween('temperatura',[-10,10]));
                $countTotalDay = count($data);

                $response[$key] = [
                    'Média' => (float) number_format($data->avg('temperatura'), 2),
                    'Mediana' => $data->median('temperatura'),
                    'Valor máximo' => $data->max('temperatura'),
                    'Valor mínimo' => $data->min('temperatura'),
                    '% acima de 10' => (float) number_format(($moreThan10/$countTotalDay)*100, 2),
                    '% abaixo de -10' => (float) number_format(($lessThanNegative10/$countTotalDay)*100, 2),
                    '% entre -10 e 10' => (float) number_format(($between10AndNegative10/$countTotalDay)*100, 2),
                ];
            }

            return response()->json($response);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar recuperar os dados. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                // 'message' => $th->getMessage()
            ],400);
        }
    }

}
