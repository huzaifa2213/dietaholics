
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=lang('Admin.master_settings')?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?=base_url('admin/dashboard') ?>"><?=lang('Admin.dashboard')?></a></li>
                                <li><a href="javascript:void(0)"><?=lang('Admin.edit_details')?></a></li>
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

                                    <form class="form-horizontal" action="<?= base_url('admin/settings') ?>/edit/<?=$results['id']?>" method="post" accept-charset="utf-8" id="editOwner" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4><?=lang('Admin.normal_settings')?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.app_name')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="website_name" placeholder="<?=lang('Admin.enter_app_name')?>" value="<?=urldecode($results['website_name'])?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.email_id')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="email" class="form-control required" type="text" name="email" placeholder="<?=lang('Admin.enter_email_id')?>" value="<?=urldecode($results['email'])?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.charges_from_owners')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="charge_from_owner" class="form-control required" type="number" name="charge_from_owner" placeholder="<?=lang('Admin.enter_charges')?>" min="0" max="99" value="<?=$results['charge_from_owner']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.phone_number')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="phone" class="form-control required" type="text" name="phone" placeholder="<?=lang('Admin.enter_phone_number')?>" value="<?=$results['phone']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.delivery_radius')?>(km):</label>
                                                    <div class="col-sm-8">
                                                        <input id="delivery_radius" class="form-control required" type="text" name="delivery_radius" placeholder="<?=lang('Admin.enter_delivery_radius')?>" value="<?=$results['delivery_radius']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.service_charge')?>(<?=CURRENCY?>):</label>
                                                    <div class="col-sm-8">
                                                        <input id="service_charge" class="form-control required" type="text" name="service_charge" placeholder="<?=lang('Admin.enter_service_charge')?>" value="<?=$results['service_charge']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.order_cancellation_charge')?>(<?=CURRENCY?>):</label>
                                                    <div class="col-sm-8">
                                                        <input id="cancellation_charge" class="form-control required" type="text" name="cancellation_charge" placeholder="<?=lang('Admin.enter_order_cancellation_charge')?>" value="<?=$results['cancellation_charge']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.app_logo')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="website_logo" class="form-control required" type="file" name="website_logo" placeholder="<?=lang('Admin.upload_app_logo')?>">
                                                    </div>
                                                </div>
                                            </div>
                                           

                                            <div class="col-md-12">
                                                <h4><?=lang('Admin.smtp_settings')?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.smtp_host')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="smtp_host" placeholder="<?=lang('Admin.enter_smtp_host')?>" value="<?=$results['smtp_host']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.smtp_port')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="smtp_port" placeholder="<?=lang('Admin.enter_smtp_port')?>" value="<?=$results['smtp_port']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.smtp_user_name')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="smtp_username" placeholder="<?=lang('Admin.enter_smtp_user_name')?>" value="<?=urldecode($results['smtp_username'])?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.smtp_password')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="password" name="smtp_password" placeholder="<?=lang('Admin.enter_smtp_password')?>" value="<?=$results['smtp_password']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.smtp_from_email')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="smtp_from_email" placeholder="<?=lang('Admin.enter_smtp_from_email')?>" value="<?=urldecode($results['smtp_from_email'])?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.smtp_from_name')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="smtp_from_name" placeholder="<?=lang('Admin.enter_smtp_from_name')?>" value="<?=urldecode($results['smtp_from_name'])?>">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <h4><?=lang('Admin.stripe_settings')?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.private_key')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="stripe_private_key" placeholder="<?=lang('Admin.enter_private_key')?>" value="<?=$results['stripe_private_key']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.publishable_key')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="stripe_publish_key" placeholder="<?=lang('Admin.enter_publishable_key')?>" value="<?=$results['stripe_publish_key']?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <h4><?=lang('Admin.paypal_braintree_settings')?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.environment')?>:</label>
                                                    <div class="col-sm-8">
                                                        <select  class="form-control required"  name="braintree_environment" >
                                                            <option <?=$results['braintree_environment']=="sandbox"?"selected":""?> value="sandbox"><?=lang('Admin.sand_box')?></option>
                                                            <option <?=$results['braintree_environment']=="live"?"selected":""?> value="live"><?=lang('Admin.live')?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.merchant_id')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input  class="form-control required" type="text" name="braintree_merchant_id" placeholder="<?=lang('Admin.enter_merchant_id')?>" value="<?=$results['braintree_merchant_id']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.public_key')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="braintree_public_key" placeholder="<?=lang('Admin.enter_public_key')?>" value="<?=$results['braintree_public_key']?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.private_key')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="braintree_private_key" placeholder="<?=lang('Admin.enter_private_key')?>" value="<?=$results['braintree_private_key']?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <h4><?=lang('Admin.razorpay_settings')?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.razorpay_key')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="razorpay_key" placeholder="<?=lang('Admin.enter_razorpay_key')?>" value="<?=$results['razorpay_key']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.razorpay_secret')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="razorpay_secret" placeholder="<?=lang('Admin.enter_razorpay_secret')?>" value="<?=$results['razorpay_secret']?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <h4><?=lang('Admin.facebook_login_settings')?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.facebook_app_id')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input  class="form-control required" type="text" name="facebook_app_id" placeholder="<?=lang('Admin.enter_facebook_app_id')?>" value="<?=$results['facebook_app_id']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.facebook_app_secret')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input  class="form-control required" type="text" name="facebook_app_secret" placeholder="<?=lang('Admin.enter_facebook_app_secret')?>" value="<?=$results['facebook_app_secret']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.facebook_graph_version')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input  class="form-control required" type="text" name="facebook_graph_version" placeholder="<?=lang('Admin.enter_facebook_graph_version')?>" value="<?=$results['facebook_graph_version']?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <h4><?=lang('Admin.google_login_settings')?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.google_client_id')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input  class="form-control required" type="text" name="google_client_id" placeholder="<?=lang('Admin.enter_google_client_id')?>" value="<?=$results['google_client_id']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.google_client_secret')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input  class="form-control required" type="text" name="google_client_secret" placeholder="<?=lang('Admin.enter_google_client_secret')?>" value="<?=$results['google_client_secret']?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <h4><?=lang('Admin.other_settings')?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.map_api_key')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input  class="form-control required" type="text" name="map_api_key" placeholder="<?=lang('Admin.enter_map_api_key')?>" value="<?=$results['map_api_key']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.fcm_key')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control required" type="text" name="fcm_key" placeholder="<?=lang('Admin.enter_fcm_key')?>" value="<?=$results['fcm_key']?>">
                                                    </div>
                                                </div>
                                            </div>

                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-9">
                                                        <button type="submit" class="btn btn-lg btn-primary"><?=lang('Admin.update')?></button>
                                                        <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-lg btn-danger"><?=lang('Admin.cancel')?></button>
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

