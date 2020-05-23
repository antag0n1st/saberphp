<!DOCTYPE html>
<html lang="en">
    <head>

        <?php Head::instance()->display(); ?>

    </head>

    <body>

        <section id="container" class="">
            <header class="header white-bg">
                <a href="#" class="logo visible-lg" >
                    <?php
                    $_parts = explode(' ', TITLE);
                    $_count = count($_parts);
                    for ($i = 0; $i < $_count; $i++) {
                        if ($i == $_count - 1) {
                            echo '<span>' . $_parts[$i] . '</span>';
                        } else {
                            echo $_parts[$i] . ' ';
                        }
                    }
                    ?>
                </a>
            </header>
        </section>

        <!--main content start-->
        <section >
            <section class="wrapper site-min-height">
                <!-- page start-->
                <?php Controller::load_main_view(); ?> 
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->


        <!--footer start-->
        <?php Load::view('elements/flatlab_footer'); ?> 
        <!--footer end-->
    </section>

    <!-- js placed at the end of the document so the pages load faster -->

    <script src="<?php echo URL::abs('public/flatlab/js/bootstrap.min.js'); ?>"></script>
    <script class="include" type="text/javascript" src="<?php echo URL::abs('public/flatlab/js/jquery.dcjqaccordion.2.7.js'); ?>"></script>
    <script src="<?php echo URL::abs('public/flatlab/js/jquery.scrollTo.min.js'); ?>"></script>
    <script src="<?php echo URL::abs('public/flatlab/js/slidebars.min.js'); ?>"></script>
    <script src="<?php echo URL::abs('public/flatlab/js/jquery.nicescroll.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo URL::abs('public/flatlab/js/respond.min.js'); ?>" ></script>
    <script src="<?php echo URL::abs('public/flatlab/assets/toastr-master/toastr.js'); ?>"></script>
    <script src="<?php echo URL::abs('public/flatlab/assets/jquery-knob/js/jquery.knob.js'); ?>"></script>

    <script src="<?php echo URL::abs('public/flatlab/assets/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>

    <!--bootstrap-switch-->
    <script src="<?php echo URL::abs('public/flatlab/assets/bootstrap-switch/static/js/bootstrap-switch.js'); ?>"></script>

    <script src="<?php echo URL::abs('public/flatlab/assets/select2/js/select2.min.js'); ?>"></script>

    <!--common script for all pages-->
    <script src="<?php echo URL::abs('public/flatlab/js/common-scripts.js'); ?>"></script>

    <?php Load::view('elements/confirmation'); ?>

</body>
</html>
