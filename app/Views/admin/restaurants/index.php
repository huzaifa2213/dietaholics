
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?= lang('Admin.restaurants') ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('admin/dashboard') ?>"><?= lang('Admin.dashboard') ?></a></li>
                                <li><a href="<?= base_url('admin/restaurants') ?>"><?= lang('Admin.restautant_list') ?></a></li>
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
                                <a class="btn btn-success btn-flat m-b-10 m-l-5" style="margin-right:15px!important" href="<?= base_url('admin/restaurants') ?>/add"><?= lang('Admin.add_restaurant') ?></a>
                                <input class="btn btn-danger btn-flat m-b-10 m-l-5" type="submit" onclick="multiple_delete('<?= base_url('admin/restaurants') ?>/multiple_delete')" id="postme" value="Delete" disabled="disabled">


                            </div>


                            <div class="bootstrap-data-table-panel">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>
                                        <tr>
                                            <th><input type='checkbox' name='select_all' id='select_all' value='' /></th>

                                            <th><?= lang('Admin.id') ?></th>
                                            <th><?= lang('Admin.owner') ?></th>
                                            <th><?= lang('Admin.title') ?></th>
                                            <th><?= lang('Admin.email_id') ?></th>
                                            <th><?= lang('Admin.phone_number') ?></th>
                                            <th><?= lang('Admin.address') ?></th>
                                            <th><?= lang('Admin.registration_date') ?></th>
                                            <th width="100px"><?= lang('Admin.action') ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if (!empty($results)) {

                                            $html = '';

                                            foreach ($results as $single) { ?>
                                                <tr id="id_<?= $single['id'] ?>">
                                                    <td><input type='checkbox' name='checked_id' id='checkbox1' class='checkbox' value='<?= $single['id'] ?>' /></td>
                                                    <td><?= $single['id'] ?></td>
                                                    <td><?= urldecode($single['first_name']) . ' ' . urldecode($single['last_name']) ?></td>
                                                    <td><?= urldecode($single['name']) ?></td>
                                                    <td><?= urldecode($single['email']) ?></td>
                                                    <td><?= $single['phone'] ?></td>
                                                    <td><?= urldecode($single['address']) . '<br>' . urldecode($single['city_name']) . ', ' . urldecode($single['state_name']) . '<br>' . urldecode($single['country_name']) . '-' . $single['pincode'] ?> </td>
                                                    <td><?= date('d-m-Y', strtotime($single['created'])) ?></td>
                                                    <td>&nbsp;&nbsp;<a class="fa fa-eye" data-toggle="tooltip" style="color: #00c0ef;" title="<?= lang('Admin.view') ?>!" href="<?= base_url('admin/restaurants') ?>/view/<?= $single['id'] ?>"></a>&nbsp;&nbsp;<a class="ti-pencil-alt" data-toggle="tooltip" style="color: #00c0ef;" title="<?= lang('Admin.edit') ?>!" href="<?= base_url('admin/restaurants') ?>/edit/<?= $single['id'] ?>"></a>&nbsp;&nbsp;
                                                        <a class="fa fa-plus" data-toggle="tooltip" style="color: #00c0ef;" title="<?= lang('Admin.add_subcategory') ?>!" href="<?= base_url('admin/subcategories') ?>/add/<?= $single['id'] ?>"></a>&nbsp;&nbsp;
                                                        <a href="javascript:void(0)" class="ti-trash" style="color:red" data-toggle="tooltip" title="<?= lang('Admin.delete') ?>!" onclick="delete_status('<?= base_url('admin/restaurants') ?>/delete', '<?= $single['id'] ?>')"></a>&nbsp;&nbsp;
                                                        <a href="<?= base_url('admin/restaurants') ?>/invoice/<?= $single['id'] ?>" class="fa fa-file" style="color:green" data-toggle="tooltip" title="<?= lang('Admin.view_invoice') ?>"></a></td>
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

