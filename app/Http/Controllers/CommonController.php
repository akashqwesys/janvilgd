<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use DataTables;

class CommonController extends Controller
{
//    public function delete(Request $request) {
//        if (isset($_REQUEST['table_id'])) {
//            
//            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([                                              
//                'is_deleted' => 1,                                
//                'date_updated' => date("Y-m-d h:i:s")
//            ]); 
//            activity($request,"deleted",$_REQUEST['module']);
////            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->delete();
//            if ($res) {
//                $data = array(
//                    'suceess' => true
//                );
//            } else {
//                $data = array(
//                    'suceess' => false
//                );
//            }
//            return response()->json($data);
//        }
//    }
//    public function status(Request $request) {       
//        if (isset($_REQUEST['table_id'])) {
//            
//            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([                                              
//                'is_active' => $_REQUEST['status'],                                
//                'date_updated' => date("Y-m-d h:i:s")
//            ]);                        
////            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->delete();
//            if ($res) {
//                $data = array(
//                    'suceess' => true
//                );
//            } else {
//                $data = array(
//                    'suceess' => false
//                );
//            }
//            activity($request,"updated",$_REQUEST['module']);
//            return response()->json($data);
//        }
//    }
    public function delete_image(Request $request) {
//         print_r($_REQUEST);die;         
        if (isset($_REQUEST['table_id'])) {

            $result = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->first();
//            print_r($result);die;
            $image_array= json_decode($result->image);            
            if(!empty($image_array)){
                $i=0;
                foreach ($image_array as $img_row){
                    if($img_row==$_REQUEST['image']){
                        unset($image_array[$i]);
                    }
                    $i=$i+1;
                }
            }
            $new_image_json=json_encode($image_array);
            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([                                              
                'image' =>$new_image_json,                                
                'date_updated' => date("Y-m-d h:i:s")
            ]);   
//            activity($request,"deleted",$_REQUEST['module']);
//            $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->delete();
            if ($res) {
                $data = array(
                    'suceess' => true
                );
            } else {
                $data = array(
                    'suceess' => false
                );
            }
            return response()->json($data);
        }
    }
}
