<?php if ($data['title'] == 'List-Orders') {
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
                ajax: "{{ route('orders.list') }}",
                columns: [
                    {data: 'index', name: 'index'},
                    {data: 'order_id', name: 'order_id'},
                    {data: 'name', name: 'name'},                      
                    {data: 'email_id', name: 'email_id'}, 
                    {data: 'mobile_no', name: 'mobile_no'}, 
                    {data: 'payment_mode_name', name: 'payment_mode_name'}, 
                    {data: 'refTransaction_id', name: 'refTransaction_id'},     
                    {data: 'date_added', name: 'date_added'},     
                    {data: 'date_updated', name: 'date_updated'},     
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
        });
    </script> 
<?php } ?>