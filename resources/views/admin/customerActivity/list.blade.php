@extends('admin.header')
@section('css')
<link href="{{ asset(check_host().'admin_assets/datatable/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset(check_host().'admin_assets/datatable/dataTables.responsive.css')}}" rel="stylesheet" type="text/css">
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
                                    <h4 style="display: inline;" class="nk-block-title">Activities list</h4>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div>
                        <div class="card card-preview">
                            <div class="card-inner">
                                <table id="table" class="table dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Subject</th>
                                            <th>Activity</th>
                                            <th>URL</th>
                                            <th>Device</th>
                                            <th>IP</th>
                                            <th>Date</th>
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
<div id='append_loader'></div>
<!-- content @e -->
@endsection
@section('script')
<script  src="{{ asset(check_host().'admin_assets/datatable/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script  src="{{ asset(check_host().'admin_assets/datatable/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{ asset(check_host().'admin_assets/datatable/dataTables.responsive.min.js')}}" type="text/javascript" ></script>
<script type="text/javascript">
    $(document).ready(function () {
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
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "paginationType": "full_numbers",
            ajax: "/admin/customer-activities/list",
            columns: [
                {data: 'index', name: 'index'},
                {data: 'subject', name: 'subject'},
                {data: 'activity', name: 'activity'},
                {data: 'url', name: 'url'},
                {data: 'device', name: 'device'},
                {data: 'ip_address', name: 'ip_address'},
                {data: 'created_at', name: 'created_at'}
            ],
            "createdRow": function (row, data, dataIndex) {
                $(row).addClass('tr_' + data['user_activity_id']);
            }
        });
    });

    $(document).ready(function () {
        $(document).on('click', '.delete_button', function () {
            var self = $(this);
            var table = self.attr('data-table');
            var wherefield = self.attr('data-wherefield');
            var module = self.attr('data-module');
            if (!confirm('Are you sure want to delete?'))
                return;
            var data = {
                'table_id': self.data('id'),
                'table': table,
                'module': module,
                'wherefield': wherefield,
                '_token': $("input[name=_token]").val()
            };
            $('#append_loader').append("<div class='d-flex justify-content-center'><div class='spinner-border text-success' role='status'><span class='sr-only'>Loading...</span></div></div>");
            $.ajax({
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('user-activity.delete') }}",
                data: data,
                success: function (res) {
                    if (res.suceess) {
                        $('.tr_' + self.data('id') + ' .is_deleted').html('<span class="badge badge-danger">Deleted</span>');
                        $('#append_loader').empty();
                    }
                }
            });
        });
    });

    $(document).ready(function () {
        $(document).on('click', '.active_inactive_button', function () {
            var self = $(this);
            var table = self.attr('data-table');
            var status = self.attr('data-status');
            var module = self.attr('data-module');
            var status_main=1;
            if(status==1){
                status_main=0;
            }
            var wherefield = self.attr('data-wherefield');
            if (!confirm('Are you sure want to delete?'))
                return;
            var data = {
                'table_id': self.data('id'),
                'table': table,
                'module': module,
                'status':status_main,
                'wherefield': wherefield,
                '_token': $("input[name=_token]").val()
            };
            $('#append_loader').append("<div class='d-flex justify-content-center'><div class='spinner-border text-success' role='status'><span class='sr-only'>Loading...</span></div></div>");
            $.ajax({
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('user-activity.status') }}",
                data: data,
                success: function (res) {
                    if (res.suceess) {
                        if(status==1){
                            $('.tr_' + self.data('id') + ' .is_active').html('<span class="badge badge-danger">inActive</span>');
                            self.attr("data-status",0);
                            self.html('<em class="icon ni ni-check-thick"></em>');
                            self.removeClass('btn-danger');
                            self.addClass('btn-success');
                        }
                        if(status==0){
                            $('.tr_' + self.data('id') + ' .is_active').html('<span class="badge badge-success">Active</span>');
                            self.attr("data-status",1);
                            self.html('<em class="icon ni ni-cross"></em>');
                            self.removeClass('btn-success');
                            self.addClass('btn-danger');
                        }
                        $('#append_loader').empty();
                    }
                }
            });
        });
    });
</script>
@endsection