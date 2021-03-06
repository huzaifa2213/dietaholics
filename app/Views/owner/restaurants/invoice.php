<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?= lang('Owner.invoice_details') ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('owner/dashboard') ?>"><?= lang('Owner.dashboard') ?></a></li>
                                <li><a href="<?= base_url('owner/restaurants') ?>"><?= lang('Owner.restaurant_list') ?></a></li>
                                <li class="active"><?= lang('Owner.invoice_details') ?></li>
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
                                            <th><input type='checkbox' name='select_all' id='select_all' value='' /></th>

                                            <th><?= lang('Owner.order_id') ?></th>
                                            <th><?= lang('Owner.payable_amount') ?></th>
                                            <th><?= lang('Owner.total_amount') ?></th>
                                            <th><?= lang('Owner.payment_status') ?></th>
                                            <th><?= lang('Owner.payment_date') ?></th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if (!empty($invoice_info)) {


                                            foreach ($invoice_info as $single) { ?>
                                                <tr id="id_<?= $single['id'] ?>">
                                                    <td><input type='checkbox' name='checked_id' id='checkbox1' class='checkbox' value='<?= $single['id'] ?>' /></td>
                                                    <td>#<?= $single['id'] ?></td>
                                                    <td><?= CURRENCY . $single['owners_amount'] ?></td>
                                                    <td><?= CURRENCY . $single['grand_total'] ?></td>
                                                    <td><?php if ($single['payment_status'] == 0) {
                                                            echo "<label class='label label-warning' >Pending</label>";
                                                        } else if ($single['payment_status'] == 1) {
                                                            echo "<label class='label label-success'>Paid</label>";
                                                        } else {
                                                            echo "-";
                                                        } ?></td>
                                                    <td><?= $single['payment_date'] ? dateFormate($single['payment_date']) : "" ?></td>
                                                </tr>
                                        <?php

                                            }
                                        }
                                        ?>




                                    </tbody>
                                </table>

                            </div>


                        </div>
                    </div>
                </div><!-- /# row -->
            </div><!-- /# main content -->
        </div><!-- /# container-fluid -->
    </div><!-- /# main -->
</div><!-- /# content wrap -->