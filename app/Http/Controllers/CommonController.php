<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
// use DataTables;
use Elastic\Elasticsearch\ClientBuilder;

class CommonController extends Controller
{

    public function projectSetup() {

        //******************* Parent Modules Entry Start *******************//
        DB::table('modules')->truncate();
        $modules_array=array();

            $data_array=array();
            $data_array['module_id']=1;
            $data_array['name']='Dashboard';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id']=0;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=1;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=2;
            $data_array['name']='Dashboard';
            $data_array['icon']='ni-dashboard-fill';
            $data_array['slug']='dashboard/inventory';
            $data_array['parent_id']=1;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=2;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=3;
            $data_array['name']='Inventory';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id']=0;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=1;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=4;
            $data_array['name']='Inventory';
            $data_array['icon']='ni-note-add';
            $data_array['slug']='dashboard/inventory';
            $data_array['parent_id']=3;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=2;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=5;
            $data_array['name']='Diamonds';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id']=4;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=6;
            $data_array['name']='Polish Diamonds';
            $data_array['slug']='diamonds/list/3';
            $data_array['icon']=null;
            $data_array['parent_id']=5;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=4;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=7;
            $data_array['name']='4P Diamonds';
            $data_array['slug']='diamonds/list/2';
            $data_array['icon']=null;
            $data_array['parent_id']=5;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=4;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=8;
            $data_array['name']='Rough Diamonds';
            $data_array['slug']='diamonds/list/1';
            $data_array['icon']=null;
            $data_array['parent_id']=5;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=4;
            array_push($modules_array,$data_array);

            $data_array = array();
            $data_array['module_id'] = 9;
            $data_array['name'] = 'Categories';
            $data_array['slug']='categories';
            $data_array['icon']=null;
            $data_array['parent_id'] = 4;
            $data_array['sort_order'] = 2;
            $data_array['added_by'] = 1;
            $data_array['is_active'] = 1;
            $data_array['is_deleted'] = 0;
            $data_array['date_added'] = date("Y-m-d H:i:s");
            $data_array['date_updated'] = date("Y-m-d H:i:s");
            $data_array['menu_level'] = 3;
            array_push($modules_array, $data_array);

            $data_array=array();
            $data_array['module_id']=10;
            $data_array['name']='Attributes';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id']=4;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=11;
            $data_array['name']='Attributes Group';
            $data_array['slug']='attribute-groups';
            $data_array['icon']=null;
            $data_array['parent_id']=10;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=4;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=12;
            $data_array['name']='Attributes';
            $data_array['slug']='attributes';
            $data_array['icon']=null;
            $data_array['parent_id']=10;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=4;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=13;
            $data_array['name']='Rapaport';
            $data_array['slug']='rapaport';
            $data_array['icon']=null;
            $data_array['parent_id']=4;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=14;
            $data_array['name']='Charges';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id']=4;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=15;
            $data_array['name']='Labour Charges';
            $data_array['slug']='labour-charges';
            $data_array['icon']=null;
            $data_array['parent_id']=14;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=4;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=16;
            $data_array['name']='Shipping/Delivery';
            $data_array['slug']='delivery-charges';
            $data_array['icon']=null;
            $data_array['parent_id']=14;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=4;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=17;
            $data_array['name']='Discount';
            $data_array['slug']='discount';
            $data_array['icon']=null;
            $data_array['parent_id']=14;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=4;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=18;
            $data_array['name']='Tax';
            $data_array['slug']='taxes';
            $data_array['icon']=null;
            $data_array['parent_id']=14;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=4;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=19;
            $data_array['name']='Transport';
            $data_array['slug']='transport';
            $data_array['icon']=null;
            $data_array['parent_id']=4;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=20;
            $data_array['name']='Payment Modes';
            $data_array['slug']='payment-modes';
            $data_array['icon']=null;
            $data_array['parent_id']=4;
            $data_array['sort_order']=7;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=21;
            $data_array['name']='Orders';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id']=0;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=1;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=22;
            $data_array['name']='Orders';
            $data_array['icon']='ni-report-profit';
            $data_array['slug']=null;
            $data_array['parent_id']=21;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=2;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=23;
            $data_array['name']='Sold Diamonds';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id']=22;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=24;
            $data_array['name']='Polish Diamonds';
            $data_array['slug']='sold-diamonds/list/polish-diamonds';
            $data_array['icon']=null;
            $data_array['parent_id']=23;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=4;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=25;
            $data_array['name']='4P Diamonds';
            $data_array['slug']='sold-diamonds/list/4p-diamonds';
            $data_array['icon']=null;
            $data_array['parent_id']=23;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=4;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=26;
            $data_array['name']='Rough Diamonds';
            $data_array['slug']='sold-diamonds/list/rough-diamonds';
            $data_array['icon']=null;
            $data_array['parent_id']=23;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=4;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=27;
            $data_array['name']='Orders';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id']=22;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=28;
            $data_array['name']='Users';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id']=0;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=1;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=29;
            $data_array['name']='Users';
            $data_array['icon']='ni-users';
            $data_array['slug']=null;
            $data_array['parent_id']=28;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=2;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=30;
            $data_array['name']='Customers';
            $data_array['slug']='customers';
            $data_array['icon']=null;
            $data_array['parent_id']=29;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=31;
            $data_array['name']='Customers Activity';
            $data_array['slug']='customer-activities';
            $data_array['icon']=null;
            $data_array['parent_id']=29;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=32;
            $data_array['name']='Customers Type';
            $data_array['slug']='customer-type';
            $data_array['icon']=null;
            $data_array['parent_id']=29;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=33;
            $data_array['name']='Employees';
            $data_array['slug']='users';
            $data_array['icon']=null;
            $data_array['parent_id']=29;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=34;
            $data_array['name']='Employees Activity';
            $data_array['slug']='user-activity';
            $data_array['icon']=null;
            $data_array['parent_id']=29;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=35;
            $data_array['name']='Employees Role';
            $data_array['slug']='user-role';
            $data_array['icon']=null;
            $data_array['parent_id']=29;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=36;
            $data_array['name']='Designation';
            $data_array['slug']='designation';
            $data_array['icon']=null;
            $data_array['parent_id']=29;
            $data_array['sort_order']=7;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=37;
            $data_array['name']='Address';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id']=0;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=1;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=38;
            $data_array['name']='Address';
            $data_array['icon']='ni-map-pin';
            $data_array['slug']=null;
            $data_array['parent_id']=37;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=2;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=39;
            $data_array['name']='Countries';
            $data_array['slug']='country';
            $data_array['icon']=null;
            $data_array['parent_id']=38;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=40;
            $data_array['name']='States';
            $data_array['slug']='state';
            $data_array['icon']=null;
            $data_array['parent_id']=38;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=41;
            $data_array['name']='Cities';
            $data_array['slug']='city';
            $data_array['icon']=null;
            $data_array['parent_id']=38;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=42;
            $data_array['name']='Web Modules';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id']=0;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=1;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=43;
            $data_array['name']='Web Modules';
            $data_array['icon']='ni-card-view';
            $data_array['slug']=null;
            $data_array['parent_id']=42;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=2;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=44;
            $data_array['name']='Informative Pages';
            $data_array['slug']='informative-pages';
            $data_array['icon']=null;
            $data_array['parent_id']=43;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=45;
            $data_array['name']='Sliders';
            $data_array['slug']='sliders';
            $data_array['icon']=null;
            $data_array['parent_id']=43;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=46;
            $data_array['name']='Events';
            $data_array['slug']='events';
            $data_array['icon']=null;
            $data_array['parent_id']=43;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=47;
            $data_array['name']='Blogs';
            $data_array['slug']='blogs';
            $data_array['icon']=null;
            $data_array['parent_id']=43;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=3;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=48;
            $data_array['name']='Modules';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id']=0;
            $data_array['sort_order']=7;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=1;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=49;
            $data_array['name']='Modules';
            $data_array['icon']='ni-list-round';
            $data_array['slug']=null;
            $data_array['parent_id']=48;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=2;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=50;
            $data_array['name']='Settings';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id']=0;
            $data_array['sort_order']=8;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=1;
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['module_id']=51;
            $data_array['name']='Settings';
            $data_array['icon']='ni-setting';
            $data_array['slug']=null;
            $data_array['parent_id']=50;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            $data_array['menu_level']=2;
            array_push($modules_array,$data_array);

            $data_array = array();
            $data_array['module_id'] = 52;
            $data_array['name'] = 'Contacts';
            $data_array['icon']=null;
            $data_array['slug']=null;
            $data_array['parent_id'] = 0;
            $data_array['sort_order'] = 9;
            $data_array['added_by'] = 1;
            $data_array['is_active'] = 1;
            $data_array['is_deleted'] = 0;
            $data_array['date_added'] = date("Y-m-d H:i:s");
            $data_array['date_updated'] = date("Y-m-d H:i:s");
            $data_array['menu_level'] = 1;
            array_push($modules_array, $data_array);

            $data_array = array();
            $data_array['module_id'] = 53;
            $data_array['name'] = 'Contacts/Inquiries';
            $data_array['icon'] = 'ni-user-list';
            $data_array['slug']='inquiries';
            $data_array['parent_id'] = 52;
            $data_array['sort_order'] = 1;
            $data_array['added_by'] = 1;
            $data_array['is_active'] = 1;
            $data_array['is_deleted'] = 0;
            $data_array['date_added'] = date("Y-m-d H:i:s");
            $data_array['date_updated'] = date("Y-m-d H:i:s");
            $data_array['menu_level'] = 2;
            array_push($modules_array, $data_array);

            DB::table('modules')->insert($modules_array);

        //******************* Parent Modules Entry End *******************//


        //******************* Categories Entry Start *******************//
        $delete = DB::table('categories')->truncate();
        $categories_array=array();

            $data_array=array();
            $data_array['name']='Rough Diamonds';
            $data_array['image']='[]';
            $data_array['description']='Rough Diamonds';
            $data_array['category_type']=2;
            $data_array['sort_order']=1;
            $data_array['slug']=clean_string('rough-diamonds');
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($categories_array,$data_array);

            $data_array=array();
            $data_array['name']='4P Diamonds';
            $data_array['image']='[]';
            $data_array['description']='4P Diamonds';
            $data_array['category_type']=1;
            $data_array['sort_order']=2;
            $data_array['slug']=clean_string('4p-diamonds');
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($categories_array,$data_array);

            $data_array=array();
            $data_array['name']='Polish Diamonds';
            $data_array['image']='[]';
            $data_array['description']='Polish Diamonds';
            $data_array['category_type']=3;
            $data_array['sort_order']=3;
            $data_array['slug']=clean_string('polish-diamonds');
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($categories_array,$data_array);

            DB::table('categories')->insert($categories_array);
        //******************* Categories Entry End *******************//


        //******************* Informative Pages Entry Start *******************//
        // $delete = DB::table('informative_pages')->truncate();
        // $informative_pages_array=array();

        //     $data_array=array();
        //     $data_array['name']='Why to order online';
        //     $data_array['content']=clean_html("<div class='content-wrapper'><!-- BANNER SECTION START --><section class='diamonds-hero-section text-white mb-5' style='background-image:url(assets/images/diamonds-banner.jpg)'><div class='container'><div class='row'><div class='col col-12 col-md-6'><h2>Why to order online</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section><!-- BANNER SECTION END --></div>");
        //     $data_array['default_content']=clean_html("<div class='content-wrapper'><!-- BANNER SECTION START --><section class='diamonds-hero-section text-white mb-5' style='background-image:url(assets/images/diamonds-banner.jpg)'><div class='container'><div class='row'><div class='col col-12 col-md-6'><h2>Why to order online</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section><!-- BANNER SECTION END --></div>");
        //     $data_array['slug']=clean_string('why-to-order-online');
        //     $data_array['updated_by']=1;
        //     $data_array['is_active']=1;
        //     $data_array['date_updated']=date("Y-m-d H:i:s");
        //     array_push($informative_pages_array,$data_array);

        //     $data_array=array();
        //     $data_array['name']='Diamonds';
        //     $data_array['content']=clean_html("<div class='content-wrapper'><!-- BANNER SECTION START --><section class='diamonds-hero-section text-white' style='background-image: url(assets/images/diamonds-banner.jpg);'><div class='container'><div class='row'><div class='col col-12 col-md-10 col-lg-7 col-xl-6'><h2>Diamonds</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section><!-- BANNER SECTION END --><!-- SHOP DIAMOND BY SHAPE SECTION START --><section class='diamond-shape-section text-center pb-0'><div class='container'><div class='row'><div class='col col-12'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Shop Diamond By Shape</h2><ul class='diamond-list'><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large3.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large2.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large4.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large5.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large7.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large6.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large8.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large1.png' alt='' ></li></ul></div></div></div></section><!-- SHOP DIAMOND BY SHAPE SECTION END --><!-- BROWSE BEYOND CONFLICT FREE SECTION START --><section class='beyond-section'><div class='container'><div class='row'><div class='col col-12'><div class='beyond-content'><h2 class='text-center'><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Browse Beyond Conflict Free</h2><p class='text-white'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div><div class='col col-12 col-md-6 mb-4 mb-md-0'><img class='img-fluid' src='assets/images/Beyond-1.jpg' alt='' ></div><div class='col col-12 col-md-6'><img class='img-fluid' src='assets/images/Beyond-2.jpg' alt='' ></div></div></div></section><!-- BROWSE BEYOND CONFLICT FREE SECTION END --><!-- COLORED DIAMOND SECTION START --><section class='color-diamond-section pt-0'><div class='container'><div class='row'><div class='col col-12 col-md-12 col-lg-6'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Colored Diamond</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='col col-12 col-md-12 col-lg-6'><img class='img-fluid' src='assets/images/colored-diamond.png' alt='' ></div></div></div></section><!-- COLORED DIAMOND SECTION END --></div>");
        //     $data_array['default_content']=clean_html("<div class='content-wrapper'><!-- BANNER SECTION START --><section class='diamonds-hero-section text-white' style='background-image: url(assets/images/diamonds-banner.jpg);'><div class='container'><div class='row'><div class='col col-12 col-md-10 col-lg-7 col-xl-6'><h2>Diamonds</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section><!-- BANNER SECTION END --><!-- SHOP DIAMOND BY SHAPE SECTION START --><section class='diamond-shape-section text-center pb-0'><div class='container'><div class='row'><div class='col col-12'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Shop Diamond By Shape</h2><ul class='diamond-list'><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large3.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large2.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large4.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large5.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large7.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large6.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large8.png' alt='' ></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large1.png' alt='' ></li></ul></div></div></div></section><!-- SHOP DIAMOND BY SHAPE SECTION END --><!-- BROWSE BEYOND CONFLICT FREE SECTION START --><section class='beyond-section'><div class='container'><div class='row'><div class='col col-12'><div class='beyond-content'><h2 class='text-center'><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Browse Beyond Conflict Free</h2><p class='text-white'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div><div class='col col-12 col-md-6 mb-4 mb-md-0'><img class='img-fluid' src='assets/images/Beyond-1.jpg' alt='' ></div><div class='col col-12 col-md-6'><img class='img-fluid' src='assets/images/Beyond-2.jpg' alt='' ></div></div></div></section><!-- BROWSE BEYOND CONFLICT FREE SECTION END --><!-- COLORED DIAMOND SECTION START --><section class='color-diamond-section pt-0'><div class='container'><div class='row'><div class='col col-12 col-md-12 col-lg-6'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Colored Diamond</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='col col-12 col-md-12 col-lg-6'><img class='img-fluid' src='assets/images/colored-diamond.png' alt='' ></div></div></div></section><!-- COLORED DIAMOND SECTION END --></div>");
        //     $data_array['slug']=clean_string('diamonds');
        //     $data_array['updated_by']=1;
        //     $data_array['is_active']=1;
        //     $data_array['date_updated']=date("Y-m-d H:i:s");
        //     array_push($informative_pages_array,$data_array);

        //     $data_array=array();
        //     $data_array['name']='Grading';
        //     $data_array['content']=clean_html("<div class='content-wrapper'><!-- BANNER SECTION START --><section class='diamonds-hero-section text-white' style='background-image:url(assets/images/diamonds-banner.jpg)'><div class='container'><div class='row'><div class='col col-12 col-md-10 col-lg-7 col-xl-6'><h2>Granding</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section><!-- BANNER SECTION END --><!-- WHAT IS DIAMOND CLARITY SECTION START --><section class='clarity-section pb-0'><div class='container text-white'><div class='row'><div class='col col-12 col-md-12 text-center'><div class='clarity-content'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > WHAT IS DIAMOND CLARITY?</h2><p class='text-white'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p></div></div></div></div></section><!-- WHAT IS DIAMOND CLARITY SECTION END --><!-- COLOR AND VALUE SECTION START --><section class='color-value-section'><div class='container'><div class='row'><div class='col col-12 text-center pb-5'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Color and Value</h2><p>Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value.</p></div><div class='col col-12 text-center'><img class='img-fluid' src='assets/images/d-color.jpg' alt='' ></div></div></div></section><!-- COLOR AND VALUE SECTION END --><!-- CLARITY SECTION START --><section class='color-scale-section pt-0'><div class='container'><div class='row'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Clarity</h2><p>Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value.</p><img class='img-fluid pt-5' src='assets/images/d-clarity.jpg' alt='' ></div></div></div></section><!-- CLARITY SECTION END --><!-- CUT SECTION START --><section class='cut-section pt-0 mb-5'><div class='container'><div class='row'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Cut</h2><p>Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value.</p><img class='img-fluid pt-3' src='assets/images/d-cut.jpg' alt='' ></div></div></div></section><!-- CUT SECTION END --></div>");
        //     $data_array['default_content']=clean_html("<div class='content-wrapper'><!-- BANNER SECTION START --><section class='diamonds-hero-section text-white' style='background-image:url(assets/images/diamonds-banner.jpg)'><div class='container'><div class='row'><div class='col col-12 col-md-10 col-lg-7 col-xl-6'><h2>Granding</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section><!-- BANNER SECTION END --><!-- WHAT IS DIAMOND CLARITY SECTION START --><section class='clarity-section pb-0'><div class='container text-white'><div class='row'><div class='col col-12 col-md-12 text-center'><div class='clarity-content'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > WHAT IS DIAMOND CLARITY?</h2><p class='text-white'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p></div></div></div></div></section><!-- WHAT IS DIAMOND CLARITY SECTION END --><!-- COLOR AND VALUE SECTION START --><section class='color-value-section'><div class='container'><div class='row'><div class='col col-12 text-center pb-5'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Color and Value</h2><p>Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value.</p></div><div class='col col-12 text-center'><img class='img-fluid' src='assets/images/d-color.jpg' alt='' ></div></div></div></section><!-- COLOR AND VALUE SECTION END --><!-- CLARITY SECTION START --><section class='color-scale-section pt-0'><div class='container'><div class='row'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Clarity</h2><p>Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value.</p><img class='img-fluid pt-5' src='assets/images/d-clarity.jpg' alt='' ></div></div></div></section><!-- CLARITY SECTION END --><!-- CUT SECTION START --><section class='cut-section pt-0 mb-5'><div class='container'><div class='row'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Cut</h2><p>Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value.</p><img class='img-fluid pt-3' src='assets/images/d-cut.jpg' alt='' ></div></div></div></section><!-- CUT SECTION END --></div>");
        //     $data_array['slug']=clean_string('grading');
        //     $data_array['updated_by']=1;
        //     $data_array['is_active']=1;
        //     $data_array['date_updated']=date("Y-m-d H:i:s");
        //     array_push($informative_pages_array,$data_array);

        //     $data_array=array();
        //     $data_array['name']='Terms & Conditions';
        //     $data_array['content']=clean_html("<div class='content-wrapper'><section class='term-condition-section sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title mb-0'>Terms And Condition</h2></div></div></section><section class='term-conditions policy-info-section'><div class='container'><div class='details-content'><div class='privacy-policy-point'><h4 class='point'>Title One :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Two :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Three :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Four :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Five :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Six :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section></div>");
        //     $data_array['default_content']=clean_html("<div class='content-wrapper'><section class='term-condition-section sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title mb-0'>Terms And Condition</h2></div></div></section><section class='term-conditions policy-info-section'><div class='container'><div class='details-content'><div class='privacy-policy-point'><h4 class='point'>Title One :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Two :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Three :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Four :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Five :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Six :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section></div>");
        //     $data_array['slug']=clean_string('terms-conditions');
        //     $data_array['updated_by']=1;
        //     $data_array['is_active']=1;
        //     $data_array['date_updated']=date("Y-m-d H:i:s");
        //     array_push($informative_pages_array,$data_array);

        //     $data_array=array();
        //     $data_array['name']='Privacy Policy';
        //     $data_array['content']=clean_html("<div class='content-wrapper'><section class='privacy-policy-section sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title mb-0'>Privacy Policy</h2></div></div></section><section class='privacy-policy policy-info-section'><div class='container'><div class='details-content'><div class='privacy-policy-point'><h4 class='point'>Title One :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Two :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Three :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Four :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Five :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Six :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section></div>");
        //     $data_array['default_content']=clean_html("<div class='content-wrapper'><section class='privacy-policy-section sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title mb-0'>Privacy Policy</h2></div></div></section><section class='privacy-policy policy-info-section'><div class='container'><div class='details-content'><div class='privacy-policy-point'><h4 class='point'>Title One :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Two :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Three :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Four :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Five :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Six :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section></div>");
        //     $data_array['slug']=clean_string('privacy-policy');
        //     $data_array['updated_by']=1;
        //     $data_array['is_active']=1;
        //     $data_array['date_updated']=date("Y-m-d H:i:s");
        //     array_push($informative_pages_array,$data_array);

        //     $data_array=array();
        //     $data_array['name']='Business Policy';
        //     $data_array['content']=clean_html("<div class='content-wrapper'><section class='business-policy-section sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title mb-0'>Business Policy</h2></div></div></section><section class='business-policy policy-info-section'><div class='container'><div class='details-content'><div class='privacy-policy-point'><h4 class='point'>Title One :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Two :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Three :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Four :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Five :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Six :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Seven :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section></div>");
        //     $data_array['default_content']=clean_html("<div class='content-wrapper'><section class='business-policy-section sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title mb-0'>Business Policy</h2></div></div></section><section class='business-policy policy-info-section'><div class='container'><div class='details-content'><div class='privacy-policy-point'><h4 class='point'>Title One :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Two :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Three :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Four :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Five :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Six :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Seven :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section></div>");
        //     $data_array['slug']=clean_string('business-policy');
        //     $data_array['updated_by']=1;
        //     $data_array['is_active']=1;
        //     $data_array['date_updated']=date("Y-m-d H:i:s");
        //     array_push($informative_pages_array,$data_array);

        //     $data_array=array();
        //     $data_array['name']='Events';
        //     $data_array['content']=clean_html("<p><br></p>");
        //     $data_array['default_content']=clean_html("<p><br></p>");
        //     $data_array['slug']=clean_string('events');
        //     $data_array['updated_by']=1;
        //     $data_array['is_active']=1;
        //     $data_array['date_updated']=date("Y-m-d H:i:s");
        //     array_push($informative_pages_array,$data_array);

        //     $data_array=array();
        //     $data_array['name']='Media';
        //     $data_array['content']=clean_html("<div class='content-wrapper'><section class='media-section sub-header'><div class='container'><div class='section-content'><div><h2 class='title bread-crumb-title'>Media</h2></div></div></div></section><section class='media-info-section media-info'><div class='container'><div class='row'><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' ></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' ></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' ></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' ></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' ></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' ></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div></div><div class='media-loader text-center'><img src='assets/images/loader.svg' class='img-fluid' ></div></div></section></div>");
        //     $data_array['default_content']=clean_html("<div class='content-wrapper'><section class='media-section sub-header'><div class='container'><div class='section-content'><div><h2 class='title bread-crumb-title'>Media</h2></div></div></div></section><section class='media-info-section media-info'><div class='container'><div class='row'><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' ></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' ></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' ></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' ></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' ></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' ></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div></div><div class='media-loader text-center'><img src='assets/images/loader.svg' class='img-fluid' ></div></div></section></div>");
        //     $data_array['slug']=clean_string('media');
        //     $data_array['updated_by']=1;
        //     $data_array['is_active']=1;
        //     $data_array['date_updated']=date("Y-m-d H:i:s");
        //     array_push($informative_pages_array,$data_array);

        //     $data_array=array();
        //     $data_array['name']='Gallery';
        //     $data_array['content']=clean_html("<div class='content-wrapper'><!-- <section class='media-section sub-header'><div class='container'><div class='section-content'><div><h2 class='title bread-crumb-title'>Gallary</h2><nav aria-label='breadcrumb'><ol class='breadcrumb mb-0'><li class='breadcrumb-item'><a href='about.php'>About Us</a></li><li class='breadcrumb-item'>Gallary</li></ol></nav></div></div></div></section> --><section style='padding-top: 140px;'><div class='gallary-section container'><img src='assets/images/Gallary1.jpg' alt='' title='test' ><img src='assets/images/Gallary5.jpg' alt='' title='test' ><img src='assets/images/Gallary2.jpg' alt='' title='test' ><img src='assets/images/Gallary6.jpg' alt='' title='test' ><img src='assets/images/Gallary3.jpg' alt='' title='test' ><img src='assets/images/Gallary7.jpg' alt='' title='test' ><img src='assets/images/Gallary8.jpg' alt='' title='test' ><img src='assets/images/Gallary4.jpg' alt='' title='test' ><img src='assets/images/Gallary9.jpg' alt='' title='test' ></div><div class='lightbox'> <div class='title'></div> <div class='filter'></div> <div class='arrowr'></div> <div class='arrowl'></div> <div class='close'></div></div></section></div>");
        //     $data_array['default_content']=clean_html("<div class='content-wrapper'><!-- <section class='media-section sub-header'><div class='container'><div class='section-content'><div><h2 class='title bread-crumb-title'>Gallary</h2><nav aria-label='breadcrumb'><ol class='breadcrumb mb-0'><li class='breadcrumb-item'><a href='about.php'>About Us</a></li><li class='breadcrumb-item'>Gallary</li></ol></nav></div></div></div></section> --><section style='padding-top: 140px;'><div class='gallary-section container'><img src='assets/images/Gallary1.jpg' alt='' title='test' ><img src='assets/images/Gallary5.jpg' alt='' title='test' ><img src='assets/images/Gallary2.jpg' alt='' title='test' ><img src='assets/images/Gallary6.jpg' alt='' title='test' ><img src='assets/images/Gallary3.jpg' alt='' title='test' ><img src='assets/images/Gallary7.jpg' alt='' title='test' ><img src='assets/images/Gallary8.jpg' alt='' title='test' ><img src='assets/images/Gallary4.jpg' alt='' title='test' ><img src='assets/images/Gallary9.jpg' alt='' title='test' ></div><div class='lightbox'> <div class='title'></div> <div class='filter'></div> <div class='arrowr'></div> <div class='arrowl'></div> <div class='close'></div></div></section></div>");
        //     $data_array['slug']=clean_string('gallery');
        //     $data_array['updated_by']=1;
        //     $data_array['is_active']=1;
        //     $data_array['date_updated']=date("Y-m-d H:i:s");
        //     array_push($informative_pages_array,$data_array);

        //     $data_array=array();
        //     $data_array['name']='About Us';
        //     $data_array['content']=clean_html("<div class='content-wrapper'><!-- SUBHEADER SECTION --><!-- <section class='sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title'>About Us</h2></div></div></section> --><!-- OUR STORY SECTION --><section class='about-section p-0'><div class='container'><div class='row'><div class='col col-12 text-center'><img class='img-fluid about-image' src='assets/images/about.png' alt='' ><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Our Story</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the </p></div></div></div></section><!-- VISION AND MISSION SECTION --><section class='vision-mission-section'><div class='container'><div class='row'><div class='col col-12 text-center pb-4'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Vision and Mission</h2></div></div><div class='row align-items-center vision-box mb-5'><div class='col col-12 col-md-6 mb-4 mb-md-0'><img class='img-fluid w-100' src='assets/images/about1.jpg' alt='' ></div><div class='col col-12 col-md-6'><h3>Vision</h3><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. </p></div></div><div class='row align-items-center vision-box'><div class='col col-12 col-md-6 mb-2 mb-md-0'><h3>Mission</h3><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. </p></div><div class='col col-12 col-md-6'><img class='img-fluid w-100' src='assets/images/about1.jpg' alt='' ></div></div></div></section><!-- OUR HISTORY SECTION --><section class='about-history p-0'><div class='container'><div class='row'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Our History</h2></div></div><div class='row'><div class='checkout-wrap col-md-7 col-sm-12 col-xs-12 pull-right'><ul class='nav nav-tabs checkout-bar' id='nav-tab' role='tablist'><li class='active'><a href='#nav-1' data-bs-toggle='tab' data-bs-target='#nav-1' type='button' role='tab' aria-controls='nav-1' aria-selected='true'>1994</a></li><li class=''><a href='#nav-2' data-bs-toggle='tab' data-bs-target='#nav-2' type='button' role='tab' aria-controls='nav-2' aria-selected='false'>1995</a></li><li class=''><a href='#nav-3' data-bs-toggle='tab' data-bs-target='#nav-3' type='button' role='tab' aria-controls='nav-3' aria-selected='false'>1996</a></li><li class=''><a href='#nav-4' data-bs-toggle='tab' data-bs-target='#nav-4' type='button' role='tab' aria-controls='nav-4' aria-selected='false'>1997</a></li><li class=''><a href='#nav-5' data-bs-toggle='tab' data-bs-target='#nav-5' type='button' role='tab' aria-controls='nav-5' aria-selected='false'>1998</a></li><li class=''><a href='#nav-6' data-bs-toggle='tab' data-bs-target='#nav-6' type='button' role='tab' aria-controls='nav-6' aria-selected='false'>2000</a></li><li class=''><a href='#nav-7' data-bs-toggle='tab' data-bs-target='#nav-7' type='button' role='tab' aria-controls='nav-7' aria-selected='false'>2000</a></li></ul></div></div><div class='tab-content' id='nav-tabContent'><div class='tab-pane fade show active' id='nav-1' role='tabpanel' aria-labelledby='nav-tab-1'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1994</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div><div class='tab-pane fade' id='nav-2' role='tabpanel' aria-labelledby='nav-tab-2'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1995</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div><div class='tab-pane fade' id='nav-3' role='tabpanel' aria-labelledby='nav-tab-3'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1996</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div><div class='tab-pane fade' id='nav-4' role='tabpanel' aria-labelledby='nav-tab-4'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1997</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div><div class='tab-pane fade' id='nav-5' role='tabpanel' aria-labelledby='nav-tab-5'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1998</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div><div class='tab-pane fade' id='nav-6' role='tabpanel' aria-labelledby='nav-tab-6'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1999</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div><div class='tab-pane fade' id='nav-7' role='tabpanel' aria-labelledby='nav-tab-7'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>2000</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div></div></div></section><!-- CHAIRPERSONS SAYS SECTION --><section class='chairpersons-section'><div class='container'><div class='row align-items-center'><div class='col col-12 col-md-6 mb-2 mb-md-0'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Chairpersons Says</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the </p></div><div class='col col-12 col-md-6'><div class='border-img'><img class='img-fluid' src='assets/images/chairpersons.jpg' alt='' ></div></div></div></div></section><!-- OUR TEAM SECTION --><section class='team-section p-0'><div class='container'><div class='row align-items-center'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Our Team</h2></div></div><div class='row'><div class='col col-12 col-md-3 mb-4 mb-md-0'><img class='img-fluid team-img' src='assets/images/team.jpg' ></div><div class='col col-12 col-md-3 mb-4 mb-md-0'><img class='img-fluid team-img' src='assets/images/team.jpg' ></div><div class='col col-12 col-md-3 mb-4 mb-md-0'><img class='img-fluid team-img' src='assets/images/team.jpg' ></div><div class='col col-12 col-md-3'><img class='img-fluid team-img' src='assets/images/team.jpg' ></div></div></div></section><!-- PARTNERS SECTION --><section class='partners-section'><div class='container'><div class='row'><div class='col col-12'><h2 class='text-center'><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Our Partners</h2><div class='partners-slider custom-slick-arrow'><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' ><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' ><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' ><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' ><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' ></div></div></div></div></section></div>");
        //     $data_array['default_content']=clean_html("<div class='content-wrapper'><!-- SUBHEADER SECTION --><!-- <section class='sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title'>About Us</h2></div></div></section> --><!-- OUR STORY SECTION --><section class='about-section p-0'><div class='container'><div class='row'><div class='col col-12 text-center'><img class='img-fluid about-image' src='assets/images/about.png' alt='' ><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Our Story</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the </p></div></div></div></section><!-- VISION AND MISSION SECTION --><section class='vision-mission-section'><div class='container'><div class='row'><div class='col col-12 text-center pb-4'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Vision and Mission</h2></div></div><div class='row align-items-center vision-box mb-5'><div class='col col-12 col-md-6 mb-4 mb-md-0'><img class='img-fluid w-100' src='assets/images/about1.jpg' alt='' ></div><div class='col col-12 col-md-6'><h3>Vision</h3><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. </p></div></div><div class='row align-items-center vision-box'><div class='col col-12 col-md-6 mb-2 mb-md-0'><h3>Mission</h3><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. </p></div><div class='col col-12 col-md-6'><img class='img-fluid w-100' src='assets/images/about1.jpg' alt='' ></div></div></div></section><!-- OUR HISTORY SECTION --><section class='about-history p-0'><div class='container'><div class='row'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Our History</h2></div></div><div class='row'><div class='checkout-wrap col-md-7 col-sm-12 col-xs-12 pull-right'><ul class='nav nav-tabs checkout-bar' id='nav-tab' role='tablist'><li class='active'><a href='#nav-1' data-bs-toggle='tab' data-bs-target='#nav-1' type='button' role='tab' aria-controls='nav-1' aria-selected='true'>1994</a></li><li class=''><a href='#nav-2' data-bs-toggle='tab' data-bs-target='#nav-2' type='button' role='tab' aria-controls='nav-2' aria-selected='false'>1995</a></li><li class=''><a href='#nav-3' data-bs-toggle='tab' data-bs-target='#nav-3' type='button' role='tab' aria-controls='nav-3' aria-selected='false'>1996</a></li><li class=''><a href='#nav-4' data-bs-toggle='tab' data-bs-target='#nav-4' type='button' role='tab' aria-controls='nav-4' aria-selected='false'>1997</a></li><li class=''><a href='#nav-5' data-bs-toggle='tab' data-bs-target='#nav-5' type='button' role='tab' aria-controls='nav-5' aria-selected='false'>1998</a></li><li class=''><a href='#nav-6' data-bs-toggle='tab' data-bs-target='#nav-6' type='button' role='tab' aria-controls='nav-6' aria-selected='false'>2000</a></li><li class=''><a href='#nav-7' data-bs-toggle='tab' data-bs-target='#nav-7' type='button' role='tab' aria-controls='nav-7' aria-selected='false'>2000</a></li></ul></div></div><div class='tab-content' id='nav-tabContent'><div class='tab-pane fade show active' id='nav-1' role='tabpanel' aria-labelledby='nav-tab-1'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1994</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div><div class='tab-pane fade' id='nav-2' role='tabpanel' aria-labelledby='nav-tab-2'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1995</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div><div class='tab-pane fade' id='nav-3' role='tabpanel' aria-labelledby='nav-tab-3'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1996</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div><div class='tab-pane fade' id='nav-4' role='tabpanel' aria-labelledby='nav-tab-4'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1997</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div><div class='tab-pane fade' id='nav-5' role='tabpanel' aria-labelledby='nav-tab-5'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1998</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div><div class='tab-pane fade' id='nav-6' role='tabpanel' aria-labelledby='nav-tab-6'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1999</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div><div class='tab-pane fade' id='nav-7' role='tabpanel' aria-labelledby='nav-tab-7'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>2000</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' ></div></div></div></div></div></section><!-- CHAIRPERSONS SAYS SECTION --><section class='chairpersons-section'><div class='container'><div class='row align-items-center'><div class='col col-12 col-md-6 mb-2 mb-md-0'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Chairpersons Says</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the </p></div><div class='col col-12 col-md-6'><div class='border-img'><img class='img-fluid' src='assets/images/chairpersons.jpg' alt='' ></div></div></div></div></section><!-- OUR TEAM SECTION --><section class='team-section p-0'><div class='container'><div class='row align-items-center'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Our Team</h2></div></div><div class='row'><div class='col col-12 col-md-3 mb-4 mb-md-0'><img class='img-fluid team-img' src='assets/images/team.jpg' ></div><div class='col col-12 col-md-3 mb-4 mb-md-0'><img class='img-fluid team-img' src='assets/images/team.jpg' ></div><div class='col col-12 col-md-3 mb-4 mb-md-0'><img class='img-fluid team-img' src='assets/images/team.jpg' ></div><div class='col col-12 col-md-3'><img class='img-fluid team-img' src='assets/images/team.jpg' ></div></div></div></section><!-- PARTNERS SECTION --><section class='partners-section'><div class='container'><div class='row'><div class='col col-12'><h2 class='text-center'><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Our Partners</h2><div class='partners-slider custom-slick-arrow'><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' ><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' ><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' ><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' ><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' ></div></div></div></div></section></div>");
        //     $data_array['slug']=clean_string('about-us');
        //     $data_array['updated_by']=1;
        //     $data_array['is_active']=1;
        //     $data_array['date_updated']=date("Y-m-d H:i:s");
        //     array_push($informative_pages_array,$data_array);

        //     $data_array=array();
        //     $data_array['name']='Blog';
        //     $data_array['content']=clean_html("<div class='content-wrapper'> <section class='media-section sub-header'> <div class='container'> <div class='section-content'> <div> <h2 class='title bread-crumb-title'>Blog</h2> </div> </div> </div> </section> <section class='blog-info-section media-info'> <div class='container'> <div class='row'> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' > </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' > </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' > </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' > </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' > </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' > </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> </div> <div class='media-loader text-center'> <img src='assets/images/loader.svg' class='img-fluid' > </div> </div> </section></div>");
        //     $data_array['default_content']=clean_html("<div class='content-wrapper'> <section class='media-section sub-header'> <div class='container'> <div class='section-content'> <div> <h2 class='title bread-crumb-title'>Blog</h2> </div> </div> </div> </section> <section class='blog-info-section media-info'> <div class='container'> <div class='row'> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' > </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' > </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' > </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' > </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' > </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' > </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> </div> <div class='media-loader text-center'> <img src='assets/images/loader.svg' class='img-fluid' > </div> </div> </section></div>");
        //     $data_array['slug']=clean_string('blog');
        //     $data_array['updated_by']=1;
        //     $data_array['is_active']=1;
        //     $data_array['date_updated']=date("Y-m-d H:i:s");
        //     array_push($informative_pages_array,$data_array);

        //     $data_array=array();
        //     $data_array['name']='Manufacturing';
        //     $data_array['content']=clean_html("<div class='content-wrapper'> <!-- BANNER SECTION START --> <section class='diamonds-hero-section text-white' style='background-image: url(assets/images/diamonds-banner.jpg)'> <div class='container'> <div class='row'> <div class='col col-12 col-md-9 col-lg-7 col-xl-6'> <h2>Manufacturing</h2> <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. </p> </div> </div> </div> </section> <!-- BANNER SECTION END --> <div class='mfg-info-section'> <div class='container'> <div class='mfg-info-content'> <div class='row align-items-center'> <div class='col col-12 col-md-12 col-lg-6'> <div class='mfg-info'> <h2 class='title'> <img src='assets/images/title-diamond.svg' alt='diamond' class='img-fluid title-diamond_img' >Manufacturing </h2> <p class='description mb-0'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy </p> </div> </div> <div class='col col-12 col-md-12 col-lg-6'> <div class='mfg-image'> <img class='img-fluid w-100' src='assets/images/about1.jpg' alt='' > </div> </div> </div> </div> </div> </div> <!-- <section class='mfg-process-section p-0'> --> <div class='mfg-process-section p-0 mb-4 mb-md-0'> <div class='container'> <div class='row align-items-center'> <div class='col col-12 col-md-12'> <div class='mfg-process-content'> <h2 class='title text-center' style='margin-bottom: 0px'> <img src='assets/images/title-diamond.svg' alt='diamond' class='img-fluid title-diamond_img' >Manufacturing Process </h2> <div class='mfg-process-image'> <img src='assets/images/mfg-ps.png' alt='mfg' class='img-fluid mfg-ps' > </div> </div> </div> </div> </div> </div> <!-- </section> --> <div class='mfg-details-section'> <div class='container'> <h2 class='title text-center'> <img src='assets/images/title-diamond.svg' alt='diamond' class='img-fluid title-diamond_img' >Manufacturing Details </h2> <div class='mfg-details-content'> <div class='row'> <div class='col col-12'> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/polishing.png' alt='polishing' > </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>1. Planning</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/cleaving.png' alt='polishing' > </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>2. Cleaving</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/bruting.png' alt='polishing' > </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>3. Bruting</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/polishing.png' alt='polishing' > </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>4. Polishing</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/inspection.png' alt='polishing' > </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>5. Inspection</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> </div> </div> </div> </div> </div></div>");
        //     $data_array['default_content']=clean_html("<div class='content-wrapper'> <!-- BANNER SECTION START --> <section class='diamonds-hero-section text-white' style='background-image: url(assets/images/diamonds-banner.jpg)'> <div class='container'> <div class='row'> <div class='col col-12 col-md-9 col-lg-7 col-xl-6'> <h2>Manufacturing</h2> <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. </p> </div> </div> </div> </section> <!-- BANNER SECTION END --> <div class='mfg-info-section'> <div class='container'> <div class='mfg-info-content'> <div class='row align-items-center'> <div class='col col-12 col-md-12 col-lg-6'> <div class='mfg-info'> <h2 class='title'> <img src='assets/images/title-diamond.svg' alt='diamond' class='img-fluid title-diamond_img' >Manufacturing </h2> <p class='description mb-0'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy </p> </div> </div> <div class='col col-12 col-md-12 col-lg-6'> <div class='mfg-image'> <img class='img-fluid w-100' src='assets/images/about1.jpg' alt='' > </div> </div> </div> </div> </div> </div> <!-- <section class='mfg-process-section p-0'> --> <div class='mfg-process-section p-0 mb-4 mb-md-0'> <div class='container'> <div class='row align-items-center'> <div class='col col-12 col-md-12'> <div class='mfg-process-content'> <h2 class='title text-center' style='margin-bottom: 0px'> <img src='assets/images/title-diamond.svg' alt='diamond' class='img-fluid title-diamond_img' >Manufacturing Process </h2> <div class='mfg-process-image'> <img src='assets/images/mfg-ps.png' alt='mfg' class='img-fluid mfg-ps' > </div> </div> </div> </div> </div> </div> <!-- </section> --> <div class='mfg-details-section'> <div class='container'> <h2 class='title text-center'> <img src='assets/images/title-diamond.svg' alt='diamond' class='img-fluid title-diamond_img' >Manufacturing Details </h2> <div class='mfg-details-content'> <div class='row'> <div class='col col-12'> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/polishing.png' alt='polishing' > </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>1. Planning</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/cleaving.png' alt='polishing' > </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>2. Cleaving</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/bruting.png' alt='polishing' > </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>3. Bruting</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/polishing.png' alt='polishing' > </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>4. Polishing</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/inspection.png' alt='polishing' > </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>5. Inspection</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> </div> </div> </div> </div> </div></div>");
        //     $data_array['slug']=clean_string('manufacturing');
        //     $data_array['updated_by']=1;
        //     $data_array['is_active']=1;
        //     $data_array['date_updated']=date("Y-m-d H:i:s");
        //     array_push($informative_pages_array,$data_array);

        //     $data_array=array();
        //     $data_array['name']='Index';
        //     $data_array['content']=clean_html("<div class='content-wrapper'><!-- LANDING SECTION --><section class='landing-section p-0'><div class='landing-bg'><img src='assets/images/PSNM.gif' alt='PSNM' ></div><div class='landing-content'><div class='container'><div class='section-head'><img src='assets/images/logo-slider.png' class='img-fluid' alt='img' ><p class='description'>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normalIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </p><div class='flex social-btns'> <a class='app-btn blu flex vert' href='javascript:;'> <img src='assets/images/apple.png' alt='' > <p>Available on the <br> <span class='big-txt'>App Store</span></p> </a> <a class='app-btn blu flex vert' href='javascript:;'> <img src='assets/images/playstore.png' alt='' > <p>Get it on <br> <span class='big-txt'>Google Play</span></p> </a></div></div></div></div></section><!-- UNEARTHING SECTION --><section class='unearthing-section'><div class='container'><div class='section-head'><h2 class='title'>What are lab grown diamonds?</h2></div><div class='section-content'><div class='row align-items-center'><div class='col col-12 col-sm-12 col-md-6'><div class='unearthing-img'><img src='assets/images/diamond.gif' class='img-fluid' alt='img' ></div></div><div class='col col-12 col-sm-12 col-md-6'><div class='unearthing-details'><p class='description'>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p></div></div></div></div></div><div class='container'><div class='row'><div class='col col-12 text-center mb-3'><h3 class='text-uppercase'>Ready to get started</h3></div><!-- <div class='col col-12 col-md-2 mb-4 mb-md-0'></div><div class='col col-12 col-md-8 mb-4 mb-md-0'></div><div class='col col-12 col-md-2 mb-4 mb-md-0'></div> --></div><div class='row justify-content-center'><div class='col col-12 col-md-4 col-lg-3 mb-4 mb-md-0'><a href='login' class='btn btn-primary grown-diamonds-btn'><span class='col-md-3'><img class='title-diamond_img' src='assets/images/Polish.png' alt='' ></span><span class='col-md-9'>Shop Polish Diamonds</span></a></div><div class='col col-12 col-md-4 col-lg-3 mb-4 mb-md-0'><a href='login' class='btn btn-primary grown-diamonds-btn'><img class='title-diamond_img' src='assets/images/4p.png' alt='' > Shop 4p Diamonds</a></div><div class='col col-12 col-md-4 col-lg-3 mb-4 mb-md-0'><a href='login' class='btn btn-primary grown-diamonds-btn'><img class='title-diamond_img' src='assets/images/Rough.png' alt='' > Shop Rough Diamonds</a></div></div></div></section><!-- WHAT WE FOLLOW SECTION --><section class='follow-section text-white' data-parallax='scroll' data-image-src='assets/images/follow.png'><div class='container'><div class='row align-items-center'><div class='col col-12 col-sm-12 col-md-6'><div class='follow-details'><h2 class='title mb-4'> What We Follow?</h2><p class='mb-4 pb-3 text-white'>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><a href='grading' class='btn btn-primary'>Read More</a></div></div></div></div></section><!-- about SECTION --><section class='about-home-section'><div class='container'><div class='row align-items-center'><div class='col col-12 col-md-7'><img class='img-fluid w-100' src='assets/images/about-home.png' alt='' ></div><div class='col col-12 col-md-5'><div class='about-box'><h2>About Us</h2><p>As opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.</p><a href='about' class='btn btn-primary'>Read More</a></div></div></div></div></section><!-- WHAT WE HAVE SECTION --><section class='we-have-section text-white' data-parallax='scroll' data-image-src='assets/images/what-we-have.jpg'><div class='container'><div class='row justify-content-end'><div class='col col-12 col-md-6'><h2>What We Have?</h2><p class='text-white'>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><a href='diamonds' class='btn btn-primary'>Read More</a></div></div></div></section><!-- CORE VALUES SECTION --><section class='core-values-section'><div class='container'><div class='row align-items-center'><div class='col col-12 col-md-12 col-lg-6 mb-4 mb-lg-0'><h2>Core Values</h2><p>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div><div class='col col-12 col-md-6 col-lg-3'><div class='card core-value-card'><div class='card-body'><img class='img-fluid' src='assets/images/suitcase_work_icon.svg' alt='' ><h4>Excellence at Work</h4><p>Editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div></div><div class='card core-value-card'><div class='card-body'><img class='img-fluid' src='assets/images/suitcase_work_icon.svg' alt='' ><h4>Excellence at Work</h4><p>Editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div></div></div><div class='col col-12 col-md-6 col-lg-3'><div class='card core-value-card'><div class='card-body'><img class='img-fluid' src='assets/images/suitcase_work_icon.svg' alt='' ><h4>Excellence at Work</h4><p>Editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div></div></div></div></div></section><!-- BLOG SECTION --><section class='home-blog-section p-0'><div class='container p-0'><div class='row g-0'><div class='col col-12 col-md-6'><div class='blog-box text-white'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Latest Blogs</h2><p class='text-white'>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</p><div class='text-center mt-4'><a href='blog' class='btn btn-primary'>Read More</a></div></div></div><div class='col col-12 col-md-6'><div class='home-blog-list custom-slick-arrow'><div class='bolg-item'><img class='img-fluid' src='assets/images/blog-single.jpg' alt='' ><h4>It is a long established fact that a reader will be.</h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p><a href='single-blog' class='btn btn-primary btn-black'>Read More</a></div><div class='bolg-item'><img class='img-fluid' src='assets/images/blog-single.jpg' alt='' ><h4>It is a long established fact that a reader will be.</h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p><a href='single-blog' class='btn btn-primary btn-black'>Read More</a></div><div class='bolg-item'><img class='img-fluid' src='assets/images/blog-single.jpg' alt='' ><h4>It is a long established fact that a reader will be.</h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p><a href='single-blog' class='btn btn-primary btn-black'>Read More</a></div></div></div></div></div></section><!-- CLIENTS SAY SECTION --><section class='home-blog-section p-0'><div class='container p-0'><div class='row g-0'><div class='col col-12 col-md-6 order-1 order-md-0'><div class='home-client-list custom-slick-arrow'><div class='client-item'><img class='img-fluid' src='assets/images/user.jpg' alt='' ><h4>Martin williams <span>-Potential customer</span></h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p></div><div class='client-item'><img class='img-fluid' src='assets/images/user.jpg' alt='' ><h4>Martin williams <span>-Potential customer</span></h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p></div><div class='client-item'><img class='img-fluid' src='assets/images/user.jpg' alt='' ><h4>Martin williams <span>-Potential customer</span></h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p></div></div></div><div class='col col-12 col-md-6'><div class='blog-box text-white'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Clients Say</h2><p class='text-white'>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of usingIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of usingIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of usingIt is a long established fact that a reader will be distracted by the readable content.</p></div></div></div></div></section><!-- PARTNERS SECTION --><section class='partners-section'><div class='container'><div class='row'><div class='col col-12'><h2 class='text-center'>Our Partners</h2><div class='partners-slider custom-slick-arrow'><img src='assets/images/partners.png' alt='' ><img src='assets/images/partners.png' alt='' ><img src='assets/images/partners.png' alt='' ><img src='assets/images/partners.png' alt='' ><img src='assets/images/partners.png' alt='' ></div></div></div></div></section></div>");
        //     $data_array['default_content']=clean_html("<div class='content-wrapper'><!-- LANDING SECTION --><section class='landing-section p-0'><div class='landing-bg'><img src='assets/images/PSNM.gif' alt='PSNM' ></div><div class='landing-content'><div class='container'><div class='section-head'><img src='assets/images/logo-slider.png' class='img-fluid' alt='img' ><p class='description'>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normalIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </p><div class='flex social-btns'> <a class='app-btn blu flex vert' href='javascript:;'> <img src='assets/images/apple.png' alt='' > <p>Available on the <br> <span class='big-txt'>App Store</span></p> </a> <a class='app-btn blu flex vert' href='javascript:;'> <img src='assets/images/playstore.png' alt='' > <p>Get it on <br> <span class='big-txt'>Google Play</span></p> </a></div></div></div></div></section><!-- UNEARTHING SECTION --><section class='unearthing-section'><div class='container'><div class='section-head'><h2 class='title'>What are lab grown diamonds?</h2></div><div class='section-content'><div class='row align-items-center'><div class='col col-12 col-sm-12 col-md-6'><div class='unearthing-img'><img src='assets/images/diamond.gif' class='img-fluid' alt='img' ></div></div><div class='col col-12 col-sm-12 col-md-6'><div class='unearthing-details'><p class='description'>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p></div></div></div></div></div><div class='container'><div class='row'><div class='col col-12 text-center mb-3'><h3 class='text-uppercase'>Ready to get started</h3></div><!-- <div class='col col-12 col-md-2 mb-4 mb-md-0'></div><div class='col col-12 col-md-8 mb-4 mb-md-0'></div><div class='col col-12 col-md-2 mb-4 mb-md-0'></div> --></div><div class='row justify-content-center'><div class='col col-12 col-md-4 col-lg-3 mb-4 mb-md-0'><a href='login' class='btn btn-primary grown-diamonds-btn'><span class='col-md-3'><img class='title-diamond_img' src='assets/images/Polish.png' alt='' ></span><span class='col-md-9'>Shop Polish Diamonds</span></a></div><div class='col col-12 col-md-4 col-lg-3 mb-4 mb-md-0'><a href='login' class='btn btn-primary grown-diamonds-btn'><img class='title-diamond_img' src='assets/images/4p.png' alt='' > Shop 4p Diamonds</a></div><div class='col col-12 col-md-4 col-lg-3 mb-4 mb-md-0'><a href='login' class='btn btn-primary grown-diamonds-btn'><img class='title-diamond_img' src='assets/images/Rough.png' alt='' > Shop Rough Diamonds</a></div></div></div></section><!-- WHAT WE FOLLOW SECTION --><section class='follow-section text-white' data-parallax='scroll' data-image-src='assets/images/follow.png'><div class='container'><div class='row align-items-center'><div class='col col-12 col-sm-12 col-md-6'><div class='follow-details'><h2 class='title mb-4'> What We Follow?</h2><p class='mb-4 pb-3 text-white'>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><a href='grading' class='btn btn-primary'>Read More</a></div></div></div></div></section><!-- about SECTION --><section class='about-home-section'><div class='container'><div class='row align-items-center'><div class='col col-12 col-md-7'><img class='img-fluid w-100' src='assets/images/about-home.png' alt='' ></div><div class='col col-12 col-md-5'><div class='about-box'><h2>About Us</h2><p>As opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.</p><a href='about' class='btn btn-primary'>Read More</a></div></div></div></div></section><!-- WHAT WE HAVE SECTION --><section class='we-have-section text-white' data-parallax='scroll' data-image-src='assets/images/what-we-have.jpg'><div class='container'><div class='row justify-content-end'><div class='col col-12 col-md-6'><h2>What We Have?</h2><p class='text-white'>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><a href='diamonds' class='btn btn-primary'>Read More</a></div></div></div></section><!-- CORE VALUES SECTION --><section class='core-values-section'><div class='container'><div class='row align-items-center'><div class='col col-12 col-md-12 col-lg-6 mb-4 mb-lg-0'><h2>Core Values</h2><p>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div><div class='col col-12 col-md-6 col-lg-3'><div class='card core-value-card'><div class='card-body'><img class='img-fluid' src='assets/images/suitcase_work_icon.svg' alt='' ><h4>Excellence at Work</h4><p>Editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div></div><div class='card core-value-card'><div class='card-body'><img class='img-fluid' src='assets/images/suitcase_work_icon.svg' alt='' ><h4>Excellence at Work</h4><p>Editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div></div></div><div class='col col-12 col-md-6 col-lg-3'><div class='card core-value-card'><div class='card-body'><img class='img-fluid' src='assets/images/suitcase_work_icon.svg' alt='' ><h4>Excellence at Work</h4><p>Editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div></div></div></div></div></section><!-- BLOG SECTION --><section class='home-blog-section p-0'><div class='container p-0'><div class='row g-0'><div class='col col-12 col-md-6'><div class='blog-box text-white'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Latest Blogs</h2><p class='text-white'>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</p><div class='text-center mt-4'><a href='blog' class='btn btn-primary'>Read More</a></div></div></div><div class='col col-12 col-md-6'><div class='home-blog-list custom-slick-arrow'><div class='bolg-item'><img class='img-fluid' src='assets/images/blog-single.jpg' alt='' ><h4>It is a long established fact that a reader will be.</h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p><a href='single-blog' class='btn btn-primary btn-black'>Read More</a></div><div class='bolg-item'><img class='img-fluid' src='assets/images/blog-single.jpg' alt='' ><h4>It is a long established fact that a reader will be.</h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p><a href='single-blog' class='btn btn-primary btn-black'>Read More</a></div><div class='bolg-item'><img class='img-fluid' src='assets/images/blog-single.jpg' alt='' ><h4>It is a long established fact that a reader will be.</h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p><a href='single-blog' class='btn btn-primary btn-black'>Read More</a></div></div></div></div></div></section><!-- CLIENTS SAY SECTION --><section class='home-blog-section p-0'><div class='container p-0'><div class='row g-0'><div class='col col-12 col-md-6 order-1 order-md-0'><div class='home-client-list custom-slick-arrow'><div class='client-item'><img class='img-fluid' src='assets/images/user.jpg' alt='' ><h4>Martin williams <span>-Potential customer</span></h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p></div><div class='client-item'><img class='img-fluid' src='assets/images/user.jpg' alt='' ><h4>Martin williams <span>-Potential customer</span></h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p></div><div class='client-item'><img class='img-fluid' src='assets/images/user.jpg' alt='' ><h4>Martin williams <span>-Potential customer</span></h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p></div></div></div><div class='col col-12 col-md-6'><div class='blog-box text-white'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' > Clients Say</h2><p class='text-white'>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of usingIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of usingIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of usingIt is a long established fact that a reader will be distracted by the readable content.</p></div></div></div></div></section><!-- PARTNERS SECTION --><section class='partners-section'><div class='container'><div class='row'><div class='col col-12'><h2 class='text-center'>Our Partners</h2><div class='partners-slider custom-slick-arrow'><img src='assets/images/partners.png' alt='' ><img src='assets/images/partners.png' alt='' ><img src='assets/images/partners.png' alt='' ><img src='assets/images/partners.png' alt='' ><img src='assets/images/partners.png' alt='' ></div></div></div></div></section></div>");
        //     $data_array['slug']=clean_string('index');
        //     $data_array['updated_by']=1;
        //     $data_array['is_active']=1;
        //     $data_array['date_updated']=date("Y-m-d H:i:s");
        //     array_push($informative_pages_array,$data_array);

        // DB::table('informative_pages')->insert($informative_pages_array);
        //******************* Informative Pages Entry End *******************//


        //******************* Atttribute groups Entry start *******************//
        $delete = DB::table('attribute_groups')->truncate();
        $attribute_groups_array=array();
        $categories = DB::table('categories')->where('is_active',1)->where('is_deleted',0)->get();
        foreach ($categories as $row){
            if($row->category_type== config('constant.CATEGORY_TYPE_ROUGH')){
                $data_array=array();
                $data_array['name']='CLARITY';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=2;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='SHAPE';
                $data_array['image_required']=1;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='COLOR';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=3;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='COMMENT';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=0;
                $data_array['sort_order']=15;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='LOCATION';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=0;
                $data_array['sort_order']=16;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

            }
            if($row->category_type==config('constant.CATEGORY_TYPE_4P')){
                $data_array=array();
                $data_array['name']='CUT';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=4;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='CLARITY';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=3;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='COLOR';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=2;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='EXP POL SIZE';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=5;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='SHAPE';
                $data_array['image_required']=1;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='HALF-CUT DIA';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='HALF-CUT HGT';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=1;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='PO. DIAMETER';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=2;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='COMMENT';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=0;
                $data_array['sort_order']=15;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='LOCATION';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=0;
                $data_array['sort_order']=16;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

            }
            if($row->category_type==config('constant.CATEGORY_TYPE_POLISH')){
                $data_array=array();
                $data_array['name']='CLARITY';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=1;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='COLOR';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=2;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='SHAPE';
                $data_array['image_required']=1;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='CERTIFICATE';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=9;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='CERTIFICATE URL';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=10;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='CROWN ANGLE';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=17;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='CROWN HEIGHT';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=16;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='CULET SIZE';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=11;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='CUT';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=3;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='DEPTH PERCENT';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=6;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='GIRDLE PERCENT';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=12;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='GRIDLE CONDITION';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=13;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='GROWTH TYPE';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=19;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='LAB';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=8;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='MEASUREMENTS';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=14;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='PAVILION ANGLE';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=18;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='PAVILION DEPTH';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=15;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='POLISH';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=4;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='SYMMETRY';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=5;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='TABLE PERCENT';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=7;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='COMMENT';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=0;
                $data_array['sort_order']=21;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='LOCATION';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=0;
                $data_array['sort_order']=20;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d H:i:s");
                $data_array['date_updated']=date("Y-m-d H:i:s");
                array_push($attribute_groups_array,$data_array);
            }
        }
        DB::table('attribute_groups')->insert($attribute_groups_array);
        //******************* Atttribute groups Entry end *******************//


        //******************* Atttributes Entry start *******************//
        $delete = DB::table('attributes')->truncate();
        $attribute_array=array();

            $data_array=array();
            $data_array['name']='Round';
            $data_array['attribute_group_id']=2;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Oval';
            $data_array['attribute_group_id']=2;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Heart';
            $data_array['attribute_group_id']=2;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Pear';
            $data_array['attribute_group_id']=2;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Princess';
            $data_array['attribute_group_id']=2;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Radiant';
            $data_array['attribute_group_id']=2;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Asscher';
            $data_array['attribute_group_id']=2;
            $data_array['sort_order']=7;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Emerald';
            $data_array['attribute_group_id']=2;
            $data_array['sort_order']=8;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Cushion';
            $data_array['attribute_group_id']=2;
            $data_array['sort_order']=9;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Marquise';
            $data_array['attribute_group_id']=2;
            $data_array['sort_order']=11;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Baguette';
            $data_array['attribute_group_id']=2;
            $data_array['sort_order']=12;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Triangle';
            $data_array['attribute_group_id']=2;
            $data_array['sort_order']=13;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);



