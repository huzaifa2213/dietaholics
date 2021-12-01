
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=lang('Admin.invoice_details')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= base_url('admin/dashboard') ?>"><?=lang('Admin.dashboard')?></a></li>
                                <li><a href="<?= base_url('admin/restaurants') ?>"><?=lang('Admin.restaurant_list')?></a></li>
                                <li class="active"><?=lang('Admin.invoice_details')?></li>
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
                                            <th><input type='checkbox' name='select_all' id='select_all' value=''/></th>

                                            <th><?=lang('Admin.order_id')?></th>
                                            <th><?=lang('Admin.admin_charge')?></th>
                                            <th><?=lang('Admin.owners_amount')?></th>
                                            <th><?=lang('Admin.total_amount')?></th>
                                            <th><?=lang('Admin.payment_status')?></th>
                                            <th><?=lang('Admin.payment_date')?></th>
                                            
                                            
                                        </tr>
                                    </thead>
                                <tbody>
                                        <?php
                                        $payable_Amount = 0;
                                        if (!empty($invoice_info)) {

                                            
                                            foreach ($invoice_info as $single) {
                                                $payable_Amount = $single['payment_status'] == 0 ? ($payable_Amount +   $single['owners_amount']) : $payable_Amount;  
                                            ?>
                                            <tr id="id_<?= $single['id'] ?>">
                                            <td><input type='checkbox' name='checked_id' id='checkbox1' class='checkbox' value='<?=$single['id']?>'/></td>
                                            <td>#<?=$single['id']?></td>
                                            <td><?=CURRENCY.$single['admin_charge_amount']?></td>
                                            <td><?=CURRENCY.$single['owners_amount']?></td>
                                            <td><?=CURRENCY.$single['grand_total']?></td>
                                            <td><?php if($single['payment_status']==0) { echo "<label class='label label-warning' >Pending</label>"; } else if($single['payment_status']==1) { echo "<label class='label label-success'>Paid</label>"; }else { echo "-"; }?></td>
                                            <td><?=$single['payment_date']?date('d-m-Y',strtotime($single['payment_date'])): ""?></td>
                                            </tr>
                                            <?php
                                             
                                            }
                                           
                                        }
                                        ?>




                                    </tbody>
                                </table>
                                <hr>
                                <table width="50%" >
                                    <tr >
                                        <th><b style="color: #000000"> <?=lang('Admin.total_payable_amount')?> : <?=CURRENCY.$payable_Amount?></b></th>
                                        <td><?php if($payable_Amount==0) { ?>
                                            <button class="btn btn-danger"><?=lang('Admin.paid')?></button>
                                     <?php   }else { ?>
                                        <a href="<?=base_url('admin/restaurants')?>/pay/<?=$restaurant_id?>/<?=$payable_Amount?>" class="btn btn-success">Pay <?=CURRENCY.$payable_Amount?></a>
                                    <?php    } ?></td>
                                    </tr>
                                    
                                </table>
                                
                                <hr />
                            </div>
                        
                            
                        </div>
                    </div>
                </div><!-- /# row -->
            </div><!-- /# main content -->
        </div><!-- /# container-fluid -->
    </div><!-- /# main -->
</div><!-- /# content wrap -->