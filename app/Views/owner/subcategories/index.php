<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?= lang('Owner.Products_list') ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('owner/dashboard') ?>"><?= lang('Owner.dashboard') ?></a></li>
                                <li><a href="<?= base_url('owner/subcategory') ?>"><?= lang('Owner.Products_list') ?></a></li>
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
                                <div class="pull-right">
                                <a class="btn btn-success btn-flat m-b-10 m-l-5" style="margin-right:15px!important" href="<?=base_url('admin/subcategories')?>/add"><?=lang('Admin.add_Product')?></a>
                                <input class="btn btn-danger  btn-flat m-b-10 m-l-5" style="margin-left:-14px!important" type="submit" onclick="multiple_delete('<?=base_url('admin/subcategories')?>/multiple_delete')" id="postme" value="<?=lang('Admin.delete')?>" disabled="disabled">


                            </div>


                            <div class="bootstrap-data-table-panel">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>
                                        <tr>

                                            <th><?= lang('Owner.image') ?></th>
                                            <th><?= lang('Owner.category') ?></th>
                                            <th><?= lang('Owner.restaurant') ?></th>
                                            <th><?= lang('Owner.Product_Name') ?></th>
                                            <th><?= lang('Owner.type') ?></th>
                                            <th><?= lang('Owner.discount') ?></th>
                                            <th width="200px"><?= lang('Owner.description') ?></th>
                                            <th><?= lang('Owner.status') ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if (!empty($results)) {
                                            foreach ($results as $single) { ?>
                                                <tr id="id_<?= $single['id'] ?>">

                                                    <td><img src="<?= getImagePath($single['image'], 'subcategory') ?>" width="80px" /></td>
                                                    <td><?= urldecode($single['cat_title']) ?></td>
                                                    <td><?= urldecode($single['restaurant_name']) ?></td>
                                                    <td><?= urldecode($single['title']) ?></td>
                                                    <td><?= $single['type'] == 1 ? lang('Owner.veg') : lang('Owner.non_veg') ?></td>
                                                    <td><?= discountType($single['discount'], $single['discount_type']) ?></td>
                                                    <td><?= urldecode($single['description']) ?></td>
                                                    <td>
                                                        <div><label class="switch"><input type="checkbox" class="subcategory_status_change ct_switch" data-id="<?= $single['id'] ?>" data-url="<?= base_url('owner/subcategories/change_visibility') ?>" value="<?= $single['status'] ?>" <?= $single['status'] == 1 ? "checked" : "" ?>><span class="slider round"></span></label></div>
                                                    </td>
                                                </tr>
                                        <?php

                                            }
                                        }
                                        ?>

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
