<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
<style type="text/css">
    tbody, td, tfoot, th, thead, tr {
        border-color: inherit;
        border-style: solid;
        border-width: 1px;
        padding: 2px;
    }
    p {
        margin-bottom: 0;
        font-size: 12px;
    }
    .card {
        border: 0;
    }
    h5 {
        font-size: 15px;
        margin-bottom: 0;
    }
    h6 {
        font-size: 13px;
        margin-bottom: 0;
    }
</style>

<div class="container mt-3 mb-3">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="flex-row invoice-logo">
                   <h5 style="text-align: center;margin-bottom: 5px;"><strong>Tax Invoice</strong></h5>
                </div>
                <div class="table-responsive p-2">
                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td colspan="2" rowspan="3" scope="rowgroup">
                                    <h5>Janvi LGD Private Limited</h5>
                                    <p>Rs 352 Paiki Sy 1446 to 1448, 1454 Paiki</p>
                                    <p>FP-31, Tp-4, Old Gujarat Plastic Compound</p>
                                    <p>A.K.Road</p>
                                    <p>Surat-395008</p>
                                    <p>Ph.No-0261-2545262/2545263</p>
                                    <p>(M)09979052062</p>
                                    <p>Email Id-Janvilgd@hotmail.Com</p>
                                    <p>GSTIN/UIN: 24AAJCR8701R1ZR</p>
                                    <p>State Name : Gujarat, Code : 24</p>
                                    <p>CIN: U36999GJ2019PTC110417</p>
                                </td>
                                <td scope="row">
                                    <p>Invoice No.</p>
                                    <h6>{{ $order->order_id }}</h6>
                                </td>
                                <td>
                                    <p>Dated</p>
                                    <h6>{{ date('d-M-Y', strtotime($order->created_at)) }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td scope="row">Delivery Note</td>
                                <td>Mode/Terms of Payment</td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <p>Invoice No.</p>
                                    <h6>{{ $order->order_id }}</h6>
                                </th>
                                <td>Other Reference(s)</td>
                            </tr>
                            <tr>
                                <td colspan="2" rowspan="3" scope="rowgroup">
                                    <p>Consignee</p>
                                    <h5>{{ $order->billing_company_name }}</h5>
                                    <p>{{ $order->billing_company_office_address }}</p>
                                    <p>GSTIN/UIN : {{ $order->billing_company_pan_gst_no }}</p>
                                    <p>State Name : {{ $order->billing_state }}, Code : 27</p>
                                </td>
                                <td scope="row">
                                    <p>Buyer's Order No.</p>
                                    <p>Dated</p>
                                </td>
                                <td>
                                    <p>Despatch Document No.</p>
                                    <p>Delivery Note Date</p>
                                </td>
                            </tr>
                            <tr>
                                <td scope="row">Delivery Note</td>
                                <td>Mode/Terms of Payment</td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <p>Despatched through</p>
                                </td>
                                <td>Destination</td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width:100%;">
                        <tr>
                            <td><h5>Sl No.</h5></td>
                            <td><h5>Description of Goods</h5></td>
                            <td><h5>HSN/SAC</h5></td>
                            <td><h5>Quantity</h5></td>
                            <td><h5>Rate</h5></td>
                            <td><h5>per</h5></td>
                            <td><h5>Amount</h5></td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">1</td>
                            <td>
                                <h6>Cut & Polish Diamond(s)</h6>
                                <p>Lab Grown Diamond(s) (Pcs-{{ $diamonds->total_diamonds }})</p>

                                <p class="mt-5 mb-5 text-end"><strong>{{ $order->tax_name }}</strong></p>
                            </td>
                            <td style="vertical-align: top;">71049010</td>
                            <td style="vertical-align: top;">{{ $diamonds->total_carats }} Crt(s)</td>
                            <td style="vertical-align: top;">{{ $order->sub_total }}</td>
                            <td style="vertical-align: top;">Crt</td>
                            <td>
                                {{ $order->total_paid_amount - $tax }}
                                <p class="mt-5 mb-5 text-end">
                                    <strong>{{ $tax }}</strong>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <p class="text-end">Total</p>
                            </td>
                            <td></td>
                            <td><h6>{{ $diamonds->total_carats }} Crt(s)</h6></td>
                            <td></td>
                            <td></td>
                            <td>
                                <h5><!--₹--> {{ $order->total_paid_amount }}</h5>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <p>Amount Chargeable (in words) E. & O.E E. & O.E</p>
                                <h5>{{ $amount_words }} Only</h5>
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td scope="rowgroup">
                                    <h6>HSN/SAC</h6>
                                </td>
                                <td scope="row">
                                    <p>Taxable<br>Value</p>
                                </td>
                                <td rowspan="3" class="p-0" border="0">
                                    <table style="width:100%">
                                      <tr>
                                        <th rowspan="2"><h5><strong>Taxable Value</strong></h5></th>
                                        <th colspan="2"><h5><strong>Integrated Tax</strong></h5></th>
                                        <th rowspan="2"><h5><strong>Total Tax Amount</strong></h5></th>

                                    </tr>
                                    <tr>
                                        <th><h5><strong>Rate</strong></h5></th>
                                        <th><h5><strong>Amount</strong></h5></th>
                                    </tr>
                                    <tr>
                                        <td>{{ $order->total_paid_amount - $tax }}</td>
                                        <td>{{ $order->tax_amount }}%</td>
                                        <td>{{ $tax }}</td>
                                        <td>{{ $tax }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $order->total_paid_amount - $tax }}</td>
                                        <td></td>
                                        <td>{{ $tax }}</td>
                                        <td>{{ $tax }}</td>
                                    </tr>
                                </table>
                                </td>
                            </tr>
                            <tr>
                                <td  scope="rowgroup">
                                    <p>71049010</p>
                                </td>
                                <td scope="row">
                                    <p>{{ $order->total_paid_amount - $tax }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td  scope="rowgroup">
                                    <h6>Total</h6>
                                </td>
                                <td scope="row">
                                    <h6>{{ $order->total_paid_amount - $tax }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" scope="rowgroup">
                                    <p>Tax Amount (in words) : <strong>{{ $tax_words }} Only</strong></p>
                                    <p class="mt-5">Company's PAN : <strong>AAJCR8701R</strong></p>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr class="content">
                                                <td class="font-weight-bold">
                                                    <p><u>Declaration</u></p>
                                                    <p>We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.</p>
                                                </td>
                                                <td class="font-weight-bold">
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
                                <td colspan="2" scope="rowgroup">
                                    <p>Customer's Seal and Signature </p>
                                </td>
                                <td colspan="2" scope="rowgroup">
                                    <p>for Janvi LGD Private Limited</p>
                                    <p>Authorised Signatory </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                     <table>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="/assets/js/jquery-3.6.0.min.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>