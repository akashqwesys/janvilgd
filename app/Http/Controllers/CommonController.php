<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;
use DataTables;

class CommonController extends Controller
{

    public function projectSetup() {

        $delete = DB::table('modules')->truncate();
        //******************* Parent Modules Entry Start *******************//
        $modules_array=array();
        $parent_modules = DB::table('modules')->where('parent_id',0)->first();
        if(empty($parent_modules)){
            $data_array=array();
            $data_array['name']='Dashboard';
            $data_array['icon']='None';
            $data_array['slug']=clean_string('None');
            $data_array['parent_id']=0;
            $data_array['sort_order']=1;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d h:i:s");
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['name']='Master Modules';
            $data_array['icon']='None';
            $data_array['slug']=clean_string('None');
            $data_array['parent_id']=0;
            $data_array['sort_order']=2;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d h:i:s");
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($modules_array,$data_array);

            $data_array=array();
            $data_array['name']='Website Modules';
            $data_array['icon']='None';
            $data_array['slug']=clean_string('None');
            $data_array['parent_id']=0;
            $data_array['sort_order']=3;
            $data_array['added_by']=1;
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;
            $data_array['date_added']=date("Y-m-d h:i:s");
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($modules_array,$data_array);

            DB::table('modules')->insert($modules_array);
        }
        //******************* Parent Modules Entry End *******************//


        //******************* Sub Modules Entry Start *******************//

        $parent_modules = DB::table('modules')->where('parent_id','>=', 1)->first();
        if(empty($parent_modules)){
            $parent_modules = DB::table('modules')->where('parent_id',0)->get();
            $modules_array=array();
            foreach ($parent_modules as $row){
                if($row->name=="Dashboard"){
                    $data_array=array();
                    $data_array['name']='Dashboard';
                    $data_array['icon']='ni-dashboard-fill';
                    $data_array['slug']=clean_string('dashboard');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);
                }
                if($row->name=="Master Modules"){
                    $data_array=array();
                    $data_array['name']='Rapaport';
                    $data_array['icon']='ni ni-centos';
                    $data_array['slug']=clean_string('rapaport');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Attributes';
                    $data_array['icon']='ni-behance-fill';
                    $data_array['slug']=clean_string('attributes');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Attribute Groups';
                    $data_array['icon']='ni-behance-fill';
                    $data_array['slug']=clean_string('attribute-groups');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Sliders';
                    $data_array['icon']='ni-img-fill';
                    $data_array['slug']=clean_string('sliders');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Taxes';
                    $data_array['icon']='ni-money';
                    $data_array['slug']=clean_string('taxes');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Delivery Charges';
                    $data_array['icon']='ni-tranx';
                    $data_array['slug']=clean_string('delivery-charges');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Customers';
                    $data_array['icon']='ni-user-fill-c';
                    $data_array['slug']=clean_string('customers');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);
                    
                    
                    $data_array=array();
                    $data_array['name']='Orders';
                    $data_array['icon']='ni-package';
                    $data_array['slug']=clean_string('orders');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);
                    

                    $data_array=array();
                    $data_array['name']='Users';
                    $data_array['icon']='ni-users-fill';
                    $data_array['slug']=clean_string('users');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='User Roles';
                    $data_array['icon']='ni-user-check-fill';
                    $data_array['slug']=clean_string('user-role');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='City';
                    $data_array['icon']='ni-map-pin-fill';
                    $data_array['slug']=clean_string('city');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='State';
                    $data_array['icon']='ni-map-pin-fill';
                    $data_array['slug']=clean_string('state');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Country';
                    $data_array['icon']='ni-map-pin-fill';
                    $data_array['slug']=clean_string('country');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='User Activity';
                    $data_array['icon']='ni-activity';
                    $data_array['slug']=clean_string('user-activity');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Transport';
                    $data_array['icon']='ni-truck';
                    $data_array['slug']=clean_string('transport');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Payment Modes';
                    $data_array['icon']='ni-money';
                    $data_array['slug']=clean_string('payment-modes');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Labour Charges';
                    $data_array['icon']='ni-account-setting';
                    $data_array['slug']=clean_string('labour-charges');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Discount';
                    $data_array['icon']='ni-tag-fill';
                    $data_array['slug']=clean_string('discount');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Customer Type';
                    $data_array['icon']='ni-users-fill';
                    $data_array['slug']=clean_string('customer-type');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Categories';
                    $data_array['icon']='ni-list-fill';
                    $data_array['slug']=clean_string('categories');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Designation';
                    $data_array['icon']='ni-briefcase';
                    $data_array['slug']=clean_string('designation');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Settings';
                    $data_array['icon']='ni-setting-fill';
                    $data_array['slug']=clean_string('settings');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                }
                if($row->name=="Website Modules"){
                    $data_array=array();
                    $data_array['name']='Events';
                    $data_array['icon']='ni-award';
                    $data_array['slug']=clean_string('events');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Web Settings';
                    $data_array['icon']='ni-setting-fill';
                    $data_array['slug']=clean_string('web-settings');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Informative Pages';
                    $data_array['icon']='ni-info-fill';
                    $data_array['slug']=clean_string('informative-pages');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);

