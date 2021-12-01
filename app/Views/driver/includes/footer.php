
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
<!-- <script type="text/javascript" src="<?= base_url('backend/js/1.9.jquery.validate.js') ?>"></script> -->
<script src="<?= base_url('backend/ckeditor/ckeditor.js') ?>"></script>
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
    function delete_status(url, id, value = false) {
        customAlertBox("", "<?= lang('Admin.delete_alert') ?>", "error", "true", "btn-danger", "");
        $('.sweet-alert').find('.confirm').click(function(e) {
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    'id': id,
                    'value': value
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if(data && data.success){
                        $('#id_' + id).remove();
                        $.NotificationApp.send("", data.message, "top-right", "rgba(0,0,0,0.2)", "success");
                    }else {
                        $.NotificationApp.send("", data.message, "top-right", "rgba(0,0,0,0.2)", "error");
                    }
                    
                },
                error: function(xhr){
                    $.NotificationApp.send(xhr.status, xhr.responseText, "top-right", "rgba(0,0,0,0.2)", "error");
                }
            });

        })

    }

    function multiple_delete(url) {
        var checkValues = $('input[name=checked_id]:checked').map(function() {
            return $(this).val();
        }).get();

        customAlertBox("", "<?= lang('Admin.multiple_delete_alert') ?>", "error", "true", "btn-danger", "");
        $('.sweet-alert').find('.confirm').click(function(e) {
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    'id': checkValues
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if(data && data.success){
                        $.NotificationApp.send("", data.message, "top-right", "rgba(0,0,0,0.2)", "success");
                        window.location.reload();
                    }else {
                        $.NotificationApp.send("", data.message, "top-right", "rgba(0,0,0,0.2)", "error");
                    }
                },
                error: function(xhr){
                    $.NotificationApp.send(xhr.status, xhr.responseText, "top-right", "rgba(0,0,0,0.2)", "error");
                }
                
            });

        })
    }
</script>

<script type="text/javascript">
    function customAlertBox(title, text, type, showCancelButton, confirmButtonClass, confirmButtonText) {
        if (showCancelButton == "false") {
            showCancelButton = false;
        } else {
            showCancelButton = true;
        }
        swal({
            title: title,
            text: text,
            type: type,
            showCancelButton: showCancelButton,
            confirmButtonClass: confirmButtonClass,
            confirmButtonText: "<?= lang('Admin.ok') ?>",
            cancelButtonText: "<?= lang('Admin.cancel') ?>"
        });

    }


    $(document).on('click', '#select_all', function() {
        if (this.checked) {
            $('.checkbox').each(function() {
                this.checked = true;
                $('#postme').removeAttr('disabled');
            });
        } else {
            $('.checkbox').each(function() {
                this.checked = false;
                $('#postme').attr('disabled', 'disabled');
            });
        }
    });

    $(document).on('click', '.checkbox', function() {
        $('#postme').prop('disabled', !$('.checkbox:checked').length);
        if ($('.checkbox:checked').length == $('.checkbox').length) {
            $('#select_all').prop('checked', true);
        } else {
            $('#select_all').prop('checked', false);
        }
    });

    $('#bootstrap-data-table').DataTable({
        lengthMenu: [
            [10, 20, 50, -1],
            [10, 20, 50, "All"]
        ],
        "language": {
            "lengthMenu": "<?= lang('Admin.display') ?> _MENU_ <?= lang('Admin.records_per_page') ?>",
            "zeroRecords": "<?= lang('Admin.no_data_available') ?>",
            "info": "<?= lang('Admin.showing_page') ?> _PAGE_ <?= lang('Admin.of') ?> _PAGES_",
            "infoEmpty": "<?= lang('Admin.no_records_available') ?>",
            "infoFiltered": "(<?= lang('Admin.filtered_from') ?> _MAX_ <?= lang('Admin.total_entries') ?>)",
            "paginate": {
                "previous": "<?= lang('Admin.previous') ?>",
                "next": "<?= lang('Admin.next') ?>"
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
            "lengthMenu": "<?= lang('Admin.display') ?> _MENU_ <?= lang('Admin.records_per_page') ?>",
            "zeroRecords": "<?= lang('Admin.no_data_available') ?>",
            "info": "<?= lang('Admin.showing_page') ?> _PAGE_ <?= lang('Admin.of') ?> _PAGES_",
            "infoEmpty": "<?= lang('Admin.no_records_available') ?>",
            "infoFiltered": "(<?= lang('Admin.filtered_from') ?> _MAX_ <?= lang('Admin.total_entries') ?>)",
            "paginate": {
                "previous": "<?= lang('Admin.previous') ?>",
                "next": "<?= lang('Admin.next') ?>"
            }
        }
    });

    if ($('[id^=page_description]').length > 0) {
        $(function() {
            CKEDITOR.replace('page_description');
            CKEDITOR.config.height = 400;

        });
    }
</script>