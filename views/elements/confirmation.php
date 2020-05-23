<?php if ( isset($_SESSION) and isset($_SESSION['_error']) and $_SESSION['_error']): ?>
    
    <script type="text/javascript">
        
       toastr['error']('<?php echo $_SESSION['_error']; ?>');

    </script>

    <?php $_SESSION['_error'] = ''; unset($_SESSION['_error']); ?>
    
<?php endif; ?>


<?php if ( isset($_SESSION) and isset($_SESSION['_confirmation']) and $_SESSION['_confirmation']): ?>
    
    <script type="text/javascript">
                
       toastr['success']('<?php echo $_SESSION['_confirmation']; ?>');

    </script>

    <?php $_SESSION['_confirmation'] = ''; unset($_SESSION['_confirmation']); ?>
    
<?php endif; ?>