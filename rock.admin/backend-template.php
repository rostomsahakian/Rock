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
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>