<!DOCTYPE html>
<html lang="en">
<head>
    <?php Head::instance()->display(); ?>
</head>

  <body class="login-body">

    <div class="container">

        <?php Controller::load_main_view(); ?> 

    </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo BASE_URL.'public/flatlab/'; ?>js/jquery.js"></script>
    <script src="<?php echo BASE_URL.'public/flatlab/'; ?>js/bootstrap.min.js"></script>
     <script src="<?php echo URL::abs('public/flatlab/assets/toastr-master/toastr.js'); ?>"></script>

    <?php Load::view('elements/confirmation'); ?>

  </body>
</html>
