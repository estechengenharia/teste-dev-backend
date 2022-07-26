<?php

namespace App\Imports;

use App\Models\Import;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportData implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $row){
            $data=[
                'date' => $row['data'],
                'temperature' => $row['temperatura'],
            ];

            Import::create($data);
        }
    }
}
