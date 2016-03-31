<?php

/**
 * Description of body
 *
 * @author rostom
 */
class body {

    public $_sContent;
    public $_dContent;
    private $_topNav = array();
    private $_sideNav = array();
    private $_navigation1;
    public $_forms;
    public $listener;
    public $queries;

    public function __construct() {
        $this->_forms = new forms();
        $this->listener = new BackendController();
        $this->queries = new queries();
    }

    public function TopNavBar(array $topNavBar) {
        $this->_navigation1 = "";
        if (!isset($_SESSION['userdata'])) {
            ?>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right"></ul></div></div></div></nav>
            <?php
        } else {
            ?>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    $this->_topNav = $topNavBar;

                    foreach ($this->_topNav as $key => $top_menu) {
                        if (is_array($top_menu)) {
                            ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $key ?><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php
                                    foreach ($top_menu as $k => $drop_items) {
                                        ?>
                                        <li ><a href="<?= $drop_items['link'] ?>"><i class="<?= $drop_items['class'] ?>"></i>  <?= $k; ?>&nbsp;&nbsp;<span class="<?= $drop_items['badge'] ?>"><?php if ($drop_items['badge'] != "") echo "0" ?></span></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li class="dropdown"><a href="<?= $top_menu ?>"><?= $key; ?></a></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            </div>
            </nav>


            <?php
        }
    }

    public function ReturnNavigationTop() {
        return $this->_navigation1;
    }

    public function SideNavbar(array $sideNavBar) {
        $this->_sideNav = $sideNavBar;
        foreach ($this->_sideNav as $side_menu) {
            if (is_array($side_menu)) {
                
            } else {
                
            }
        }
    }

    public function BodyStaticContent() {
        ?>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Rock CMS <?= date("Y"); ?></a>
                </div>

                <?php
                echo $this->ReturnNavigationTop();
                ?>


                <?php
            }
            /*
             * @athur: Rostom
             * Desc: All dynamic content will pass through here then to class BackendController::controller
             * then class BackendController::controller transmits
             */
            public function BodyDynamicContent() {
                ?>



                <?php
                /*
                 * listener listens to the command and executes
                 */
                /*
                 * If user needs to change the order of page this should be where we process the data for cleaness
                 * the sned it to form processor in class forms
                 * This put here so when the GetData is called it will fetch the latest data from table. 
                 * increases the speed
                 */

                if ((isset($_REQUEST['new_order']) && is_numeric($_REQUEST['new_order']) && $_REQUEST['new_order'] != '' && $_REQUEST['new_order'] != $_REQUEST['old_order'])) {
                    $change_order_number = $_REQUEST['new_order'];
                    $change_order_number_old = $_REQUEST['old_order'];
                    $change_order_page_id = $_REQUEST['page_id'];
                    $change_order_parent_id = $_REQUEST['parent'];
                    $order_processor_data = array(
                        $change_order_number,
                        $change_order_number_old,
                        $change_order_page_id,
                        $change_order_parent_id
                    );
                    $this->_forms->DoUpdateOrderForPages($order_processor_data);
                }

                /*
                 * page data
                 */
                $this->queries->_res = NULL;
                $data_for_side_bar = $this->queries->GetData("pages", NULL, NULL, "3");
                $data_for_side_bar = $this->queries->RetData();

                /*
                 * Login
                 */
                $command = (isset($_REQUEST['cmd']) ? $_REQUEST['cmd'] : 'login');
                $option = (isset($_REQUEST['option']) ? $_REQUEST['option'] : 'true');
                $page_id = (isset($_REQUEST['page_id']) ? $_REQUEST['page_id'] : '');

                /*
                 * For moving pages jstree
                 */
                $move_page_id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : '');
                $to = (isset($_REQUEST['parent_id']) ? $_REQUEST['parent_id'] : '');
                $order = explode(",", (isset($_REQUEST['order']) ? $_REQUEST['order'] : ''));


                /*
                 * Moves the pages to different parent jsTree
                 * Changes the order of pages 
                 * More work needed 03/28/2016 @1625
                 */
                $move_data = array(
                    "1" => $move_page_id,
                    "2" => $to,
                    "order" => $order);

                $this->queries->_res = NULL;
                $data_for_editor = $this->queries->GetData("pages", "id", $page_id, "0");
                if ($data_for_editor) {
                    $data_for_editor = $this->queries->RetData();
                } else {
                    return false;
                }
                /*
                 * Edit or save page
                 * Get data from Request
                 */
                if (isset($_REQUEST['form']['page_edit']['action'])) {

                    $page_name = trim($_REQUEST['form']['page_edit']['page_name']);
                    $page_title = trim($_REQUEST['form']['page_edit']['page_title']);
                    $page_type = trim($_REQUEST['form']['page_edit']['type']);
                    $page_parent = trim($_REQUEST['form']['page_edit']['parent']);
                    $page_ass_date = trim($_REQUEST['form']['page_edit']['associated_date']);
                    $page_content = $_REQUEST['form']['page_edit']['content'];
                    $page_advanced_options_keywords = $_REQUEST['form']['page_edit']['keywords'];
                    $page_advanced_options_description = $_REQUEST['form']['page_edit']['description'];
                    $page_advanced_options_homepage = (isset($_REQUEST['form']['page_edit']['is_homepage']) ? $_REQUEST['form']['page_edit']['is_homepage'] : '');
                    $page_advanced_options_hidden = (isset($_REQUEST['form']['page_edit']['is_hidden']) ? $_REQUEST['form']['page_edit']['is_hidden'] : '');

                }


                ################################################
                /* -----------Logical Controller---------------*\
                  ################################################
                  /*
                 * Controls the backend accoring to command
                 */
                $cmd = array(
                    "option" => $option,
                    "cmd" => $command,
                    "pages" => $data_for_side_bar,
                    "page_id" => $page_id,
                    "move_data" => $move_data,
                    "editor_data" => $data_for_editor,
                );
                $this->listener->controller($cmd);
                /*
                 * DO NOT REMOVE
                 */
                #################################################
                ?>








                <?php
            }

        }
        