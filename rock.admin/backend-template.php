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
                            case "see_page":
                                $page_body = $this->seePageLook($cmd['pages'], $cmd['page_id']);
                                break;
                            /*
                             * Available moculdes and capabilites 
                             */
                            case "menus":
                                echo "hi there I am going to be a menu";
                                break;
                            /*
                             * Move pages parent or children
                             * This is an Ajax call done behind the scene with jstree $.getJSON function
                             */
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
                            /*
                             * Edit form in main content area
                             */
                            case "edit_page":

                                $this->_forms->EditPageForm($cmd['editor_data'], $cmd['page_id']);
                                break;
                            /*
                             * Pages manu in main content section
                             */
                            case "choose_edit_page":
                                $this->_forms->ListAllPagesOnMainContent($cmd['pages']);
                                break;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>