<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"> --}}
    <title></title>
    <style type="text/css">
        body {
            border: 1px solid;
        }
        table {
            width: 100%;
        }
        tbody, td, tfoot, th, thead, tr {
            border-color: inherit;
            border-style: solid;
            border-width: 1px;
            padding: 2px;
        }
        tr {
            vertical-align: top;
        }
        p {
            margin-bottom: 2px;
            font-size: 11px;
        }
        .div-h5 {
            font-size: 13px;
            margin-bottom: 0;
        }
        .div-h6 {
            font-size: 12px;
            margin-bottom: 0;
        }
        .div-h7 {
            font-size: 10px;
            margin-bottom: 0;
        }
        .lh-13 {
            line-height: 1.2;
        }
        .display-inline-block {
            display: inline-block;
        }
        .cs-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .va-middle {
            vertical-align: middle;
        }
        .bg-lightgray {
            background-color: #828282;
        }
        .border-none, .border-none tbody, .border-none tr, .border-none td {
            border: none;
        }
        .td-pd-0 td {
            padding: 0;
        }
        .td-pd-0 p {
            margin: 0;
        }
        .love-dia {
            font-size: 13px;
            display: inline-block;
            border-bottom: 1px solid;
            padding-left: 10px;
            width: 69.4%;
        }
        .invoice-title {
            font-size: 13px;
            display: inline-block;
            border-left: 1px solid;
            border-right: 1px solid;
            padding: 0px 15px;
        }
        .mt--4 {
            margin-top: -4px;
        }
        .ml--5 {
            margin-left: -5px;
        }
        .bb-1 {
            border-bottom: 1px solid;
        }
        .w-120p {
            width: 120px;
        }
        .w-48 {
            width: 48%;
        }
    </style>
</head>

