<!-- Navigation -->

<div class="navigation">
    <ul>
        <li><a  href="<?php echo URL::abs(''); ?>" class="<?php echo Controller::is_active('browse'); ?>">Main Page</a></li>
        <li><a href="<?php echo URL::abs('category-name'); ?>" class="<?php echo Controller::is_active('category_name'); ?>">category name</a></li>
        <li><a href="<?php echo URL::abs('admin-posts/browse-posts'); ?>" class="<?php echo Controller::is_active('browse-posts'); ?>">admin blog</a></li>
    </ul>
</div>

<div class="clear"></div>