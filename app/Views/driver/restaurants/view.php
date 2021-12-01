
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=lang('Admin.restaurants')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('admin/dashboard') ?>"><?=lang('Admin.dashboard')?></a></li>
                                <li><a href="<?= base_url('admin/restaurants') ?>"><?=lang('Admin.restaurant_list')?></a></li>
                                <li class="active"><?=lang('Admin.restaurant_details')?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card alert">
                            <div class="card-header">
                                <h4><?=urldecode($restaurant_info['name']); ?> </h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                
                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            
                                            <tr>
                                                <td><?=lang('Admin.opening_time')?>:</td>
                                                <td class="text-right"><?=dateFormate($restaurant_info['opening_time']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=lang('Admin.closing_time')?>:</td>
                                                <td class="text-right"><?=dateFormate($restaurant_info['closing_time']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=lang('Admin.availability')?></td>
                                                <td class="text-right"><?=$restaurant_info['is_available']==1?("<lable class='label label-success'>".lang('Admin.available')."</label>"): ("<lable class='label label-danger'>".lang('Admin.unavailable')."</label>"); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=lang('Admin.discount')?>:</td>
                                                <td class="text-right"><?=$restaurant_info['discount']; ?><?=($restaurant_info['discount_type']==1? "%" : CURRENCY); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=lang('Admin.average_price')?>:</td>
                                                <td class="text-right"><?=CURRENCY.$restaurant_info['average_price']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card alert">
                            <div class="card-header">
                                <h4><?=lang('Admin.contact_and_address_information')?></h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                        
                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            <tr>
                                                <td><?=lang('Admin.phone_number')?>:</td>
                                                <td class="text-right"><?=$restaurant_info['phone'];?></td>
                                            </tr>
                                            <tr>
                                                <td><?=lang('Admin.email_id')?>:</td>
                                                <td class="text-right"><?=urldecode($restaurant_info['email']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=lang('Admin.address')?>:</td>
                                                <td class="text-right"><?php echo urldecode($restaurant_info['address']) .', '.urldecode($restaurant_info['city_name']).', '.urldecode($restaurant_info['state_name']).', '.urldecode($restaurant_info['country_name']).'-'.$restaurant_info['pincode']?></td>
                                            </tr>
                                           
                                            
                                           
                                        </tbody>
                                    </table>
                    
                                    
                                </div>                                    
                            </div>
                                
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-header">
                                <h4><?=lang('Admin.food_information')?></h4></h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                <?php foreach($categories as $cats) { ?>
                                    <div class="card-header">
                                    <h2 style="color:#0a9822"><center><?=urldecode($cats['title'])?></center></h2>
                                </div>
                                <table id="bootstrap-data-table<?=$cats['id']?>" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?=lang('Admin.image')?></th>
                                            <th><?=lang('Admin.name')?></th>
                                            <th><?=lang('Admin.description')?></th>
                                            <th><?=lang('Admin.price')?></th>
                                            <th><?=lang('Admin.discount')?></th>
                                            <th><?=lang('Admin.food_type')?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php
                                    $subcategory=  $controller->getProducts($restaurant_info['id'], $cats['id']);
                                      foreach($subcategory as $rows){ ?>
                                        <tr>
                                            <td width="100px"><img src="<?=getImagePath($rows['image'], 'subcategory')?>" width="80px" /></td>
                                            <td><?=urldecode($rows['title'])?></td>
                                            <td><?=urldecode($rows['description'])?></td>
                                            <td><?=CURRENCY?><?=$rows['price']?></td>
                                            <td><?=$rows['discount']?><?=($rows['discount_type']==1? "%" : CURRENCY); ?></td>
                                            <td><?=($rows['type']==1? "Veg" : "Non-veg"); ?></td>
                                        </tr>
                                        <?php } ?>
                                      </tbody>
                                    </table>



                             <?php   } ?>
                                    
                                    
                                        
                                    
                                </div>
                                    
                                
                                
                            </div>
                                
                        </div>
                    </div>

                                        
                </div><!-- /# row -->
                                
               
                    
                    
                    
                </div>
            </div><!-- /# main content -->
        </div><!-- /# container-fluid -->
    </div><!-- /# main -->
</div><!-- /# content wrap -->
<script type="text/javascript">
    $('[id^=bootstrap-data-table]').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
    });

   
</script>
