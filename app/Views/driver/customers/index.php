<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?= lang('Admin.customers') ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('admin/dashboard') ?>"><?= lang('Admin.dashboard') ?></a></li>
                                <li><a href="<?= base_url('admin/customers') ?>"><?= lang('Admin.customer_list') ?></a></li>
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

                                <input class="btn btn-danger btn-flat m-b-10 m-l-5" type="submit" onclick="multiple_delete('<?= base_url('admin/customers/multiple_delete') ?>')" id="postme" value="<?= lang('Admin.delete') ?>" disabled="disabled">
                            </div>
                            <div class="bootstrap-data-table-panel">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type='checkbox' name='select_all' id='select_all' value='' /></th>

                                            <th><?= lang('Admin.id') ?></th>
                                            <th><?= lang('Admin.full_name') ?></th>
                                            <th><?= lang('Admin.email_id') ?></th>
                                            <th><?= lang('Admin.phone_number') ?></th>
                                            <th><?= lang('Admin.registration_date') ?></th>
                                            <th><?= lang('Admin.registration_type') ?></th>
                                            <th><?= lang('Admin.action') ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if (!empty($results)) {
                                            foreach ($results as $single) { ?>
                                                <tr id="id_<?= $single['id'] ?>">
                                                    <td><input type='checkbox' name='checked_id' class='checkbox' value='<?= $single['id'] ?>' /></td>
                                                    <td><?= $single['id'] ?></td>
                                                    <td><?= urldecode($single['fullname']) ?></td>
                                                    <td><?= urldecode($single['email']) ?></td>
                                                    <td><?= $single['phone'] ?></td>
                                                    <td><?= date('d-m-Y', strtotime($single['created'])) ?></td>
                                                    <td><?= $single['is_social_login'] == "1" ? lang('Admin.facebook') : ($single['is_social_login'] == "2" ? lang('Admin.twitter') : ($single['is_social_login'] == "3" ? lang('Admin.google') : lang('Admin.normal'))) ?></td>
                                                    <td>&nbsp;&nbsp;<a href="javascript:void(0)" class="ti-trash" style="color:red" data-toggle="tooltip" title="<?= lang('Admin.delete') ?>!" onclick="delete_status('<?= base_url('admin/customers/delete') ?>', '<?= $single['id'] ?>')"></a>&nbsp;&nbsp</td>
                                                </tr>
                                        <?php }
                                        }  ?>
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