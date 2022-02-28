<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Customers;
use App\Models\Order;
use App\Models\CustomerCompanyDetail;
use App\Http\Controllers\API\DiamondController as APIDiamond;
use App\Http\Controllers\API\OrderController as APIOrder;
use DB;
use Carbon\Carbon;
use PDF;

class OrderController extends Controller {

    public function placeOrder(Request $request)
    {
        $customer = Auth::user();
        $tk = $request->token;
        $token = explode('---', base64_decode($request->token));
        $exists = DB::table('customer_company_details')
            ->select('customer_company_id')
            ->where('refCustomer_id', $customer->customer_id)
            ->where(function($q) use($token) {
                $q->where('customer_company_id', $token[0])
                ->orWhere('customer_company_id', $token[1]);
            })
            ->get();
        $cart = new APIDiamond;
        $result = $cart->getCart();
        if (count($exists) < 2 && !count($result->original['data'])) {
            return redirect()->back();
        }
        $title = 'Place Order';
        return view('front.orders.place_order', compact('title', 'tk'));
    }

    public function saveOrder(Request $request)
    {
        // $customer = Auth::user();
        $token = explode('---', base64_decode($request->token));
        $request->request->add([
            'shipping_company_id' => $token[0],
            'billing_company_id' => $token[1]
        ]);

        $api = new APIOrder;
        $data = $api->saveMyOrder($request);
        if ($data->original['flag'] == true) {
            return redirect('/customer/my-orders')->with(['success' => 1, 'message' => $data->original['message']]);
        } else {
            return redirect('/customer/my-orders')->with(['error' => 1, 'message' => $data->original['message']]);
        }
    }

    public function getMyOrders(Request $request)
    {
        $api = new APIOrder;
        $data = $api->myOrders($request);
        $orders = $data->original['data']['orders'];
        if (count($orders)) {
            $orders = collect($orders)->groupBy('order_id')->values()->toArray();
        }
        $title = 'My Orders';
        return view('front.orders.my_orders', compact('title', 'orders'));
    }

    public function orderDetails(Request $request, $transaction_id, $order_id)
    {
        $api = new APIOrder;
        $data = $api->myOrderDetails($request, $transaction_id, $order_id);
        if ($data->original['flag'] == false) {
            return redirect('/customer/my-orders')->with(['error' => 1, 'message' => $data->original['message']]);
        }
        $orders = $data->original['data']['orders'];
        $status = $data->original['data']['status'];
        $diamonds = $data->original['data']['diamonds'];
        $title = 'Order Details';
        return view('front.orders.orders_details', compact('title', 'orders', 'status', 'diamonds'));
    }

