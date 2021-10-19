<?php if ($data['title'] == 'List-User-Activity') {
    ?>
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
                ajax: "{{ route('user-activity.list') }}",
                columns: [
                    {data: 'index', name: 'index'},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'module_name', name: 'module_name'},
                    {data: 'activity', name: 'activity'},
                    {data: 'subject', name: 'subject'},
                    {data: 'url', name: 'url'},
                    {data: 'device', name: 'device'},
                    {data: 'ip_address', name: 'ip_address'},
                    {data: 'date_added', name: 'date_added'}
                ],
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('tr_' + data['user_activity_id']);
                }
            });
        });
    </script>
    <script type="text/javascript">
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
    </script>
    <script type="text/javascript">     
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
<?php } ?>