<?php /* @var $paginator Paginator */ if(!$paginator->has_next_page() and !$paginator->has_previous_page()) : else : ?>

<div>
    
         <span> <a href="<?php echo URL::abs($paginator->paging_url.$paginator->get_prev_page()); ?>">Previous</a></span>

         <?php  for($i = 1; $i <= $paginator->number_of_pages(); $i++): ?>
              <?php if(($paginator->current_page - 3) < $i and $i < ($paginator->current_page +3)): ?>
              <?php if ($paginator->current_page == $i):   ?>

                        <b><?php echo $i; ?></b> 
                        
              <?php else: ?>  
                        
                        <a href="<?php echo URL::abs($paginator->paging_url.$i); ?>"><?php echo $i; ?></a> 
                        
              <?php endif; ?>
              <?php endif; ?>               
         <?php endfor; ?>
                        

         <span><a href="<?php echo URL::abs($paginator->paging_url.$paginator->get_next_page()); ?>">Next</a></span>
</div>

<?php endif; ?>