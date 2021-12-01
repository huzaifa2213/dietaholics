<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=lang('Admin.cities') ?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('admin/dashboard') ?>"><?=lang('Admin.dashboard') ?></a></li>
                                <li><a href="<?= base_url('admin/city') ?>"><?=lang('Admin.list') ?></a></li>
                                <li><a class="active" href="javascript:void(0)"><?= lang('Admin.edit_charges') ?></a></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->

            <div class="main-content">
            
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card alert">
                            
                            <div class="card-body">
                                <div class="menu-upload-form">

                                    <form class="form-horizontal" action="<?= base_url('admin/delivery_charges') ?>/edit/<?= $row['id'] ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="addState">

                                    <div class="form-group">
                                            <label class="col-sm-3 control-label"><?= lang('Admin.min_distance') ?>(km):</label>
                                            <div class="col-sm-9">
                                                <input id="min_distance" class="form-control required" type="nuber" name="min_distance" placeholder="<?= lang('Admin.enter_min_distance') ?>" value="<?= $row['min_distance'] ?>" required>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?= lang('Admin.max_distance') ?>(km):</label>
                                            <div class="col-sm-9">
                                                <input id="max_distance" class="form-control required" type="nuber" name="max_distance" placeholder="<?= lang('Admin.enter_max_distance') ?>" value="<?= $row['max_distance'] ?>" required>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?= lang('Admin.delivery_charges').'('.CURRENCY.')' ?>:</label>
                                            <div class="col-sm-9">
                                                <input id="delivery_charges" class="form-control required" type="nuber" name="charges" placeholder="<?= lang('Admin.enter_delivery_charges') ?>" value="<?= $row['charges'] ?>" required>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-lg btn-primary"><?=lang('Admin.update') ?></button>
                                                <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-lg btn-danger"><?= lang('Admin.cancel') ?></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!-- /# card -->
                    </div><!-- /# column -->
                </div><!-- /# row -->
            </div><!-- /# main content -->
        </div><!-- /# container-fluid -->
    </div><!-- /# main -->
</div><!-- /# content wrap -->
