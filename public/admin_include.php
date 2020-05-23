<?php

//Head::instance()->reset_data();


Head::instance()->title = 'Administration';

Head::instance()->load_css('all');

Head::instance()->add('<link href="' . BASE_URL . 'public/flatlab/' . 'css/bootstrap.min.css" rel="stylesheet">');
Head::instance()->add('<link href="' . BASE_URL . 'public/flatlab/' . 'css/bootstrap-reset.css" rel="stylesheet">');
// <!--external css-->
Head::instance()->add('<link href="' . BASE_URL . 'public/flatlab/' . 'assets/font-awesome/css/font-awesome.css" rel="stylesheet" />');
// <!--right slidebar-->
// <!-- Custom styles for this template -->
Head::instance()->add('<link href="' . BASE_URL . 'public/flatlab/' . 'css/style.css" rel="stylesheet">');
Head::instance()->add('<link href="' . BASE_URL . 'public/flatlab/' . 'css/style-responsive.css" rel="stylesheet" />');

Head::instance()->add('<link href="' . BASE_URL . 'public/flatlab/' . 'assets/toastr-master/toastr.css" rel="stylesheet" type="text/css" />');

// <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
Head::instance()->add('<!--[if lt IE 9]><script src="' . BASE_URL . 'public/flatlab/' . 'js/html5shiv.js"></script><script src="' . BASE_URL . 'public/flatlab/' . 'js/respond.min.js"></script><![endif]-->');

Head::instance()->add('<link rel="stylesheet" type="text/css" href="' . BASE_URL . 'public/flatlab/' . 'assets/select2/css/select2.min.css" />');

Head::instance()->add('<script type="text/javascript" > var base_url = "' . BASE_URL . '"; </script>');
Head::instance()->add('<script src="' . BASE_URL . 'public/flatlab/js/jquery.js"></script>');

Head::instance()->load_js('main');

Head::instance()->add('<link rel="icon" sizes="192x192" href="'.BASE_URL.'public/images/phone-icon.png'.'">');