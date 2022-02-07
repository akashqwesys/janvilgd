@extends('admin.header')
@section('css')
<link href="/admin_assets/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="/admin_assets/datatable/dataTables.responsive.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>

</style>
@endsection
@section('content')
<!-- content @s -->

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide mx-auto">
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <div class="row-">
                                        <div class="col-md-2-">
                                            <h4 class="nk-block-title">Sold {{ $request->session()->get('categories')->where('slug', $slug)->pluck('name')->first() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div>
                        <div class="card card-preview">
                            <div id='append_loader' class="overlay">
                                <div class='d-flex justify-content-center' style="padding-top: 10%;">
                                    <div class='spinner-border text-success' role='status'>
                                        <span class='sr-only'>Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <table id="table" class="table dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Trans. Date</th>
                                            <th class="text-center">Stock No</th>
                                            <th class="text-center">Shape</th>
                                            <th class="text-right">Carat</th>
                                            <th class="text-center">Color</th>
                                            <th class="text-center">Clarity</th>
                                            <th class="text-center">Cut</th>
                                            <th class="text-center">Rapaport</th>
                                            <th class="text-center">Discount</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Sold Disc.</th>
                                            <th class="text-center">Amount</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div><!-- .card-preview -->
                    </div> <!-- nk-block -->
                </div><!-- .components-preview -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->
@endsection
@section('script')
<script src="/admin_assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/admin_assets/datatable/dataTables.responsive.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    var table = $('#table').DataTable({
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        columnDefs: [{
                className: 'control',
                orderable: false,
                targets: 0
            }],
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "paginationType": "full_numbers",
        ajax: {
            'url': "/admin/sold-diamonds/list",
            'data': function (data) {
                $('#append_loader').hide();
                data.slug = "<?= $slug ?>";
            },
            'complete': function (data) {
                $('#append_loader').hide();
            }
        },
        columns: [
            {data: 'index', name: 'index'},
            {data: 'created_at', name: 'created_at'},
            {data: 'barcode', name: 'barcode'},
            {data: 'shape', name: 'shape'},
            {data: 'carat', name: 'carat'},
            {data: 'color', name: 'color'},
            {data: 'clarity', name: 'clarity'},
            {data: 'cut', name: 'cut'},
            {data: 'rapaport', name: 'rapaport'},
            {data: 'discount', name: 'discount'},
            {data: 'status', name: 'status'},
            {data: 'new_discount', name: 'new_discount'},
            {data: 'price', name: 'price'}
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).children(':nth-child(1)').addClass('text-center');
            $(row).children(':nth-child(2)').addClass('text-center');
            $(row).children(':nth-child(3)').addClass('text-center');
            $(row).children(':nth-child(4)').addClass('text-center');
            $(row).children(':nth-child(5)').addClass('text-center');
            $(row).children(':nth-child(6)').addClass('text-center');
            $(row).children(':nth-child(7)').addClass('text-center');
            $(row).children(':nth-child(8)').addClass('text-center');
            $(row).children(':nth-child(9)').addClass('text-center');
            $(row).children(':nth-child(10)').addClass('text-center');
            $(row).children(':nth-child(11)').addClass('text-center');
            $(row).children(':nth-child(12)').addClass('text-center');
            $(row).children(':nth-child(13)').addClass('text-center');
        }
    });
</script>
@endsection