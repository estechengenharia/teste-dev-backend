<?php

namespace App\Http\Controllers;

use App\Models\TemperatureData;
use Illuminate\Support\Facades\DB;

class TemperatureAnalysisController {
    
    public function analyze()
    {
        $results = DB::table('temperature_data')->selectRaw(
            "DATE(recorded_at) as date,
            AVG(temperature) as avg_temp,
            MIN(temperature) as min_temp,
            MAX(temperature) as max_temp,
            SUBSTRING_INDEX(
                SUBSTRING_INDEX(
                    GROUP_CONCAT(temperature ORDER BY temperature SEPARATOR ','),
                    ',',
                    CEIL(COUNT(*) / 2)
                ),
                ',',
                -1
            ) as median_temp,
            SUM(CASE WHEN temperature > 10 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as above_10,
            SUM(CASE WHEN temperature < -10 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as below_minus_10,
            SUM(CASE WHEN temperature BETWEEN -10 AND 10 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as between_range"
        )
        ->groupBy('date')
        ->get();

        return response()->json($results);
    }
}