<script src="<?= base_url('backend/js/app.js') ?>"></script>
<script src="<?= base_url('backend/js/lib/jquery.nanoscroller.min.js') ?>"></script><!-- nano scroller -->
<script src="<?= base_url('backend/js/lib/sidebar.js') ?>"></script><!-- sidebar -->

<!-- <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
<script src="<?= base_url('backend/js/lib/mmc-common.js') ?>"></script>


<script src="<?= base_url('backend/js/lib/owl-carousel/owl.carousel.min.js') ?>"></script>
<script src="<?= base_url('backend/js/scripts.js') ?>"></script><!-- scripit init-->
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('backend/js/lib/data-table/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('backend/js/lib/data-table/buttons.flash.min.js') ?>"></script>
<script src="<?= base_url('backend/js/lib/data-table/jszip.min.js') ?>"></script>
<script src="<?= base_url('backend/js/lib/data-table/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('backend/js/lib/data-table/vfs_fonts.js') ?>"></script>
<script src="<?= base_url('backend/js/lib/data-table/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('backend/js/lib/data-table/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('backend/js/lib/data-table/datatables-init.js') ?>"></script>
<script src="<?= base_url('backend/js/lib/sweetalert/sweetalert.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('backend/js/1.9.jquery.validate.js') ?>"></script>
<?php

if (isset($error) || $session->getFlashdata('error')) : ?>
    <script type="text/javascript">
        $.NotificationApp.send("", "<?= isset($error) ? $error : $session->getFlashdata('error') ?>", "top-right", "rgba(0,0,0,0.2)", "error");
    </script>
<?php endif; ?>

<?php

if (isset($success) || $session->getFlashdata('success')) : ?>
    <script type="text/javascript">
        $.NotificationApp.send("", "<?= isset($success) ? $success : $session->getFlashdata('success') ?>", "top-right", "rgba(0,0,0,0.2)", "success");
    </script>
<?php endif; ?>
<script type="text/javascript">
    function customAlertBox(title, text, type, showCancelButton, confirmButtonClass, confirmButtonText) {
        if (showCancelButton == "false") {
            showCancelButton = false;
        } else {
            showCancelButton = true;
        }
        //alert(showCancelButton)
        swal({
            title: title,
            text: text,
            type: type,
            showCancelButton: showCancelButton,
            confirmButtonClass: confirmButtonClass,
            confirmButtonText: "<?= lang('Owner.ok') ?>",
            cancelButtonText: "<?= lang('Owner.cancel') ?>"
        });

    }

    
    $('#bootstrap-data-table').DataTable({
        lengthMenu: [
            [10, 20, 50, -1],
            [10, 20, 50, "All"]
        ],
        "language": {
            "lengthMenu": "<?= lang('Owner.display') ?> _MENU_ <?= lang('Owner.records_per_page') ?>",
            "zeroRecords": "<?= lang('Owner.no_data_available') ?>",
            "info": "<?= lang('Owner.showing_page') ?> _PAGE_ <?= lang('Owner.of') ?> _PAGES_",
            "infoEmpty": "<?= lang('Owner.no_records_available') ?>",
            "infoFiltered": "(<?= lang('Owner.filtered_from') ?> _MAX_ <?= lang('Owner.total_entries') ?>)",
            "paginate": {
                "previous": "<?= lang('Owner.previous') ?>",
                "next": "<?= lang('Owner.next') ?>"
            }
        }
    });



    $('#bootstrap-data-table-export').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        buttons: [
            'excel', 'pdf', 'print'
        ],
        "language": {
            "lengthMenu": "<?= lang('Owner.display') ?> _MENU_ <?= lang('Owner.records_per_page') ?>",
            "zeroRecords": "<?= lang('Owner.no_data_available') ?>",
            "info": "<?= lang('Owner.showing_page') ?> _PAGE_ <?= lang('Owner.of') ?> _PAGES_",
            "infoEmpty": "<?= lang('Owner.no_records_available') ?>",
            "infoFiltered": "(<?= lang('Owner.filtered_from') ?> _MAX_ <?= lang('Owner.total_entries') ?>)",
            "paginate": {
                "previous": "<?= lang('Owner.previous') ?>",
                "next": "<?= lang('Owner.next') ?>"
            }
        }
    });
$(document).on('change', '.change_state', function() {
        var order_id = $(this).attr('data-id');
        var driver_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?= base_url('owner/orders/assign_driver') ?>",
            data: {
                'order_id': order_id,
                'driver_id': driver_id
            },
            success: function(data) {
                window.location.reload();
            }
        });

    });

</script>