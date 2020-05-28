<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <li class="menu" >
                <a href="<?php echo URL::abs('home'); ?>" class="<?php HTML::main_menu('home'); ?>" >
                    <i class="fa fa-home"></i> <span>Home</span>
                </a>
            </li>
            
            <li class="menu" >
                <a href="<?php echo URL::abs('gallery-photos'); ?>" class="<?php HTML::main_menu('gallery-photos'); ?>" >
                    <i class="fa fa-photo"></i> <span>Gallery Photos</span>
                </a>
            </li>
            
            <?php if (Membership::instance()->has(Permission::USER_MANAGEMENT)): ?>

                <li class="sub-menu" >
                    <a href="javascript:;" class="<?php HTML::main_menu('user-management'); ?>" >
                        <i class="fa fa-user"></i>
                        <span>User Management</span>
                    </a>
                    <ul class="sub">
                        <li>
                            <a href="<?php echo URL::abs('users/manage'); ?>" class="<?php HTML::sub_menu('manage'); ?>">
                                <i class="fa fa-user"></i>
                                <span>Manage Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo URL::abs('users/roles'); ?>" class="<?php HTML::sub_menu('roles'); ?>">
                                <i class="fa fa-user"></i>
                                <span>Roles</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo URL::abs('users/permissions'); ?>" class="<?php HTML::sub_menu('permissions'); ?>">
                                <i class="fa fa-key"></i>
                                <span>Permissions</span>
                            </a>
                        </li>
                    </ul>

                <?php endif; ?>

        </ul>

        <!-- sidebar menu end-->
    </div>
</aside>