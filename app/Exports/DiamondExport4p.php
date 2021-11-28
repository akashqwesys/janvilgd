<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DiamondExport4p implements FromCollection, WithHeadings
{
    protected $data;
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function collection()
    {
        return collect($this->data);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings() :array
    {
        return [
            'BARCODE',
            'MAIN PKTNO',
            'SHAPE',
            'EXP POL SIZE',
            'COLOR',
            'CLARITY',
            'MKBL CTS',
            'EXP POL CTS',
            'REMARKS',
            'HALF-CUT DIA',
            'HALF-CUT HGT',
            'PO. DIAMETER',
            'DISCOUNT',
            'VIDEO LINK',
            'image-1',
            'image-2',
            'image-3',
            'image-4',
            'Location',
            'Comment'
        ];
    }
}
