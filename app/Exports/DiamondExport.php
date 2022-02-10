<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DiamondExport implements FromCollection, WithHeadings
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
            'Barcode',
            'Pkt No',
            'Availability',
            'Org Cts',
            'Exp Pol',
            'SHAPE',
            'COLOR',
            'CLARITY',
            'Rapaport Price/CT',
            'Discount',
            'Labour Charges/CT',
            'Price/CT',
            'Price',
            'Location',
            'Comment',
            'Video Link',
            'image-1',
            'image-2',
            'image-3',
            'image-4',
        ];
    }
}
