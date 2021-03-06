<?php if ($data['title'] == 'List-Customers') {
    ?>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function (xhr) {
                $("#append_loader").show();
            },
            complete: function (xhr) {
                $("#append_loader").hide();
            }
        });
        var data_table = null;
        var is_approved = '{{ $request["filter"] }}';
        if (is_approved == 'approved') {
            is_approved = 1;
        } else if (is_approved == 'unapproved') {
            is_approved = 0;
        } else {
            is_approved = 2;
        }
        setTimeout(() => {
            $('#is_approved').val(is_approved).trigger('change');
        }, 10);

        function list_customers(){
            data_table = $('#table').DataTable({
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
                    'url': "{{ route('customers.list') }}",
                    'data': function (data) {
                        data.is_approved = is_approved
                    }
                },
                columns: [
                    {data: 'index', name: 'index'},
                    {data: 'name', name: 'name'},
                    {data: 'mobile', name: 'mobile'},
                    {data: 'email', name: 'email'},
                    // {data: 'address', name: 'address'},
                    // {data: 'pincode', name: 'pincode'},
                    // {data: 'city_name', name: 'city_name'},
                    // {data: 'state_name', name: 'state_name'},
                    // {data: 'country_name', name: 'country_name'},
                    // {data: 'refCustomerType_id', name: 'refCustomerType_id'},
                    // {data: 'restrict_transactions', name: 'restrict_transactions'},
                    // {data: 'added_by', name: 'added_by'},
                    {data: 'is_active', name: 'is_active',className: "is_active"},
                    // {data: 'is_deleted', name: 'is_deleted',className: "is_deleted"},
                    {data: 'is_approved', name: 'is_approved',className: "is_approved"},
                    {data: 'date_added', name: 'date_added'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    }
                ],
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('tr_'+data['customer_id']);
                }
            });
        }

        $(document).on('change', '#is_approved', function () {
            is_approved = $(this).val();
            if (data_table == null) {
                list_customers();
            } else {
                data_table.clear().draw();
            }
        });

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
            $.ajax({
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('customers.delete') }}",
                data: data,
                success: function (res) {
                    if (res.suceess) {
                        $('.tr_' + self.data('id') + ' .is_deleted').html('<span class="badge badge-danger">Deleted</span>');
                    }
                }
            });
        });

        $(document).on('click', '.active_inactive_button', function () {
            var self = $(this);
            var table = self.attr('data-table') == undefined ? '' : self.attr('data-table');
            var status = self.attr('data-status') == undefined ? '' : self.attr('data-status');
            var module = self.attr('data-module') == undefined ? '' : self.attr('data-module');
            var status_main=1;
            if(status==1){
                status_main=0;
            }
            var wherefield = self.attr('data-wherefield') == undefined ? '' : self.attr('data-wherefield');

            if (!confirm('Are you sure want to update?')) {
                return;
            }
            var data = {
                'table_id': $(this).attr('data-id'),
                'table': table,
                'module': module,
                'status': status_main,
                'wherefield': wherefield,
                'approved' : $(this).hasClass('approved') ? true : false,
                '_token': $("meta[name=csrf-token]").attr('content')
            };
            $.ajax({
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('customers.status') }}",
                data: data,
                success: function (res) {
                    if (res.suceess) {
                        data_table.clear().draw();
                        /* if(status==1){
                            if(table==="customer_company_details"){
                                $('.tr_' + self.data('id') + ' .is_approved').html('<span class="badge badge-danger">Unverified</span>');
                                self.html('Verify');
                            }else{
                                $('.tr_' + self.data('id') + ' .is_active').html('<span class="badge badge-danger">inActive</span>');
                                self.html('<em class="icon ni ni-check-thick"></em>');
                            }
                            self.attr("data-status",0);
                            self.removeClass('btn-danger');
                            self.addClass('btn-success');
                        }
                        if(status==0){
                            if(table==="customer_company_details"){
                                $('.tr_' + self.data('id') + ' .is_approved').html('<span class="badge badge-success">Verified</span>');
                                self.html('UnVerify');
                            }else{
                                $('.tr_' + self.data('id') + ' .is_active').html('<span class="badge badge-success">Active</span>');
                                self.html('<em class="icon ni ni-cross"></em>');
                            }
                            self.attr("data-status",1);
                            self.removeClass('btn-success');
                            self.addClass('btn-danger');
                        } */
                        $('#append_loader').hide();
                    }
                }
            });
        });

    </script>
<?php } ?>