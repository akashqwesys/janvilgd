<?php if ($data['title'] == 'Edit-Blogs' || $data['title'] == 'Edit-Categories' || $data['title'] == 'Edit-Events' || $data['title'] == 'Edit-Sliders' || $data['title'] == 'Edit-Attributes' || $data['title'] == 'Edit-Diamonds') {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.delete_img_button', function () {
                var self = $(this);
                var id = self.data('id');
                var table = self.attr('data-table');
                var inc = self.attr('data-inc');
                var image = self.attr('data-image');
                var wherefield = self.attr('data-wherefield');
                if (!confirm('Are you sure want to remove image?'))
                    return;
                var data = {
                    'table_id': self.data('id'),
                    'table': table,
                    'image': image,
                    'wherefield': wherefield,
                    '_token': $("input[name=_token]").val()
                };
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('data.image') }}",
                    data: data,
                    success: function (res) {
                        if (res.suceess) {
                            $("#img_"+id+"_"+inc).remove();
                        }
                    }
                });
            });
        });
    </script>
<?php } ?>

<?php if ($data['title'] == 'Add-Order') {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#import_order_refCustomer_id').on('change', function () {
                $('#append_loader').show();
                var refCustomer_id = $(this).val();
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('orders.address')}}",
                    data: {'refCustomer_id': refCustomer_id},
                    success: function (res) {
                        var result = $.parseJSON(res);
                        $("#refCustomer_company_id_shipping").empty();
                        $("#refCustomer_company_id_shipping").append(new Option('------ Select Shipping Address ------', ''));
                        $.each(result, function (index, value) {
                            $('#refCustomer_company_id_shipping').append($('<option />').val(value.customer_company_id).text(value.name +', '+value.office_address +', '+value.city_name +', '+value.state_name+', '+value.country_name+', '+value.pincode));
                        });

                        $("#refCustomer_company_id_billing").empty();
                        $("#refCustomer_company_id_billing").append(new Option('------ Select Billing Address ------', ''));
                        $.each(result, function (index, value) {
                            $('#refCustomer_company_id_billing').append($('<option />').val(value.customer_company_id).text(value.name +', '+value.office_address +', '+value.city_name +', '+value.state_name+', '+value.country_name+', '+value.pincode));
                        });
                    }
                });
                $('#append_loader').hide();
            });
        });
    </script>
<?php } ?>



<?php if ($data['title'] == 'Edit-Attributes' || $data['title'] == 'Add-Attributes') {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#attribute_group_id').on('change', function () {
                var attribute_group_id = $(this).val();
    //                alert(".yes_"+attribute_group_id);
                if ($('option').hasClass("yes_" + attribute_group_id)) {
                    $(".image_div").removeClass("d-none");
                } else {
                    $(".image_div").removeClass("d-none");
                    $(".image_div").addClass("d-none");
                }
            });
            $('#refCategory_id').on('change', function () {
                var refCategory_id = $(this).val();
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('attribute-groups.attributeGroupByCategory')}}",
                    data: {'refCategory_id': refCategory_id},
                    success: function (res) {
                        var result = $.parseJSON(res);
                        $("#attribute_group_id").empty();
                        $("#attribute_group_id").append(new Option('------ Select Attribute groups ------', ''));
                        $.each(result, function (index, value) {
                            var option_class = 0
                            if (value.image_required === 1) {
                                option_class = "yes_" + value.attribute_group_id;
                            }
                            if (value.image_required === 0) {
                                option_class = "no_" + value.attribute_group_id;
                            }
                            $('#attribute_group_id').append($('<option />').val(value.attribute_group_id).text(value.name).addClass(option_class));
                        });
                    }
                });
            });
        });
    </script>
<?php } ?>


