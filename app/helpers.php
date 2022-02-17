<?php

use App\Models\UserActivity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
        return ' checked ';
    } else {
        return '';
    }
}

function check_host() {
    if (request()->getHost() == "127.0.0.1" || request()->getHost() == 'localhost') {
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
        $string = preg_replace('/[^A-Za-z0-9\/\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

}

if (!function_exists('activity')) {

    function activity($request, $activity, $module, $id=0) {
        $agent = new \Jenssegers\Agent\Agent;
        $device = 'None';
        if ($agent->isDesktop()) {
            $device = "web";
        }
        else if ($agent->isMobile()) {
            $device = "mobile";
        }
        else if ($agent->isTablet()) {
            $device = "mobile";
        }

        if (in_array($module, ['modules', 'diamonds', 'customer_company_details', 'orders', 'customers'])) {
            $module_id = 0;
            $module_name = $module;
        }
        else if (strpos($module, "export") !== false) {
            $module_id = 0;
            $module_name = $module;
        }
        else {
            $module_id = moduleId($module)['module_id'];
            $module_name = moduleId($module)['name'];
        }

        DB::table('user_activity')->insert([
            'refUser_id' => $request->session()->get('loginId'),
            'refModule_id' => $module_id,
            'activity' => $activity,
            'subject' => $module_name . ' ' . $activity." (id:$id)",
            'url' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            'device' => $device,
            'ip_address' => get_client_ip(),
            'date_added' => date("Y-m-d H:i:s")
        ]);
    }

}
if (!function_exists('customer_activity')) {

    function customer_activity($activity, $subject, $url = null, $id = 0)
    {
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

        DB::table('customer_activities')->insert([
            'refCustomer_id' => Auth::id(),
            'activity' => $activity,
            'subject' => $subject,
            'url' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . ($url ?? $_SERVER['REQUEST_URI']),
            'device' => $device,
            'ip_address' => get_client_ip(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
if (!function_exists('moduleId')) {
    function moduleId($module_name) {
        // $res = array();
        foreach (session('module') as $row) {
            if ($module_name == $row['slug']) {
                // $res = $row;
                return $row;
            }
        }
        // return $res;
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

function send_email($to, $subject)
{
    // Create an instance of PHPMailer class
    $mail = new PHPMailer;

    // SMTP configurations
    $mail->isSMTP();
    $mail->Host         = 'smtp.gmail.com';
    $mail->SMTPAuth     = true;
    $mail->Username     = 'developer.qwesys@gmail.com';
    $mail->Password     = 'U-G$3s2Jy6H*cm5s';
    $mail->SMTPSecure   = 'tls';
    $mail->Port         = 587;

    // Sender info
    $mail->setFrom('developer.qwesys@gmail.com', 'JANVI LGD');

    // Add a recipient
    $mail->addAddress($to);

    // Add cc or bcc
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Email subject
    $mail->Subject = $subject;

    // Set email format to HTML
    $mail->isHTML(true);

    // Email body content
    $mailContent = '
    <h2>Send HTML Email using SMTP Server in Laravel</h2>
    <p>It is a test email by CodexWorld, sent via SMTP server with PHPMailer in Laravel.</p>
    <p>Read the tutorial and download this script from <a href="https://www.codexworld.com/">CodexWorld</a>.</p>';
    $mail->Body = $mailContent;

    // Send email
    if (!$mail->send()) {
        return ['success' => true, 'message' => $mail->ErrorInfo];
    } else {
        return ['success' => true, 'message' => null];
    }

}

function alter_login_session() {
    $arr_keys = array_keys(session()->all());
    $aa = array_filter($arr_keys, function ($a) {
        return str_starts_with($a, 'login_web_');
    });
    session()->put(array_values($aa)[0], '123');
}

function total_cart_item()
{
    $customer = Auth::user();
    return $total = DB::table('customer_cart')->select('id')->where('refCustomer_id', $customer->customer_id)->count();
}

function sendWebNotification($title, $body)
{
    $url = 'https://fcm.googleapis.com/fcm/send';
    $FcmToken = User::select('device_token')->where('id', session()->get('loginId'))->pluck('device_token')->all();
    // $FcmToken = ['cZUXVT4kicjK_1iWeCMI4T:APA91bEsKK0SPS-aqbnK5r5LjvtknnQVTVxmccUcJ_Dfw9PHUTkYzV4INFz8mVNR3rTbKJeRUP-jifItWRm8yX7ZHzvVJQR1uGqw9cnlXyHxaXw4OHRM8FK8CTQn8kApew3E15NyVvP6'];

    $serverKey = 'AAAAI2QkRPw:APA91bGSXXmthSXP_1saral1ejlOGNAP4MCqAU8Lsib8L1L0rBjE0ubD7vpiq3B4UXK86lTfaTr8Ae4Mm_5uJSp-akeeV0777FgNsG8eZAtRdJI3lXrBJcQxjnn-CeziwYgO7ORFWYeI';

    $data = [
        "registration_ids" => $FcmToken,
        "notification" => [
            "title" => $title,
            "body" => $body,
            "content_available" => true,
            "priority" => "high",
            "sound" => "default",
            "icon" => "/admin_assets/images/logo-small.png",
            "click_action" => "http://localhost:8000",
            /* "data" => [
                "one" => "yes",
                "two" => "yo"
            ] */
        ]
    ];
    $encodedData = json_encode($data);

    $headers = [
        'Authorization:key=' . $serverKey,
        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    // Disabling SSL Certificate support temporarly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
    // Execute post
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    // Close connection
    curl_close($ch);
    // FCM response
    dd($result);
}