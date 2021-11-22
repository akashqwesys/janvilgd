<?php if ($data['title'] == 'List-Rapaport') {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            var table_columns = [                    
                    {data: 'index', name: 'index'},
                    {data: 'name', name: 'name'},                    
                    {data: 'date_updated', name: 'date_updated'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    }                 
                ];                              
            $('#table').DataTable({
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
                 ajax: "{{ route('rapaport.list') }}",               
                columns:table_columns,
                "createdRow": function (row, data, dataIndex) {                    
                    $(row).addClass('tr_'+data['rapaport_id']);                      
                }
            });
        });
    </script>   
<?php } ?>