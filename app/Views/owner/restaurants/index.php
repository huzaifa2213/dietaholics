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

                                            <th><?= lang('Owner.id') ?></th>
                                            <th><?= lang('Owner.owner') ?></th>
                                            <th><?= lang('Owner.title') ?></th>
                                            <th><?= lang('Owner.email_id') ?></th>
                                            <th><?= lang('Owner.phone_number') ?></th>
                                            <th><?= lang('Owner.address') ?></th>
                                            <th><?= lang('Owner.registration_date') ?></th>
                                            <th><?= lang('Owner.availability') ?></th>
                                            <th width="100px"><?= lang('Owner.action') ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if (!empty($results)) {

                                            foreach ($results as $single) { ?>
                                                <tr id="id_<?= $single['id'] ?>">

                                                    <td><?= $single['id'] ?></td>
                                                    <td><?= urldecode($single['first_name'] . ' ' . $single['last_name']) ?></td>
                                                    <td><?= urldecode($single['name']) ?></td>
                                                    <td><?= urldecode($single['email']) ?></td>
                                                    <td><?= $single['phone'] ?></td>
                                                    <td><?= urldecode($single['address']) . '<br>' . urldecode($single['city_name']) . ', ' . urldecode($single['state_name']) . '<br>' . urldecode($single['country_name']) . '-' . $single['pincode'] ?> </td>
                                                    <td><?= dateFormate($single['created']) ?></td>
                                                    <td>
                                                        <div><label class="switch"><input type="checkbox" class="status_change ct_switch restaurant_status_change" data-id="<?= $single['id'] ?>" data-url="<?= base_url('owner/restaurants/change_availablity') ?>" value="<?= $single['is_available'] ?>" <?= $single['is_available'] == 1 ? "checked" : "" ?>><span class="slider round"></span></label></div>
                                                    </td>
                                                    <td>&nbsp;&nbsp;<a class="fa fa-eye" data-toggle="tooltip" style="color: #00c0ef;" title="View Details!" href="<?= base_url('owner/restaurants/view/' . $single['id']) ?>"></a>&nbsp;&nbsp;
                                                        <a href="<?= base_url('owner/restaurants/invoice/' . $single['id']) ?>" class="fa fa-file" style="color:green" data-toggle="tooltip" title="View Invoice"></a>
                                                    </td>
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

<!-- $('[id^=bootstrap-data-table]').DataTable({
        lengthMenu: [
            [10, 20, 50, -1],
            [10, 20, 50, "All"]
        ],
    }); -->