    public function downloadInvoiceOld(Request $request, $order_id)
    {
        $customer = Auth::user();
        $order = DB::table('orders as o')
            ->select('o.order_id', 'o.total_paid_amount', 'o.sub_total', 'o.discount_amount', 'o.delivery_charge_amount', 'o.refPayment_mode_id', 'o.payment_mode_name', 'o.refTransaction_id', 'o.refCustomer_company_id_billing', 'o.billing_company_name', 'o.billing_company_office_no', 'o.billing_company_office_email', 'o.billing_company_office_address', 'o.billing_company_office_pincode', DB::raw('(select "name" from "city" where "city_id" = "o"."refCity_id_billing") as "billing_city"'), DB::raw('(select "name" from "state" where "state_id" = "o"."refState_id_billing") as "billing_state"'), DB::raw('(select "name" from "country" where "country_id" = "o"."refCountry_id_billing") as "billing_country"'), 'o.billing_company_pan_gst_no', 'o.refCustomer_company_id_shipping', 'o.shipping_company_name', 'o.shipping_company_office_no', 'o.shipping_company_office_email', 'o.shipping_company_office_address', 'o.shipping_company_office_pincode', DB::raw('(select "name" from "city" where "city_id" = "o"."refCity_id_shipping") as "shipping_city"'), DB::raw('(select "name" from "state" where "state_id" = "o"."refState_id_shipping") as "shipping_state"'), DB::raw('(select "name" from "country" where "country_id" = "o"."refCountry_id_shipping") as "shipping_country"'), 'o.created_at', 'o.additional_discount', 'o.tax_name', 'o.tax_amount', 'o.additional_discount', 'o.order_status')
            ->where('o.refCustomer_id', $customer->customer_id)
            ->where('o.order_id', $order_id)
            ->first();
        /* $diamonds = DB::table('order_diamonds')
            ->selectRaw('COUNT(order_diamond_id) as total_diamonds, SUM(expected_polish_cts) as total_carats')
            ->where('refOrder_id', $order->order_id)
            ->first(); */
        $diamonds = DB::table('order_diamonds')
            ->select('order_diamond_id', 'expected_polish_cts', 'refDiamond_id', 'barcode')
            ->where('refOrder_id', $order->order_id)
            ->get();
        $total_diamonds = $total_carats = 0;
        $barcodes = [];
        foreach ($diamonds as $v) {
            $total_carats += $v->expected_polish_cts;
            $barcodes[] = $v->barcode;
        }
        $tax = number_format(($order->sub_total - $order->discount_amount - ($order->additional_discount * $order->sub_total / 100)) * $order->tax_amount / 100, 2, '.', ',');
        $amount_words = $this->numberToWords($order->total_paid_amount);
        $tax_words = $this->numberToWords($tax);
        $pdf = PDF::loadView('front.orders.invoice_pdf', compact('order', 'customer', 'diamonds', 'tax', 'amount_words', 'tax_words', 'barcodes', 'total_carats'));
        $fileName =  $order_id . '.' . 'pdf';
        // $path = public_path('pdf/');
        // $pdf->save($path . '/' . $fileName);
        // $pdf = public_path('pdf/' . $fileName);
        // return view('front.orders.invoice_pdf', compact('order', 'customer', 'diamonds', 'tax', 'amount_words', 'tax_words', 'barcodes', 'total_carats'));
        // return response()->download($pdf);
        return $pdf->download($fileName);
    }

