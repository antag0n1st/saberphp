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
                    <img alt="" src="<?php echo URL::abs('public/flatlab/img/avatar-mini2.jpg'); ?>">
                    <span class="username"><?php echo Membership::instance()->user->username; ?> </span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">                  
                    <li><a href="<?php echo URL::abs('logout'); ?>"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>

        </ul>
    </div>
</header>