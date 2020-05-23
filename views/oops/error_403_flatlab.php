<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Mosaddek">
        <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        <link rel="shortcut icon" href="<?php echo URL::image('favicon.png'); ?>">

        <title>404</title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo BASE_URL . 'public/flatlab/'; ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo BASE_URL . 'public/flatlab/'; ?>css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="<?php echo BASE_URL . 'public/flatlab/'; ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <!-- Custom styles for this template -->
        <link href="<?php echo BASE_URL . 'public/flatlab/'; ?>css/style.css" rel="stylesheet">
        <link href="<?php echo BASE_URL . 'public/flatlab/'; ?>css/style-responsive.css" rel="stylesheet" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
        <script src="<?php echo BASE_URL . 'public/flatlab/'; ?>js/html5shiv.js"></script>
        <script src="<?php echo BASE_URL . 'public/flatlab/'; ?>js/respond.min.js"></script>
        <![endif]-->
    </head>


    <style>
        .body-403{
            background: #e03535;
            color: #fff;
        }
        .body-403 section{
            margin-top: 10%;
            text-align: center;
        }
        .body-403 i{
            font-size: 150pt;
        }
        .body-403 h1{
            font-size: 80pt;
            font-weight: 300;
        }
        
        .body-403 a{
            color: #f5c1c1;
            font-size: 15pt;
            text-decoration: underline;
        }
        
        .body-403 a:hover{
            color: white;
        }
    </style>

    <body class="body-403" >

        <div class="container">

            <section class="row" >

                <div class="col-lg-12">
                    <i  class="fa fa-warning" ></i>
                </div>

                <div class=" col-lg-12">
                    <h1>403</h1>
                    <h2>Access Restricted</h2>
                    <p> You don't have permissions to access this page 
                        <a href="<?php echo URL::abs(''); ?>">
                            Return Home
                        </a>
                    </p>
                </div>

            </section>

        </div>


    </body>
</html>
