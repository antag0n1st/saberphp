<?php /* @var $paginator Paginator */ if (!$paginator->has_next_page() and ! $paginator->has_previous_page()) : else : ?>

    <?php
    $pages_to_display = [];

    for ($i = 1; $i <= $paginator->number_of_pages(); $i++) {
        if (($paginator->current_page - 3) < $i and $i < ($paginator->current_page + 3)) {
            $pages_to_display[] = $i;
        }
    }
    ?>

    <ul class="pagination">

        <?php if (!in_array(1, $pages_to_display)): ?>
            <li><a href="<?php echo URL::abs($paginator->paging_url . "1"); ?>"> 1 </a></li>
        <?php else: ?>
            <li><a href="#" onclick="return false;" style="color:white;" > 1 </a></li>
        <?php endif; ?>




        <?php if ($paginator->has_previous_page()): ?>

            <li><a href="<?php echo URL::abs($paginator->paging_url . $paginator->get_prev_page()); ?>"> < </a></li>
        <?php else: ?>
            <li><a href="#" onclick="return false;" style="color:white;" > < </a></li>
        <?php endif; ?>

        <?php foreach ($pages_to_display as $i): ?>

            <?php if ($paginator->current_page == $i): ?>
                <li class="active" ><a onclick="return false;" href="#"><?php echo $i; ?></a></li>
            <?php else: ?>  
                <li><a href="<?php echo URL::abs($paginator->paging_url . $i); ?>"><?php echo $i; ?></a></li>
            <?php endif; ?>

        <?php endforeach; ?>

        <?php if ($paginator->has_next_page()): ?>
            <li><a href="<?php echo URL::abs($paginator->paging_url . $paginator->get_next_page()); ?>"> > </a></li>
            <?php if (in_array($paginator->number_of_pages(), $pages_to_display)): ?>
                <li><a href="#" onclick="return false;" style="color:white;" > <?php echo $paginator->number_of_pages(); ?> </a></li>
            <?php else: ?>
                <li><a href="<?php echo URL::abs($paginator->paging_url . $paginator->number_of_pages()); ?>"> <?php echo $paginator->number_of_pages(); ?> </a></li>
            <?php endif; ?>

        <?php else: ?>
            <li><a href="#" onclick="return false;" style="color:white;" > > </a></li>
            <li><a href="#" onclick="return false;" style="color:white;" > <?php echo $paginator->number_of_pages(); ?> </a></li>
            <?php endif; ?>
    </ul>

<?php endif; ?>

