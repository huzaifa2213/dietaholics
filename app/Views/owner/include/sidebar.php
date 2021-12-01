<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <!--<li class="label">Main</li>-->

                <li class="active"><a href="<?= base_url('owner/dashboard') ?>"><i class="ti-home"></i> <?= lang('Owner.dashboard') ?> </a></li>


                <li><a class="sidebar-sub-toggle"><i class="fa fa-clipboard"></i> <?= lang('Owner.menu') ?> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>

                        <li><a href="<?= base_url('owner/subcategories') ?>"><?= lang('Owner.Products') ?></a></li>

                    </ul>
                </li>

                <li><a href="<?= base_url('owner/orders') ?>"><i class="fa fa-truck"></i> <?= lang('Owner.orders') ?> </a></li>
                <li><a href="<?= base_url('owner/restaurants') ?>"><i class="fa fa-cutlery"></i><?= lang('Owner.restaurants') ?></a></li>

            </ul>
        </div>
    </div>
</div><!-- /# sidebar -->
<div class="header">
    <div class="pull-left">
        <div class="logo"><span><?= strtoupper(urldecode($settings['website_name'])) ?></span></a></div>
        <div class="hamburger sidebar-toggle">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </div>

    <div class="pull-right p-r-15">


        <ul>
            <li class="header-icon dib">
                <img class="avatar-img" src="<?=base_url('backend/images/'.($session->lang ? $session->lang : "english").'.png')?>" alt="" />

                <span class="user-avatar"><?= $session->lang_short ? strtoupper($session->lang_short) : "EN" ?>
                    <i class="ti-angle-down f-s-10"></i>
                </span>
                <div class="drop-down dropdown-profile">
                    <div class="dropdown-content-body">
                        <ul>
                            <li><a href="<?= base_url('owner/profile') ?>/change_language/english/en"><img class="avatar-img" src="<?=base_url('backend/images/english.png')?>" alt="" /><span>&nbsp;&nbsp;&nbsp;English(EN)</span></a></li>
                            <li><a href="<?= base_url('owner/profile') ?>/change_language/french/fr"><img class="avatar-img" src="<?=base_url('backend/images/french.png')?>" alt="" /><span>&nbsp;&nbsp;&nbsp;French(FR)</span></a></li>
                            <li><a href="<?= base_url('owner/profile') ?>/change_language/spanish/es"><img class="avatar-img" src="<?=base_url('backend/images/spanish.png')?>" alt="" /><span>&nbsp;&nbsp;&nbsp;Spanish(ES)</span></a></li>
                            <li><a href="<?= base_url('owner/profile') ?>/change_language/arabic/ar"><img class="avatar-img" src="<?=base_url('backend/images/arabic.png')?>" alt="" /><span>&nbsp;&nbsp;&nbsp;Arabic(AR)</span></a></li>

                        </ul>
                    </div>
                </div>
            </li>
            <li class="header-icon dib">

                <img class="avatar-img" src="<?=getImagePath($session_detail['image'], 'owners')?>" alt="" />


                <span class="user-avatar"><?= urldecode($session_detail['first_name']) . ' ' . urldecode($session_detail['last_name']); ?>
                    <i class="ti-angle-down f-s-10"></i>
                </span>
                <div class="drop-down dropdown-profile">
                    <div class="dropdown-content-body">
                        <ul>
                            <li><a href="<?= base_url('owner/profile') ?>"><i class="ti-user"></i> <span><?= lang('Owner.profile') ?></span></a></li>
                            <li><a href="<?= base_url('owner/profile/change_password') ?>"><i class="ti-user"></i> <span><?= lang('Owner.change_password') ?></span></a></li>
                            <li>
                                <a href="<?= base_url('owner/profile/logout'); ?>">
                                    <i class="ti-power-off"></i> <span><?= lang('Owner.logout') ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>