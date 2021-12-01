
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=lang('Admin.states')?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<? base_url('admin/dashboard') ?>"><?=lang('Admin.dashboard')?></a></li>
                                <li><a href="<? base_url('admin/state') ?>"><?=lang('Admin.state_list')?></a></li>
                                <li><a href="javascrit:void(0)" class="active"><?=lang('Admin.edit_state')?></a></li>

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

                                    <form class="form-horizontal" action="<?= base_url('admin/state') ?>/add" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="addState">

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?=lang('Admin.country')?>:</label>
                                            <div class="col-sm-9">
                                                <select class="form-control required" name="country_id" id="country_id" required>

                                                    <option value=""><?=lang('Admin.select_country')?></option>
                                                    <?php
                                                    foreach ($country as $row) { ?>
                                                    <option  <?= $row['id'] == set_value('country_id') ? 'selected' : '' ?> value="<?= $row['id']; ?>"><?= urldecode($row['name']); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?=lang('Admin.name')?>:</label>
                                            <div class="col-sm-9">
                                                <input id="name" class="form-control required" type="text" name="name" placeholder="<?=lang('Admin.enter_name')?>" value="<?= set_value('name') ?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-lg btn-primary"><?=lang('Admin.add')?></button>
                                                <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-lg btn-danger"><?=lang('Admin.cancel')?></button>
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


