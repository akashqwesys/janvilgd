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

            function calculate_current_price() {
                $("#display_current_price").html('');
                var cat_name = $("#refCategory_id").children("option").filter(":selected").text();
                if (cat_name == '4P Diamonds') {
                    var expected_polish_cts = $("#expected_polish_cts_input").val();
                    var rapaport_price = $("#rapaport_price_input").val();
                    var discount = $("#discount_input").val();
                    var makable_cts = $("#makable_cts_input").val();
                    var labour_charge_4p = $("#labour_charge_4p").val();
                    var labour_charge_rough = $("#labour_charge_rough").val();
                    if (expected_polish_cts !== '' && expected_polish_cts !== 0) {
                        $("#display_exp_pol_cts").text(expected_polish_cts);
                    }
                    if (rapaport_price !== '' && rapaport_price !== 0) {
                        $("#display_rapa").text(rapaport_price);
                    }
                    if (discount === '') {
                        discont = 0;
                    }
                    $("#display_discount").text(discount);
                    discount = (100 - discount) / 100;

                    if (makable_cts !== '' && makable_cts !== 0) {
                        $("#display_makable_cts").text(makable_cts);
                    }
                    if (expected_polish_cts !== '' && expected_polish_cts !== 0 && rapaport_price !== '' && rapaport_price !== 0) {
                        let c_price = Math.abs(rapaport_price * expected_polish_cts * discount) - labour_charge_4p;
                        $("#display_current_price").text(c_price);
                    }
                }
                if (cat_name == 'Rough Diamonds') {
                    var expected_polish_cts = $("#expected_polish_cts_input").val();
                    var rapaport_price = $("#rapaport_price_input").val();
                    var discount = $("#discount_input").val();
                    var makable_cts = $("#makable_cts_input").val();
                    var labour_charge_4p = $("#labour_charge_4p").val();
                    var labour_charge_rough = $("#labour_charge_rough").val();
                    if (expected_polish_cts !== '' && expected_polish_cts !== 0) {
                        $("#display_exp_pol_cts").text(expected_polish_cts);
                    }
                    if (rapaport_price !== '' && rapaport_price !== 0) {
                        $("#display_rapa").text(rapaport_price);
                    }
                    if (discount === '') {
                        discont = 0;
                    }
                    $("#display_discount").text(discount);
                    discount = (100 - discount) / 100;
                    if (makable_cts !== '' && makable_cts !== 0) {
                        $("#display_makable_cts").text(makable_cts);
                    }
                    if (expected_polish_cts !== '' && expected_polish_cts !== 0 && rapaport_price !== '' && rapaport_price !== 0 && makable_cts !== '' && makable_cts !== 0) {
                        var price = Math.abs(rapaport_price * (discount));
                        var amount = Math.abs(price * expected_polish_cts);
                        var ro_amount = Math.abs(amount / makable_cts);
                        var final_price = ro_amount - labour_charge_rough;
                        var total = Math.abs(final_price * makable_cts);
                        $("#display_current_price").text(total.toFixed(2));
                    }
                }
                if (cat_name == 'Polish Diamonds') {
                    var expected_polish_cts = $("#expected_polish_cts_input").val();
                    var rapaport_price = $("#rapaport_price_input").val();
                    var discount = $("#discount_input").val();
                    var makable_cts = $("#makable_cts_input").val();
                    var labour_charge_4p = $("#labour_charge_4p").val();
                    var labour_charge_rough = $("#labour_charge_rough").val();
                    if (expected_polish_cts !== '' && expected_polish_cts !== 0) {
                        $("#display_exp_pol_cts").text(expected_polish_cts);
                    }
                    if (rapaport_price !== '' && rapaport_price !== 0) {
                        $("#display_rapa").text(rapaport_price);
                    }
                    if (discount === '') {
                        discont = 0;
                    }
                    $("#display_discount").text(discount);
                    discount = (100 - discount) / 100;
                    if (makable_cts !== '' && makable_cts !== 0) {
                        $("#display_makable_cts").text(makable_cts);
                    }
                    if (expected_polish_cts !== '' && expected_polish_cts !== 0 && rapaport_price !== '' && rapaport_price !== 0) {                       
                        var total = Math.abs(expected_polish_cts * rapaport_price*discount);
                        $("#display_current_price").text(total.toFixed(2));
                    }
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
                    $("#makable_cts_label").html('');
                    $("#makable_cts_label").text('Makable cts:');
                    $("#display_labour_charges").html('');
                    $("#display_labour_charges").text(labour_charge_4p);

                    $("#expected_polish_cts_label").html('');
                    $("#expected_polish_cts_label").text('Expected polish cts:');

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
                    $("#video_link").addClass("d-none");
                    $("#image").addClass("d-none");

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
                    $("#video_link").removeClass("d-none");
                    $("#image").removeClass("d-none");
                }
                if (cat_name == 'Polish Diamonds') {
                    
                    $("#expected_polish_cts_label").html('');
                    $("#expected_polish_cts_label").text('Weight:');
                    
                    $("#display_labour_charges").html('');                    

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
                    $("#video_link").addClass("d-none");
                    $("#image").addClass("d-none");

                    $("#barcode").removeClass("d-none");
                    $("#rapaport_price").removeClass("d-none");
                    $("#discount").removeClass("d-none");
                    $("#expected_polish_cts").removeClass("d-none");
                    $("#video_link").removeClass("d-none");
                    $("#image").removeClass("d-none");
                }
                if (cat_name == 'Rough Diamonds') {
                    $("#makable_cts_label").html('');
                    $("#makable_cts_label").text('Org cts:');                    
                    $("#display_labour_charges").html('');
                    $("#display_labour_charges").text(labour_charge_rough);

                    $("#expected_polish_cts_label").html('');
                    $("#expected_polish_cts_label").text('Expected polish cts:');

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
                    $("#video_link").addClass("d-none");
                    $("#image").addClass("d-none");

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
                    $("#weight_loss_input").val(weight_loss);
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
                    $("#weight_loss_input").val(weight_loss);
                } else {
                    $("#weight_loss_input").val('');
                }
            });
            $('#refCategory_id').on('change', function () {
                show_diamond_form_field();
            });
        });
    </script>
<?php } ?>   