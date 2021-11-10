<?php if ($data['title'] == 'List-Diamonds') {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            var table_columns=[];
            <?php if($data['cat_type']== config('constant.CATEGORY_TYPE_4P')){
            ?>
                    table_columns = [                    
                    {data: 'index', name: 'index'},
                    {data: 'name', name: 'name'},
                    {data: 'barcode', name: 'barcode'},
                    {data: 'packate_no', name: 'packate_no'},                    
                    {data: 'available_pcs', name: 'available_pcs'},
                    {data: 'makable_cts', name: 'makable_cts'},
                    {data: 'expected_polish_cts', name: 'expected_polish_cts'},                                       
                    {data: 'discount', name: 'discount'},
                    {data: 'weight_loss', name: 'weight_loss'}, 
                    {data: 'total', name: 'total'},  
                    {data: 'category_name', name: 'category_name'},                    
                    {data: 'is_active', name: 'is_active',className: "is_active"},
                    {data: 'is_deleted', name: 'is_deleted',className: "is_deleted"},
                    {data: 'date_added', name: 'date_added'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    }
                ];
                    <?php
            } ?>
            <?php if($data['cat_type']== config('constant.CATEGORY_TYPE_ROUGH')){
            ?>                    
                    table_columns = [                    
                    {data: 'index', name: 'index'},
                    {data: 'name', name: 'name'},
                    {data: 'barcode', name: 'barcode'},
                    {data: 'packate_no', name: 'packate_no'},                                        
                    {data: 'makable_cts', name: 'makable_cts'},
                    {data: 'expected_polish_cts', name: 'expected_polish_cts'},                                       
                    {data: 'discount', name: 'discount'},  
                    {data: 'total', name: 'total'},  
                    {data: 'category_name', name: 'category_name'},                    
                    {data: 'is_active', name: 'is_active',className: "is_active"},
                    {data: 'is_deleted', name: 'is_deleted',className: "is_deleted"},
                    {data: 'date_added', name: 'date_added'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    }
                ];
                    <?php
            } ?>
            <?php if($data['cat_type'] == config('constant.CATEGORY_TYPE_POLISH')){
            ?>
                    table_columns = [                    
                    {data: 'index', name: 'index'},
                    {data: 'name', name: 'name'},
                    {data: 'barcode', name: 'barcode'},
                    {data: 'packate_no', name: 'packate_no'},                                                                                                                 
                    {data: 'expected_polish_cts', name: 'expected_polish_cts'}, 
                    {data: 'discount', name: 'discount'}, 
                    {data: 'total', name: 'total'},  
                    {data: 'category_name', name: 'category_name'},                    
                    {data: 'is_active', name: 'is_active',className: "is_active"},
                    {data: 'is_deleted', name: 'is_deleted',className: "is_deleted"},
                    {data: 'date_added', name: 'date_added'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    }
                    ];
                    <?php
            } ?>
            
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
                "ajax": {                      
                        'url': "{{ route('diamonds.list') }}",
                        'data': {                            
                            'refCategory_id':<?php echo $data['cat_id']; ?>                           
                        }
                    },
                        columns:table_columns,
                "createdRow": function (row, data, dataIndex) {                    
                    $(row).addClass('tr_'+data['diamond_id']);                      
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.delete_button', function () {
                var self = $(this);
                var table = self.attr('data-table');
                var image = self.attr('data-imahe');
                var wherefield = self.attr('data-wherefield');
                var module = self.attr('data-module');
                if (!confirm('Are you sure want to delete?'))
                    return;
                var data = {
                    'table_id': self.data('id'),
                    'table': table,
                    'image':image,
                    'module': module,
                    'wherefield': wherefield,
                    '_token': $("input[name=_token]").val()
                };
                $('#append_loader').append("<div class='d-flex justify-content-center'><div class='spinner-border text-success' role='status'><span class='sr-only'>Loading...</span></div></div>");
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('diamonds.delete') }}",
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
                if (!confirm('Are you sure want to update?'))
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
                    url: "{{ route('diamonds.status') }}",
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