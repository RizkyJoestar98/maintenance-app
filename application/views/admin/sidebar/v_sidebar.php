<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('assets/template/') ?>index3.html" class="brand-link">
        <center>
            <img src="<?= base_url('assets/image/') ?>logo/Isuzu.svg.png" alt="Logo-Isuzu.png" width="150">
        </center>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('assets/image/') ?>logo/default-profil.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $session['name'] ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php $dashboard = (uri_string() == 'admin/dashboard') ? 'active' : ''; ?>
                <li class="nav-item">
                    <a href="<?= site_url('admin/dashboard') ?>" class="nav-link <?= $dashboard; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <?php
                $menu_open  = '';
                $active     = '';
                if (uri_string() == 'admin/material_list' || uri_string() == 'admin/add_material_list' || uri_string() == 'admin/category' || uri_string() == 'admin/add_category' || uri_string() == 'admin/area' || uri_string() == 'admin/add_area' || uri_string() == 'admin/line' || uri_string() == 'admin/add_line' || uri_string() == 'admin/machine' || uri_string() == 'admin/add_machine' || uri_string() == 'admin/uom' || uri_string() == 'admin/add_uom' || uri_string() == 'admin/location' || uri_string() == 'admin/add_location' || uri_string() == 'admin/detail_material_list') {
                    $menu_open = 'menu-open';
                    $active    = 'active';
                }
                ?>
                <li class="nav-item <?= $menu_open; ?>">
                    <a href="#" class="nav-link <?= $active; ?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Material
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php $material_list = (uri_string() == 'admin/material_list' || uri_string() == 'admin/add_material_list') ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/material_list') ?>" class="nav-link <?= $material_list; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Material List</p>
                            </a>
                        </li>
                        <?php $category = (uri_string() == 'admin/category' || uri_string() == 'admin/add_category') ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/category') ?>" class="nav-link <?= $category; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <?php $area = (uri_string() == 'admin/area' || uri_string() == 'admin/add_area') ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/area') ?>" class="nav-link <?= $area; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Area</p>
                            </a>
                        </li>
                        <?php $line = (uri_string() == 'admin/line' || uri_string() == 'admin/add_line') ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/line') ?>" class="nav-link <?= $line; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Line</p>
                            </a>
                        </li>
                        <?php $machine = (uri_string() == 'admin/machine' || uri_string() == 'admin/add_machine') ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/machine') ?>" class="nav-link <?= $machine; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Machine</p>
                            </a>
                        </li>
                        <?php $uom = (uri_string() == 'admin/uom' || uri_string() == 'admin/add_uom') ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/uom') ?>" class="nav-link <?= $uom; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>UOM</p>
                            </a>
                        </li>
                        <?php $location = (uri_string() == 'admin/location' || uri_string() == 'admin/add_location') ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/location') ?>" class="nav-link <?= $location; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Location</p>
                            </a>
                        </li>
                        <?php $detail_material = (uri_string() == 'admin/detail_material_list') ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/detail_material_list') ?>" class="nav-link <?= $detail_material; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Detail Material</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php
                $menu_open  = '';
                $active     = '';
                if (uri_string() == 'admin/goods_receive' || uri_string() == 'admin/add_goods_receive' || uri_string() == 'admin/goods_issue' || uri_string() == 'admin/add_goods_issue' || uri_string() == 'admin/history_transaction') {
                    $menu_open  = 'menu-open';
                    $active     = 'active';
                }
                ?>
                <li class="nav-item <?= $menu_open; ?>">
                    <a href="#" class="nav-link <?= $active; ?>">
                        <i class="nav-icon fas fa-exchange-alt"></i>

                        <p>
                            Transaction
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php $goods_receive = (uri_string() == 'admin/goods_receive' || uri_string() == 'admin/add_goods_receive') ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/goods_receive') ?>" class="nav-link <?= $goods_receive; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Goods Receive (Barang Masuk)</p>
                            </a>
                        </li>
                        <?php $goods_issue = (uri_string() == 'admin/goods_issue' || uri_string() == 'admin/add_goods_issue') ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/goods_issue') ?>" class="nav-link <?= $goods_issue; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Goods Issue (Barang Keluar)</p>
                            </a>
                        </li>
                        <?php $hist_transaction = (uri_string() == 'admin/history_transaction') ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/history_transaction') ?>" class="nav-link <?= $hist_transaction; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>History Transaction</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php $manage_user = (uri_string() == 'admin/manage_user') ? 'active' : ''; ?>
                <li class="nav-item">
                    <a href="<?= site_url('admin/manage_user') ?>" class="nav-link <?= $manage_user; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Manage User
                        </p>
                    </a>
                </li>
                <?php $change_password = (uri_string() == 'admin/change_password') ? 'active' : ''; ?>
                <li class="nav-item">
                    <a href="<?= site_url('admin/change_password') ?>" class="nav-link <?= $change_password; ?>">
                        <i class="nav-icon fas fa-key"></i>
                        <p>
                            Change Password
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-file-pdf"></i>
                        <p>
                            Guide Book
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('admin/logout'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>