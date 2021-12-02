
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=lang('Admin.drivers')?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('driver/dashboard') ?>"><?=lang('Admin.dashboard')?></a></li>
                                <li><a href="<?= base_url('driver/drivers') ?>"><?=lang('Admin.driver_list')?></a></li>
                                <li><a class="active" href="javascript:void(0)"><?=lang('Admin.add_driver')?></a></li>
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

                                    <form class="form-horizontal" action="<?=base_url('driver/drivers/add') ?>" method="post" accept-charset="utf-8" id="addOwner" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.full_name') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="fullname" class="form-control required" type="text" name="fullname" placeholder="<?= lang('Admin.enter_name') ?>" value="<?= set_value('fullname') ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.email_id') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="email_id" class="form-control required" type="text" name="email_id" placeholder="<?= lang('Admin.enter_email_id') ?>" value="<?= set_value('email_id') ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.phone_number') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="phone_number" class="form-control required" type="text" name="phone_number" placeholder="<?= lang('Admin.enter_phone_number') ?>" value="<?= set_value('phone_number') ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.password') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="password" class="form-control required" type="password" name="password" placeholder="<?= lang('Admin.enter_password') ?>" value="<?= set_value('password') ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.birthdate') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="date_of_birth" class="form-control required" type="date" name="date_of_birth" placeholder="<?= lang('Admin.enter_birthdate') ?>" value="<?= set_value('date_of_birth') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.gender') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <label class="customRadio"><?= lang('Admin.male') ?>
                                                            <input type="radio" name="gender" value="Male" checked>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label class="customRadio"><?= lang('Admin.female') ?>
                                                            <input type="radio" name="gender"   value="Female">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.country') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control required" name="country_id" id="country_id" required>

                                                            <option value=""><?= lang('Admin.select_country') ?></option>
                                                            <?php
                                                            foreach ($country as $row) { ?>
                                                                <option <?=set_value('country_id')==$row['id']?"selected":""?> value="<?= $row['id']; ?>"><?= urldecode($row['name']); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.state') ?>:</label>
                                                    <div class="col-sm-8" id="change_state">
                                                        <select class="form-control required" name="state_id" id="state_id" required>

                                                            <option value=""><?= lang('Admin.select_state') ?></option>
                                                           
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.city') ?>:</label>
                                                    <div class="col-sm-8" id="change_city">
                                                        <select class="form-control required" name="city_id" id="city_id" required>

                                                            <option value=""><?= lang('Admin.select_city') ?></option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.pincode') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="pincode" class="form-control required" type="text" name="pincode" placeholder="<?= lang('Admin.enter_pincode') ?>" value="<?= set_value('pincode') ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?= lang('Admin.address') ?>:</label>
                                                    <div class="col-sm-10">
                                                        <textarea id="address" class="form-control required" name="address" placeholder="<?= lang('Admin.enter_address') ?>" required><?= set_value('address') ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.identity_number') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="identity_number" class="form-control required" type="text" name="identity_number" placeholder="<?= lang('Admin.enter_identity_number') ?>" value="<?= set_value('identity_number') ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.identity_image') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="identity_image" class="form-control required" type="file" name="identity_image" placeholder="<?= lang('Admin.upload_identity_image') ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.license_number') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="license_number" class="form-control required" type="text" name="license_number" placeholder="<?= lang('Admin.enter_license_number') ?>" value="<?= set_value('license_number') ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?= lang('Admin.license_image') ?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="license_image" class="form-control required" type="file" name="license_image" placeholder="<?= lang('Admin.upload_license_image') ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-9">
                                                        <button type="submit" class="btn btn-lg btn-primary"><?= lang('Admin.add') ?></button>
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

<script type="text/javascript">
    $(document).on('change', '#country_id', function() {
        var country_id = $(this).val();
        $('#state_id').val("");
        $('#city_id').val("");
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/drivers/getState') ?>",
            data: {
                'country_id': country_id
            },
            success: function(data) {
                $('#state_id').html(data);
            }
        });
    })

    $(document).on('change', '#state_id', function() {
        var state_id = $(this).val();
        $('#city_id').val("");
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/drivers/getCity') ?>",
            data: {
                'state_id': state_id
            },
            success: function(data) {
                $('#city_id').html(data);
            }
        });
    })
</script>
