<?php if ($data['title'] == 'Edit-Blogs' || $data['title'] == 'Edit-Categories' || $data['title'] == 'Edit-Events') {
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