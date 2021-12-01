<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?= lang('Owner.update_profile') ?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('owner/dashboard') ?>"><?= lang('Owner.dashboard') ?></a></li>
                                <li><a href="<?= base_url('owner/profile') ?>"><?= lang('Owner.update_profile') ?></a></li>
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

                                    <form class="form-horizontal" action="<?= base_url('owner/profile') ?>" method="post" accept-charset="utf-8" id="editProfile" enctype="multipart/form-data">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Owner.first_name') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="first_name" class="form-control required" type="text" name="first_name" placeholder="<?= lang('Owner.enter_first_name') ?>" value="<?= urldecode($results['first_name']) ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Owner.last_name') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="last_name" class="form-control required" type="text" name="last_name" placeholder="<?= lang('Owner.enter_last_name') ?>" value="<?= urldecode($results['last_name']) ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Owner.email_id') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="email" class="form-control required" type="text" name="email" placeholder="<?= lang('Owner.enter_email_id') ?>" value="<?= urldecode($results['email']) ?>" required>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Owner.phone_number') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="phone" class="form-control required" type="text" name="phone" placeholder="<?= lang('Owner.enter_phone_number') ?>" value="<?= $results['phone'] ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Owner.profile_image') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="image" class="form-control required" type="file" name="image" placeholder="<?= lang('Owner.upload_image') ?>">
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