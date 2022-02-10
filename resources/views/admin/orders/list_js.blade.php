<?php if ($data['title'] == 'List-Orders') {
    ?>

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