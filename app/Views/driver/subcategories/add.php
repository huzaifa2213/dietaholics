
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=lang('Admin.subcategories')?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<? base_url('admin/dashboard') ?>"><?=lang('Admin.dashboard')?></a></li>
                                <li><a href="<? base_url('admin/subcategories') ?>"><?=lang('Admin.Products_list')?></a></li>
                                <li><a href="javascrit:void(0)" class="active"><?=lang('Admin.add_Product')?></a></li>

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

                                    <form class="form-horizontal" action="<?= base_url('admin/subcategories/add') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="addSubcategory">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.restaurant_name')?>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control required" name="restaurant_id" id="restaurant_id" required>

                                                            <option value=""><?=lang('Admin.select_restaurant')?></option>
                                                            <?php
                                                            foreach ($restaurants as $row) { ?>
                                                                <option <?= (isset($restaurant_id) && $restaurant_id == $row['id']) ? "selected" : "" ?> value="<?= $row['id']; ?>"><?= urldecode($row['name']); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.category')?>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control required" name="category_id" id="category_id" required>

                                                            <option value=""><?=lang('Admin.select_category')?></option>
                                                            <?php
                                                            foreach ($foodcategory as $row) { ?>
                                                                <option <?= $row['id'] == set_value('category_id') ? 'selected' : '' ?> value="<?= $row['id']; ?>"><?= urldecode($row['title']); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.title')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="title" class="form-control required" type="text" name="title" placeholder="<?=lang('Admin.enter_title')?>" value="<?=set_value('title')?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.food_type')?>:</label>
                                                    <div class="col-sm-8">
                                                        <label class="customRadio"><?=lang('Admin.veg')?>
                                                            <input type="radio" name="type" checked value="1">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label class="customRadio"><?=lang('Admin.non_veg')?>
                                                            <input type="radio" name="type" value="2">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?=lang('Admin.description')?>:</label>
                                                    <div class="col-sm-10">
                                                        <textarea id="description" class="form-control required" name="description" placeholder="Enter description" required><?=set_value('description')?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.discount_type')?>:</label>
                                                    <div class="col-sm-8">
                                                        <label class="customRadio"><?=lang('Admin.flat_amount')?>
                                                            <input type="radio" name="discount_type" checked value="0">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label class="customRadio"><?=lang('Admin.percentage')?>
                                                            <input type="radio" name="discount_type" value="1">
                                                            <span class="checkmark"></span>
                                                        </label>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=lang('Admin.discount')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="discount" class="form-control" type="number" name="discount" placeholder="<?=lang('Admin.enter_discount')?>" value="<?=set_value('discount')?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?=lang('Admin.price')?>:</label>
                                                    <div class="col-sm-10">
                                                        <input id="price" class="form-control" type="number" name="price" placeholder="<?=lang('Admin.enter_price')?>" value="<?=set_value('price')?>" min="1" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?=lang('Admin.image')?>:</label>
                                                    <div class="col-sm-10">
                                                        <div class="form-control file-input dark-browse-input-box">
                                                            <label for="inputFile-2">
                                                                <span class="btn btn-danger dark-input-button image-custom">

                                                                    <input type="file" name="image" id="inputFile-2" onchange="validateImage()">
                                                                    <i class="fa fa-file-archive-o"></i>
                                                                    <div class="row fileuploadvalid">
                                                                    </div>
                                                                </span>
                                                            </label>
                                                            <input class="file-name input-flat" type="text" readonly="readonly" placeholder="<?=lang('Admin.upload_image')?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" class="btn btn-lg btn-primary"><?=lang('Admin.add')?></button>
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


<script type="text/javascript">
    function validateImage() {
        var formData = new FormData();

        var file = document.getElementById("inputFile-2").files[0];


        formData.append("Filedata", file);
        var t = file.type.split('/').pop().toLowerCase();
        if (t != "jpeg" && t != "jpg" && t != "png" && t != "bmp" && t != "gif") {
            $('.fileuploadvalid').css("display", "block");
            $('.image-custom label').css("display", "none");

            $('.fileuploadvalid').text('Accepted extensions are jpg, jpeg, png, gif,bmp');
            $('.fileuploadvalid').css("position", "absolute");
            $('.fileuploadvalid').css("top", "32px");
            $('.fileuploadvalid').css("float", "left");
            $('.fileuploadvalid').css("left", "-550px");
            $('.fileuploadvalid').css("font-weight", "400");
            $('.fileuploadvalid').css("font-size", "14px");
            document.getElementById('inputFile-2').value = '';
            $('.file-name').val('');


            return false;



        } else {
            var x = document.getElementById("inputFile-2").value;
            $('.file-name').val(x);
            $('.fileuploadvalid').css("display", "none");
            $('.image-custom label').css("display", "none");
        }


        return true;
    }

    $('form').each(function() {
        $(this).submit(function(e) {
            var x = document.getElementById("inputFile-2").value;

            if (x == '') {
                $('.fileuploadvalid').css("display", "block");
                $('.image-custom label').css("display", "none");
                e.preventDefault();

                return false;
            }

        })
    })
</script>
