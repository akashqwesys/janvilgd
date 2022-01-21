@extends('admin.header')
@section('css')
<link href="/admin_assets/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="/admin_assets/datatable/dataTables.responsive.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
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
                                    <div class="">
                                        <h4 class="nk-block-title">Contact Inquiries List</h4>
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
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Mobile No</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Placed on</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contacts as $c)
                                        <tr>
                                            <td> </td>
                                            <td> {{ $c->name }} </td>
                                            <td> {{ $c->phone }} </td>
                                            <td> {{ $c->email }} </td>
                                            <td> {{ $c->subject }} </td>
                                            <td> <?php echo wordwrap($c->message,150,"<br>\n"); ?> </td>
                                            <td> {{ $c->date_added }} </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
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
        order: []
    });
</script>
@endsection