<body>
    <div class="">
        <div class="table-responsive p-2-">
            <table>
                <tbody>
                    <tr>
                        <td width="18%" class="va-middle bg-lightgray">
                            <div class="text-center">
                                <img src="{{ url('/') }}/assets/images/logo.png" alt="" height="35" class="">
                            </div>
                        </td>
                        <td width="65%" class="va-middle">
                            <div class="">
                                <h6 class="mb-1">LAB GROWN DIAMONDS</h6>
                                <p class=""><i>YOU WILL LOVE OUR DIAMONDS</i></p>
                            </div>
                        </td>
                        <td width="17%">
                            <table class="border-none td-pd-0">
                                <tbody>
                                    <tr>
                                        <td width="45%" class="text-end"><p><b>Invoice: </b> </p></td>
                                        <td><p><b>&nbsp;#{{ $order->order_id }}</b></p></td>
                                    </tr>
                                    <tr>
                                        <td width="45%" class="text-end"><p>Date: </p></td>
                                        <td><p>&nbsp;{{ date('d/m/Y', strtotime($order->created_at)) }}</p></td>
                                    </tr>
                                    <tr>
                                        <td width="45%" class="text-end"><p>Due Date: </p></td>
                                        <td><p>&nbsp;{{ date('d/m/Y', strtotime($order->due_date)) }}</p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- <div class="">
            <div class="love-dia">YOU WILL LOVE OUR DIAMONDS</div>
            <div class="invoice-title ml--5" style="">INVOICE</div>
            <div class="display-inline-block ml--5 bb-1 w-120p"> &nbsp;</div>
        </div> --}}
        <div class="div-h6">
            <table class="border-none td-pd-0">
                <tbody>
                    <tr>
                        <td width="50%">
                            <div class="ps-1">
                                <div><u>Bill To: </u></div>
                                <div>
                                    {{ $order->billing_company_name }} <br>
                                    <i class="fa fa-building"></i> {{ $order->billing_company_office_address }}
                                    {{ $order->billing_city . ' - ' . $order->billing_company_office_pincode }} <br>
                                    {{ $order->billing_state }}
                                </div>
                                <div>
                                    <i class="fa fa-user"> </i>&nbsp;{{ $order->name }} -
                                    <i class="fa fa-phone-alt"> </i>&nbsp;{{ $order->billing_company_office_no }}
                                </div>
                            </div>
                        </td>
                        <td width="50%">
                            <div>
                                <div><u>Ship To: </u></div>
                                <div>
                                    {{ $order->shipping_company_name }} <br>
                                    <i class="fa fa-building"></i> {{ $order->shipping_company_office_address }}
                                    {{ $order->shipping_city . ' - ' . $order->shipping_company_office_pincode }} <br>
                                    {{ $order->shipping_state }}
                                </div>
                                <div>
                                    <i class="fa fa-user"> </i>&nbsp;{{ $order->name }} -
                                    <i class="fa fa-phone-alt"> </i>&nbsp;{{ $order->shipping_company_office_no }}
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="table-responsive div-h6 pb-1">
            <table>
                <tbody>
                    <tr>
                        <td class="text-center" width="25px">S.N.</td>
                        <td class="text-center" width="70px">STOCK NO.</td>
                        <td class="text-center" width="80px">SHAPE</td>
                        <td class="text-center" width="25px">COLOR</td>
                        <td class="text-center" width="35px">CLARITY</td>
                        <td class="text-center" width="70px">CUT</td>
                        <td class="text-end" width="25px">WEIGHT</td>
                        <td class="text-end" width="70px">RAP</td>
                        <td class="text-end" width="40px">DISC</td>
                        <td class="text-end" width="70px">$/CT</td>
                        <td class="text-end" width="80px">AMT</td>
                    </tr>
                    @for ($i = 0; $i < count($final_d); $i++)
                    <tr>
                        <td class="text-center">{{ $i+1 }}</td>
                        <td class="text-center">{{ $final_d[$i]['barcode'] }}</td>
                        <td class="text-center">{{ $final_d[$i]['attributes']['SHAPE'] }}</td>
                        <td class="text-center">{{ $final_d[$i]['attributes']['COLOR'] }}</td>
                        <td class="text-center">{{ $final_d[$i]['attributes']['CLARITY'] }}</td>
                        <td class="text-center">{{ $final_d[$i]['attributes']['CUT'] ?? '-' }}</td>
                        <td class="text-end">{{ $final_d[$i]['expected_polish_cts'] }}</td>
                        <td class="text-end">${{ number_format($final_d[$i]['rapaport_price'], 2, '.', ',') }}</td>
                        <td class="text-end">{{ $final_d[$i]['discount'] }}%</td>
                        <td class="text-end">${{ number_format($final_d[$i]['total'] / $final_d[$i]['expected_polish_cts'], 2, '.', ',') }}</td>
                        <td class="text-end">${{ number_format($final_d[$i]['total'], 2, '.', ',') }}</td>
                    </tr>
                    @endfor
                    <tr>
                        <td colspan="6" rowspan="6">
                            <div class="div-h7 ps-1">
                                <div class="text-center">PAYMENT INFORMATION</div>
                                <div class="w-48 display-inline-block">
                                    <div class="">INDIA</div>
                                    <div>----------------------------</div>
                                    <div>
                                        BANK NAME: HDFC BANK <br>
                                        ACCOUNT NAME: JANVI LGD PRIVATE LIMITED <br>
                                        ACCOUNT NUMBER: 50200045669788 <br>
                                        BRANCH NAME : Sachin <br>
                                        IFSC CODE: HDFC0001706 <br>
                                        SHIFT CODE: HDFCINBB
                                    </div>
                                </div>
                                <div class="w-48 display-inline-block">
                                    <div class="">USA</div>
                                    <div>----------------------------</div>
                                    <div>
                                        BANK NAME: JPMORGAN CHASE <br>
                                        ACCOUNT NAME: JANVI LGD PRIVATE LIMITED <br>
                                        ACCOUNT NUMBER: 8420108663 <br>
                                        ROUTING NUMBER: 122333248 <br>
                                        USA PAYMENT: WDBIU6S <br>
                                        SHIFT CODE: CHASUS33XXX
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td colspan="4" class="text-end">SUBTOTAL</td>
                        <td class="text-end">${{ number_format($order->sub_total, 2, '.', ',') }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end">DISCOUNT</td>
                        <td class="text-end">${{ number_format($order->discount_amount, 2, '.', ',') }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end">ADDITIONAL DISCOUNT</td>
                        <td class="text-end">${{ number_format($order->sub_total * $order->additional_discount / 100, 2, '.', ',') }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end">TAX</td>
                        <td class="text-end">${{ $tax }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end">SHIPPING CHARGE</td>
                        <td class="text-end">${{ number_format($order->delivery_charge_amount, 2, '.', ',') }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end"><b>TOTAL AMOUNT</b></td>
                        <td class="text-end"><b>${{ number_format($order->total_paid_amount, 2, '.', ',') }}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="div-h6">
            <table class="border-none td-pd-0">
                <tbody>
                    <tr>
                        <td width="66%" class="ps-1">
                            <b>Terms & Conditions:</b>
                            <p class="mb-2">JANVI LGD PRIVATE LTD sells laboratory grown diamonds. Sales of these diamonds must be accompanied by disclosure of there origin as lab grown diamonds. Hereby JANVI Lab- grown Diamonds guarantees that lab-grown diamonds are conflict-free & eco-friendly. </p>
                            <b >Cancel & Return Policy:</b>
                            <p>Goods must be returned within two days from the date of delivery. Goods can not be returned unless its in original condition. If a certificate is not returned or returned damaged with your return, there will be a charge of $150 in order to re-certify the diamond. We reserve the rights to determine whether the goods have been damaged or used. You will be completely responsible for the safe return and the shipping cost of the goods. If the goods are approved for return then the payment will be refunded at our earliest.</p>
                        </td>
                        <td class="ps-1">
                            <div class="text-center pt-2 bg-lightgray">
                                <img src="{{ url('/') }}/assets/images/logo.png" alt="" height="25" class="">
                            </div>
                            <div>
                                <b>ADDRESS</b> <br>
                                <b>Janvi LGD Private Limited</b> <br>
                                Rs 352 Paiki Sy 1446 to 1448, 1454 Paiki <br>
                                FP-31, Old Gujarat Plastic Compound, <br>
                                A. K. Road. Surat-395008, Guj. India <br>
                                GSTIN/UIN: 24AAJCR8701R1ZR <br>
                                CIN: U36999GJ2019PTC110417
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="bb-1"></div>
            <div class="div-h6">
                <table class="border-none td-pd-0">
                    <tbody>
                        <tr>
                            <td width="40%">
                                <div class="text-center">
                                    Thank You for shopping with us.
                                </div>
                            </td>
                            <td>
                                <div class="text-end pe-1">
                                    <i class="fa fa-phone-alt"> </i> +1-6268327068 &nbsp;&nbsp;
                                    <i class="fa fa-phone-alt"> </i> +1-6268327068 &nbsp;&nbsp;
                                    <i class="fa fa-envelope"> </i> sales@janvilgd.com
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bb-1"></div>
            <div class="div-h6 cs-center">
                <table class="border-none td-pd-0">
                    <tbody>
                        <tr>
                            <td width="40%" style="padding: 15px 0;">
                                <div class="text-center">
                                    <i class="fa fa-globe"> </i> www.janvilgd.com
                                </div>
                            </td>
                            <td style="padding: 15px 0;">
                                <div class="" style="padding-left: 130px;"> Authorised Signatory </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bb-1"></div>
        </div>
    </div>

</body>

</html>