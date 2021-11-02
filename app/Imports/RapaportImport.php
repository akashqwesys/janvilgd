<?php

namespace App\Imports;

use Illuminate\Http\Request;
use App\Models\Rapaportcsv;
use Maatwebsite\Excel\Concerns\ToModel;
use Session;

class RapaportImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Rapaportcsv([
            'shape'     => $row[0],
            'clarity'    => $row[1],
            'color' => $row[2],
            'from_range'     => $row[3],
            'to_range'    => $row[4],
            'rapaport_price' => $row[5],
            'refRapaport_type_id' => session('import_refRapaport_type_id')
        ]);
    }
}
