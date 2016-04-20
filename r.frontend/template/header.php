<?php
//include_once '../../rock.classes/Page.php';
?>
<!DOCTYPE html>
<html lang="en" >
    <head>
        <?php
        $title = ($page_title != '') ? $page_title : str_replace('www.', '', $_SERVER['HTTP_HOST']) . '>' . $page_name;
        $metadata = '<title>' . htmlspecialchars($title) . '</title>';
        $metadata.='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';
//        if ($PAGEDATA->keywords != NULL) {
//            $metadata .= '<meta http-equiv="keywords" content="' . htmlspecialchars($PAGEDATA->keywords) . '"/>';
//            if ($PAGEDATA->description != NULL) {
//                $metadata .='<meta http-equiv="description" content="' . htmlspecialchars($PAGEDATA->description) . '"/>';
//            }
//        }
        //var_dump($PAGEDATA->_files);






        echo $metadata;
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php
        $navjs = "/r.frontend/js/script.js";
        $maincCSS = "/r.frontend/css/page_styles.css";
        $navcss = "/r.frontend/css/styles.css";
        $css = array();
        $js = array();
//        if ($PAGEDATA->_files != NULL) {
//            foreach ($PAGEDATA->_files as $files) {
//                if ($files['file_extension'] == "css") {
//                    $css[] = $files['file_path'] . $files['file_name'];
//
////                $smarty->assign('CSS', $css);
//                } else if ($files['file_extension'] == "js") {
//
//                    $js[] = $files['file_path'] . $files['file_name'];
////                $smarty->assign('JS', $js);
//                } else {
//                    $files = array();
//                }
//            }
//            foreach ($css as $styles) {
//                
        ?>

        <?php
//            }
//            foreach ($js as $javascripts) {
//                
        ?>

        <?php
//            }
//        }
        ?>
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>       
        <link rel="stylesheet" href="<?= ABSOLUTH_PATH_FRONTEND_CSS ?>bootstrap.min.css" type="text/css"/>
        <link rel="stylesheet" href="<?= ABSOLUTH_PATH_OWL_CAR ?>owl.carousel.css" type="text/css"/>
        <link rel="stylesheet" href="<?= ABSOLUTH_PATH_OWL_CAR ?>owl.theme.css" type="text/css"/>
        <script src="<?= ABSOLUTH_PATH_OWL_CAR ?>owl.carousel.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="<?php // $navcss ?>" />
        <link rel="stylesheet" href="<?= $maincCSS ?>" />
        <link href="/r.frontend/css/megamenu.css" rel="stylesheet"/>
        <link href="web/css/style.css" rel="stylesheet" type="text/css" media="all"/>
        <link href="web/css/slider.css" rel="stylesheet" type="text/css" media="all"/>
        <script type="text/javascript" src="web/js/jquery-1.7.2.min.js"></script> 
        <script type="text/javascript" src="web/js/move-top.js"></script>
        <script type="text/javascript" src="web/js/easing.js"></script>
        <script type="text/javascript" src="web/js/startstop-slider.js"></script>
        <script src="<?= $navjs ?>" type="text/javascript"></script>
        <script src="/r.frontend/js/jquery.zoom.js"></script>
<!--        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>-->

        <style>


            #owl-demo .item img{
                display: block;
                width: 100%;
                height: auto;
            }
            #bar{
                width: 0%;
                max-width: 100%;
                height: 4px;
                background: #E21A2C;
            }
            #progressBar{
                width: 100%;
                background: #EDEDED;
            }
    img { border:3px solid #fff;}
        .jzoom {
            position: absolute;
            top: 250px;
            left: 100px;
            width: 350px;
            height: 350px;
        }

        </style>
        <!--ATTENTION--->
        <!--THIS IS WHERE YOU CAN CHANGE THE MAGNIFICATION OF ZOOM ON ITEM PAGE-->
        <script>
		$(document).ready(function(){
			$('#ex1').zoom({magnify: '1.5'});
			
		});
	</script>
        <!--DO NOT REMOVE -->
    </head>

    <body >
            <nav class="navbar navbar-default navbar-fixed-top rock-top-banner">
                <div class="container">
                    <div>
                        <ul class="nav navbar-nav">
                            <li ><a href="#">login</a></li>
                            <li><a href="#about">sign up</a></li>

                        </ul>
                    </div>
                </div>
            </nav>
       
        <!-- Logo and search and social media go here-->
            <div class="container rock-mid-bar-container">
                <div class="clear-fix"></div>
                <div class="col-lg-12">
                    <div class="col-lg-4" style="vertical-align:top !important; padding-bottom: 10px;">
                        <!--Logo-->
                        <center>
                            <img src="/r.frontend/logo_grow.png" alt=""  style="width: auto;"/>
                        </center>
                    </div>
                    <div class="col-lg-4 ">
                        <!--Search-->
                       <!-- /.col-lg-6 -->
                        <div class="col-md-12">
                            <div class="input-group ">
                                <input type="text" class="form-control pull-right" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-danger rock-search-btn" type="button">Go!</button>
                                </span>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                    </div>
                    <div class="col-lg-4" style="margin-top: 10px; margin-bottom: 10px;">
                        <center>
                            <!--Social Media-->
                            
                                <div class="btn-group">
                                    <?php
                                    $social_media = $PAGEDATA->SetSocialMedia();
                                    $social_media = $PAGEDATA->getSocialMedia();
                                    if ($social_media != NULL) {
                                        foreach ($social_media as $sm) {
                                            ?> 
                                            <a href="<?= $sm['url'] ?>" alt="Social Media Icons" title="<?= $sm['image_name'] ?>" target="_blank"><img src="<?= $sm['image_url'] . "/" . $sm['image_name'] ?>" alt="" height="30" width="30"/></a>

                                            <?php
                                        }
                                    }
                                    ?>

                                </div>
                           
                            <!-- Shopping cart info goes here -->
                            <div class="row rock-shopping-cart">
                                <a href="#">My cart (0)</a> <i class="glyphicon glyphicon-shopping-cart"></i>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        <!--End of mid bar-->
        <!-- Navigation Begins-->
        <div class="rock-background-color-manager">
            <div class="rock-nav-bar-container">
                <div class="container">
<!--                    main Navigation-->
                   
                        <?php
                        $nav = new Navigation();
//                        echo $nav->showNavigation(0, NULL);
                        echo $nav->MegaNavigationMenu();
                        ?>

                    </div>
                </div><!--
            </div>-->
            <!--Breadcrumb goas here-->

            
                <div class="container">
                    <ol class="breadcrumb rock-breadcrumb">
                        <?php
                        ?>
                        <li ></li>
                        <?php
                        ?>


                    </ol>
                </div>
        