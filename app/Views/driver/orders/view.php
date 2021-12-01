<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?= lang('Admin.orders') ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('admin/dashboard') ?>"><?= lang('Admin.dashboard') ?></a></li>
                                <li><a href="<?= base_url('admin/orders') ?>"><?= lang('Admin.order_list') ?></a></li>
                                <li class="active"><?= lang('Admin.order_details') ?></li>
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
                                <h4><?= lang('Admin.order_id') ?> # <?= $order_info['id']; ?> </h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">

                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            <tr>
                                                <td><?= lang('Admin.order_date') ?>:</td>
                                                <td class="text-right"><?= dateFormate($order_info['created']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.order_status') ?>:</td>
                                                <td class="text-right"><?= getOrderStatus($order_info['order_status']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.payment_status') ?>:</td>
                                                <td class="text-right"><?= getPaymentStatus($order_info['payment_status']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.payment_type') ?>:</td>
                                                <td class="text-right"><?= getPaymentType($order_info['payment_type']); ?></td>
                                            </tr>
                                            <!--<tr>-->
                                            <!--    <td><?= lang('Admin.tip') ?>:</td>-->
                                            <!--    <td class="text-right"><?= CURRENCY ?><?= $order_info['tip_price']; ?></td>-->
                                            <!--</tr>-->
                                            <tr>
                                                <td><?= lang('Admin.discount') ?>:</td>
                                                <td class="text-right"><?= CURRENCY ?><?= $order_info['discount_price']; ?></td>
                                            </tr>
                                            <!--<tr>-->
                                            <!--    <td><?= lang('Admin.wallet_amount') ?>:</td>-->
                                            <!--    <td class="text-right"><?= CURRENCY ?><?= $order_info['wallet_price']; ?></td>-->
                                            <!--</tr>-->
                                            <tr>
                                                <td><?= lang('Admin.paid_amount') ?>:</td>
                                                <td class="text-right"><?= CURRENCY ?><?= $order_info['total_price']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.admin_charge') ?>:</td>
                                                <td class="text-right"><?= CURRENCY ?><?= $order_info['admin_charge']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.grand_total') ?>:</td>
                                                <td class="text-right"><?= CURRENCY ?><?= $order_info['grand_total']; ?></td>
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
                                <h4><?= lang('Admin.restaurant_information') ?></h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">

                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            <tr>
                                                <td><?= lang('Admin.name') ?>:</td>
                                                <td class="text-right"><a href="<?= $order_info['restaurant_id']; ?>" style="color:#ff2e44"><?= urldecode($order_info['name']); ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.phone_number') ?>:</td>
                                                <td class="text-right"><?= $order_info['r_phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.email_id') ?>:</td>
                                                <td class="text-right"><a href=<?= 'mailto:' . urldecode($order_info['r_email']); ?>><?= urldecode($order_info['r_email']); ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.address') ?>:</td>
                                                <td class="text-right"><?= urldecode($order_info['address']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.opening_time') ?>:</td>
                                                <td class="text-right"><?= dateFormate($order_info['opening_time']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.closing_time') ?>:</td>
                                                <td class="text-right"><?= dateFormate($order_info['closing_time']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.average_price') ?>:</td>
                                                <td class="text-right"><?= CURRENCY . $order_info['average_price']; ?></td>
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
                                <h4><?= lang('Admin.customer_information') ?></h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">

                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            <tr>
                                                <td><?= lang('Admin.name') ?>:</td>
                                                <td class="text-right"><a href="<?= $order_info['user_id']; ?>" style="color:#ff2e44"><?= urldecode($order_info['customer_name']); ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.phone_number') ?>:</td>
                                                <td class="text-right"><?= $order_info['customer_phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.email_id') ?>:</td>
                                                <td class="text-right"><a href=<?= 'mailto:' . urldecode($order_info['customer_email']); ?>><?= urldecode($order_info['customer_email']); ?></a></td>
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
                                <h4><?= lang('Admin.delivery_information') ?></h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">

                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>

                                            <tr>
                                                <td><?= lang('Admin.name') ?>:</td>
                                                <td class="text-right"><?= urldecode($order_info['user_name']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Admin.address') ?>:</td>
                                                <td class="text-right"><?= urldecode($order_info['address_line_1']) . ' ' . urldecode($order_info['address_line_2']) . ', ' . urldecode($order_info['city']); ?></td>
                                            </tr>

                                            <tr>
                                                <td>Phone:</td>
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
                            <h4><?= lang('Admin.order_information') ?></h4>
                            </h4>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">

                                <table class="table table-borderless table-sm table-responsive custom-table">
                                    <tr>
                                        <th><?= lang('Admin.image') ?></th>
                                        <th><?= lang('Admin.item') ?></th>
                                        <th><?= lang('Admin.quantity') ?></th>
                                        <th><?= lang('Admin.item_price') ?></th>
                                        <th><?= lang('Admin.total_price') ?></th>
                                        <th><?= lang('Admin.extra_note') ?></th>
                                    </tr>
                                    <?php
                                    foreach ($get_order_details as $rows) { ?>
                                        <tr>
                                            <td width="100px"><img src="<?= getImagePath($rows['image'], 'subcategory') ?>" width="80px" /></td>
                                            <td><?= urldecode($rows['title']) ?></td>
                                            <td><?= $rows['product_quantity'] ?></td>
                                            <td><?= CURRENCY ?><?= $rows['product_price'] ?></td>
                                            <td><?= CURRENCY ?><?= $rows['product_price'] * $rows['product_quantity'] ?></td>
                                            <td><?= urldecode($rows['extra_note']) ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>


                            </div>



                        </div>

                    </div>
                </div>

            </div><!-- /# row -->
        </div>
    </div><!-- /# main content -->
</div><!-- /# container-fluid -->
</div><!-- /# main -->
</div><!-- /# content wrap -->