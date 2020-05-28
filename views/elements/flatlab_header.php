<header class="header white-bg">
    <div class="sidebar-toggle-box">
        <i class="fa fa-bars"></i>
    </div>
    <!--logo start-->
    <a href="<?php echo URL::abs('admin'); ?>" class="logo visible-lg" >
        <?php 
            $_parts = explode(' ', TITLE);
            $_count = count($_parts);
            for($i=0;$i < $_count;$i++){
                if($i == $_count -1){
                     echo '<span>'.$_parts[$i].'</span>';
                } else {
                     echo $_parts[$i].' ';
                }               
            }
        ?>
    </a>
    <!--logo end-->
    
    <div class="top-nav ">
        <ul class="nav pull-right top-menu">
<!--            <li>
                <input type="text" class="form-control search" placeholder="Search">
            </li>-->
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="<?php echo $profile_image->thumbnail()->url; ?>" style="height: 32px;">
                    <span class="username"><?php echo Membership::instance()->user->username; ?> </span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">     
                    <div class="log-arrow-up"></div>
                    <li><a href="<?php echo URL::abs('profile'); ?>"><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href="<?php echo URL::abs('logout'); ?>"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>

        </ul>
    </div>
</header>