                    $data_array=array();
                    $data_array['name']='Blogs';
                    $data_array['icon']='ni-blogger-fill';
                    $data_array['slug']=clean_string('blogs');
                    $data_array['parent_id']=$row->module_id;
                    $data_array['sort_order']=0;
                    $data_array['added_by']=1;
                    $data_array['is_active']=1;
                    $data_array['is_deleted']=0;
                    $data_array['date_added']=date("Y-m-d h:i:s");
                    $data_array['date_updated']=date("Y-m-d h:i:s");
                    array_push($modules_array,$data_array);
                }
            }
            DB::table('modules')->insert($modules_array);
        }

        //******************* Sub Modules Entry End *******************//


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
            $data_array['date_added']=date("Y-m-d h:i:s");
            $data_array['date_updated']=date("Y-m-d h:i:s");
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
            $data_array['date_added']=date("Y-m-d h:i:s");
            $data_array['date_updated']=date("Y-m-d h:i:s");
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
            $data_array['date_added']=date("Y-m-d h:i:s");
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($categories_array,$data_array);

            DB::table('categories')->insert($categories_array);
        //******************* Categories Entry End *******************//


        //******************* Informative Pages Entry Start *******************//

        $delete = DB::table('informative_pages')->truncate();
        $informative_pages_array=array();

            $data_array=array();
            $data_array['name']='Why to order online';
            $data_array['content']=clean_html("<div class='content-wrapper'><!-- BANNER SECTION START --><section class='diamonds-hero-section text-white mb-5' style='background-image:url(assets/images/diamonds-banner.jpg)'><div class='container'><div class='row'><div class='col col-12 col-md-6'><h2>Why to order online</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section><!-- BANNER SECTION END --></div>");
            $data_array['default_content']=clean_html("<div class='content-wrapper'><!-- BANNER SECTION START --><section class='diamonds-hero-section text-white mb-5' style='background-image:url(assets/images/diamonds-banner.jpg)'><div class='container'><div class='row'><div class='col col-12 col-md-6'><h2>Why to order online</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section><!-- BANNER SECTION END --></div>");
            $data_array['slug']=clean_string('why-to-order-online');
            $data_array['updated_by']=1;
            $data_array['is_active']=1;
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($informative_pages_array,$data_array);

            $data_array=array();
            $data_array['name']='Diamonds';
            $data_array['content']=clean_html("<div class='content-wrapper'><!-- BANNER SECTION START --><section class='diamonds-hero-section text-white' style='background-image: url(assets/images/diamonds-banner.jpg);'><div class='container'><div class='row'><div class='col col-12 col-md-10 col-lg-7 col-xl-6'><h2>Diamonds</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section><!-- BANNER SECTION END --><!-- SHOP DIAMOND BY SHAPE SECTION START --><section class='diamond-shape-section text-center pb-0'><div class='container'><div class='row'><div class='col col-12'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Shop Diamond By Shape</h2><ul class='diamond-list'><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large3.png' alt='' data-pagespeed-url-hash='3017176295' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large2.png' alt='' data-pagespeed-url-hash='2722676374' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large4.png' alt='' data-pagespeed-url-hash='3311676216' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large5.png' alt='' data-pagespeed-url-hash='3606176137' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large7.png' alt='' data-pagespeed-url-hash='4195175979' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large6.png' alt='' data-pagespeed-url-hash='3900676058' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large8.png' alt='' data-pagespeed-url-hash='194708604' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large1.png' alt='' data-pagespeed-url-hash='2428176453' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li></ul></div></div></div></section><!-- SHOP DIAMOND BY SHAPE SECTION END --><!-- BROWSE BEYOND CONFLICT FREE SECTION START --><section class='beyond-section'><div class='container'><div class='row'><div class='col col-12'><div class='beyond-content'><h2 class='text-center'><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Browse Beyond Conflict Free</h2><p class='text-white'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div><div class='col col-12 col-md-6 mb-4 mb-md-0'><img class='img-fluid' src='assets/images/Beyond-1.jpg' alt='' data-pagespeed-url-hash='281768360' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='col col-12 col-md-6'><img class='img-fluid' src='assets/images/Beyond-2.jpg' alt='' data-pagespeed-url-hash='576268281' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- BROWSE BEYOND CONFLICT FREE SECTION END --><!-- COLORED DIAMOND SECTION START --><section class='color-diamond-section pt-0'><div class='container'><div class='row'><div class='col col-12 col-md-12 col-lg-6'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Colored Diamond</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='col col-12 col-md-12 col-lg-6'><img class='img-fluid' src='assets/images/colored-diamond.png' alt='' data-pagespeed-url-hash='3116678586' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- COLORED DIAMOND SECTION END --></div>");
            $data_array['default_content']=clean_html("<div class='content-wrapper'><!-- BANNER SECTION START --><section class='diamonds-hero-section text-white' style='background-image: url(assets/images/diamonds-banner.jpg);'><div class='container'><div class='row'><div class='col col-12 col-md-10 col-lg-7 col-xl-6'><h2>Diamonds</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section><!-- BANNER SECTION END --><!-- SHOP DIAMOND BY SHAPE SECTION START --><section class='diamond-shape-section text-center pb-0'><div class='container'><div class='row'><div class='col col-12'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Shop Diamond By Shape</h2><ul class='diamond-list'><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large3.png' alt='' data-pagespeed-url-hash='3017176295' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large2.png' alt='' data-pagespeed-url-hash='2722676374' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large4.png' alt='' data-pagespeed-url-hash='3311676216' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large5.png' alt='' data-pagespeed-url-hash='3606176137' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large7.png' alt='' data-pagespeed-url-hash='4195175979' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large6.png' alt='' data-pagespeed-url-hash='3900676058' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large8.png' alt='' data-pagespeed-url-hash='194708604' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li><li><img class='img-fluid' src='assets/images/Diamond_Shapes_large1.png' alt='' data-pagespeed-url-hash='2428176453' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></li></ul></div></div></div></section><!-- SHOP DIAMOND BY SHAPE SECTION END --><!-- BROWSE BEYOND CONFLICT FREE SECTION START --><section class='beyond-section'><div class='container'><div class='row'><div class='col col-12'><div class='beyond-content'><h2 class='text-center'><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Browse Beyond Conflict Free</h2><p class='text-white'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div><div class='col col-12 col-md-6 mb-4 mb-md-0'><img class='img-fluid' src='assets/images/Beyond-1.jpg' alt='' data-pagespeed-url-hash='281768360' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='col col-12 col-md-6'><img class='img-fluid' src='assets/images/Beyond-2.jpg' alt='' data-pagespeed-url-hash='576268281' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- BROWSE BEYOND CONFLICT FREE SECTION END --><!-- COLORED DIAMOND SECTION START --><section class='color-diamond-section pt-0'><div class='container'><div class='row'><div class='col col-12 col-md-12 col-lg-6'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Colored Diamond</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='col col-12 col-md-12 col-lg-6'><img class='img-fluid' src='assets/images/colored-diamond.png' alt='' data-pagespeed-url-hash='3116678586' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- COLORED DIAMOND SECTION END --></div>");
            $data_array['slug']=clean_string('diamonds');
            $data_array['updated_by']=1;
            $data_array['is_active']=1;
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($informative_pages_array,$data_array);

            $data_array=array();
            $data_array['name']='Grading';
            $data_array['content']=clean_html("<div class='content-wrapper'><!-- BANNER SECTION START --><section class='diamonds-hero-section text-white' style='background-image:url(assets/images/diamonds-banner.jpg)'><div class='container'><div class='row'><div class='col col-12 col-md-10 col-lg-7 col-xl-6'><h2>Granding</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section><!-- BANNER SECTION END --><!-- WHAT IS DIAMOND CLARITY SECTION START --><section class='clarity-section pb-0'><div class='container text-white'><div class='row'><div class='col col-12 col-md-12 text-center'><div class='clarity-content'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> WHAT IS DIAMOND CLARITY?</h2><p class='text-white'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p></div></div></div></div></section><!-- WHAT IS DIAMOND CLARITY SECTION END --><!-- COLOR AND VALUE SECTION START --><section class='color-value-section'><div class='container'><div class='row'><div class='col col-12 text-center pb-5'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Color and Value</h2><p>Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value.</p></div><div class='col col-12 text-center'><img class='img-fluid' src='assets/images/d-color.jpg' alt='' data-pagespeed-url-hash='4226245959' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- COLOR AND VALUE SECTION END --><!-- CLARITY SECTION START --><section class='color-scale-section pt-0'><div class='container'><div class='row'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Clarity</h2><p>Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value.</p><img class='img-fluid pt-5' src='assets/images/d-clarity.jpg' alt='' data-pagespeed-url-hash='2884589816' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- CLARITY SECTION END --><!-- CUT SECTION START --><section class='cut-section pt-0 mb-5'><div class='container'><div class='row'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Cut</h2><p>Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value.</p><img class='img-fluid pt-3' src='assets/images/d-cut.jpg' alt='' data-pagespeed-url-hash='2285023082' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- CUT SECTION END --></div>");
            $data_array['default_content']=clean_html("<div class='content-wrapper'><!-- BANNER SECTION START --><section class='diamonds-hero-section text-white' style='background-image:url(assets/images/diamonds-banner.jpg)'><div class='container'><div class='row'><div class='col col-12 col-md-10 col-lg-7 col-xl-6'><h2>Granding</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section><!-- BANNER SECTION END --><!-- WHAT IS DIAMOND CLARITY SECTION START --><section class='clarity-section pb-0'><div class='container text-white'><div class='row'><div class='col col-12 col-md-12 text-center'><div class='clarity-content'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> WHAT IS DIAMOND CLARITY?</h2><p class='text-white'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p></div></div></div></div></section><!-- WHAT IS DIAMOND CLARITY SECTION END --><!-- COLOR AND VALUE SECTION START --><section class='color-value-section'><div class='container'><div class='row'><div class='col col-12 text-center pb-5'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Color and Value</h2><p>Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value.</p></div><div class='col col-12 text-center'><img class='img-fluid' src='assets/images/d-color.jpg' alt='' data-pagespeed-url-hash='4226245959' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- COLOR AND VALUE SECTION END --><!-- CLARITY SECTION START --><section class='color-scale-section pt-0'><div class='container'><div class='row'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Clarity</h2><p>Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value.</p><img class='img-fluid pt-5' src='assets/images/d-clarity.jpg' alt='' data-pagespeed-url-hash='2884589816' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- CLARITY SECTION END --><!-- CUT SECTION START --><section class='cut-section pt-0 mb-5'><div class='container'><div class='row'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Cut</h2><p>Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value. Subtle differences in color can dramatically affect diamond value. Two diamonds of the same clarity, weight, and cut can differ in value based on color alone. Even the slightest hint of color can make a dramatic difference in value.</p><img class='img-fluid pt-3' src='assets/images/d-cut.jpg' alt='' data-pagespeed-url-hash='2285023082' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- CUT SECTION END --></div>");
            $data_array['slug']=clean_string('grading');
            $data_array['updated_by']=1;
            $data_array['is_active']=1;
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($informative_pages_array,$data_array);

            $data_array=array();
            $data_array['name']='Terms & Conditions';
            $data_array['content']=clean_html("<div class='content-wrapper'><section class='term-condition-section sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title mb-0'>Terms And Condition</h2></div></div></section><section class='term-conditions policy-info-section'><div class='container'><div class='details-content'><div class='privacy-policy-point'><h4 class='point'>Title One :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Two :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Three :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Four :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Five :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Six :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section></div>");
            $data_array['default_content']=clean_html("<div class='content-wrapper'><section class='term-condition-section sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title mb-0'>Terms And Condition</h2></div></div></section><section class='term-conditions policy-info-section'><div class='container'><div class='details-content'><div class='privacy-policy-point'><h4 class='point'>Title One :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Two :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Three :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Four :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Five :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Six :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section></div>");
            $data_array['slug']=clean_string('terms-conditions');
            $data_array['updated_by']=1;
            $data_array['is_active']=1;
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($informative_pages_array,$data_array);

            $data_array=array();
            $data_array['name']='Privacy Policy';
            $data_array['content']=clean_html("<div class='content-wrapper'><section class='privacy-policy-section sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title mb-0'>Privacy Policy</h2></div></div></section><section class='privacy-policy policy-info-section'><div class='container'><div class='details-content'><div class='privacy-policy-point'><h4 class='point'>Title One :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Two :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Three :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Four :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Five :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Six :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section></div>");
            $data_array['default_content']=clean_html("<div class='content-wrapper'><section class='privacy-policy-section sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title mb-0'>Privacy Policy</h2></div></div></section><section class='privacy-policy policy-info-section'><div class='container'><div class='details-content'><div class='privacy-policy-point'><h4 class='point'>Title One :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Two :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Three :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Four :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Five :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Six :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section></div>");
            $data_array['slug']=clean_string('privacy-policy');
            $data_array['updated_by']=1;
            $data_array['is_active']=1;
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($informative_pages_array,$data_array);

            $data_array=array();
            $data_array['name']='Business Policy';
            $data_array['content']=clean_html("<div class='content-wrapper'><section class='business-policy-section sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title mb-0'>Business Policy</h2></div></div></section><section class='business-policy policy-info-section'><div class='container'><div class='details-content'><div class='privacy-policy-point'><h4 class='point'>Title One :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Two :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Three :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Four :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Five :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Six :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Seven :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section></div>");
            $data_array['default_content']=clean_html("<div class='content-wrapper'><section class='business-policy-section sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title mb-0'>Business Policy</h2></div></div></section><section class='business-policy policy-info-section'><div class='container'><div class='details-content'><div class='privacy-policy-point'><h4 class='point'>Title One :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Two :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Three :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Four :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Five :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Six :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div><div class='privacy-policy-point'><h4 class='point'>Title Seven :</h4><p class='details'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div></div></div></section></div>");
            $data_array['slug']=clean_string('business-policy');
            $data_array['updated_by']=1;
            $data_array['is_active']=1;
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($informative_pages_array,$data_array);

            $data_array=array();
            $data_array['name']='Events';
            $data_array['content']=clean_html("<p><br></p>");
            $data_array['default_content']=clean_html("<p><br></p>");
            $data_array['slug']=clean_string('events');
            $data_array['updated_by']=1;
            $data_array['is_active']=1;
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($informative_pages_array,$data_array);

            $data_array=array();
            $data_array['name']='Media';
            $data_array['content']=clean_html("<div class='content-wrapper'><section class='media-section sub-header'><div class='container'><div class='section-content'><div><h2 class='title bread-crumb-title'>Media</h2></div></div></div></section><section class='media-info-section media-info'><div class='container'><div class='row'><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div></div><div class='media-loader text-center'><img src='assets/images/loader.svg' class='img-fluid' data-pagespeed-url-hash='3175844603' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></section></div>");
            $data_array['default_content']=clean_html("<div class='content-wrapper'><section class='media-section sub-header'><div class='container'><div class='section-content'><div><h2 class='title bread-crumb-title'>Media</h2></div></div></div></section><section class='media-info-section media-info'><div class='container'><div class='row'><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div><div class='col col-12 col-md-6 col-lg-4'><div class='media-card'><div class='card-body p-0'><div class='media-box'><img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='media-details'><h4>Media Title</h4><p>It is a long established fact that a reader</p><a href='Javascript:;' class='btn btn-primary'>Read more</a></div></div></div></div></div><div class='media-loader text-center'><img src='assets/images/loader.svg' class='img-fluid' data-pagespeed-url-hash='3175844603' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></section></div>");
            $data_array['slug']=clean_string('media');
            $data_array['updated_by']=1;
            $data_array['is_active']=1;
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($informative_pages_array,$data_array);

            $data_array=array();
            $data_array['name']='Gallery';
            $data_array['content']=clean_html("<div class='content-wrapper'><!-- <section class='media-section sub-header'><div class='container'><div class='section-content'><div><h2 class='title bread-crumb-title'>Gallary</h2><nav aria-label='breadcrumb'><ol class='breadcrumb mb-0'><li class='breadcrumb-item'><a href='about.php'>About Us</a></li><li class='breadcrumb-item'>Gallary</li></ol></nav></div></div></div></section> --><section style='padding-top: 140px;'><div class='gallary-section container'><img src='assets/images/Gallary1.jpg' alt='' title='test' data-pagespeed-url-hash='4280954612' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary5.jpg' alt='' title='test' data-pagespeed-url-hash='1163987000' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary2.jpg' alt='' title='test' data-pagespeed-url-hash='280487237' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary6.jpg' alt='' title='test' data-pagespeed-url-hash='1458486921' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary3.jpg' alt='' title='test' data-pagespeed-url-hash='574987158' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary7.jpg' alt='' title='test' data-pagespeed-url-hash='1752986842' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary8.jpg' alt='' title='test' data-pagespeed-url-hash='2047486763' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary4.jpg' alt='' title='test' data-pagespeed-url-hash='869487079' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary9.jpg' alt='' title='test' data-pagespeed-url-hash='2341986684' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='lightbox'> <div class='title'></div> <div class='filter'></div> <div class='arrowr'></div> <div class='arrowl'></div> <div class='close'></div></div></section></div>");
            $data_array['default_content']=clean_html("<div class='content-wrapper'><!-- <section class='media-section sub-header'><div class='container'><div class='section-content'><div><h2 class='title bread-crumb-title'>Gallary</h2><nav aria-label='breadcrumb'><ol class='breadcrumb mb-0'><li class='breadcrumb-item'><a href='about.php'>About Us</a></li><li class='breadcrumb-item'>Gallary</li></ol></nav></div></div></div></section> --><section style='padding-top: 140px;'><div class='gallary-section container'><img src='assets/images/Gallary1.jpg' alt='' title='test' data-pagespeed-url-hash='4280954612' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary5.jpg' alt='' title='test' data-pagespeed-url-hash='1163987000' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary2.jpg' alt='' title='test' data-pagespeed-url-hash='280487237' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary6.jpg' alt='' title='test' data-pagespeed-url-hash='1458486921' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary3.jpg' alt='' title='test' data-pagespeed-url-hash='574987158' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary7.jpg' alt='' title='test' data-pagespeed-url-hash='1752986842' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary8.jpg' alt='' title='test' data-pagespeed-url-hash='2047486763' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary4.jpg' alt='' title='test' data-pagespeed-url-hash='869487079' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/Gallary9.jpg' alt='' title='test' data-pagespeed-url-hash='2341986684' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='lightbox'> <div class='title'></div> <div class='filter'></div> <div class='arrowr'></div> <div class='arrowl'></div> <div class='close'></div></div></section></div>");
            $data_array['slug']=clean_string('gallery');
            $data_array['updated_by']=1;
            $data_array['is_active']=1;
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($informative_pages_array,$data_array);

            $data_array=array();
            $data_array['name']='About Us';
            $data_array['content']=clean_html("<div class='content-wrapper'><!-- SUBHEADER SECTION --><!-- <section class='sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title'>About Us</h2></div></div></section> --><!-- OUR STORY SECTION --><section class='about-section p-0'><div class='container'><div class='row'><div class='col col-12 text-center'><img class='img-fluid about-image' src='assets/images/about.png' alt='' data-pagespeed-url-hash='1836089386' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Our Story</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the </p></div></div></div></section><!-- VISION AND MISSION SECTION --><section class='vision-mission-section'><div class='container'><div class='row'><div class='col col-12 text-center pb-4'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Vision and Mission</h2></div></div><div class='row align-items-center vision-box mb-5'><div class='col col-12 col-md-6 mb-4 mb-md-0'><img class='img-fluid w-100' src='assets/images/about1.jpg' alt='' data-pagespeed-url-hash='744599385' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='col col-12 col-md-6'><h3>Vision</h3><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. </p></div></div><div class='row align-items-center vision-box'><div class='col col-12 col-md-6 mb-2 mb-md-0'><h3>Mission</h3><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. </p></div><div class='col col-12 col-md-6'><img class='img-fluid w-100' src='assets/images/about1.jpg' alt='' data-pagespeed-url-hash='744599385' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- OUR HISTORY SECTION --><section class='about-history p-0'><div class='container'><div class='row'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Our History</h2></div></div><div class='row'><div class='checkout-wrap col-md-7 col-sm-12 col-xs-12 pull-right'><ul class='nav nav-tabs checkout-bar' id='nav-tab' role='tablist'><li class='active'><a href='#nav-1' data-bs-toggle='tab' data-bs-target='#nav-1' type='button' role='tab' aria-controls='nav-1' aria-selected='true'>1994</a></li><li class=''><a href='#nav-2' data-bs-toggle='tab' data-bs-target='#nav-2' type='button' role='tab' aria-controls='nav-2' aria-selected='false'>1995</a></li><li class=''><a href='#nav-3' data-bs-toggle='tab' data-bs-target='#nav-3' type='button' role='tab' aria-controls='nav-3' aria-selected='false'>1996</a></li><li class=''><a href='#nav-4' data-bs-toggle='tab' data-bs-target='#nav-4' type='button' role='tab' aria-controls='nav-4' aria-selected='false'>1997</a></li><li class=''><a href='#nav-5' data-bs-toggle='tab' data-bs-target='#nav-5' type='button' role='tab' aria-controls='nav-5' aria-selected='false'>1998</a></li><li class=''><a href='#nav-6' data-bs-toggle='tab' data-bs-target='#nav-6' type='button' role='tab' aria-controls='nav-6' aria-selected='false'>2000</a></li><li class=''><a href='#nav-7' data-bs-toggle='tab' data-bs-target='#nav-7' type='button' role='tab' aria-controls='nav-7' aria-selected='false'>2000</a></li></ul></div></div><div class='tab-content' id='nav-tabContent'><div class='tab-pane fade show active' id='nav-1' role='tabpanel' aria-labelledby='nav-tab-1'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1994</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div><div class='tab-pane fade' id='nav-2' role='tabpanel' aria-labelledby='nav-tab-2'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1995</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div><div class='tab-pane fade' id='nav-3' role='tabpanel' aria-labelledby='nav-tab-3'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1996</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div><div class='tab-pane fade' id='nav-4' role='tabpanel' aria-labelledby='nav-tab-4'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1997</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div><div class='tab-pane fade' id='nav-5' role='tabpanel' aria-labelledby='nav-tab-5'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1998</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div><div class='tab-pane fade' id='nav-6' role='tabpanel' aria-labelledby='nav-tab-6'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1999</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div><div class='tab-pane fade' id='nav-7' role='tabpanel' aria-labelledby='nav-tab-7'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>2000</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></div></div></section><!-- CHAIRPERSONS SAYS SECTION --><section class='chairpersons-section'><div class='container'><div class='row align-items-center'><div class='col col-12 col-md-6 mb-2 mb-md-0'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Chairpersons Says</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the </p></div><div class='col col-12 col-md-6'><div class='border-img'><img class='img-fluid' src='assets/images/chairpersons.jpg' alt='' data-pagespeed-url-hash='622378294' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></div></section><!-- OUR TEAM SECTION --><section class='team-section p-0'><div class='container'><div class='row align-items-center'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Our Team</h2></div></div><div class='row'><div class='col col-12 col-md-3 mb-4 mb-md-0'><img class='img-fluid team-img' src='assets/images/team.jpg' data-pagespeed-url-hash='1448386302' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='col col-12 col-md-3 mb-4 mb-md-0'><img class='img-fluid team-img' src='assets/images/team.jpg' data-pagespeed-url-hash='1448386302' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='col col-12 col-md-3 mb-4 mb-md-0'><img class='img-fluid team-img' src='assets/images/team.jpg' data-pagespeed-url-hash='1448386302' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='col col-12 col-md-3'><img class='img-fluid team-img' src='assets/images/team.jpg' data-pagespeed-url-hash='1448386302' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- PARTNERS SECTION --><section class='partners-section'><div class='container'><div class='row'><div class='col col-12'><h2 class='text-center'><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Our Partners</h2><div class='partners-slider custom-slick-arrow'><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></div></section></div>");
            $data_array['default_content']=clean_html("<div class='content-wrapper'><!-- SUBHEADER SECTION --><!-- <section class='sub-header'><div class='container'><div class='section-content'><h2 class='title bread-crumb-title'>About Us</h2></div></div></section> --><!-- OUR STORY SECTION --><section class='about-section p-0'><div class='container'><div class='row'><div class='col col-12 text-center'><img class='img-fluid about-image' src='assets/images/about.png' alt='' data-pagespeed-url-hash='1836089386' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Our Story</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the </p></div></div></div></section><!-- VISION AND MISSION SECTION --><section class='vision-mission-section'><div class='container'><div class='row'><div class='col col-12 text-center pb-4'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Vision and Mission</h2></div></div><div class='row align-items-center vision-box mb-5'><div class='col col-12 col-md-6 mb-4 mb-md-0'><img class='img-fluid w-100' src='assets/images/about1.jpg' alt='' data-pagespeed-url-hash='744599385' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='col col-12 col-md-6'><h3>Vision</h3><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. </p></div></div><div class='row align-items-center vision-box'><div class='col col-12 col-md-6 mb-2 mb-md-0'><h3>Mission</h3><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. </p></div><div class='col col-12 col-md-6'><img class='img-fluid w-100' src='assets/images/about1.jpg' alt='' data-pagespeed-url-hash='744599385' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- OUR HISTORY SECTION --><section class='about-history p-0'><div class='container'><div class='row'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Our History</h2></div></div><div class='row'><div class='checkout-wrap col-md-7 col-sm-12 col-xs-12 pull-right'><ul class='nav nav-tabs checkout-bar' id='nav-tab' role='tablist'><li class='active'><a href='#nav-1' data-bs-toggle='tab' data-bs-target='#nav-1' type='button' role='tab' aria-controls='nav-1' aria-selected='true'>1994</a></li><li class=''><a href='#nav-2' data-bs-toggle='tab' data-bs-target='#nav-2' type='button' role='tab' aria-controls='nav-2' aria-selected='false'>1995</a></li><li class=''><a href='#nav-3' data-bs-toggle='tab' data-bs-target='#nav-3' type='button' role='tab' aria-controls='nav-3' aria-selected='false'>1996</a></li><li class=''><a href='#nav-4' data-bs-toggle='tab' data-bs-target='#nav-4' type='button' role='tab' aria-controls='nav-4' aria-selected='false'>1997</a></li><li class=''><a href='#nav-5' data-bs-toggle='tab' data-bs-target='#nav-5' type='button' role='tab' aria-controls='nav-5' aria-selected='false'>1998</a></li><li class=''><a href='#nav-6' data-bs-toggle='tab' data-bs-target='#nav-6' type='button' role='tab' aria-controls='nav-6' aria-selected='false'>2000</a></li><li class=''><a href='#nav-7' data-bs-toggle='tab' data-bs-target='#nav-7' type='button' role='tab' aria-controls='nav-7' aria-selected='false'>2000</a></li></ul></div></div><div class='tab-content' id='nav-tabContent'><div class='tab-pane fade show active' id='nav-1' role='tabpanel' aria-labelledby='nav-tab-1'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1994</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div><div class='tab-pane fade' id='nav-2' role='tabpanel' aria-labelledby='nav-tab-2'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1995</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div><div class='tab-pane fade' id='nav-3' role='tabpanel' aria-labelledby='nav-tab-3'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1996</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div><div class='tab-pane fade' id='nav-4' role='tabpanel' aria-labelledby='nav-tab-4'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1997</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div><div class='tab-pane fade' id='nav-5' role='tabpanel' aria-labelledby='nav-tab-5'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1998</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div><div class='tab-pane fade' id='nav-6' role='tabpanel' aria-labelledby='nav-tab-6'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>1999</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div><div class='tab-pane fade' id='nav-7' role='tabpanel' aria-labelledby='nav-tab-7'><div class='row align-items-center'><div class='col-md-8'><h3>Pilot</h3><h5>2000</h5><p>First pilot calciner facility is built to test what was possible.First pilot calciner facility is built to test what was possible First pilot calciner facility is built to test what was possibleFirst pilot calciner facility is built to test what was possible</p><p>First pilot calciner facility is built to test what was possible</p></div><div class='col-md-4'><img class='img-fluid timeline-img' src='assets/images/timeline.png' alt='' data-pagespeed-url-hash='3433168482' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></div></div></section><!-- CHAIRPERSONS SAYS SECTION --><section class='chairpersons-section'><div class='container'><div class='row align-items-center'><div class='col col-12 col-md-6 mb-2 mb-md-0'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Chairpersons Says</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing a industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the </p></div><div class='col col-12 col-md-6'><div class='border-img'><img class='img-fluid' src='assets/images/chairpersons.jpg' alt='' data-pagespeed-url-hash='622378294' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></div></section><!-- OUR TEAM SECTION --><section class='team-section p-0'><div class='container'><div class='row align-items-center'><div class='col col-12 text-center'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Our Team</h2></div></div><div class='row'><div class='col col-12 col-md-3 mb-4 mb-md-0'><img class='img-fluid team-img' src='assets/images/team.jpg' data-pagespeed-url-hash='1448386302' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='col col-12 col-md-3 mb-4 mb-md-0'><img class='img-fluid team-img' src='assets/images/team.jpg' data-pagespeed-url-hash='1448386302' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='col col-12 col-md-3 mb-4 mb-md-0'><img class='img-fluid team-img' src='assets/images/team.jpg' data-pagespeed-url-hash='1448386302' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='col col-12 col-md-3'><img class='img-fluid team-img' src='assets/images/team.jpg' data-pagespeed-url-hash='1448386302' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></section><!-- PARTNERS SECTION --><section class='partners-section'><div class='container'><div class='row'><div class='col col-12'><h2 class='text-center'><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Our Partners</h2><div class='partners-slider custom-slick-arrow'><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/xpartners.png.pagespeed.ic.gAYgyj6trb.webp' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></div></section></div>");
            $data_array['slug']=clean_string('about-us');
            $data_array['updated_by']=1;
            $data_array['is_active']=1;
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($informative_pages_array,$data_array);

            $data_array=array();
            $data_array['name']='Blog';
            $data_array['content']=clean_html("<div class='content-wrapper'> <section class='media-section sub-header'> <div class='container'> <div class='section-content'> <div> <h2 class='title bread-crumb-title'>Blog</h2> </div> </div> </div> </section> <section class='blog-info-section media-info'> <div class='container'> <div class='row'> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> </div> <div class='media-loader text-center'> <img src='assets/images/loader.svg' class='img-fluid' data-pagespeed-url-hash='3175844603' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> </section></div>");
            $data_array['default_content']=clean_html("<div class='content-wrapper'> <section class='media-section sub-header'> <div class='container'> <div class='section-content'> <div> <h2 class='title bread-crumb-title'>Blog</h2> </div> </div> </div> </section> <section class='blog-info-section media-info'> <div class='container'> <div class='row'> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> <div class='col col-12 col-md-6 col-lg-4'> <div class='media-card'> <div class='card-body p-0'> <div class='media-box'> <img src='assets/images/media.jpg' alt='media' class='img-fluid' data-pagespeed-url-hash='621457133' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> <div class='media-details'> <h4>Media Title</h4> <p>It is a long established fact that a reader</p> <a href='Javascript:;' class='btn btn-primary'>Read more</a> </div> </div> </div> </div> </div> <div class='media-loader text-center'> <img src='assets/images/loader.svg' class='img-fluid' data-pagespeed-url-hash='3175844603' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> </section></div>");
            $data_array['slug']=clean_string('blog');
            $data_array['updated_by']=1;
            $data_array['is_active']=1;
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($informative_pages_array,$data_array);

            $data_array=array();
            $data_array['name']='Manufacturing';
            $data_array['content']=clean_html("<div class='content-wrapper'> <!-- BANNER SECTION START --> <section class='diamonds-hero-section text-white' style='background-image: url(assets/images/diamonds-banner.jpg)'> <div class='container'> <div class='row'> <div class='col col-12 col-md-9 col-lg-7 col-xl-6'> <h2>Manufacturing</h2> <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. </p> </div> </div> </div> </section> <!-- BANNER SECTION END --> <div class='mfg-info-section'> <div class='container'> <div class='mfg-info-content'> <div class='row align-items-center'> <div class='col col-12 col-md-12 col-lg-6'> <div class='mfg-info'> <h2 class='title'> <img src='assets/images/title-diamond.svg' alt='diamond' class='img-fluid title-diamond_img' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'>Manufacturing </h2> <p class='description mb-0'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy </p> </div> </div> <div class='col col-12 col-md-12 col-lg-6'> <div class='mfg-image'> <img class='img-fluid w-100' src='assets/images/about1.jpg' alt='' data-pagespeed-url-hash='744599385' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> </div> </div> </div> </div> <!-- <section class='mfg-process-section p-0'> --> <div class='mfg-process-section p-0 mb-4 mb-md-0'> <div class='container'> <div class='row align-items-center'> <div class='col col-12 col-md-12'> <div class='mfg-process-content'> <h2 class='title text-center' style='margin-bottom: 0px'> <img src='assets/images/title-diamond.svg' alt='diamond' class='img-fluid title-diamond_img' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'>Manufacturing Process </h2> <div class='mfg-process-image'> <img src='assets/images/mfg-ps.png' alt='mfg' class='img-fluid mfg-ps' data-pagespeed-url-hash='2311447911' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> </div> </div> </div> </div> <!-- </section> --> <div class='mfg-details-section'> <div class='container'> <h2 class='title text-center'> <img src='assets/images/title-diamond.svg' alt='diamond' class='img-fluid title-diamond_img' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'>Manufacturing Details </h2> <div class='mfg-details-content'> <div class='row'> <div class='col col-12'> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/polishing.png' alt='polishing' data-pagespeed-url-hash='3179251826' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>1. Planning</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/cleaving.png' alt='polishing' data-pagespeed-url-hash='1072209318' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>2. Cleaving</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/bruting.png' alt='polishing' data-pagespeed-url-hash='2224684004' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>3. Bruting</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/polishing.png' alt='polishing' data-pagespeed-url-hash='3179251826' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>4. Polishing</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/inspection.png' alt='polishing' data-pagespeed-url-hash='255516601' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>5. Inspection</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> </div> </div> </div> </div> </div></div>");
            $data_array['default_content']=clean_html("<div class='content-wrapper'> <!-- BANNER SECTION START --> <section class='diamonds-hero-section text-white' style='background-image: url(assets/images/diamonds-banner.jpg)'> <div class='container'> <div class='row'> <div class='col col-12 col-md-9 col-lg-7 col-xl-6'> <h2>Manufacturing</h2> <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. </p> </div> </div> </div> </section> <!-- BANNER SECTION END --> <div class='mfg-info-section'> <div class='container'> <div class='mfg-info-content'> <div class='row align-items-center'> <div class='col col-12 col-md-12 col-lg-6'> <div class='mfg-info'> <h2 class='title'> <img src='assets/images/title-diamond.svg' alt='diamond' class='img-fluid title-diamond_img' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'>Manufacturing </h2> <p class='description mb-0'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummyLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy </p> </div> </div> <div class='col col-12 col-md-12 col-lg-6'> <div class='mfg-image'> <img class='img-fluid w-100' src='assets/images/about1.jpg' alt='' data-pagespeed-url-hash='744599385' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> </div> </div> </div> </div> <!-- <section class='mfg-process-section p-0'> --> <div class='mfg-process-section p-0 mb-4 mb-md-0'> <div class='container'> <div class='row align-items-center'> <div class='col col-12 col-md-12'> <div class='mfg-process-content'> <h2 class='title text-center' style='margin-bottom: 0px'> <img src='assets/images/title-diamond.svg' alt='diamond' class='img-fluid title-diamond_img' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'>Manufacturing Process </h2> <div class='mfg-process-image'> <img src='assets/images/mfg-ps.png' alt='mfg' class='img-fluid mfg-ps' data-pagespeed-url-hash='2311447911' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> </div> </div> </div> </div> <!-- </section> --> <div class='mfg-details-section'> <div class='container'> <h2 class='title text-center'> <img src='assets/images/title-diamond.svg' alt='diamond' class='img-fluid title-diamond_img' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'>Manufacturing Details </h2> <div class='mfg-details-content'> <div class='row'> <div class='col col-12'> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/polishing.png' alt='polishing' data-pagespeed-url-hash='3179251826' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>1. Planning</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/cleaving.png' alt='polishing' data-pagespeed-url-hash='1072209318' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>2. Cleaving</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/bruting.png' alt='polishing' data-pagespeed-url-hash='2224684004' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>3. Bruting</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/polishing.png' alt='polishing' data-pagespeed-url-hash='3179251826' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>4. Polishing</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> <div class='row align-items-center'> <div class='col col-12 col-md-6'> <div class='manufactur-product-image text-center'> <img class='img-fluid mfg-dtl' src='assets/images/inspection.png' alt='polishing' data-pagespeed-url-hash='255516601' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> </div> </div> <div class='col col-12 col-md-6'> <div class='manufactur-product-details'> <h4 class='title'>5. Inspection</h4> <p class='description'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like </p> </div> </div> </div> </div> </div> </div> </div> </div></div>");
            $data_array['slug']=clean_string('manufacturing');
            $data_array['updated_by']=1;
            $data_array['is_active']=1;
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($informative_pages_array,$data_array);

            $data_array=array();
            $data_array['name']='Index';
            $data_array['content']=clean_html("<div class='content-wrapper'><!-- LANDING SECTION --><section class='landing-section p-0'><div class='landing-bg'><img src='assets/images/PSNM.gif' alt='PSNM' data-pagespeed-url-hash='4209866710' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='landing-content'><div class='container'><div class='section-head'><img src='assets/images/logo-slider.png' class='img-fluid' alt='img' data-pagespeed-url-hash='753056528' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><p class='description'>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normalIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </p><div class='flex social-btns'> <a class='app-btn blu flex vert' href='javascript:;'> <img src='assets/images/apple.png' alt='' data-pagespeed-url-hash='3401533139' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> <p>Available on the <br> <span class='big-txt'>App Store</span></p> </a> <a class='app-btn blu flex vert' href='javascript:;'> <img src='assets/images/playstore.png' alt='' data-pagespeed-url-hash='1398266034' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> <p>Get it on <br> <span class='big-txt'>Google Play</span></p> </a></div></div></div></div></section><!-- UNEARTHING SECTION --><section class='unearthing-section'><div class='container'><div class='section-head'><h2 class='title'>What are lab grown diamonds?</h2></div><div class='section-content'><div class='row align-items-center'><div class='col col-12 col-sm-12 col-md-6'><div class='unearthing-img'><img src='assets/images/diamond.gif' class='img-fluid' alt='img' data-pagespeed-url-hash='2920935452' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div><div class='col col-12 col-sm-12 col-md-6'><div class='unearthing-details'><p class='description'>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p></div></div></div></div></div><div class='container'><div class='row'><div class='col col-12 text-center mb-3'><h3 class='text-uppercase'>Ready to get started</h3></div><!-- <div class='col col-12 col-md-2 mb-4 mb-md-0'></div><div class='col col-12 col-md-8 mb-4 mb-md-0'></div><div class='col col-12 col-md-2 mb-4 mb-md-0'></div> --></div><div class='row justify-content-center'><div class='col col-12 col-md-4 col-lg-3 mb-4 mb-md-0'><a href='login' class='btn btn-primary grown-diamonds-btn'><span class='col-md-3'><img class='title-diamond_img' src='assets/images/Polish.png' alt='' data-pagespeed-url-hash='1281385418' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></span><span class='col-md-9'>Shop Polish Diamonds</span></a></div><div class='col col-12 col-md-4 col-lg-3 mb-4 mb-md-0'><a href='login' class='btn btn-primary grown-diamonds-btn'><img class='title-diamond_img' src='assets/images/4p.png' alt='' data-pagespeed-url-hash='2838713985' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Shop 4p Diamonds</a></div><div class='col col-12 col-md-4 col-lg-3 mb-4 mb-md-0'><a href='login' class='btn btn-primary grown-diamonds-btn'><img class='title-diamond_img' src='assets/images/Rough.png' alt='' data-pagespeed-url-hash='2917607242' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Shop Rough Diamonds</a></div></div></div></section><!-- WHAT WE FOLLOW SECTION --><section class='follow-section text-white' data-parallax='scroll' data-image-src='assets/images/follow.png'><div class='container'><div class='row align-items-center'><div class='col col-12 col-sm-12 col-md-6'><div class='follow-details'><h2 class='title mb-4'> What We Follow?</h2><p class='mb-4 pb-3 text-white'>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><a href='grading' class='btn btn-primary'>Read More</a></div></div></div></div></section><!-- about SECTION --><section class='about-home-section'><div class='container'><div class='row align-items-center'><div class='col col-12 col-md-7'><img class='img-fluid w-100' src='assets/images/about-home.png' alt='' data-pagespeed-url-hash='461072352' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='col col-12 col-md-5'><div class='about-box'><h2>About Us</h2><p>As opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.</p><a href='about' class='btn btn-primary'>Read More</a></div></div></div></div></section><!-- WHAT WE HAVE SECTION --><section class='we-have-section text-white' data-parallax='scroll' data-image-src='assets/images/what-we-have.jpg'><div class='container'><div class='row justify-content-end'><div class='col col-12 col-md-6'><h2>What We Have?</h2><p class='text-white'>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><a href='diamonds' class='btn btn-primary'>Read More</a></div></div></div></section><!-- CORE VALUES SECTION --><section class='core-values-section'><div class='container'><div class='row align-items-center'><div class='col col-12 col-md-12 col-lg-6 mb-4 mb-lg-0'><h2>Core Values</h2><p>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div><div class='col col-12 col-md-6 col-lg-3'><div class='card core-value-card'><div class='card-body'><img class='img-fluid' src='assets/images/suitcase_work_icon.svg' alt='' data-pagespeed-url-hash='2178070905' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>Excellence at Work</h4><p>Editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div></div><div class='card core-value-card'><div class='card-body'><img class='img-fluid' src='assets/images/suitcase_work_icon.svg' alt='' data-pagespeed-url-hash='2178070905' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>Excellence at Work</h4><p>Editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div></div></div><div class='col col-12 col-md-6 col-lg-3'><div class='card core-value-card'><div class='card-body'><img class='img-fluid' src='assets/images/suitcase_work_icon.svg' alt='' data-pagespeed-url-hash='2178070905' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>Excellence at Work</h4><p>Editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div></div></div></div></div></section><!-- BLOG SECTION --><section class='home-blog-section p-0'><div class='container p-0'><div class='row g-0'><div class='col col-12 col-md-6'><div class='blog-box text-white'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Latest Blogs</h2><p class='text-white'>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</p><div class='text-center mt-4'><a href='blog' class='btn btn-primary'>Read More</a></div></div></div><div class='col col-12 col-md-6'><div class='home-blog-list custom-slick-arrow'><div class='bolg-item'><img class='img-fluid' src='assets/images/blog-single.jpg' alt='' data-pagespeed-url-hash='3893797572' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>It is a long established fact that a reader will be.</h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p><a href='single-blog' class='btn btn-primary btn-black'>Read More</a></div><div class='bolg-item'><img class='img-fluid' src='assets/images/blog-single.jpg' alt='' data-pagespeed-url-hash='3893797572' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>It is a long established fact that a reader will be.</h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p><a href='single-blog' class='btn btn-primary btn-black'>Read More</a></div><div class='bolg-item'><img class='img-fluid' src='assets/images/blog-single.jpg' alt='' data-pagespeed-url-hash='3893797572' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>It is a long established fact that a reader will be.</h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p><a href='single-blog' class='btn btn-primary btn-black'>Read More</a></div></div></div></div></div></section><!-- CLIENTS SAY SECTION --><section class='home-blog-section p-0'><div class='container p-0'><div class='row g-0'><div class='col col-12 col-md-6 order-1 order-md-0'><div class='home-client-list custom-slick-arrow'><div class='client-item'><img class='img-fluid' src='assets/images/user.jpg' alt='' data-pagespeed-url-hash='4115964488' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>Martin williams <span>-Potential customer</span></h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p></div><div class='client-item'><img class='img-fluid' src='assets/images/user.jpg' alt='' data-pagespeed-url-hash='4115964488' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>Martin williams <span>-Potential customer</span></h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p></div><div class='client-item'><img class='img-fluid' src='assets/images/user.jpg' alt='' data-pagespeed-url-hash='4115964488' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>Martin williams <span>-Potential customer</span></h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p></div></div></div><div class='col col-12 col-md-6'><div class='blog-box text-white'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Clients Say</h2><p class='text-white'>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of usingIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of usingIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of usingIt is a long established fact that a reader will be distracted by the readable content.</p></div></div></div></div></section><!-- PARTNERS SECTION --><section class='partners-section'><div class='container'><div class='row'><div class='col col-12'><h2 class='text-center'>Our Partners</h2><div class='partners-slider custom-slick-arrow'><img src='assets/images/partners.png' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/partners.png' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/partners.png' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/partners.png' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/partners.png' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></div></section></div>");
            $data_array['default_content']=clean_html("<div class='content-wrapper'><!-- LANDING SECTION --><section class='landing-section p-0'><div class='landing-bg'><img src='assets/images/PSNM.gif' alt='PSNM' data-pagespeed-url-hash='4209866710' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='landing-content'><div class='container'><div class='section-head'><img src='assets/images/logo-slider.png' class='img-fluid' alt='img' data-pagespeed-url-hash='753056528' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><p class='description'>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normalIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </p><div class='flex social-btns'> <a class='app-btn blu flex vert' href='javascript:;'> <img src='assets/images/apple.png' alt='' data-pagespeed-url-hash='3401533139' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> <p>Available on the <br> <span class='big-txt'>App Store</span></p> </a> <a class='app-btn blu flex vert' href='javascript:;'> <img src='assets/images/playstore.png' alt='' data-pagespeed-url-hash='1398266034' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> <p>Get it on <br> <span class='big-txt'>Google Play</span></p> </a></div></div></div></div></section><!-- UNEARTHING SECTION --><section class='unearthing-section'><div class='container'><div class='section-head'><h2 class='title'>What are lab grown diamonds?</h2></div><div class='section-content'><div class='row align-items-center'><div class='col col-12 col-sm-12 col-md-6'><div class='unearthing-img'><img src='assets/images/diamond.gif' class='img-fluid' alt='img' data-pagespeed-url-hash='2920935452' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div><div class='col col-12 col-sm-12 col-md-6'><div class='unearthing-details'><p class='description'>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p></div></div></div></div></div><div class='container'><div class='row'><div class='col col-12 text-center mb-3'><h3 class='text-uppercase'>Ready to get started</h3></div><!-- <div class='col col-12 col-md-2 mb-4 mb-md-0'></div><div class='col col-12 col-md-8 mb-4 mb-md-0'></div><div class='col col-12 col-md-2 mb-4 mb-md-0'></div> --></div><div class='row justify-content-center'><div class='col col-12 col-md-4 col-lg-3 mb-4 mb-md-0'><a href='login' class='btn btn-primary grown-diamonds-btn'><span class='col-md-3'><img class='title-diamond_img' src='assets/images/Polish.png' alt='' data-pagespeed-url-hash='1281385418' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></span><span class='col-md-9'>Shop Polish Diamonds</span></a></div><div class='col col-12 col-md-4 col-lg-3 mb-4 mb-md-0'><a href='login' class='btn btn-primary grown-diamonds-btn'><img class='title-diamond_img' src='assets/images/4p.png' alt='' data-pagespeed-url-hash='2838713985' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Shop 4p Diamonds</a></div><div class='col col-12 col-md-4 col-lg-3 mb-4 mb-md-0'><a href='login' class='btn btn-primary grown-diamonds-btn'><img class='title-diamond_img' src='assets/images/Rough.png' alt='' data-pagespeed-url-hash='2917607242' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Shop Rough Diamonds</a></div></div></div></section><!-- WHAT WE FOLLOW SECTION --><section class='follow-section text-white' data-parallax='scroll' data-image-src='assets/images/follow.png'><div class='container'><div class='row align-items-center'><div class='col col-12 col-sm-12 col-md-6'><div class='follow-details'><h2 class='title mb-4'> What We Follow?</h2><p class='mb-4 pb-3 text-white'>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><a href='grading' class='btn btn-primary'>Read More</a></div></div></div></div></section><!-- about SECTION --><section class='about-home-section'><div class='container'><div class='row align-items-center'><div class='col col-12 col-md-7'><img class='img-fluid w-100' src='assets/images/about-home.png' alt='' data-pagespeed-url-hash='461072352' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div><div class='col col-12 col-md-5'><div class='about-box'><h2>About Us</h2><p>As opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.</p><a href='about' class='btn btn-primary'>Read More</a></div></div></div></div></section><!-- WHAT WE HAVE SECTION --><section class='we-have-section text-white' data-parallax='scroll' data-image-src='assets/images/what-we-have.jpg'><div class='container'><div class='row justify-content-end'><div class='col col-12 col-md-6'><h2>What We Have?</h2><p class='text-white'>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><a href='diamonds' class='btn btn-primary'>Read More</a></div></div></div></section><!-- CORE VALUES SECTION --><section class='core-values-section'><div class='container'><div class='row align-items-center'><div class='col col-12 col-md-12 col-lg-6 mb-4 mb-lg-0'><h2>Core Values</h2><p>as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div><div class='col col-12 col-md-6 col-lg-3'><div class='card core-value-card'><div class='card-body'><img class='img-fluid' src='assets/images/suitcase_work_icon.svg' alt='' data-pagespeed-url-hash='2178070905' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>Excellence at Work</h4><p>Editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div></div><div class='card core-value-card'><div class='card-body'><img class='img-fluid' src='assets/images/suitcase_work_icon.svg' alt='' data-pagespeed-url-hash='2178070905' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>Excellence at Work</h4><p>Editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div></div></div><div class='col col-12 col-md-6 col-lg-3'><div class='card core-value-card'><div class='card-body'><img class='img-fluid' src='assets/images/suitcase_work_icon.svg' alt='' data-pagespeed-url-hash='2178070905' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>Excellence at Work</h4><p>Editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. search for 'lorem ipsum' will uncover many web sites still in their infancy.</p></div></div></div></div></div></section><!-- BLOG SECTION --><section class='home-blog-section p-0'><div class='container p-0'><div class='row g-0'><div class='col col-12 col-md-6'><div class='blog-box text-white'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Latest Blogs</h2><p class='text-white'>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</p><div class='text-center mt-4'><a href='blog' class='btn btn-primary'>Read More</a></div></div></div><div class='col col-12 col-md-6'><div class='home-blog-list custom-slick-arrow'><div class='bolg-item'><img class='img-fluid' src='assets/images/blog-single.jpg' alt='' data-pagespeed-url-hash='3893797572' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>It is a long established fact that a reader will be.</h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p><a href='single-blog' class='btn btn-primary btn-black'>Read More</a></div><div class='bolg-item'><img class='img-fluid' src='assets/images/blog-single.jpg' alt='' data-pagespeed-url-hash='3893797572' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>It is a long established fact that a reader will be.</h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p><a href='single-blog' class='btn btn-primary btn-black'>Read More</a></div><div class='bolg-item'><img class='img-fluid' src='assets/images/blog-single.jpg' alt='' data-pagespeed-url-hash='3893797572' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>It is a long established fact that a reader will be.</h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p><a href='single-blog' class='btn btn-primary btn-black'>Read More</a></div></div></div></div></div></section><!-- CLIENTS SAY SECTION --><section class='home-blog-section p-0'><div class='container p-0'><div class='row g-0'><div class='col col-12 col-md-6 order-1 order-md-0'><div class='home-client-list custom-slick-arrow'><div class='client-item'><img class='img-fluid' src='assets/images/user.jpg' alt='' data-pagespeed-url-hash='4115964488' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>Martin williams <span>-Potential customer</span></h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p></div><div class='client-item'><img class='img-fluid' src='assets/images/user.jpg' alt='' data-pagespeed-url-hash='4115964488' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>Martin williams <span>-Potential customer</span></h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p></div><div class='client-item'><img class='img-fluid' src='assets/images/user.jpg' alt='' data-pagespeed-url-hash='4115964488' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><h4>Martin williams <span>-Potential customer</span></h4><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using....</p></div></div></div><div class='col col-12 col-md-6'><div class='blog-box text-white'><h2><img class='img-fluid title-diamond_img' src='assets/images/title-diamond.svg' alt='' data-pagespeed-url-hash='3523125347' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'> Clients Say</h2><p class='text-white'>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of usingIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of usingIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of usingIt is a long established fact that a reader will be distracted by the readable content.</p></div></div></div></div></section><!-- PARTNERS SECTION --><section class='partners-section'><div class='container'><div class='row'><div class='col col-12'><h2 class='text-center'>Our Partners</h2><div class='partners-slider custom-slick-arrow'><img src='assets/images/partners.png' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/partners.png' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/partners.png' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/partners.png' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'><img src='assets/images/partners.png' alt='' data-pagespeed-url-hash='3051449720' onload='pagespeed.CriticalImages.checkImageForCriticality(this);'></div></div></div></div></section></div>");
            $data_array['slug']=clean_string('index');
            $data_array['updated_by']=1;
            $data_array['is_active']=1;
            $data_array['date_updated']=date("Y-m-d h:i:s");
            array_push($informative_pages_array,$data_array);

        DB::table('informative_pages')->insert($informative_pages_array);
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
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='SHAPE';
                $data_array['image_required']=1;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=1;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
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
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);
                
            }
            if($row->category_type==config('constant.CATEGORY_TYPE_4P')){
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
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
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
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='EXP POL SIZE';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=4;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='SHAPE';
                $data_array['image_required']=1;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=2;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='HALF-CUT DIA';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=2;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='HALF-CUT HGT';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='PO. DIAMETER';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='PO. DIAMETER';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);
            }
            if($row->category_type==config('constant.CATEGORY_TYPE_POLISH')){
                $data_array=array();
                $data_array['name']='CLARITY';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=4;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
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
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='SHAPE';
                $data_array['image_required']=1;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=1;
                $data_array['added_by']=1;
                $data_array['is_fix']=1;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='CERTIFICATE';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='CERTIFICATE URL';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='CROWN ANGLE';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='CROWN HEIGHT';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='CULET SIZE';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='CUT GRADE';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='DEPTH PERCENT';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='GIRDLE PERCENT';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='GRIDLE CONDITION';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='GROWTH TYPE';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='LAB';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='MEASUREMENTS';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='PAVILION ANGLE';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='PAVILION DEPTH';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='POLISH';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='SYMMETRY';
                $data_array['image_required']=0;
                $data_array['field_type']=1;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);

                $data_array=array();
                $data_array['name']='TABLE PERCENT';
                $data_array['image_required']=0;
                $data_array['field_type']=0;
                $data_array['refCategory_id']=$row->category_id;
                $data_array['is_required']=1;
                $data_array['sort_order']=0;
                $data_array['added_by']=1;
                $data_array['is_fix']=0;
                $data_array['is_active']=1;
                $data_array['is_deleted']=0;
                $data_array['date_added']=date("Y-m-d h:i:s");
                $data_array['date_updated']=date("Y-m-d h:i:s");
                array_push($attribute_groups_array,$data_array);
            }
        }        
        DB::table('attribute_groups')->insert($attribute_groups_array);
        //******************* Atttribute groups Entry end *******************//
        
        
        //******************* labour charges Entry start *******************//
        $delete = DB::table('labour_charges')->delete();
        $labour_charges_array=array();
        
            $data_array=array();            
            $data_array['labour_charge_id']=1;
            $data_array['name']='4P diamonds';
            $data_array['amount']=25;                   
            $data_array['added_by']=1;           
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;     
            $data_array['date_added']=date("Y-m-d h:i:s"); 
            $data_array['date_updated']=date("Y-m-d h:i:s"); 
            array_push($labour_charges_array,$data_array); 
            
            $data_array=array();
            $data_array['labour_charge_id']=2;
            $data_array['name']='Rough Diamonds';
            $data_array['amount']=65;                   
            $data_array['added_by']=1;           
            $data_array['is_active']=1;
            $data_array['is_deleted']=0;     
            $data_array['date_added']=date("Y-m-d h:i:s"); 
            $data_array['date_updated']=date("Y-m-d h:i:s"); 
            array_push($labour_charges_array,$data_array); 
            
            DB::table('labour_charges')->insert($labour_charges_array);

        successOrErrorMessage("Project Setup Done", 'success');
        return redirect('admin/dashboard');
    }

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
