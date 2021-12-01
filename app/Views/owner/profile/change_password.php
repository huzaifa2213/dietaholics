<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?= lang('Owner.change_password') ?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('owner/dashboard') ?>"><?= lang('Owner.dashboard') ?></a></li>
                                <li><a href="<?= base_url('owner/profile/change_password')?>"><?= lang('Owner.chnage_password') ?></a></li>
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

                                    <form class="form-horizontal" action="<?= base_url('owner/profile/change_password') ?>" method="post" accept-charset="utf-8" id="editPassword" enctype="multipart/form-data">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?= lang('Owner.old_password') ?>:</label>
                                                    <div class="col-sm-6">
                                                        <input id="old_password" class="form-control required" type="password" name="old_password" placeholder="<?= lang('Owner.enter_old_password') ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?= lang('Owner.new_password') ?>:</label>
                                                    <div class="col-sm-6">
                                                        <input id="new_password" class="form-control required" type="password" name="new_password" placeholder="<?= lang('Owner.enter_new_password') ?>" required>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?= lang('Owner.confirm_new_password') ?>:</label>
                                                    <div class="col-sm-6">
                                                        <input id="confirm_password" class="form-control required" type="password" name="confirm_password" placeholder="<?= lang('Owner.confirm_new_password') ?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-9">
                                                        <button type="submit" class="btn btn-lg btn-primary"><?= lang('Owner.update') ?></button>
                                                        <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-lg btn-danger"><?= lang('Owner.cancel') ?></button>
                                                    </div>
                                                </div>
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