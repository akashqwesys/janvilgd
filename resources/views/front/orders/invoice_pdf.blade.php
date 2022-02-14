<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title></title>
    <style type="text/css">
        table {
            width: 100%;
        }
        page {
            background: white;
            display: block;
            margin: 0 auto;
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
            margin-bottom: 0;
            font-size: 11px;
        }
        .card {
            border: 0;
        }
        h5 {
            font-size: 13px;
            margin-bottom: 0;
        }
        h6 {
            font-size: 12px;
            margin-bottom: 0;
        }
        page[size="A4"] {
            width: 23cm;
            height: auto;
        }
        page[size="A4"][layout="landscape"] {
            width: 31.7cm;
            height: auto;
        }
        .lh-13 {
            line-height: 1.2;
        }
        .display-inline-block {
            display: inline-block;
        }
    </style>
</head>

<body>
    <!-- <page size="A4"> -->
    <div class="mt-2 mb-2">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="text-center"><b>Tax Invoice</b></div>
                    <div class="table-responsive p-2">
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td colspan="2" rowspan="3" scope="rowgroup" width="50%">
                                        <h5>Janvi LGD Private Limited</h5>
                                        <p class="lh-13">Rs 352 Paiki Sy 1446 to 1448, 1454 Paiki</p>
                                        <p class="lh-13">FP-31, Tp-4, Old Gujarat Plastic Compound,</p>
                                        <p class="lh-13">A. K. Road. Surat-395008</p>
                                        <p class="lh-13">Ph.No - 0261-2545262/2545263</p>
                                        <p class="lh-13">(M)+91 9979052062</p>
                                        <p class="lh-13">Email ID: Janvilgd@hotmail.Com</p>
                                        <p class="lh-13">GSTIN/UIN: 24AAJCR8701R1ZR</p>
                                        <p class="lh-13">State Name : Gujarat, Code : 24</p>
                                        <p class="lh-13">CIN: U36999GJ2019PTC110417</p>
                                    </td>
                                    <td scope="row" style="height: 40px;">
                                        <p>Invoice No.</p>
                                        <h6>{{ $order->order_id }}</h6>
                                    </td>
                                    <td style="height: 40px;">
                                        <p>Dated</p>
                                        <h6>{{ date('d-M-Y', strtotime($order->created_at)) }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">
                                        <p>Delivery Note</p>
                                        <h6></h6>
                                    </td>
                                    <td>
                                        <p>Mode/Terms of Payment</p>
                                        <h6></h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">
                                        <p>Supplier's Ref.</p>
                                        <h6></h6>
                                    </td>
                                    <td>
                                        <p>Other Reference(s)</p>
                                        <h6></h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" rowspan="3" scope="rowgroup">
                                        <p class="">Consignee</p>
                                        <h5 class="">{{ $order->billing_company_name }}</h5>
                                        <p class="">{{ $order->billing_company_office_address }}</p>
                                        <p class="">{{ $order->billing_city . ' - ' . $order->billing_company_office_pincode }}</p>
                                        <p class="">GSTIN/UIN : {{ $order->billing_company_pan_gst_no }}</p>
                                        <p class="">State Name : {{ $order->billing_state }}, Code : 27</p>
                                    </td>
                                    <td scope="row">
                                        <p>Buyer's Order No.</p>
                                    </td>
                                    <td>
                                        <p>Dated</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Dispatch Document No</p>
                                    </td>
                                    <td scope="row">
                                        <p>Delivery Note Date</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">
                                        <p>Dispatched through</p>
                                    </td>
                                    <td>
                                        <p>Destination</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" scope="rowgroup">
                                        <p class="">Buyer (if other than consignee)</p>
                                        <h5 class="">{{ $order->billing_company_name }}</h5>
                                        <p class="">{{ $order->billing_company_office_address }}</p>
                                        <p class="">{{ $order->billing_city . ' - ' . $order->billing_company_office_pincode }}</p>
                                        <p class="">GSTIN/UIN : {{ $order->billing_company_pan_gst_no }}</p>
                                        <p class="">State Name : {{ $order->billing_state }}, Code : 27</p>
                                    </td>
                                    <td colspan="2" scope="row">
                                        <p>Terms of Delivery</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; ">
                            <tr style="height: fit-content;">
                                <td width="6%">
                                    <h5>Sl No.</h5>
                                </td>
                                <td width="45.3%">
                                    <h5>Description of Goods</h5>
                                </td>
                                <td>
                                    <h5>HSN/SAC</h5>
                                </td>
                                <td>
                                    <h5>Quantity</h5>
                                </td>
                                <td>
                                    <h5>Rate</h5>
                                </td>
                                <td>
                                    <h5>per</h5>
                                </td>
                                <td>
                                    <h5>Amount</h5>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">1</td>
                                <td>
                                    <h6>Cut & Polish Diamond</h6>
                                    <p><i>Lab Grown Diamond (Pcs-{{ $diamonds->total_diamonds }})</i></p>

                                    <p class="mt-4 mb-4 text-end"><strong><i>IGST</i></strong></p>
                                </td>
                                <td style="vertical-align: top;">
                                    <p>---</p>
                                </td>
                                <td style="vertical-align: top;">
                                    <p>{{ $diamonds->total_carats }} CTS</p>
                                </td>
                                <td style="vertical-align: top;">
                                    <p>50,290.36</p>
                                </td>
                                <td style="vertical-align: top;">
                                    <p>CTS</p>
                                </td>
                                <td>
                                    <p><strong>{{ $order->sub_total - $order->discount_amount }}</strong></p>
                                    <p class="mt-5 mb-5 text-end"><strong>{{ $tax }}</strong></p>
                                </td>
                            </tr>
                            <tr style="height: fit-content;">
                                <td></td>
                                <td>
                                    <p class="text-end">Total</p>
                                </td>
                                <td></td>
                                <td>
                                    <h6>{{ $diamonds->total_carats }} CTS</h6>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h5><!-- ₹ --> ${{ $order->total_paid_amount }}</h5>
                                </td>
                            </tr>
                            <tr style="height: fit-content;">
                                <td colspan="7">
                                    <div class="">
                                        <div class="display-inline-block">
                                            <p class="">Amount Chargeable (in words)</p>
                                        </div>
                                        <div class="display-inline-block float-end">
                                            <p class=""><i>E. & O.E</i></p>
                                        </div>
                                    </div>
                                    <h5>USD {{ $amount_words }} Only</h5>
                                </td>
                            </tr>
                        </table>
                        <table style="width:100%;">
                            <tbody>
                                <tr class="text-center">
                                    <th rowspan="2" width="52%">
                                        <h6>HSN/SAC</h6>
                                    </th>
                                    <th rowspan="2">
                                        <h5><strong>Taxable Value</strong></h5>
                                    </th>
                                    <th colspan="2">
                                        <h5><strong>Integrated Tax</strong></h5>
                                    </th>
                                    <th rowspan="2">
                                        <h5><strong>Total Tax Amount</strong></h5>
                                    </th>
                                </tr>
                                <tr class="text-center">
                                    <th>
                                        <h5><strong>Rate</strong></h5>
                                    </th>
                                    <th>
                                        <h5><strong>Amount</strong></h5>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <p>71049010</p>
                                    </td>
                                    <td class="text-end">
                                        <p>{{ $order->sub_total - $order->discount_amount }}</p>
                                    </td>
                                    <td class="text-end">
                                        <p>{{ $order->tax_amount }}%</p>
                                    </td>
                                    <td class="text-end">
                                        <p>{{ $tax }}</p>
                                    </td>
                                    <td class="text-end">
                                        <p>{{ $tax }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">
                                        <p><strong>Total</strong></p>
                                    </td>
                                    <td class="text-end"><strong>
                                            <p>{{ $order->sub_total - $order->discount_amount }}</p>
                                        </strong></td>
                                    <td class="text-end"></td>
                                    <td class="text-end">
                                        <p>{{ $tax }}</p>
                                    </td>
                                    <td class="text-end">
                                        <p>{{ $tax }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td colspan="4" scope="rowgroup">
                                        <p>Tax Amount (in words) : <strong>USD {{ $tax_words }} Only</strong></p>
                                        <p class="mt-5">Company's PAN : <strong>AAJCR8701R</strong></p>
                                        <table class="table table-borderless m-0 border-white">
                                            <tbody>
                                                <tr class="content">
                                                    <td class="font-weight-bold p-0" width="50%">
                                                        <p><u>Declaration</u></p>
                                                        <p>We declare that this invoice shows the actual price of the
                                                            goods described and that all particulars are true and
                                                            correct.</p>
                                                    </td>
                                                    <td class="font-weight-bold p-0" width="50%">
                                                        <p>Company's Bank Details</p>
                                                        <p>Bank Name : <strong>HDFC Bank</strong> </p>
                                                        <p>A/c No. : <strong> 50200045669788</strong> </p>
                                                        <p>Branch & IFS Code: <strong> Sachin & HDFC0001706</strong></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" scope="rowgroup" width="50%">
                                        <p>Customer's Seal and Signature </p>
                                    </td>
                                    <td colspan="2" scope="rowgroup" width="50%" class="text-end">
                                        <p class="mb-5">For Janvi LGD Private Limited</p>
                                        <p>Authorised Signatory </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <p>This is a Computer Generated Invoice</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </page> -->
</body>

</html>