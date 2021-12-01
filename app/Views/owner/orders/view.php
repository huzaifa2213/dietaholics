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
                                <li class="active"><?= lang('Owner.order_details') ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card alert">
                            <div class="card-header">
                                <h4>Order # <?= $order_info['id']; ?> </h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">

                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            <tr>
                                                <td><?= lang('Owner.order_date') ?>:</td>
                                                <td class="text-right"><?= dateFormate($order_info['created']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.order_status') ?>:</td>
                                                <td class="text-right"><?= getOrderStatus($order_info['order_status']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.payment_status') ?>:</td>
                                                <td class="text-right"><?= getPaymentStatus($order_info['payment_status']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.payment_type') ?>:</td>
                                                <td class="text-right"><?= getPaymentType($order_info['payment_type']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.tip') ?>:</td>
                                                <td class="text-right"><?= CURRENCY . $order_info['tip_price']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.discount') ?>:</td>
                                                <td class="text-right"><?= CURRENCY . $order_info['discount_price']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.wallet_amount') ?>:</td>
                                                <td class="text-right"><?= CURRENCY . $order_info['wallet_price']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.paid_amount') ?>:</td>
                                                <td class="text-right"><?= CURRENCY . $order_info['total_price']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.admin_charge') ?>:</td>
                                                <td class="text-right"><?= CURRENCY . $order_info['admin_charge']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.grand_total') ?>:</td>
                                                <td class="text-right"><?= CURRENCY . $order_info['grand_total']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card alert">
                            <div class="card-header">
                                <h4><?= lang('Owner.customer_and_address_information') ?></h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">

                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            <tr>
                                                <td><?= lang('Owner.name') ?>:</td>
                                                <td class="text-right"><a href="<?= $order_info['user_id']; ?>" style="color:#ff2e44"><?= urldecode($order_info['customer_name']); ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.phone_number') ?>:</td>
                                                <td class="text-right"><?= $order_info['customer_phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.email_id') ?>:</td>
                                                <td class="text-right"><a href=<?= 'mailto:' . urldecode($order_info['customer_email']); ?>><?= urldecode($order_info['customer_email']); ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.name_on_address') ?>:</td>
                                                <td class="text-right"><?= urldecode($order_info['user_name']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.address') ?>:</td>
                                                <td class="text-right"><?= urldecode($order_info['address_line_1']) . ' ' . urldecode($order_info['address_line_2']) . ', ' . urldecode($order_info['city']); ?></td>
                                            </tr>

                                            <tr>
                                                <td><?= lang('Owner.contact_no') ?>:</td>
                                                <td class="text-right"><?= $order_info['phone']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card alert">
                        <div class="card-header">
                            <h4><?= lang('Owner.order_information') ?></h4>
                            </h4>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">

                                <table class="table table-borderless table-sm table-responsive custom-table">
                                    <tr>
                                        <th><?= lang('Owner.image') ?></th>
                                        <th><?= lang('Owner.item') ?></th>
                                        <th><?= lang('Owner.quantity') ?></th>
                                        <th><?= lang('Owner.item_price') ?></th>
                                        <th><?= lang('Owner.total_price') ?></th>
                                        <th><?= lang('Owner.extra_note') ?></th>
                                    </tr>
                                    <?php
                                    foreach ($get_order_details as $rows) { ?>
                                        <tr>
                                            <td width="100px"><img src="<?= getImagePath($rows['image'], 'subcategory') ?>" width="80px" /></td>
                                            <td><?= urldecode($rows['title']) ?></td>
                                            <td><?= $rows['product_quantity'] ?></td>
                                            <td><?= CURRENCY . $rows['product_price'] ?></td>
                                            <td><?= CURRENCY . $rows['product_price'] * $rows['product_quantity'] ?></td>
                                            <td><?= urldecode($rows['extra_note']) ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>


                            </div>



                        </div>

                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card alert">
                        <div class="card-header">
                            <h4><?= lang('Owner.change_order_status') ?></h4>
                        </div>
                        <div class="row">




                            <div class="card-body">
                                <div class="menu-upload-form">

                                    <form class="form-horizontal" action="<?= base_url('owner/orders/change_order_status'); ?>" method="post" accept-charset="utf-8" id="MenuForm">
                                        <div class="form-group">

                                            <div class="col-sm-6">
                                                <select class="form-control required" name="order_status" id="order_status">
                                                    <?= $order_info['order_status'] ?>
                                                    <option <?= $order_info['order_status'] == 1 ? "Selected" : "" ?> value="1"><?= lang('Owner.pending') ?></option>
                                                    <option <?= $order_info['order_status'] == 2 ? "Selected" : "" ?> value="2"><?= lang('Owner.accepted') ?></option>
                                                    <option <?= $order_info['order_status'] == 3 ? "Selected" : "" ?> value="3"><?= lang('Owner.declined') ?></option>
                                                    <option <?= $order_info['order_status'] == 4 ? "Selected" : "" ?> value="4"><?= lang('Owner.inprocess') ?></option>
                                                    <!-- <option <?= $order_info['order_status'] == 5 ? "Selected" : "" ?> value="5">Delivered</option> -->

                                                </select>
                                            </div>
                                            <input type="hidden" name="orderid" value="<?= $order_info['id']; ?>">
                                            <input type="hidden" name="user_id" value="<?= $order_info['user_id']; ?>">

                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-lg btn-primary"><?= lang('Owner.change_status') ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- /# row -->
                </div>
            </div><!-- /# main content -->
        </div><!-- /# container-fluid -->
    </div><!-- /# main -->
</div><!-- /# content wrap -->