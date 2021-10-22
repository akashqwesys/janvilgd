<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
//HeadingRowFormatter::default('none');

class DiamondsImport implements ToArray, WithHeadingRow, WithEvents
{
    public $sheetNames;
    public $sheetData;
	
    public function __construct(){
        $this->sheetNames = [];
	$this->sheetData = [];
    }
    public function array(array $array)
    {
    	$this->sheetData[] = $array;
    }
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
            	$this->sheetNames[] = $event->getSheet()->getTitle();
            } 
        ];
    }
    public function model(array $row)
    {  
        return $row;
//        
//        $row['rapa']=str_replace(',','',$row['rapa']);
//        $row['discount']=str_replace('-','',$row['discount']);
//        $row['weight_loss']=str_replace('-','',$row['weight_loss']);
//        
//        $row['rapa']=doubleval($row['rapa']);
//        $row['discount']=doubleval($row['discount']);
//        $row['weight_loss']=doubleval($row['weight_loss']);        
//        
//        $data_array=[                                           
//        'name'=> 'name',
//        'barcode'=> strval($row['barcode']),
//        'packate_no'=> strval($row['main_pktno']),
//        'actual_pcs'=> doubleval($row['pcs']),
//        'available_pcs'=> doubleval($row['pcs']),
//        'makable_cts'=> doubleval($row['mkbl_cts']),
//        'expected_polish_cts'=> doubleval($row['exp_pol_cts']),
//        'remarks'=> strval($row['remarks']),
//        'rapaport_price'=> $row['rapa'],
//        'discount'=> $row['discount'],
//        'weight_loss'=>  $row['weight_loss'],
//        'video_link'=> strval($row['video_link']),
//        'images'=> 0,
//        'refCategory_id'=> 1,       
//        'added_by' => session()->get('loginId'),
//        'is_active' => 1,
//        'is_deleted' => 0,
//        'date_added' => date("yy-m-d h:i:s"),
//        'date_updated' => date("yy-m-d h:i:s")
//        ];
////        print_r($data_array);die;
//        return new Diamonds($data_array);
    }
}
