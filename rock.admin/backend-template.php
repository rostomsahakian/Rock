<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
                            case "menus":
                                echo "hi there i am going to be a menu";
                                break;
                            case "move_page":
                                var_dump($cmd['move_data']['order']);
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
                                for ($i = 0; $i < count($cmd['move_data']['order']); $i++)
                                    $pid = $cmd["move_data"][$i];
                                $update_fields = array(
                                    "field1" => "ord",
                                    "field2" => "id"
                                );
                                $update_values = array(
                                    "value1" => $i,
                                    "value2" => $pid
                                );
                                $order_update = array(
                                    "tables" => $tables,
                                    "fields" => $update_fields,
                                    "values" => $update_values
                                );
                                $q->UpdateQueriesServices($order_update, $option = "1");
                                echo "done";

                                break;
                            case "edit_page":
                               
                                $this->_forms->EditPageForm($cmd['editor_data'], $cmd['page_id']);
                                break;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>