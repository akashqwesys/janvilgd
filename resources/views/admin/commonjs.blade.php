<?php if ($data['title'] == 'Edit-Blogs' || $data['title'] == 'Edit-Categories' || $data['title'] == 'Edit-Events' || $data['title'] == 'Edit-Sliders' || $data['title'] == 'Edit-Attributes' || $data['title'] == 'Edit-Diamonds') {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.delete_img_button', function () {
                var self = $(this);
                var id = self.data('id');
                var table = self.attr('data-table');
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
                            $("#img_" + id).remove();
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
                if($('option').hasClass("yes_"+attribute_group_id)){                     
                    $(".image_div").removeClass("d-none");
                }else{
                    $(".image_div").removeClass("d-none");
                    $(".image_div").addClass("d-none");
                }                               
            });
        });
    </script>
<?php } ?>
       
   
<?php if ($data['title'] == 'Edit-Diamonds' || $data['title'] == 'Add-Diamonds') {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {            
             $('#refCategory_id').on('change', function () {                 
                var cat_val = $(this).val();
//                var cat_name = $(this).text(); 
                
               var cat_name= $("#refCategory_id").children("option").filter(":selected").text();
                alert(cat_val);
                $(".attr_group").addClass("d-none");
                $(".attr_grp_"+cat_val).removeClass("d-none"); 
                 
                if(cat_name=='4P Diamonds'){
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
                if(cat_name=='Polish Diamonds'){
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
                                        
//                    $("#barcode").removeClass("d-none");
//                    $("#packate_no").removeClass("d-none");
//                    $("#actual_pcs").removeClass("d-none");
//                    $("#available_pcs").removeClass("d-none");
//                    $("#makable_cts").removeClass("d-none");
//                    $("#expected_polish_cts").removeClass("d-none");
//                    $("#remarks").removeClass("d-none");
                    $("#rapaport_price").removeClass("d-none");
                    $("#discount").removeClass("d-none");
                    $("#weight_loss").removeClass("d-none");
                    $("#video_link").removeClass("d-none");
                    $("#image").removeClass("d-none");
                }
                if(cat_name=='Rough Diamonds'){
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
                                        
//                    $("#barcode").removeClass("d-none");
                    $("#packate_no").removeClass("d-none");
//                    $("#actual_pcs").removeClass("d-none");
//                    $("#available_pcs").removeClass("d-none");
                    $("#makable_cts").removeClass("d-none");
                    $("#expected_polish_cts").removeClass("d-none");
//                    $("#remarks").removeClass("d-none");
                    $("#rapaport_price").removeClass("d-none");
                    $("#discount").removeClass("d-none");
//                    $("#weight_loss").removeClass("d-none");
//                    $("#video_link").removeClass("d-none"); 
//                    $("#image").removeClass("d-none");
                }
            });
        });
    </script>
<?php } ?>

    
    <?php if ($data['title'] == 'Edit-Diamonds') {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {                                         
               var cat_val = $("#refCategory_id").val();                
               var cat_name= $("#refCategory_id").children("option").filter(":selected").text();                
                $(".attr_group").addClass("d-none");
                $(".attr_grp_"+cat_val).removeClass("d-none");                                     
                if(cat_name=='4P Diamonds'){
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
                if(cat_name=='Polish Diamonds'){
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
                                        
//                    $("#barcode").removeClass("d-none");
//                    $("#packate_no").removeClass("d-none");
//                    $("#actual_pcs").removeClass("d-none");
//                    $("#available_pcs").removeClass("d-none");
//                    $("#makable_cts").removeClass("d-none");
//                    $("#expected_polish_cts").removeClass("d-none");
//                    $("#remarks").removeClass("d-none");
                    $("#rapaport_price").removeClass("d-none");
                    $("#discount").removeClass("d-none");
                    $("#weight_loss").removeClass("d-none");
                    $("#video_link").removeClass("d-none");
                    $("#image").removeClass("d-none");
                }
                if(cat_name=='Rough Diamonds'){
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
                                        
//                    $("#barcode").removeClass("d-none");
                    $("#packate_no").removeClass("d-none");
//                    $("#actual_pcs").removeClass("d-none");
//                    $("#available_pcs").removeClass("d-none");
                    $("#makable_cts").removeClass("d-none");
                    $("#expected_polish_cts").removeClass("d-none");
//                    $("#remarks").removeClass("d-none");
                    $("#rapaport_price").removeClass("d-none");
                    $("#discount").removeClass("d-none");
//                    $("#weight_loss").removeClass("d-none");
//                    $("#video_link").removeClass("d-none"); 
//                    $("#image").removeClass("d-none");
                }           
        });
    </script>
<?php } ?>