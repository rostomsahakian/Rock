<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of main
 *
 * @author rostom
 */
class main {
    /*
     * Public, private, and proteced methods go here
     */

    public $_header;
    public $_body;
    public $_footer;
    public $_pageTitle;
    public $_forms;

    /*
     * Control Constructor
     */

    public function __construct() {
        $this->_forms = new forms();
        $this->_header = new header();
        $this->_body = new body();
        $this->_footer = new footer();

        echo $this->Loadheader();

        if (!isset($_SESSION['logged_in']) && (defined('TEST_ENVIRONMENT') && TEST_ENVIRONMENT === false)) {
            
        } else {
            echo $this->LoadBody();
        }

        echo $this->LoadFooter();
    }

    /*
     * @auth: Rostom
     * Desc: Loads the header
     */

    public function Loadheader() {
        /*
         * Add page title, CSS links, JavaScript, meta tags links here for the backend
         */
        $this->_pageTitle = (isset($_POST['page_title']) ? $_POST['page_title'] : "Rock-Content Management System");
        $header_data = array(
            "page_title" => $this->_pageTitle,
            "meta_tags" => array(
                "1" => '<meta charset="utf-8" />',
                "2" => '<meta http-equiv="X-UA-Compatible" content="IE=edge">',
                "3" => ' <meta name="viewport" content="width=device-width, initial-scale=1">'
            ),
            "css_links" => array(
                "1" => '<link href="' . ABSOLUTH_PATH_CSS . 'bootstrap.min.css" rel="stylesheet">',
                "2" => '<link rel="stylesheet" type="text/css" href="' . ABSOLUTH_PATH_CSS . 'styles.css"/>',
                "3" => '<link rel="stylesheet" href="' . ABSOLUTH_PATH_JS . 'dist/themes/default/style.min.css" />'
            ),
            "js_links" => array(
                "1" => '    <!-- jQuery (necessary for Bootstrap\'s JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>',
                "2" => '  <script src="' . ABSOLUTH_PATH_ADMIN . '/pages/menu.js"></script>'
            ),
        );

        $head = $this->_header->SetHeader($header_data);
        $head = $this->_header->GetHeader();
    }

    /*
     * @auth: Rostom
     * Desc: Loads the Body
     */

    public function LoadBody() {

        /*
         * Static Content Of the CMS (i.e nav on top and side)
         */

        /* !Important
         * Declare Navigations below 
         */
        $top_nav = array(
            "Home" => "/rock.admin/?cmd=menus&option=true",
            "Page manager" => array(
                "Add New Page" => array(
                    "link" => "/rock.admin/?cmd=add_page&option=true",
                    "class" => "glyphicon glyphicon-plus",
                    "badge" => ""
                ),
                "Edit Pages" => array(
                    "link" => "/rock.admin/?cmd=edit_page&option=true",
                    "class" => "glyphicon glyphicon-pencil",
                    "badge" => ""
                )
            ),
            "Contact Manager" => "/rock.admin/?cmd=con_man&option=true",
            "Modules Manager" => "/rock.admin/?cmd=con_man&option=true",
            "Stuck Manager" => "/rock.admin/?cmd=con_man&option=true",
            "Reports" => array(
                "Sells Report" => array(
                    "link" => "/rock.admin/?cmd=add_pages&option=true",
                    "class" => "glyphicon glyphicon-usd",
                    "badge" => ""
                ),
                "Google Analytic Report" => array(
                    "link" => "/rock.admin/?cmd=add_pages&option=true",
                    "class" => "glyphicon glyphicon-open-file",
                    "badge" => ""
                ),
            ),
            "Account" => array(
                "Profile" => array(
                    "link" => "profile",
                    "class" => "glyphicon glyphicon-user",
                    "badge" => ""
                ),
                "Settings" => array(
                    "link" => "settings",
                    "class" => "glyphicon glyphicon-cog",
                    "badge" => ""
                ),
                "Messages" => array(
                    "link" => "messages",
                    "class" => "glyphicon glyphicon-envelope",
                    "badge" => "badge"
                ),
                "Log out" => array(
                    "link" => "/rock.includes/logout.php?redirect=/rock.admin/",
                    "class" => "glyphicon glyphicon-minus-sign",
                    "badge" => ""
                )
            )
        );
        $side_nav = array(
        );
        /*
         * Navigation
         */
        $this->_body->BodyStaticContent();
        $this->_body->TopNavBar($top_nav);

        /*
         * Dynamic contnet
         */
        $this->_body->BodyDynamicContent();
        ?>


        <?php

    }

    /*
     * @auth: Rsotom
     * Desc: Loads the footer
     */

    public function LoadFooter() {
        /*
         * Add links and other things for footer backend
         */
        $footer_data = array(
            "links" => "control.php#back",
            "rights" => "GrowARock.com All Rigths Reserved" . date("Y"),
            "js" => array(
                "1" => '<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>',
                "3" => '<script src="' . ABSOLUTH_PATH_JS . 'bootstrap.min.js"></script>',
                "4" => " ",
            ),
        );

        $footer = $this->_footer->GetFooter($footer_data);
        $footer = $this->_footer->SetFooter();
    }

}

$rock_back_end = new main();