    public function downloadInvoice(Request $request, $order_id)
    {
        $customer = Auth::user();
        $order = DB::table('orders as o')
            ->select('o.order_id', 'o.total_paid_amount', 'o.sub_total', 'o.discount_amount', 'o.delivery_charge_amount', 'o.refPayment_mode_id', 'o.payment_mode_name', 'o.refTransaction_id', 'o.refCustomer_company_id_billing', 'o.billing_company_name', 'o.billing_company_office_no', 'o.billing_company_office_email', 'o.billing_company_office_address', 'o.billing_company_office_pincode', DB::raw('(select "name" from "city" where "city_id" = "o"."refCity_id_billing") as "billing_city"'), DB::raw('(select "name" from "state" where "state_id" = "o"."refState_id_billing") as "billing_state"'), DB::raw('(select "name" from "country" where "country_id" = "o"."refCountry_id_billing") as "billing_country"'), 'o.billing_company_pan_gst_no', 'o.refCustomer_company_id_shipping', 'o.shipping_company_name', 'o.shipping_company_office_no', 'o.shipping_company_office_email', 'o.shipping_company_office_address', 'o.shipping_company_office_pincode', DB::raw('(select "name" from "city" where "city_id" = "o"."refCity_id_shipping") as "shipping_city"'), DB::raw('(select "name" from "state" where "state_id" = "o"."refState_id_shipping") as "shipping_state"'), DB::raw('(select "name" from "country" where "country_id" = "o"."refCountry_id_shipping") as "shipping_country"'), 'o.created_at', 'o.additional_discount', 'o.tax_name', 'o.tax_amount', 'o.order_status', 'o.due_date', 'o.name')
            ->where('o.refCustomer_id', $customer->customer_id)
            ->where('o.order_id', $order_id)
            ->first();
        /* $diamonds = DB::table('order_diamonds')
            ->selectRaw('COUNT(order_diamond_id) as total_diamonds, SUM(expected_polish_cts) as total_carats')
            ->where('refOrder_id', $order->order_id)
            ->first(); */
        $diamonds = DB::table('order_diamonds as od')
            ->join('categories as c', 'od.refCategory_id', '=', 'c.category_id')
            ->join('diamonds_attributes as da', 'od.refDiamond_id', '=', 'da.refDiamond_id')
            ->join('attribute_groups as ag', 'da.refAttribute_group_id', '=', 'ag.attribute_group_id')
            ->join('attributes as a', 'da.refAttribute_id', '=', 'a.attribute_id')
            ->select('od.price', 'od.barcode', 'od.rapaport_price', 'od.new_discount', 'od.refDiamond_id', 'od.expected_polish_cts', 'ag.name as ag_name', 'a.name as a_name', 'c.name as cat_name')
            ->where('od.refOrder_id', $order->order_id)
            ->whereIn('ag.name', ['COLOR','CLARITY','SHAPE','CUT'])
            ->get()
            ->toArray();

        $final_d = [];
        foreach ($diamonds as $v_row) {
            $final_d[$v_row->refDiamond_id]['attributes'][$v_row->{'ag_name'}] = $v_row->{'a_name'};
            $final_d[$v_row->refDiamond_id]['cat_name'] = $v_row->cat_name;
            $final_d[$v_row->refDiamond_id]['barcode'] = $v_row->barcode;
            $final_d[$v_row->refDiamond_id]['rapaport_price'] = $v_row->rapaport_price;
            $final_d[$v_row->refDiamond_id]['discount'] = $v_row->new_discount * 100;
            $final_d[$v_row->refDiamond_id]['total'] = $v_row->price;
            $final_d[$v_row->refDiamond_id]['expected_polish_cts'] = $v_row->expected_polish_cts;
        }
        $final_d = array_values($final_d);
        $tax = number_format(($order->sub_total - $order->discount_amount - ($order->additional_discount * $order->sub_total / 100)) * $order->tax_amount / 100, 2, '.', ',');
        // $amount_words = $this->numberToWords($order->total_paid_amount);
        // $tax_words = $this->numberToWords($tax);
        /* $html = null;
        for ($i = 0; $i < count($final_d); $i++) {
            $html .= '<tr>
                <td class="text-center">'. $i+1 .'</td>
                <td class="text-center">'. $final_d[$i]['barcode'] .'</td>
                <td class="text-center">'. $final_d[$i]['attributes']['SHAPE'] .'</td>
                <td class="text-center">'. $final_d[$i]['attributes']['COLOR'] .'</td>
                <td class="text-center">'. $final_d[$i]['attributes']['CLARITY'] .'</td>
                <td class="text-center">'.  '-' .'</td>
                <td class="text-end">'. $final_d[$i]['expected_polish_cts'] .'</td>
                <td class="text-end">$'. number_format($final_d[$i]['rapaport_price'], 2, '.', ',') .'</td>
                <td class="text-end">'. $final_d[$i]['discount'] .'%</td>
                <td class="text-end">$'. number_format($final_d[$i]['total'] / $final_d[$i]['expected_polish_cts'], 2, '.', ',') .'</td>
                <td class="text-end">$'. number_format($final_d[$i]['total'], 2, '.', ',') .'</td>
            </tr>';
        } */
        // $pdf = PDF::loadView('front.orders.new_invoice', compact('order', 'customer', 'diamonds', 'tax', 'final_d'));
        $fileName =  $order_id . '.' . 'pdf';
        // $path = public_path('pdf/');
        // $pdf->save($path . '/' . $fileName);
        // $pdf = public_path('pdf/' . $fileName);
        return view('front.orders.new_invoice', compact('order', 'customer', 'diamonds', 'tax', 'final_d'));
        // return response()->download($pdf);
        // return $pdf->download($fileName);
    }

    // Create a function for converting the amount in words
    public function numberToWords(float $amount)
    {
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
        // Check if there is any number after decimal
        $amt_hundred = null;
        $count_length = strlen($num);
        $x = 0;
        $string = array();
        $change_words = array(
            0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );
        $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($x < $count_length) {
            $get_divider = ($x == 2) ? 10 : 100;
            $amount = floor($num % $get_divider);
            $num = floor($num / $get_divider);
            $x += $get_divider == 10 ? 1 : 2;
            if ($amount) {
                $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
                $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . '
                ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . '
                ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
            } else {
                $string[] = null;
            }
        }
        $implode_to_Rupees = implode('', array_reverse($string));
        $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . "
        " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
        return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
    }
}