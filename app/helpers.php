<?php

use Illuminate\Support\Facades\DB;
use App\Models\UserActivity;

if (!function_exists('date_formate')) {
    function date_formate($date) {
        $Date = "$date";
        return date('d-m-Y', strtotime($Date));
    }
}

if (!function_exists('date_time_formate')) {
    function date_time_formate($date) {
        $Date = "$date";
        return date('d-m-Y h:i:s', strtotime($Date));
    }
}

if (!function_exists('successOrErrorMessage')) {

    function successOrErrorMessage($message, $type) {
        session([$type => 1]);
        session(['message' => $message]);
    }

}

function set_selected($desired_value, $new_value) {
    if ($desired_value == $new_value) {
        $str = ' selected="selected" ';
        return $str;
    } else {
        return '';
    }
}

function set_cheked($desired_value, $new_value) {
    if ($desired_value == $new_value) {
        $str = ' checked ';
        return $str;
    } else {
        return '';
    }
}

function check_host() {
    if (request()->getHost() == "127.0.0.1") {
        return '';
    } else {
        return 'public/';
    }
}

function clean_html($body_content) {
    $search = array(
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        // '/<!--(.|\s)*?-->/' // Remove HTML comments
    );
    $replace = array(
        '>',
        '<',
        '\\1',
        // ''
    );
    $body_content = preg_replace($search, $replace, $body_content);
    $body_content = stripslashes($body_content);
    $body_content = htmlspecialchars($body_content);
    return $body_content;
}

if (!function_exists('clean_string')) {

    function clean_string($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

}

if (!function_exists('activity')) {

    function activity($request, $activity, $module) {
        $agent = new \Jenssegers\Agent\Agent;
        $device = 'None';
        if ($agent->isDesktop()) {
            $device = "web";
        }
        if ($agent->isMobile()) {
            $device = "mobile";
        }
        if ($agent->isTablet()) {
            $device = "mobile";
        }


        if ($module == "modules") {
            $module_id = 0;
            $module_name = $module;
        } else {
            $module_id = moduleId($module)->module_id;
            $module_name = moduleId($module)->name;
        }


        DB::table('user_activity')->insert([
            'refUser_id' => $request->session()->get('loginId'),
            'refModule_id' => $module_id,
            'activity' => $activity,
            'subject' => $module_name . ' ' . $activity,
            'url' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            'device' => $device,
            'ip_address' => get_client_ip(),
            'date_added' => date("yy-m-d h:i:s")
        ]);
    }

}
if (!function_exists('moduleId')) {

    function moduleId($module_name) {
        $res = array();
        foreach (session('module') as $row) {
            if ($module_name == $row->slug) {
                $res = $row;
            }
        }
        return $res;
    }

}
if (!function_exists('get_client_ip')) {

    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

}
if (!function_exists('get_rapaport_price')) {

    function get_rapaport_price() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://technet.rapaport.com/HTTP/JSON/Prices/GetPrice.aspx',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "request": {
                    "header": {
                        "username": "harshillimbasiya@yahoo.in",
                        "password": "J@nvi2022"
                    },
                    "body": {
            \'shape\' : \'round\',
            \'size\' : 2.10,
            \'color\' : \'E\',
            \'clarity\' : \'VS2\'
                    }
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Cookie: ASP.NET_SessionId=t1pjx2yp4zvmrnckw0ihmlsd'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

}



