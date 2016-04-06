<?php
/*
 * This page is the template for the Rock back-end 
 * It gets most of the data from body.php class in $cmd variable array()
 * Do not change the side bar area and main content area.
 */
?>
<!--Side Bar-->
<div class="row">
    <div class="col-lg-12">

        <div class="col-md-2">
            <div class="panel panel-default after-nav-left">
                <div class="panel-heading bg-primary"><?= WEBSITE_NAME ?> Pages</div>
                <div class="panel-body">
                    <?php
                    /*
                     * Get Data from body.php
                     * Set the parent child relationship
                     * Rostom 03/26/2016
                     */
                    $pages_array = array();
                    foreach ($cmd['pages'] as $p) {
                        if (!isset($pages_array[$p['parent']])) {
                            $pages_array[$p['parent']] = array();
                        }
                        $pages_array[$p['parent']][] = $p;
                    }
                    ?>
                    <div id="pages-wrapper">
                        <?php
                        $t = $this->show_pages("0", $pages_array);
                        ?>
                    </div>
                    <p id="event_result"></p>
                </div>
            </div>
        </div>
        <!--Main Content-->
        <div class="col-md-9">
            <div class="panel panel-default after-nav-right">
                <div class="panel-body">
                    <?php
                    if (!isset($cmd['cmd'])) {
                        return false;
                    } else {
                        switch ($cmd['cmd']) {

                            /* ######################
                             * See pages
                             */#####################
                            case "see_page":
                                $page_body = $this->seePageLook($cmd['pages'], $cmd['page_id']);
                                break;
                            /* ##################################
                             * Available moculdes and capabilites 
                             * to be added
                             */##################################
                            case "menus":
                                echo "hi there I am going to be a menu";
                                break;
                            /* #################################
                             * Move pages parent or children
                             * This is an Ajax call done behind the scene with jstree $.getJSON function
                             */################################
                            case "move_page":

                                $tables = array("table1" => "pages");
                                $fields = array(
                                    "field1" => "parent",
                                    "field2" => "id"
                                );

                                $values = array(
                                    "value1" => $cmd['move_data']["2"],
                                    "value2" => $cmd['move_data']["1"]
                                );

                                $move_data = array(
                                    "tables" => $tables,
                                    "fields" => $fields,
                                    "values" => $values
                                );

                                $q = new queries();

                                $q->UpdateQueriesServices($move_data, "1");
                                break;
                            /* ###############################
                             * Edit form in main content area
                             */##############################
                            case "edit_page":


                                /*
                                 * URL OPTIONS
                                 * SHORT
                                 * LONG
                                 */

                                if (isset($_REQUEST['form']['page_edit']['rewrite_url']) && $_REQUEST['form']['page_edit']['rewrite_url'] != '') {

                                    $url_values = array(
                                        "option" => $_REQUEST['form']['page_edit']['url_rewrite'],
                                        "id" => $_REQUEST['form']['page_edit']['id'],
                                        "url_page_id" => $_REQUEST['form']['page_edit']['url_page_id']
                                    );

                                    $URL_OPTIONS = $this->_forms->ReWriteUrl($url_values);

                                    if ($URL_OPTIONS) {
                                        $message = array("message" => "URL Option Updated");
                                        $this->_forms->ReturnMessages($message, $flag = 1);
                                    } else {
                                        $message = array("message" => "Unable to update");
                                        $this->_forms->ReturnMessages($message, $flag = 1);
                                    }
                                }

                                /*
                                 * Upload Images
                                 * 
                                 */
                                if (isset($_REQUEST['form']['page_edit']['douploadimage']) && $_REQUEST['form']['page_edit']['douploadimage'] != '') {


                                    $upload_images = $this->_forms->Do_Upload_images($_POST['form']['page_edit']['douploadimage'], ABSOLUTH_PATH_IMAGE_FRONT_END, DATE_ADDED, $cmd['page_id'], NULL);
                                    if ($upload_images) {
                                        $message = array("message" => "Images Uploaded");
                                        $this->_forms->ReturnMessages($message, $flag = 1);
                                    } else {
                                        $message = array("message" => "Unable to upload image");
                                        $this->_forms->ReturnMessages($message, $flag = 1);
                                    }
                                }
                                /*
                                 * Upload files
                                 */
                                if (isset($_REQUEST['form']['page_edit']['douploadfile']) && $_REQUEST['form']['page_edit']['douploadfile'] != '') {


                                    $upload_files = $this->_forms->Do_Upload_files($_POST['form']['page_edit']['douploadfile'], ABSOLUTH_PATH_FILE_FRONT_END, DATE_ADDED, $cmd['page_id'], NULL);
                                    if ($upload_files) {
                                        $message = array("message" => "File was Uploaded");
                                        $this->_forms->ReturnMessages($message, $flag = 1);
                                    } else {
                                        $message = array("message" => "Unable to upload file");
                                        $this->_forms->ReturnMessages($message, $flag = 1);
                                    }
                                }




                                $this->_forms->EditPageForm($cmd['editor_data'], $cmd['url_options'], $cmd['page_images'], $cmd['page_files'], $cmd['page_id']);
                                break;
                            /* ###################################
                             * Pages manu in main content section
                             */##################################
                            case "choose_edit_page":

                                if ($cmd['message'] != NULL) {

                                    $flag = 1;
                                    $pass_message = $this->_forms->ReturnMessages($cmd['message'], $flag);
                                }

                                $this->_forms->ListAllPagesOnMainContent($cmd['pages']);

                                break;
                            /* #################################################
                             * If clciked to update the page in the pages form
                             */#################################################
                            case "update_page_details":

                                /*
                                 * First We check if the page name is does not exist under the same directory 
                                 */
                                if (isset($cmd['edit_save_page_data']) && $cmd['edit_save_page_data'] != '') {

                                    $name_checked = $this->_forms->setupPagesNames($cmd['edit_save_page_data']);

                                    if ($name_checked) {

                                        $flag = 1;
                                        $message = array("message" => "All names under parent have been updated to be unqiue");

                                        $pass_message = $this->_forms->ReturnMessages($message, $flag);
                                    } else {
                                        $flag = 1;
                                        $message = array("message" => "All names under directory are unique#12");
                                        $pass_message = $this->_forms->ReturnMessages($message, $flag);
                                    }
                                    /*
                                     * If the page is special
                                     * case 1 there must be only a single home page
                                     * check that
                                     * case 2 if the page is not a home page then it can be a hidden page(not shown on navigation)
                                     */
                                    $check_special = $this->_forms->setupSpecialPages($cmd['edit_save_page_data']);
                                    $get_home_page_name = $this->_forms->ReturnvaluesFromFormsFunctions();

                                    $page_name_for_message = (isset($get_home_page_name[0]['name']) && $get_home_page_name[0]['name'] != NULL ? $get_home_page_name[0]['name'] : '');

                                    if ($check_special) {

                                        $flag = 1;
                                        $message = array("message" => "There must at be one home page. {$page_name_for_message} is assigned as home page");
                                        $pass_message = $this->_forms->ReturnMessages($message, $flag);
                                    } else {
                                        $flag = 1;
                                        $message = array("message" => "Home page is assigned as {$page_name_for_message}");
                                        $pass_message = $this->_forms->ReturnMessages($message, $flag);
                                    }
                                    if (isset($cmd['edit_save_page_data'][12]) && $cmd['edit_save_page_data'][12] == "update_page_details") {

                                        $do_update_page = $this->_forms->UpdatePages($cmd['edit_save_page_data'], $type = "update_page_details");

                                        if ($do_update_page) {

                                            $flag = 1;
                                            $message = array("message" => "Page was successfully update!");
                                            $pass_message = $this->_forms->ReturnMessages($message, $flag);
                                        } else {
                                            $flag = 1;
                                            $message = array("message" => "Unable to update page");
                                            $pass_message = $this->_forms->ReturnMessages($message, $flag);
                                        }
                                    } else {
                                        $do_save_page = $this->_forms->UpdatePages($cmd['edit_save_page_data'], $type = "insert_page_details");
                                    }
                                } else {
                                    return false;
                                }




                                /*
                                 * After form is processed
                                 */
//                                $this->_queries->_res = NULL;
//                                $data_for_editor_after_update = $this->_queries->GetData("pages", "id", $cmd['page_id'], "0");
//                                $data_for_editor_after_update = $this->_queries->RetData();
                                $this->_forms->EditPageForm($cmd['editor_data'], $cmd['url_options'], $cmd['page_images'], $cmd['page_files'], $cmd['page_id']);


                                break;

                            /* ##################
                             * Add New page
                             */#################
                            case "add_page":


                                if ($cmd['message'] != NULL) {

                                    $flag = 1;
                                    $pass_message = $this->_forms->ReturnMessages($cmd['message'], $flag);
                                }
                                /*
                                 * pop dialog to add new page
                                 */
                                $this->_forms->AddNewPagePopUp($cmd['pages']);


                                break;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>