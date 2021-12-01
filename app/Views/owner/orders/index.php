<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?= lang('Owner.orders') ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('owner/dashboard') ?>"><?= lang('Owner.dashboard') ?></a></li>
                                <li><a href="<?= base_url('owner/orders') ?>"><?= lang('Owner.order_list') ?></a></li>
                                <!--	<li class="active">Data Table</li>-->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card alert">



                            <div class="bootstrap-data-table-panel">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>
                                        <tr>
                                            <th><?= lang('Owner.order_id') ?></th>
                                            <th><?= lang('Owner.user') ?></th>
                                            <th><?= lang('Owner.order_status') ?></th>
                                           
                                            <th><?= lang('Owner.total_amount') ?></th>
                                            <th><?= lang('Owner.discount') ?></th>
                                            <th><?= lang('Owner.order_date') ?></th>
                                            <th><?= lang('Owner.drivers') ?></th>
                                            <th><?= lang('Owner.driver_status') ?></th>
                                            <th><?= lang('Owner.action') ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if (!empty($results)) {
                                            foreach ($results as $single) { ?>
                                                <tr id="id_<?= $single['id'] ?>">
                                                    
                                                    <td>#<?= $single['id'] ?></td>
                                                    <td><?= urldecode($single['name']) ?></td>
                                                    <td><?= getOrderStatus($single['order_status']) ?></td>
                                                   
                                                    <td><?= CURRENCY . $single['grand_total'] ?></td>
                                                    <td><?= CURRENCY . $single['discount_price'] ?></td>
                                                    <td><?= date('d-m-Y h:i a', strtotime($single['created'])) ?></td>
                                                    <?php
                                                    $driver_name = "-";
                                                    $driver_status = "-";
                                                    if ($single['order_status'] == 1) { ?>
                                                        <td><label class="label label-warning"><?= lang('Owner.waiting_for_restaurant_approval') ?></label></td>
                                                    <?php } else if ($single['order_status'] == 3) {   ?>
                                                        <td><label class="label label-danger"><?= lang('Owner.declined_by_restaurant') ?></label></td>
                                                        <?php } else if ($single['order_status'] == 5) {
                                                       $getAssignedDriver = $controller->getAssignedDriver($single['id'], $single['order_status']);
                                                        if (!empty($getAssignedDriver)) {
                                                            $driver_status = getDriverOrderStatus($getAssignedDriver->driver_status);
                                                        ?>
                                                            <td><label class="label label-success"><?= urldecode($getAssignedDriver['fullname']) ?></label></td>
                                                        <?php  } else { ?>
                                                            <td>-</td>
                                                            <?php  }
                                                    } else {
                                                        $getAssignedDriver = $controller->getAssignedDriver($single['id'], $single['order_status']);
                                                        if (!empty($getAssignedDriver)) {
                                                            $driver_status = getDriverOrderStatus($getAssignedDriver->driver_status);
                                                            if ($getAssignedDriver->driver_status != 2) { ?>
                                                                <td><?= urldecode($getAssignedDriver->fullname) ?></td>
                                                            <?php  } else {
                                                               $get_nearby_drivers =$controller->getNearByDriver($single['latitude'], $single['longitude']); ?>
                                                                <td>
                                                                    <select data-id="<?= $single['id'] ?>" name="driver_id" class="change_state">
                                                                        <option value=""><?= lang('Owner.select_driver') ?></option>
                                                                        <?php foreach ($get_nearby_drivers as $drivers) { ?>
                                                                            <option value="<?= $drivers->id ?>"><?= urldecode($drivers->fullname) ?></option>
                                                                        <?php  } ?>
                                                                    </select>
                                                                </td>

                                                            <?php }
                                                        } else {

                                                            $get_nearby_drivers = $controller->getNearByDriver($single['latitude'], $single['longitude']);  ?>
                                                            <td>
                                                                <select data-id="<?= $single['id'] ?>" name="driver_id" class="change_state">
                                                                    <option value=""><?= lang('Owner.select_driver') ?></option>
                                                                    <?php foreach ($get_nearby_drivers as $drivers) { ?>
                                                                        <option value="<?= $drivers->id ?>"><?= urldecode($drivers->fullname) ?></option>
                                                                    <?php  } ?>
                                                                </select>
                                                            </td>
                                                    <?php }
                                                    } ?>
                                                    <td><?= $driver_status ?></td>
                                                    <td>&nbsp;&nbsp;<a class="ti-eye" data-toggle="tooltip" style="color: #00c0ef;" title="View!" href="<?= base_url('owner/orders') ?>/view/<?= $single['id'] ?>"></a></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /# card -->
                    </div><!-- /# column -->
                </div><!-- /# row -->
            </div><!-- /# main content -->
        </div><!-- /# container-fluid -->
    </div><!-- /# main -->
</div><!-- /# content wrap -->
<script type="text/javascript">
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
