
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=lang('Admin.notifications')?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?=base_url('admin/dashboard') ?>"><?=lang('Admin.dashboard')?></a></li>
                                <li><a href="<?=base_url('admin/notifications') ?>"><?=lang('Admin.notification_list')?></a></li>
                                <li><a class="active" href="javascript:void(0)"><?=lang('Admin.add_notification')?></a></li>
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

                                    <form class="form-horizontal" action="<?= base_url('admin/notifications') ?>/add" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="addNotification">

                                        <div class="row">
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?=lang('Admin.title')?>:</label>
                                                    <div class="col-sm-10">
                                                        <input id="title" class="form-control required" type="text" name="title" placeholder="<?=lang('Admin.enter_title')?>" value="<?= set_value('title') ?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?=lang('Admin.description')?>:</label>
                                                    <div class="col-sm-10">
                                                        <textarea id="description" class="form-control required" name="description" placeholder="<?=lang('Admin.enter_description')?>" required><?= set_value('description') ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" class="btn btn-lg btn-primary"><?=lang('Admin.add')?></button>
                                                        <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-lg btn-danger"><?= lang('Admin.cancel') ?></a>
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


