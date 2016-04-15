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
        $this->_forms = new forms(); //Forms
        $this->listener = new BackendController(); //BackendController
        $this->queries = new queries(); //queries (MySQL commands)
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
                    /*
                     * Control Modules
                     */
                    if (array_key_exists("Carousel Manager", $topNavBar['Module manager'])) {

                        if (defined('CAROUSEL_MANAGER') && CAROUSEL_MANAGER === "0") {
                            unset($topNavBar['Module manager']['Carousel Manager']);
                        }
                    }
                    if(array_key_exists("Theme Manager", $topNavBar['Module manager'])){
                        if (defined('THEME_MANAGER') && THEME_MANAGER === "0") {
                            unset($topNavBar['Module manager']['Theme Manager']);
                        }
                    }
                    if(array_key_exists("Forms Manager", $topNavBar['Module manager'])){
                        if (defined('FORMS_MANAGER') && FORMS_MANAGER === "0") {
                            unset($topNavBar['Module manager']['Forms Manager']);
                        }
                    }
                    if(array_key_exists("Sells Report", $topNavBar['Reports'])){
                        if (defined('REPORTS') && REPORTS === "0") {
                            unset($topNavBar['Reports']['Sells Report']);
                        }
                    }
                    if(array_key_exists("Google Analytic Report", $topNavBar['Reports'])){
                        if (defined('GAR') && GAR === "0") {
                            unset($topNavBar['Reports']['Google Analytic Report']);
                        }
                    }
                    if(array_key_exists("Page manager", $topNavBar)){
                        if (defined('PAGE_MANAGER') && PAGE_MANAGER === "0") {
                            unset($topNavBar['Page manager']);
                        }
                    }
                    if(count($topNavBar['Module manager']) == 0){
                        unset($topNavBar['Module manager']);
                    }
                    if(count($topNavBar['Reports']) == 0){
                        unset($topNavBar['Reports']);
                    }




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

    /*
     * NOT USED
     */

    public function SideNavbar(array $sideNavBar) {
        $this->_sideNav = $sideNavBar;
        foreach ($this->_sideNav as $side_menu) {
            if (is_array($side_menu)) {
                
            } else {
                
            }
        }
    }

    /*
     * Page static content top navigation(i.e modules)
     */

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
                if (isset($_REQUEST['do_delete_page'])) {
                    $flag = 1;
                    $page_id = $_REQUEST['p_id'];
                    $parent_id = $_REQUEST['page_parent'];
                    $process_delete_data = array(
                        $page_id,
                        $parent_id
                    );
                    $page_to_delete = $this->_forms->DoDeleteSelectedPage($process_delete_data);
                    $page_to_delete = $this->_forms->RET_MESSAGE_TO();
                    if ($page_to_delete != NULL) {
                        $message['message'] = $page_to_delete['message'];
                    }
                }

                /*
                 * page data
                 */
                $this->queries->_res = NULL;
                $data_for_side_bar = $this->queries->GetData("pages", NULL, NULL, "3");
                $data_for_side_bar = $this->queries->RetData();




                if (isset($_REQUEST['form']['add_new_page']['do_add_new_page'])) {

                    $do_add_new_page = $this->_forms->DoAddNewPage($_REQUEST, $data_for_side_bar);
                    $do_add_new_page = $this->_forms->RET_MESSAGE_TO();
                    if ($do_add_new_page != NULL) {
                        $message['message'] = $do_add_new_page['message'];
                    }
                }






                /*
                 * Login
                 * OR
                 * Any command variable passed through which will be analyzed 
                 * in back-end template
                 * logic
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
                /*
                 * Data for page editor form 
                 */

                $data_for_editor = array();
                $get_url_option_info = array();
                $get_all_page_images = array();
                $get_all_page_files = array();


                /*
                 * Editor main data
                 */
                $this->queries->_res = NULL;
                $data_for_editor = $this->queries->GetData("pages", "id", $page_id, "0");
                if ($data_for_editor) {
                    $data_for_editor = $this->queries->RetData();
                } else {
                    $data_for_editor = array();
                }
                /*
                 * Url Option Data
                 */
                $this->queries->_res = NULL;
                $get_url_option_info = $this->queries->GetData("url_options", "page_id", $page_id, "0");
                if ($get_url_option_info) {
                    $get_url_option_info = $this->queries->RetData();
                } else {
                    $get_url_option_info = array();
                }

                /*
                 * Images for each page data
                 */
                $this->queries->_res = NULL;
                $get_all_page_images = $this->queries->GetData("page_images", "page_id", $page_id, "0");
                if ($get_all_page_images) {
                    $get_all_page_images = $this->queries->RetData();
                } else {
                    $get_all_page_images = array();
                }

                /*
                 * Associated files for each page data
                 */
                $this->queries->_res = NULL;
                $get_all_page_files = $this->queries->GetData("page_files", "page_id", $page_id, "0");
                if (is_array($get_all_page_files) ? $get_all_page_files : array("3")) {
                    $get_all_page_files = $this->queries->RetData();
                } else {
                    $get_all_page_files = array();
                }

                /*
                 * Get Data for item page
                 */
                $this->queries->_res = NULL;
                $get_data_for_items = $this->queries->GetData("products", "product_id", $page_id, "0");
                if ($get_data_for_items) {
                    $get_data_for_items = $this->queries->RetData();
                } else {
                    $get_data_for_items = array();
                }
                                /*
                 * Get Data for social media
                 */
                $this->queries->_res = NULL;
                $get_data_for_social_media = $this->queries->GetData("social_media", NULL, NULL, "7");
              
                if ($get_data_for_social_media) {
                    $get_data_for_social_media = $this->queries->RetData();
                   
                } else {
                    $get_data_for_social_media = array();
                }



                /*
                 * Edit or save page
                 * Get data from Request
                 */
                if (isset($_REQUEST['form']['page_edit']['action'])) {
                    $edit_save_command = str_replace(' ', '_', strtolower($_REQUEST['form']['page_edit']['action']));
                    $command = ($_REQUEST['form']['page_edit']['action']) ? $edit_save_command : 'edit_page';
                    /*
                     * Changes the command when the edit button in the form is clicked
                     */
                    $_REQUEST['cmd'] = $command;
                    $page_name = trim($_REQUEST['form']['page_edit']['page_name']);
                    $page_title = trim($_REQUEST['form']['page_edit']['page_title']);
                    $page_type = trim($_REQUEST['form']['page_edit']['type']);
                    $page_n_id = trim((int) $_REQUEST['form']['page_edit']['id']);
                    $page_parent = trim((int) $_REQUEST['form']['page_edit']['parent']);
                    $page_ass_date = trim($_REQUEST['form']['page_edit']['associated_date']);
                    $page_content = $_REQUEST['form']['page_edit']['content'];
                    $page_advanced_options_keywords = $_REQUEST['form']['page_edit']['keywords'];
                    $page_advanced_options_description = $_REQUEST['form']['page_edit']['description'];
                    $page_advanced_options_homepage = (isset($_REQUEST['form']['page_edit']['is_homepage']) ? $_REQUEST['form']['page_edit']['is_homepage'] : '');
                    $page_advanced_options_hidden = (isset($_REQUEST['form']['page_edit']['is_hidden']) ? $_REQUEST['form']['page_edit']['is_hidden'] : '');
                    $page_advanced_options_pages_vars_array = (isset($_REQUEST['form']['page_edit']['page_vars']) ? json_encode($_REQUEST['form']['page_edit']['page_vars']) : '[]');


                    /*
                     * put all the variables into array and pass it to listener in BackendController
                     * else pass a empty string
                     */
                    $page_data_array = array(
                        $page_name, //[0]->name string
                        $page_title, //[1]->title string
                        $page_type, //[2]->type string
                        $page_n_id, //[3]->id string
                        $page_parent, //[4]->parent string
                        $page_ass_date, //[5]-> associated_date string
                        $page_content, //[6]-> content string
                        $page_advanced_options_keywords, //[7]->keywords (Must use commas as delimiter)
                        $page_advanced_options_description, //[8]->description string
                        $page_advanced_options_homepage, //[9]-> is Homapage or not
                        $page_advanced_options_hidden, //[10]-> is hidden page (not showing in navigation
                        $page_advanced_options_pages_vars_array, //[11]->json format
                        $edit_save_command //[12] request type edit or save
                    );
                } else {
                    $page_data_array = "";
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
                    "url_options" => $get_url_option_info,
                    "page_images" => $get_all_page_images,
                    "page_files" => $get_all_page_files,
                    "edit_save_page_data" => $page_data_array,
                    "message" => (isset($message) ? $message : ""),
                    "item_page_data" => $get_data_for_items,
                    "social_media" => $get_data_for_social_media
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
        