<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Models\Import;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contas = Cache::remember('imports', 60, function(){
            return Import::get(['date', 'temperature'])->groupBy(function($item) {
                        return Carbon::parse($item->date)->format('Y-m-d');
                    })->map(function($item, $key){
                        $total =  $item->count();
                        return [
                            'media' => number_format($item->sum("temperature") / $total, 2, '.', ' '),
                            'mediana' => number_format($item->median("temperature"), 2, '.', ' '),
                            'minimo' => number_format($item->min("temperature"), 2, '.', ' '),
                            'maximo' => number_format($item->max("temperature"), 2, '.', ' '),
                            'percent_maior_10' => number_format(($item->where('temperature', '>', 10)->count() * 100) / $total, 2, '.', ' '),
                            'percent_menor_menos_10' => number_format(($item->where('temperature', '<', -10)->count() * 100) / $total, 2, '.', ' '),
                            'percent_between_menos_10_10' => number_format(($item->whereBetween('temperature', [-10, 10])->count() * 100) / $total, 2, '.', ' '),
                        ];
                    });
        });
        
        return response()->json($contas);
    }

}
