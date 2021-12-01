<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <!--<li class="label">Main</li>-->

                <li class="active"><a href="<?= base_url('admin/dashboard') ?>"><i class="ti-home"></i> <?= lang('Admin.dashboard') ?> </a></li>

                <li><a class="sidebar-sub-toggle"><i class="fa fa-group"></i> <?= lang('Admin.users') ?> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="<?= base_url('admin/customers') ?>"><?= lang('Admin.customers') ?></a></li>
                        <li><a href="<?= base_url('admin/drivers') ?>"><?= lang('Admin.drivers') ?></a></li>
                        <li><a href="<?= base_url('admin/owners') ?>"><?= lang('Admin.restaurant_owners') ?></a></li>

                    </ul>
                </li>
                
                <li><a class="sidebar-sub-toggle"><i class="fa fa-group"></i> <?= lang('Admin.driver_company') ?> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="<?= base_url('admin/driver_company') ?>"><?= lang('Admin.driver_company') ?></a></li>
                      

                    </ul>
                </li>

                <li><a class="sidebar-sub-toggle"><i class="fa fa-clipboard"></i> <?= lang('Admin.menu') ?> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>

                        <li><a href="<?= base_url('admin/categories') ?>"><?= lang('Admin.categories') ?></a></li>
                        <li><a href="<?= base_url('admin/subcategories') ?>"><?= lang('Admin.Products') ?></a></li>

                    </ul>
                </li>
                
                
                
                <li><a class="sidebar-sub-toggle"><i class="fa fa-map-marker"></i> <?= lang('Admin.locations') ?> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="<?= base_url('admin/country') ?>"><?= lang('Admin.countries') ?></a></li>
                        <li><a href="<?= base_url('admin/state') ?>"><?= lang('Admin.states') ?></a></li>
                        <li><a href="<?= base_url('admin/city') ?>"><?= lang('Admin.cities') ?></a></li>

                    </ul>
                </li>
                <li><a href="<?= base_url('admin/notifications') ?>"><i class="fa fa-envelope"></i> <?= lang('Admin.push_notifications') ?> </a></li>
                <li><a href="<?= base_url('admin/coupons') ?>"><i class="fa fa-tags"></i> <?= lang('Admin.coupons') ?> </a></li>
                <li><a href="<?= base_url('admin/orders') ?>"><i class="fa fa-truck"></i> <?= lang('Admin.orders') ?> </a></li>
                <li><a href="<?= base_url('admin/restaurants') ?>"><i class="fa fa-cutlery"></i><?= lang('Admin.restaurants') ?></a></li>
                <li><a href="<?= base_url('admin/settings') ?>"><i class="ti-settings"></i><?= lang('Admin.master_settings') ?></a></li>
                <li><a href="<?= base_url('admin/pages') ?>"><i class="ti-settings"></i><?= lang('Admin.pages') ?></a></li>


            </ul>
        </div>
    </div>
</div><!-- /# sidebar -->
<div class="header">
    <div class="pull-left">
        <div class="logo">
            <span><?= strtoupper(urldecode($settings['website_name'])) ?></span></a>
        
        
        </div>
        <div class="hamburger sidebar-toggle">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </div>

    <div class="pull-right p-r-15">

        <ul>
            <li class="header-icon dib">
                <img class="avatar-img" src="<?= base_url('backend/images/' . ($session->lang ? $session->lang: "english") . '.png') ?>" alt="" />

                <span class="user-avatar"><?= $session->lang_short ? strtoupper($session->lang_short) : "EN" ?>
                    <i class="ti-angle-down f-s-10"></i>
                </span>
                <div class="drop-down dropdown-profile">
                    <div class="dropdown-content-body">
                        <ul>
                            <li><a href="<?= base_url('admin/profile/change_language/english/en') ?>"><img class="avatar-img" src="<?= base_url('backend/images/english.png') ?>" alt="" /><span>&nbsp;&nbsp;&nbsp;English(EN)</span></a></li>
                            <li><a href="<?= base_url('admin/profile/change_language/french/fr') ?>"><img class="avatar-img" src="<?= base_url('backend/images/french.png') ?>" alt="" /><span>&nbsp;&nbsp;&nbsp;French(FR)</span></a></li>
                            <li><a href="<?= base_url('admin/profile/change_language/spanish/es') ?>"><img class="avatar-img" src="<?= base_url('backend/images/spanish.png') ?>" alt="" /><span>&nbsp;&nbsp;&nbsp;Spanish(ES)</span></a></li>
                            <li><a href="<?= base_url('admin/profile/change_language/arabic/ar') ?>"><img class="avatar-img" src="<?= base_url('backend/images/arabic.png') ?>" alt="" /><span>&nbsp;&nbsp;&nbsp;Arabic(AR)</span></a></li>

                        </ul>
                    </div>
                </div>
            </li>



            <li class="header-icon dib">

                <img class="avatar-img" src="<?= getImagePath($session_detail['image'], 'profile') ?>" alt="" />


                <span class="user-avatar"><?= urldecode($session_detail['first_name']) . ' ' . urldecode($session_detail['last_name']); ?>
                    <i class="ti-angle-down f-s-10"></i>
                </span>
                <div class="drop-down dropdown-profile">
                    <div class="dropdown-content-body">
                        <ul>
                            <li><a href="<?= base_url('admin/profile') ?>"><i class="ti-user"></i> <span><?= lang('Admin.profile') ?></span></a></li>
                            <li><a href="<?= base_url('admin/profile/change_password') ?>/"><i class="ti-user"></i> <span><?= lang('Admin.change_password') ?></span></a></li>
                            <li>
                                <a href="<?= base_url('admin/profile/logout') ?>">
                                    <i class="ti-power-off"></i> <span><?= lang('Admin.logout') ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>