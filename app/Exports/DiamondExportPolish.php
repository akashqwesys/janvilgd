<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DiamondExportPolish implements FromCollection, WithHeadings
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
            'Stock',
            'Availability',
            'Shape',
            'Weight',
            'Clarity',
            'Color',
            'Rapaport Price/CT',
            'Discount Percent',
            'Price/CT',
            'Price',
            'Cut Grade',
            'Polish',
            'Symmetry',
            'Depth Percent',
            'Table Percent',
            'Lab',
            'Certificate',
            'Certificate Url',
            'Culet Size',
            'Girdle Percent',
            'Girdle Condition',
            'Measurements',
            'Pavilion Depth',
            'Crown Height',
            'Crown Angle',
            'Pavilion Angle',
            'Growth Type',
            'Comment',
            'Location',
            'Video Link',
            'image-1',
            'image-2',
            'image-3',
            'image-4'
        ];
    }
}

