<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?= lang('Admin.master_settings') ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('admin/dashboard') ?>"><?= lang('Admin.dashboard') ?></a></li>
                                <li><a href="<?= base_url('admin/settings') ?>"><?= lang('Admin.master_settings') ?></a></li>

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
                                            <th><?= lang('Admin.app_name') ?></th>
                                            <th><?= lang('Admin.app_logo') ?></th>
                                            <th><?= lang('Admin.email_id') ?></th>
                                            <th><?= lang('Admin.phone_number') ?></th>
                                            <th><?= lang('Admin.modified_date') ?></th>
                                            <th width="100px"><?= lang('Admin.action') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($results)) {


                                            foreach ($results as $single) { ?>
                                                <tr id="id_<?= $single['id'] ?>">
                                                    <td><?= urldecode($single['website_name']) ?></td>
                                                    <td><img src="<?= getImagePath($single['website_logo'], '') ?>" width="80px" /></td>
                                                    <td><?= urldecode($single['email']) ?></td>
                                                    <td><?= $single['phone'] ?></td>
                                                    <td><?= date('d-m-Y', strtotime($single['updated'])) ?></td>
                                                    <td>&nbsp;&nbsp;<a class="fa fa-pencil" data-toggle="tooltip" style="color: #00c0ef;" title="<?= lang('Admin.edit') ?>!" href="<?= base_url('admin/settings') ?>/edit/<?= $single['id'] ?>"></a></td>
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