            //shape for 4p
            $data_array=array();
            $data_array['name']='Round';
            $data_array['attribute_group_id']=10;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Oval';
            $data_array['attribute_group_id']=10;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Heart';
            $data_array['attribute_group_id']=10;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Pear';
            $data_array['attribute_group_id']=10;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Princess';
            $data_array['attribute_group_id']=10;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Radiant';
            $data_array['attribute_group_id']=10;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Asscher';
            $data_array['attribute_group_id']=10;
            $data_array['sort_order']=7;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Emerald';
            $data_array['attribute_group_id']=10;
            $data_array['sort_order']=8;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Cushion';
            $data_array['attribute_group_id']=10;
            $data_array['sort_order']=9;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Marquise';
            $data_array['attribute_group_id']=10;
            $data_array['sort_order']=11;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Baguette';
            $data_array['attribute_group_id']=10;
            $data_array['sort_order']=12;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Triangle';
            $data_array['attribute_group_id']=10;
            $data_array['sort_order']=13;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            //shape for polish
            $data_array=array();
            $data_array['name']='Round';
            $data_array['attribute_group_id']=18;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Oval';
            $data_array['attribute_group_id']=18;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Heart';
            $data_array['attribute_group_id']=18;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Pear';
            $data_array['attribute_group_id']=18;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Princess';
            $data_array['attribute_group_id']=18;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Radiant';
            $data_array['attribute_group_id']=18;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Asscher';
            $data_array['attribute_group_id']=18;
            $data_array['sort_order']=7;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Emerald';
            $data_array['attribute_group_id']=18;
            $data_array['sort_order']=8;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Cushion';
            $data_array['attribute_group_id']=18;
            $data_array['sort_order']=9;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Marquise';
            $data_array['attribute_group_id']=18;
            $data_array['sort_order']=11;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Baguette';
            $data_array['attribute_group_id']=18;
            $data_array['sort_order']=12;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Triangle';
            $data_array['attribute_group_id']=18;
            $data_array['sort_order']=13;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            //clarity for rough
            $data_array=array();
            $data_array['name']='IF';
            $data_array['attribute_group_id']=1;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='VVS1';
            $data_array['attribute_group_id']=1;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='VVS2';
            $data_array['attribute_group_id']=1;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='VS1';
            $data_array['attribute_group_id']=1;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='VS2';
            $data_array['attribute_group_id']=1;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='SI1';
            $data_array['attribute_group_id']=1;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='SI2';
            $data_array['attribute_group_id']=1;
            $data_array['sort_order']=7;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='SI3';
            $data_array['attribute_group_id']=1;
            $data_array['sort_order']=8;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='I1';
            $data_array['attribute_group_id']=1;
            $data_array['sort_order']=9;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='I2';
            $data_array['attribute_group_id']=1;
            $data_array['sort_order']=10;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='I3';
            $data_array['attribute_group_id']=1;
            $data_array['sort_order']=11;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);


            //clarity for polish
            $data_array=array();
            $data_array['name']='IF';
            $data_array['attribute_group_id']=16;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='VVS1';
            $data_array['attribute_group_id']=16;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='VVS2';
            $data_array['attribute_group_id']=16;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='VS1';
            $data_array['attribute_group_id']=16;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='VS2';
            $data_array['attribute_group_id']=16;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='SI1';
            $data_array['attribute_group_id']=16;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='SI2';
            $data_array['attribute_group_id']=16;
            $data_array['sort_order']=7;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='SI3';
            $data_array['attribute_group_id']=16;
            $data_array['sort_order']=8;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='I1';
            $data_array['attribute_group_id']=16;
            $data_array['sort_order']=9;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='I2';
            $data_array['attribute_group_id']=16;
            $data_array['sort_order']=10;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='I3';
            $data_array['attribute_group_id']=16;
            $data_array['sort_order']=11;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);


            //clarity for 4p
            $data_array=array();
            $data_array['name']='VS';
            $data_array['attribute_group_id']=7;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='SI';
            $data_array['attribute_group_id']=7;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);


            //color for 4p
            $data_array=array();
            $data_array['name']='D-E';
            $data_array['attribute_group_id']=8;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='E-F';
            $data_array['attribute_group_id']=8;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='F-G';
            $data_array['attribute_group_id']=8;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='G-H';
            $data_array['attribute_group_id']=8;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='H-I';
            $data_array['attribute_group_id']=8;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='I-J';
            $data_array['attribute_group_id']=8;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='J-K';
            $data_array['attribute_group_id']=8;
            $data_array['sort_order']=7;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            //color for Polish
            $data_array=array();
            $data_array['name']='D';
            $data_array['attribute_group_id']=17;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='E';
            $data_array['attribute_group_id']=17;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='F';
            $data_array['attribute_group_id']=17;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='G';
            $data_array['attribute_group_id']=17;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='H';
            $data_array['attribute_group_id']=17;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='I';
            $data_array['attribute_group_id']=17;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='J';
            $data_array['attribute_group_id']=17;
            $data_array['sort_order']=7;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='K';
            $data_array['attribute_group_id']=17;
            $data_array['sort_order']=8;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);


            //color for Rough
            $data_array=array();
            $data_array['name']='D';
            $data_array['attribute_group_id']=3;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='E';
            $data_array['attribute_group_id']=3;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='F';
            $data_array['attribute_group_id']=3;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='G';
            $data_array['attribute_group_id']=3;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='H';
            $data_array['attribute_group_id']=3;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='I';
            $data_array['attribute_group_id']=3;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='J';
            $data_array['attribute_group_id']=3;
            $data_array['sort_order']=7;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='K';
            $data_array['attribute_group_id']=3;
            $data_array['sort_order']=8;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            //cut for Polish
            $data_array=array();
            $data_array['name']='IDEAL';
            $data_array['attribute_group_id']=24;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='EXCELLENT';
            $data_array['attribute_group_id']=24;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='VERY GOOD';
            $data_array['attribute_group_id']=24;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='GOOD';
            $data_array['attribute_group_id']=24;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);


            $data_array=array();
            $data_array['name']='FAIR';
            $data_array['attribute_group_id']=24;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='POOR';
            $data_array['attribute_group_id']=24;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);


            //cut for 4p
            $data_array=array();
            $data_array['name']='IDEAL';
            $data_array['attribute_group_id']=6;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='EXCELLENT';
            $data_array['attribute_group_id']=6;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='VERY GOOD';
            $data_array['attribute_group_id']=6;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='GOOD';
            $data_array['attribute_group_id']=6;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='FAIR';
            $data_array['attribute_group_id']=6;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='POOR';
            $data_array['attribute_group_id']=6;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);


            //polish for polish
            $data_array=array();
            $data_array['name']='IDEAL';
            $data_array['attribute_group_id']=33;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='EXCELLENT';
            $data_array['attribute_group_id']=33;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='VERY GOOD';
            $data_array['attribute_group_id']=33;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='GOOD';
            $data_array['attribute_group_id']=33;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);


            $data_array=array();
            $data_array['name']='FAIR';
            $data_array['attribute_group_id']=33;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='POOR';
            $data_array['attribute_group_id']=33;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            //SYMMETRY for polish
            $data_array=array();
            $data_array['name']='IDEAL';
            $data_array['attribute_group_id']=34;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='EXCELLENT';
            $data_array['attribute_group_id']=34;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='VERY GOOD';
            $data_array['attribute_group_id']=34;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='GOOD';
            $data_array['attribute_group_id']=34;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);


            $data_array=array();
            $data_array['name']='FAIR';
            $data_array['attribute_group_id']=34;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='POOR';
            $data_array['attribute_group_id']=34;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);


            //GRIDLE CONDITION for polish
            $data_array=array();
            $data_array['name']='Medium To Slightly Thick (Faceted)';
            $data_array['attribute_group_id']=27;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Medium To Slightly Thick (Faceted)';
            $data_array['attribute_group_id']=27;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Medium (Faceted)';
            $data_array['attribute_group_id']=27;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Medium To Thick (Faceted)';
            $data_array['attribute_group_id']=27;
            $data_array['sort_order']=4;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Slightly Thick To Thick (Faceted)';
            $data_array['attribute_group_id']=27;
            $data_array['sort_order']=5;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Medium To Slightly Thick';
            $data_array['attribute_group_id']=27;
            $data_array['sort_order']=6;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Slightly Thick To Thick';
            $data_array['attribute_group_id']=27;
            $data_array['sort_order']=7;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Medium';
            $data_array['attribute_group_id']=27;
            $data_array['sort_order']=8;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Thick';
            $data_array['attribute_group_id']=27;
            $data_array['sort_order']=9;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            $data_array=array();
            $data_array['name']='Slightly Thick';
            $data_array['attribute_group_id']=27;
            $data_array['sort_order']=10;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

            //LAB for polish
            $data_array=array();
            $data_array['name']='IGI';
            $data_array['attribute_group_id']=29;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($attribute_array,$data_array);

        DB::table('attributes')->insert($attribute_array);
        //******************* Atttributes Entry end *******************//


        //******************* Labour Charges Entry start *******************//
        $delete = DB::table('labour_charges')->truncate();
        $labour_charges_array=array();

            $data_array=array();
            $data_array['labour_charge_id']=1;
            $data_array['name']='4P diamonds';
            $data_array['amount']=25;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($labour_charges_array,$data_array);

            $data_array=array();
            $data_array['labour_charge_id']=2;
            $data_array['name']='Rough Diamonds';
            $data_array['amount']=65;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d H:i:s");
            $data_array['date_updated']=date("Y-m-d H:i:s");
            array_push($labour_charges_array,$data_array);

        DB::table('labour_charges')->insert($labour_charges_array);
        //******************* Labour Charges Entry end *******************//


        //******************* Order Statuses Entry start *******************//
        DB::table('order_statuses')->truncate();
        $order_statuses_array = array();

            $data_array = array();
            $data_array['order_status_id'] = 1;
            $data_array['name'] = 'PENDING';
            $data_array['sort_order'] = 0;
            $data_array['is_active'] = 1;
            $data_array['is_deleted'] = 0;
            $data_array['date_added'] = date("Y-m-d H:i:s");
            $data_array['date_updated'] = date("Y-m-d H:i:s");
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($order_statuses_array, $data_array);

            $data_array = array();
            $data_array['order_status_id'] = 2;
            $data_array['name'] = 'UNPAID';
            $data_array['sort_order'] = 1;
            $data_array['is_active'] = 1;
            $data_array['is_deleted'] = 0;
            $data_array['date_added'] = date("Y-m-d H:i:s");
            $data_array['date_updated'] = date("Y-m-d H:i:s");
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($order_statuses_array, $data_array);

            $data_array = array();
            $data_array['order_status_id'] = 3;
            $data_array['name'] = 'PAID';
            $data_array['sort_order'] = 2;
            $data_array['is_active'] = 1;
            $data_array['is_deleted'] = 0;
            $data_array['date_added'] = date("Y-m-d H:i:s");
            $data_array['date_updated'] = date("Y-m-d H:i:s");
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($order_statuses_array, $data_array);

            $data_array = array();
            $data_array['order_status_id'] = 4;
            $data_array['name'] = 'CANCELLED';
            $data_array['sort_order'] = 3;
            $data_array['is_active'] = 1;
            $data_array['is_deleted'] = 0;
            $data_array['date_added'] = date("Y-m-d H:i:s");
            $data_array['date_updated'] = date("Y-m-d H:i:s");
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($order_statuses_array, $data_array);

        DB::table('order_statuses')->insert($order_statuses_array);
        //******************* Order Statuses Entry end *******************//

        $this->createElasticIndex();
        $this->truncateDiamonds();
        DB::table('customer_cart')->truncate();
        DB::table('customer_whishlist')->truncate();
        DB::table('orders')->truncate();
        DB::table('order_diamonds')->truncate();
        DB::table('order_updates')->truncate();
        DB::table('recently_view_diamonds')->truncate();
        DB::table('share_cart')->truncate();
        DB::table('share_wishlist')->truncate();
        successOrErrorMessage("Project Setup Done", 'success');
        return redirect('admin/dashboard');
    }

    public function createElasticIndex()
    {
        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();

        $client->indices()->delete(['index' => 'diamonds']);

        $params = [
            'index' => 'diamonds',
            // 'id'    => 'diamond_id',
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,

                    "analysis" => [
                        "normalizer" => [
                            "analyzer_case_insensitive" => [
                                "type" => "custom",
                                "filter" => ["lowercase"]
                            ]
                        ]
                    ]

                ],
                'mappings' => [
                    'properties' => [
                        "diamond_id" => [
                            "type" => "long"
                        ],
                        'name' => [
                            'type' => 'text'
                        ],
                        "actual_pcs" => [
                            "type" => "long"
                        ],
                        "added_by" => [
                            "type" => "long"
                        ],
                        "available_pcs" => [
                            "type" => "long"
                        ],
                        "barcode" => [
                            "type" => "keyword"
                        ],
                        "barcode_search" => [
                            "type" => "keyword",
                            "normalizer" => "analyzer_case_insensitive"
                        ],
                        "date_added" => [
                            "type" => "date",
                            "format" => "yyyy-MM-dd HH:mm:ss"
                        ],
                        "date_updated" => [
                            "type" => "date",
                            "format" => "yyyy-MM-dd HH:mm:ss"
                        ],
                        "discount" => [
                            "type" => "float"
                        ],
                        "expected_polish_cts" => [
                            "type" => "double"
                        ],
                        "makable_cts" => [
                            "type" => "double"
                        ],
                        "image" => [
                            "type" => "text"
                        ],
                        "is_active" => [
                            "type" => "byte"
                        ],
                        "is_deleted" => [
                            "type" => "byte"
                        ],
                        "is_recommended" => [
                            "type" => "byte"
                        ],
                        "packate_no" => [
                            "type" => "text"
                        ],
                        "packate_no_sort" => [
                            "type" => "double"
                        ],
                        "rapaport_price" => [
                            "type" => "double"
                        ],
                        "refCategory_id" => [
                            "type" => "integer"
                        ],
                        "remarks" => [
                            "type" => "text"
                        ],
                        "price_ct" => [
                            "type" => "double"
                        ],
                        "total" => [
                            "type" => "double"
                        ],
                        "weight_loss" => [
                            "type" => "text"
                        ],
                        "attributes" => [
                            "type" => "flattened"
                        ],
                        "attributes_id" => [
                            "type" => "nested"
                        ]
                    ]
                ]
            ]
        ];

        $client->indices()->create($params);
        return redirect('admin/dashboard');
    }

    public function truncateDiamonds()
    {
        $this->createElasticIndex();
        DB::table('diamonds')->truncate();
        DB::table('diamonds_attributes')->truncate();

        //******************* Most Ordered Diamonds Entry start *******************//
        DB::table('most_ordered_diamonds')->truncate();
        $mvd = array();

        // ------------------------ Rough Category ----------------------
            $data_array = array();
            $data_array['refCategory_id'] = 1;
            $data_array['shape'] = 'Round';
            $data_array['color'] = 'D';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'VVS1';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 1;
            $data_array['shape'] = 'Oval';
            $data_array['color'] = 'E';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'VVS2';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 1;
            $data_array['shape'] = 'Heart';
            $data_array['color'] = 'F';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'VS1';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 1;
            $data_array['shape'] = 'Pear';
            $data_array['color'] = 'G';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'VS2';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 1;
            $data_array['shape'] = 'Princess';
            $data_array['color'] = 'H';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'SI1';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 1;
            $data_array['shape'] = 'Emerald';
            $data_array['color'] = 'I';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'SI2';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 1;
            $data_array['shape'] = 'Cushion';
            $data_array['color'] = 'J';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'IF';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 1;
            $data_array['shape'] = 'Radiant';
            $data_array['color'] = 'K';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'SI3';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 1;
            $data_array['shape'] = 'Asscher';
            $data_array['color'] = null;
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'I1';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 1;
            $data_array['shape'] = 'Marquise';
            $data_array['color'] = null;
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'I2';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 1;
            $data_array['shape'] = 'Baguette';
            $data_array['color'] = null;
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'I3';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 1;
            $data_array['shape'] = 'Triangle';
            $data_array['color'] = null;
            $data_array['carat'] = 0;
            $data_array['clarity'] = null;
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);


        // ----------------------------- 4P Category ----------------------------------
            $data_array = array();
            $data_array['refCategory_id'] = 2;
            $data_array['shape'] = 'Round';
            $data_array['color'] = 'D-E';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'VS';
            $data_array['cut'] = 'IDEAL';
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 2;
            $data_array['shape'] = 'Oval';
            $data_array['color'] = 'E-F';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'SI';
            $data_array['cut'] = 'EXCELLENT';
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 2;
            $data_array['shape'] = 'Heart';
            $data_array['color'] = 'F-G';
            $data_array['carat'] = 0;
            $data_array['clarity'] = null;
            $data_array['cut'] = 'VERY GOOD';
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 2;
            $data_array['shape'] = 'Pear';
            $data_array['color'] = 'G-H';
            $data_array['carat'] = 0;
            $data_array['clarity'] = null;
            $data_array['cut'] = 'GOOD';
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 2;
            $data_array['shape'] = 'Princess';
            $data_array['color'] = 'H-I';
            $data_array['carat'] = 0;
            $data_array['clarity'] = null;
            $data_array['cut'] = 'FAIR';
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 2;
            $data_array['shape'] = 'Emerald';
            $data_array['color'] = 'I-J';
            $data_array['carat'] = 0;
            $data_array['clarity'] = null;
            $data_array['cut'] = 'POOR';
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 2;
            $data_array['shape'] = 'Cushion';
            $data_array['color'] = 'J-K';
            $data_array['carat'] = 0;
            $data_array['clarity'] = null;
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 2;
            $data_array['shape'] = 'Radiant';
            $data_array['color'] = null;
            $data_array['carat'] = 0;
            $data_array['clarity'] = null;
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 2;
            $data_array['shape'] = 'Asscher';
            $data_array['color'] = null;
            $data_array['carat'] = 0;
            $data_array['clarity'] = null;
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 2;
            $data_array['shape'] = 'Marquise';
            $data_array['color'] = null;
            $data_array['carat'] = 0;
            $data_array['clarity'] = null;
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 2;
            $data_array['shape'] = 'Baguette';
            $data_array['color'] = null;
            $data_array['carat'] = 0;
            $data_array['clarity'] = null;
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 2;
            $data_array['shape'] = 'Triangle';
            $data_array['color'] = null;
            $data_array['carat'] = 0;
            $data_array['clarity'] = null;
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);


        // --------------------------- Polish Category ----------------------------------
            $data_array = array();
            $data_array['refCategory_id'] = 3;
            $data_array['shape'] = 'Round';
            $data_array['color'] = 'D';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'VVS1';
            $data_array['cut'] = 'IDEAL';
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 3;
            $data_array['shape'] = 'Oval';
            $data_array['color'] = 'E';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'VVS2';
            $data_array['cut'] = 'EXCELLENT';
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 3;
            $data_array['shape'] = 'Heart';
            $data_array['color'] = 'F';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'VS1';
            $data_array['cut'] = 'VERY GOOD';
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 3;
            $data_array['shape'] = 'Pear';
            $data_array['color'] = 'G';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'VS2';
            $data_array['cut'] = 'GOOD';
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 3;
            $data_array['shape'] = 'Princess';
            $data_array['color'] = 'H';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'SI1';
            $data_array['cut'] = 'FAIR';
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 3;
            $data_array['shape'] = 'Emerald';
            $data_array['color'] = 'I';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'SI2';
            $data_array['cut'] = 'POOR';
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 3;
            $data_array['shape'] = 'Cushion';
            $data_array['color'] = 'J';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'IF';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 3;
            $data_array['shape'] = 'Radiant';
            $data_array['color'] = 'K';
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'SI3';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 3;
            $data_array['shape'] = 'Asscher';
            $data_array['color'] = null;
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'I1';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 3;
            $data_array['shape'] = 'Marquise';
            $data_array['color'] = null;
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'I2';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 3;
            $data_array['shape'] = 'Baguette';
            $data_array['color'] = null;
            $data_array['carat'] = 0;
            $data_array['clarity'] = 'I3';
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

            $data_array = array();
            $data_array['refCategory_id'] = 3;
            $data_array['shape'] = 'Triangle';
            $data_array['color'] = null;
            $data_array['carat'] = 0;
            $data_array['clarity'] = null;
            $data_array['cut'] = null;
            $data_array['shape_cnt'] = 0;
            $data_array['color_cnt'] = 0;
            $data_array['carat_cnt'] = 0;
            $data_array['clarity_cnt'] = 0;
            $data_array['cut_cnt'] = 0;
            $data_array['created_at'] = date("Y-m-d H:i:s");
            $data_array['updated_at'] = date("Y-m-d H:i:s");
            array_push($mvd, $data_array);

        DB::table('most_ordered_diamonds')->insert($mvd);
        //******************* Most Ordered Diamonds Entry end *******************//


        //******************* Most Viewed Diamonds Entry start *******************//
        DB::table('most_viewed_diamonds')->truncate();
        DB::table('most_viewed_diamonds')->insert([
            [
                'refCategory_id' => 1,
                'views_cnt' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], [
                'refCategory_id' => 2,
                'views_cnt' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], [
                'refCategory_id' => 3,
                'views_cnt' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);
        //******************* Most Viewed Diamonds Entry end *******************//
        return redirect('admin/dashboard');
    }

    public function truncateOrders()
    {
        DB::table('orders')->truncate();
        DB::table('order_updates')->truncate();
        DB::table('order_diamonds')->truncate();
    }

   /* public function delete(Request $request) {
       if (isset($_REQUEST['table_id'])) {

           $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([
               'is_deleted' => 1,
               'date_updated' => date("Y-m-d H:i:s")
           ]);
           activity($request,"deleted",$_REQUEST['module']);
        //    $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->delete();
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
   public function status(Request $request) {
       if (isset($_REQUEST['table_id'])) {

           $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->update([
               'is_active' => $_REQUEST['status'],
               'date_updated' => date("Y-m-d H:i:s")
           ]);
        //    $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->delete();
           if ($res) {
               $data = array(
                   'suceess' => true
               );
           } else {
               $data = array(
                   'suceess' => false
               );
           }
           activity($request,"updated",$_REQUEST['module']);
           return response()->json($data);
       }
   } */

   public function delete_image(Request $request) {
        if (isset($_REQUEST['table_id'])) {

            $result = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->first();

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
                'date_updated' => date("Y-m-d H:i:s")
            ]);
            // activity($request,"deleted",$_REQUEST['module']);
            // $res = DB::table($_REQUEST['table'])->where($_REQUEST['wherefield'], $_REQUEST['table_id'])->delete();
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
