<?php if ($data['title'] == 'List-Diamonds') {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            var table_columns=[];
            <?php if($data['cat_type'] == config('constant.CATEGORY_TYPE_POLISH')){ ?>
                table_columns = [
                    { data: 'barcode', name: 'barcode' },
                    { data: 'shape', name: 'shape' },
                    { data: 'carat', name: 'carat' },
                    { data: 'color', name: 'color' },
                    { data: 'clarity', name: 'clarity' },
                    { data: 'cut', name: 'cut' },                   
                    { data: 'price_per_carat', name: 'price_per_carat', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                    { data: 'total', name: 'total', render: $.fn.dataTable.render.number(',', '.', 2, '$') },

                    { data: 'action', name: 'action' }
                ];
            <?php } elseif($data['cat_type'] == config('constant.CATEGORY_TYPE_4P')) {?>
                table_columns = [
                    { data: 'barcode', name: 'barcode' },
                    { data: 'shape', name: 'shape' },
                    { data: 'makable_cts', name: 'makable_cts' },
                    { data: 'carat', name: 'carat' },
                    { data: 'color', name: 'color' },
                    { data: 'clarity', name: 'clarity' }, 
                    { data: 'cut', name: 'cut' },                    
                    { data: 'price_per_carat', name: 'price_per_carat', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                    { data: 'total', name: 'total', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                    { data: 'action', name: 'action' }
                ];
            <?php } else {?>
                table_columns = [
                    { data: 'barcode', name: 'barcode' },
                    { data: 'shape', name: 'shape' },
                    { data: 'makable_cts', name: 'makable_cts' },
                    { data: 'carat', name: 'carat' },
                    { data: 'color', name: 'color' },
                    { data: 'clarity', name: 'clarity' },              
                    { data: 'price_per_carat', name: 'price_per_carat', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                    { data: 'total', name: 'total', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                    { data: 'action', name: 'action' }
                ];
            <?php } ?>

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
                    targets: 8
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
                    $(row).addClass('tr_'+['diamond_id']);
                    $(row).children(':nth-child(1)').addClass('text-center');
                    $(row).children(':nth-child(2)').addClass('text-center');
                    $(row).children(':nth-child(3)').addClass('text-right');
                    $(row).children(':nth-child(5)').addClass('text-center');
                    $(row).children(':nth-child(6)').addClass('text-center');
                    $(row).children(':nth-child(7)').addClass('text-right');
                    $(row).children(':nth-child(8)').addClass('text-right');
                    $(row).children(':nth-child(9)').addClass('text-center');

                    <?php if($data['cat_type'] == config('constant.CATEGORY_TYPE_POLISH')){ ?>
                        $(row).children(':nth-child(4)').addClass('text-center');
                    <?php } else {?>
                        $(row).children(':nth-child(4)').addClass('text-right');
                    <?php } ?>
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