<?php if ($data['title'] == 'List-Orders') {
    ?>
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
                'url': "{{ route('orders.list') }}",
                'data': function (data) {
                    $('#append_loader').hide();
                    data.startDate = startDate;
                    data.endDate =  endDate;
                    data.customer_id = customer_id;
                    data.order_status = order_status;
                    data.category = category;
                    data.shape = 'Round';
                },
                'complete': function (data) {
                    $('#append_loader').hide();
                }
            },
            columns: [
                {data: 'index', name: 'index'},
                {data: 'order_id', name: 'order_id'},
                {data: 'name', name: 'name'},
                {data: 'email_id', name: 'email_id'},
                {data: 'mobile_no', name: 'mobile_no'},
                // {data: 'payment_mode_name', name: 'payment_mode_name'},
                {data: 'refTransaction_id', name: 'refTransaction_id'},
                {data: 'date_added', name: 'date_added'},
                // {data: 'date_updated', name: 'date_updated'},
                {data: 'total_paid_amount', name: 'total_paid_amount'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                }
            ],
            "createdRow": function (row, data, dataIndex) {
                $(row).addClass('tr_' + data['order_id']);
            }
        });
        $(document).ready(function () {
        });
    </script>
<?php } ?>
<?php if ($data['title'] == 'Edit-Orders' || $data['title'] == 'View-Orders') {
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
                "bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
                "paging": false,//Dont want paging
                "bPaginate": false,//Dont want paging
                "bFilter": false
            });

            var table = $('#table1').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr'
                    }
                },

                "paginationType": "simple",
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": false,
                "bAutoWidth": false
            });
        });
    </script>
<?php } ?>