<?php if ($data['title'] == 'Edit-Diamonds' || $data['title'] == 'Add-Diamonds') {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            function getRapaport(diamondType){
                if(diamondType==1 || diamondType==3){
                    var shape = $("#SHAPE_"+diamondType).children("option").filter(":selected").text();
                    var clarity = $("#CLARITY_"+diamondType).children("option").filter(":selected").text();
                    var color = $("#COLOR_"+diamondType).children("option").filter(":selected").text();
                    var expected_polish_cts = $("#expected_polish_cts_input").val();
                    var data = {
                        'shape': shape,
                        'clarity': clarity,
                        'color': color,
                        'expected_polish_cts': expected_polish_cts,
                        'cat_type': diamondType
                    };
                }
                if(diamondType==2){
                    var shape = $("#SHAPE_"+diamondType).children("option").filter(":selected").text();
                    var expected_polish_cts = $("#expected_polish_cts_input").val();
                    var color = $("#COLOR_"+diamondType).children("option").filter(":selected").text();
                    var clarity = $("#CLARITY_"+diamondType).children("option").filter(":selected").text();
                    var data = {
                        'shape': shape,
                        'clarity': clarity,
                        'color': color,
                        'expected_polish_cts': expected_polish_cts,
                        'cat_type': diamondType
                    };
                }
                $('#append_loader_rapa').empty();
                $('#append_loader_rapa').append("<div class='d-flex justify-content-center'><div class='spinner-border text-dark' style='width: 5rem; height: 5rem;' role='status'><span class='sr-only'>Loading...</span></div></div>");
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('rapaport.price') }}",
                    data: data,
                    success: function (res) {
                        if (res.suceess) {
                            $("#rapaport_price_input").val(res.rapa_price);
                            $("#labour_charge_4p").val(res.labour_charge);
                            $("#labour_charge_rough").val(res.labour_charge);
                            $('#append_loader_rapa').empty();
                        } else{
                            $("#rapaport_price_input").val('');
                            $('#append_loader_rapa').empty();
                        }
                    }
                });
            }
            $('#SHAPE_1').on('change', function () {
                calculate_current_price();
            });
            $('#SHAPE_2').on('change', function () {
                calculate_current_price();
            });
            $('#SHAPE_3').on('change', function () {
                calculate_current_price();
            });
            $('#COLOR_1').on('change', function () {
                calculate_current_price();
            });
            $('#COLOR_2').on('change', function () {
                calculate_current_price();
            });
            $('#COLOR_3').on('change', function () {
                calculate_current_price();
            });
            $('#CLARITY_1').on('change', function () {
                calculate_current_price();
            });
            $('#CLARITY_2').on('change', function () {
                calculate_current_price();
            });
            $('#CLARITY_3').on('change', function () {
                calculate_current_price();
            });
            function calculate_current_price() {
                $("#display_current_price").html('');
                var cat_name = $("#refCategory_id").children("option").filter(":selected").text();
                if (cat_name == '4P Diamonds') {
                    getRapaport(1);
                    setTimeout(function(){
                        var cat_name = $("#refCategory_id").children("option").filter(":selected").text();
                        var expected_polish_cts = $("#expected_polish_cts_input").val();
                        var rapaport_price = $("#rapaport_price_input").val();
                        var discount = $("#discount_input").val();
                        var makable_cts = $("#makable_cts_input").val();
                        var labour_charge_4p = $("#labour_charge_4p").val();
                        var labour_charge_rough = $("#labour_charge_rough").val();

                        $("#display_exp_pol_cts").text('');
                        if (expected_polish_cts !== '' && expected_polish_cts !== 0) {
                            $("#display_exp_pol_cts").text(expected_polish_cts);
                        }

                        $("#display_rapa").text('');
                        if (rapaport_price !== '' && rapaport_price !== 0) {
                            nfObject = new Intl.NumberFormat('en-US');
                            $("#display_rapa").text('$'+nfObject.format(rapaport_price));
                        }

                        $("#display_discount").text('0%');
                        if (discount >=1) {
                            $("#display_discount").text(discount+'%');
                        }
                        discount = (100 - discount)/100;

                        $("#display_makable_cts").text('');
                        if (makable_cts !== '' && makable_cts !== 0) {
                            $("#display_makable_cts").text(makable_cts);
                        }

                        $("#display_price").text('');
                        if (rapaport_price !== '' && rapaport_price !== 0 && discount!='') {
                            nfObject = new Intl.NumberFormat('en-US');
                            $("#display_price").text(('$'+nfObject.format(rapaport_price*discount)));
                        }

                        $("#display_current_price").text('');
                        if (expected_polish_cts !== '' && expected_polish_cts !== 0 && rapaport_price !== '' && rapaport_price !== 0) {
                            let c_price = Math.abs(rapaport_price * expected_polish_cts * discount) - (expected_polish_cts*labour_charge_4p);
                             nfObject = new Intl.NumberFormat('en-US');
                            $("#display_current_price").text('$'+nfObject.format(c_price.toFixed(2)));
                        }
                    },1000);

                }
                if (cat_name == 'Rough Diamonds') {
                    getRapaport(2);
                    nfObject = new Intl.NumberFormat('en-US');
                    setTimeout(function(){
                        var expected_polish_cts = $("#expected_polish_cts_input").val();
                        var rapaport_price = $("#rapaport_price_input").val();
                        var discount = $("#discount_input").val();
                        var makable_cts = $("#makable_cts_input").val();
                        var labour_charge_4p = $("#labour_charge_4p").val();
                        var labour_charge_rough = $("#labour_charge_rough").val();

                        $("#display_exp_pol_cts").text('');
                        if (expected_polish_cts !== '' && expected_polish_cts !== 0) {
                            $("#display_exp_pol_cts").text(expected_polish_cts);
                        }

                        $("#display_rapa").text('');
                        if (rapaport_price !== '' && rapaport_price !== 0) {
                            nfObject = new Intl.NumberFormat('en-US');
                            $("#display_rapa").text('$'+nfObject.format(rapaport_price));
                        }

                        $("#display_discount").text('0%');
                        if (discount >=1) {
                            $("#display_discount").text(discount+'%');
                        }
                        discount = (100 - discount) / 100;

                        $("#display_makable_cts").text('');
                        if (makable_cts !== '' && makable_cts !== 0) {
                            $("#display_makable_cts").text(makable_cts);
                        }

                        $("#display_price").text('');
                        $("#display_current_price").text('');


                        var total_labour = Math.abs(labour_charge_rough * makable_cts);
                        $("#display_total_labour").text('$'+nfObject.format(total_labour.toFixed(2)));

                        if (expected_polish_cts !== '' && expected_polish_cts !== 0 && rapaport_price !== '' && rapaport_price !== 0 && makable_cts !== '' && makable_cts !== 0) {
                            var price = Math.abs(rapaport_price * (discount));
                            var amount = Math.abs(price * expected_polish_cts);
                            var ro_amount = Math.abs(amount / makable_cts);
                            var final_price = ro_amount - labour_charge_rough;
                            var total = Math.abs(final_price * makable_cts);

                            $("#display_price").text(('$'+nfObject.format((total/makable_cts).toFixed(2))));
                            $("#display_current_price").text('$'+nfObject.format(total.toFixed(2)));
                        }
                    },1000);
                }
                if (cat_name == 'Polish Diamonds') {
                    getRapaport(3);
                    setTimeout(function(){
                        var expected_polish_cts = $("#expected_polish_cts_input").val();
                        var rapaport_price = $("#rapaport_price_input").val();
                        var discount = $("#discount_input").val();
                        var makable_cts = $("#makable_cts_input").val();
                        var labour_charge_4p = $("#labour_charge_4p").val();
                        var labour_charge_rough = $("#labour_charge_rough").val();

                        $("#display_exp_pol_cts").text('');
                        if (expected_polish_cts !== '' && expected_polish_cts !== 0) {
                            $("#display_exp_pol_cts").text(expected_polish_cts);
                        }

                        $("#display_rapa").text('');
                        if (rapaport_price !== '' && rapaport_price !== 0) {
                            nfObject = new Intl.NumberFormat('en-US');
                            $("#display_rapa").text('$'+nfObject.format(rapaport_price));
                        }

                        $("#display_discount").text('');
                        if (discount >=1) {
                            $("#display_discount").text(discount+'%');
                        }

                        discount = (100 - discount) / 100;

                        $("#display_makable_cts").text('');
                        if (makable_cts !== '' && makable_cts !== 0) {
                            $("#display_makable_cts").text(makable_cts);
                        }

                        $("#display_price").text('');
                        if (rapaport_price !== '' && rapaport_price !== 0 && discount!='') {
                            nfObject = new Intl.NumberFormat('en-US');
                            $("#display_price").text(('$'+nfObject.format(rapaport_price*discount)));
                        }

                        $("#display_current_price").text('');
                        if (expected_polish_cts !== '' && expected_polish_cts !== 0 && rapaport_price !== '' && rapaport_price !== 0) {
                            var total = Math.abs(expected_polish_cts * rapaport_price*discount);
                            nfObject = new Intl.NumberFormat('en-US');
                            $("#display_current_price").text('$'+nfObject.format(total.toFixed(2)));
                        }
                    },1000);
                }
            }
            function show_diamond_form_field(){

                var cat_val = $("#refCategory_id").children("option").filter(":selected").val();
                var cat_name = $("#refCategory_id").children("option").filter(":selected").text();

                var labour_charge_4p = $("#labour_charge_4p").val();
                var labour_charge_rough = $("#labour_charge_rough").val();

                $(".attr_group").addClass("d-none");
                $(".attr_grp_" + cat_val).removeClass("d-none");

                if (cat_name == '4P Diamonds') {
                    $(".makable_cts_div").removeClass("d-none");
                    $(".labour_charges_div").removeClass("d-none");
                    $(".wieght_loss_div").removeClass("d-none");
                    $(".price_div").removeClass("d-none");
                    $("#display_exp_pol_cts_text").html('');
                    $("#display_exp_pol_cts_text").text("Expected Polish CTS");
                    $("#display_makable_cts_text").html('');
                    $("#display_makable_cts_text").text("Makable CTS");

                    $("#makable_cts_label").html('');
                    $("#makable_cts_label").text('Makable cts:');
                    $("#display_labour_charges").html('');
                    $("#display_labour_charges").text('$'+labour_charge_4p);

                    $("#expected_polish_cts_label").html('');
                    $("#expected_polish_cts_label").text('Expected Polish CTS:');

                    $("#barcode").addClass("d-none");
                    $("#packate_no").addClass("d-none");
                    $("#actual_pcs").addClass("d-none");
                    $("#available_pcs").addClass("d-none");
                    $("#makable_cts").addClass("d-none");
                    $("#expected_polish_cts").addClass("d-none");
                    $("#remarks").addClass("d-none");
                    $("#rapaport_price").addClass("d-none");
                    $("#discount").addClass("d-none");
                    $("#weight_loss").addClass("d-none");

                    $("#barcode").removeClass("d-none");
                    $("#packate_no").removeClass("d-none");
                    $("#actual_pcs").removeClass("d-none");
                    $("#available_pcs").removeClass("d-none");
                    $("#makable_cts").removeClass("d-none");
                    $("#expected_polish_cts").removeClass("d-none");
                    $("#remarks").removeClass("d-none");
                    $("#rapaport_price").removeClass("d-none");
                    $("#discount").removeClass("d-none");
                    $("#weight_loss").removeClass("d-none");
                }
                if (cat_name == 'Polish Diamonds') {
                    $("#display_labour_charges").html('');
                    $(".labour_charges_div").addClass("d-none");
                    $(".price_div").removeClass("d-none");
                    $(".makable_cts_div").addClass("d-none");
                    $(".wieght_loss_div").addClass("d-none");

                    $("#display_exp_pol_cts_text").html('');
                    $("#display_exp_pol_cts_text").text("Carat weight");

                    $("#expected_polish_cts_label").html('');
                    $("#expected_polish_cts_label").text('Carat:');

                    $("#barcode").addClass("d-none");
                    $("#packate_no").addClass("d-none");
                    $("#actual_pcs").addClass("d-none");
                    $("#available_pcs").addClass("d-none");
                    $("#makable_cts").addClass("d-none");
                    $("#expected_polish_cts").addClass("d-none");
                    $("#remarks").addClass("d-none");
                    $("#rapaport_price").addClass("d-none");
                    $("#discount").addClass("d-none");
                    $("#weight_loss").addClass("d-none");

                    $("#barcode").removeClass("d-none");
                    $("#rapaport_price").removeClass("d-none");
                    $("#discount").removeClass("d-none");
                    $("#expected_polish_cts").removeClass("d-none");

                }
                if (cat_name == 'Rough Diamonds') {
                    $(".makable_cts_div").removeClass("d-none");
                    $(".labour_charges_div").removeClass("d-none");
                    $(".price_div").removeClass("d-none");
                    $(".wieght_loss_div").addClass("d-none");

                    $("#display_exp_pol_cts_text").html('');
                    $("#display_exp_pol_cts_text").text("Expected Polish CTS");
                    $("#display_makable_cts_text").html('');
                    $("#display_makable_cts_text").text("Original CTS");

                    $("#makable_cts_label").html('');
                    $("#makable_cts_label").text('Org CTS:');
                    $("#display_labour_charges").html('');
                    $("#display_labour_charges").text('$'+labour_charge_rough);

                    $("#expected_polish_cts_label").html('');
                    $("#expected_polish_cts_label").text('Expected Polish CTS:');

                    $("#barcode").addClass("d-none");
                    $("#packate_no").addClass("d-none");
                    $("#actual_pcs").addClass("d-none");
                    $("#available_pcs").addClass("d-none");
                    $("#makable_cts").addClass("d-none");
                    $("#expected_polish_cts").addClass("d-none");
                    $("#remarks").addClass("d-none");
                    $("#rapaport_price").addClass("d-none");
                    $("#discount").addClass("d-none");
                    $("#weight_loss").addClass("d-none");

                    $("#barcode").removeClass("d-none");
                    $("#packate_no").removeClass("d-none");
                    $("#makable_cts").removeClass("d-none");
                    $("#expected_polish_cts").removeClass("d-none");
                    $("#rapaport_price").removeClass("d-none");
                    $("#discount").removeClass("d-none");
                }
            }
            show_diamond_form_field();
            $('#rapaport_price_input').on('keyup', function () {
                calculate_current_price();
            });
            $('#discount_input').on('keyup', function () {
                calculate_current_price();
            });
            $('#makable_cts_input').on('keyup', function () {
                calculate_current_price();
                var makable_cts = $(this).val();
                var expected_polish_cts = $("#expected_polish_cts_input").val();
                if (makable_cts != '' && expected_polish_cts != '') {
                    var weight_loss = 100 - ((expected_polish_cts * 100) / makable_cts);
                    nfObject = new Intl.NumberFormat('en-US');
                    var weight_loss_value=nfObject.format(weight_loss.toFixed(2));
                    $("#weight_loss_input").val(weight_loss_value);
                    $("#display_wieght_loss").text((weight_loss_value)+'%');
                } else {
                    $("#weight_loss_input").val('');
                }
            });
            $('#expected_polish_cts_input').on('keyup', function () {
                calculate_current_price();
                var expected_polish_cts = $("#expected_polish_cts_input").val();
                var makable_cts = $("#makable_cts_input").val();
                if (makable_cts != '' && expected_polish_cts != '') {
                    var weight_loss = 100 - ((expected_polish_cts * 100) / makable_cts);
                    nfObject = new Intl.NumberFormat('en-US');
                    var weight_loss_value=nfObject.format(weight_loss.toFixed(2));
                    $("#weight_loss_input").val(weight_loss_value);
                    $("#display_wieght_loss").text((weight_loss_value)+'%');
                } else {
                    $("#weight_loss_input").val('');
                }
            });
            $('#refCategory_id').on('change', function () {
                var refCategory_id = $(this).val();
                $("#add_diamond_form")[0].reset();
                $("#refCategory_id").val(refCategory_id);
                show_diamond_form_field();
            });
        });
    </script>
<?php } ?>