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
}