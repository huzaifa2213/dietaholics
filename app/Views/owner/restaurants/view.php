<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?= lang('Owner.restaurants') ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('owner/dashboard') ?>"><?= lang('Owner.dashboard') ?></a></li>
                                <li><a href="<?= base_url('owner/restaurants') ?>"><?= lang('Owner.restaurant_list') ?></a></li>
                                <li class="active"><?= lang('Owner.restaurant_details') ?></li>
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
                                <h4><?= urldecode($restaurant_info['name']); ?> </h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">

                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>

                                            <tr>
                                                <td><?= lang('Owner.opening_time') ?>:</td>
                                                <td class="text-right"><?= timeFormat($restaurant_info['opening_time']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.closing_time') ?>:</td>
                                                <td class="text-right"><?= timeFormat($restaurant_info['closing_time']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.availability') ?></td>
                                                <td class="text-right"><?= $restaurant_info['is_available'] == 1 ? "<lable class='label label-success'>Available</label>" : "<lable class='label label-danger'>Unavailable</label>"; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.discount') ?>:</td>
                                                <td class="text-right"><?= discountType($restaurant_info['discount'], $restaurant_info['discount_type']) ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.average_price') ?>:</td>
                                                <td class="text-right"><?= CURRENCY . $restaurant_info['average_price']; ?></td>
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
                                <h4><?= lang('Owner.contact_and_address_inforamtion') ?></h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">

                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            <tr>
                                                <td><?= lang('Owner.phone_number') ?>:</td>
                                                <td class="text-right"><?= $restaurant_info['phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.email_id') ?>:</td>
                                                <td class="text-right"><?= urldecode($restaurant_info['email']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('Owner.address') ?>:</td>
                                                <td class="text-right"><?php echo urldecode($restaurant_info['address']) . ', ' . urldecode($restaurant_info['city_name']) . ', ' . urldecode($restaurant_info['state_name']) . ', ' . urldecode($restaurant_info['country_name']) . '-' . $restaurant_info['pincode'] ?></td>
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
                            <h4><?= lang('Owner.food_information') ?></h4>
                            </h4>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <?php foreach ($categories as $cats) { ?>
                                    <div class="card-header">
                                        <h2 style="color:#0a9822">
                                            <center><?= urldecode($cats['title']) ?></center>
                                        </h2>
                                    </div>
                                    <table id="bootstrap-data-table<?= $cats['id'] ?>" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?= lang('Owner.image') ?></th>
                                                <th width="200px"><?= lang('Owner.name') ?></th>
                                                <th width="400px"><?= lang('Owner.description') ?></th>
                                                <th><?= lang('Owner.price') ?></th>
                                                <th><?= lang('Owner.discount') ?></th>
                                                <th><?= lang('Owner.type') ?></th>
                                                <th><?= lang('Owner.status') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // $where = array('status!=' => 9, "category_id" => $cats['id'], "restaurant_id" => $restaurant_info->id);
                                            // $columns = "*";
                                            // $join = array();
                                            // $group_by = '';
                                            $subcategory = $controller->getProducts($restaurant_info['id'], $cats['id']);   //$this->Sitefunction->get_all_rows(TBL_SUBCATEGORIES, $columns, $where, $join, array(), '', '', array(), $group_by, array(), array());
                                            foreach ($subcategory as $rows) { ?>
                                                <tr>
                                                    <td width="100px"><img src="<?= getImagePath($rows['image'], 'subcategory') ?>" width="80px" /></td>
                                                    <td><?= urldecode($rows['title']) ?></td>
                                                    <td><?= urldecode($rows['description']) ?></td>
                                                    <td><?= CURRENCY . $rows['price'] ?></td>
                                                    <td><?= discountType($rows['discount'], $rows['discount_type']) ?></td>
                                                    <td><?= ($rows['type'] == 1 ? "Veg" : "Non-veg"); ?></td>
                                                    <td>
                                                        <div><label class="switch"><input type="checkbox" class="subcategory_status_change ct_switch"  data-url="<?= base_url('owner/subcategories/change_visibility') ?>" data-id="<?= $rows['id'] ?>" value="<?= $rows['status'] ?>" <?= $rows['status'] == 1 ? "checked" : "" ?>><span class="slider round"></span></label></div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php   } ?>
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

