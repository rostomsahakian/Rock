<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Choosepages
 *
 * @author rostom
 */
class Choosepages {

    public $_queries;
    public $_pageType;
    public $_child_count;
    public $_children_data = array();

    public function __construct() {
        $this->_queries = new queries();

        if (isset($_REQUEST['delete_page'])) {

            $this->AskQuestion($_REQUEST['del_page_id']);
        }
        if (isset($_REQUEST['warn']) && $_REQUEST['warn'] == "Yes") {
            $this->DeleteRecursivePages($_REQUEST['del_page_id']);
            $page_to_delete = array(
                "table" => "pages",
                "field1" => "id",
                "value1" => $_REQUEST['del_page_id']
            );
            $delete_main_page = $this->_queries->DeleteServices($page_to_delete, $option = "2");
        }
    }

    public function DoShowTopLevelPages($parent = "0") {
        /*
         * When the option is clicked show the top level pages first
         */
        if ($parent == "0") {
            $this->_queries->_res = NULL;
            $get_top_level_pages = $this->_queries->GetData("pages", "parent", "0", "0");
            $get_top_level_pages = $this->_queries->RetData();
        } else {
            $get_top_level_pages = $this->EditImidiateChildren($parent);
            $get_top_level_pages = $this->ReturnPageChildData();
        }
        if (count($get_top_level_pages) > 0) {
            ?>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                        Select a page for Editing 
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>Order</th>
                                <th>ID#</th>
                                <th>Name</th>
                                <th>Parent</th>
                                <th>Type</th>
                                <th>Children</th>
                                <th>Created Date</th>
                                <th>Delete</th>
                                <th>Edit</th>
                            </tr>
                            <?php
                            foreach ($get_top_level_pages as $top_levels) {
                                ?>

                                <tr>
                                    <?php
                                    /*
                                     * The order of pages
                                     */
                                    ?>
                                    <!--Page order-->
                                    <td></td>
                                    <td><?= $top_levels['id'] ?></td>
                                    <td><?= $top_levels['name'] ?></td>
                                    <td><?= $top_levels['parent'] ?></td>
                                    <?php
                                    /*
                                     * here get the page types and translate it to english
                                     *
                                     * Write a function that does this 
                                     */
                                    $this->TranslatePageType($top_levels['type']);
                                    ?>
                                    <td>
                                        <?= $this->ReturnTranslatedPageType(); ?>
                                    </td>
                                    <?php
                                    /*
                                     * Here we need to find the number of children each page has
                                     */
                                    $this->FindAllChildrenOfPage($top_levels['id'], $top_levels['type'], $top_levels['parent'], $top_levels['name']);
                                    ?>
                                    <td><?php
                                        $link_to_children_pages = '';
                                        if ($this->ReturnChildCount() != "0") {

                                            $link_to_children_pages = '<a href="?cmd=choose_edit_page&option=true&edit_subs=sp&parent=' . $top_levels['id'] . '">' . $this->ReturnChildCount() . '</a>';
                                        } else {
                                            $link_to_children_pages = $this->ReturnChildCount();
                                        }
                                        echo $link_to_children_pages;
                                        ?>
                                    </td>
                                    <td><?= $top_levels['cdate'] ?></td>
                                    <?php
                                    /*
                                     * Put a form here for delete
                                     * Important do not forget if the page is top level and has children delete recursively
                                     * Ask question before delete
                                     */
                                    ?>
                                    <td>

                                        <form method="post">
                                            <input type="hidden" name="cmd" value="choose_edit_page"/>
                                            <input type="hidden" name="del_page_id" value="<?= $top_levels['id'] ?>"/>
                                            <input type="submit" name="delete_page" value="Delete" class="btn btn-danger btn-xs"/>
                                        </form>
                                    </td>
                                    <td><a href="?cmd=edit_page&option=edit&page_id=<?= $top_levels['id'] ?>" class="btn btn-primary btn-xs">Edit</a></td>

                                </tr>
                                <?php
                            }
                            ?>

                        </table>
                    </div>
                </div>
            </div>

            <?php
        }
    }

    public function DoSelectPageToEdit($page_id) {

        if (isset($page_id)) {
            /*
             * get the page id
             */
        }
    }

    /*
     * translates the page types from db which are in numeric shape
     */

    public function TranslatePageType($page_type) {

        if ($page_type == "0") {
            $this->_pageType = "Home";
        } else if ($page_type == "1") {
            $this->_pageType = "Sub-Menu";
        } else if ($page_type == "3") {
            $this->_pageType = "Category";
        } else if ($page_type == "5") {
            $this->_pageType = "Sub-Category";
        } else if ($page_type == "7") {
            $this->_pageType = "Item Page";
        } else if ($page_type == "9") {
            $this->_pageType = "Brand";
        } else if ($page_type == "11") {
            $this->_pageType = "Static";
        } else if ($page_type == "13") {
            $this->_pageType = "Contact Us";
        } else if ($page_type == "15") {
            $this->_pageType = "hidden";
        } else if ($page_type == "17") {
            $this->_pageType = "Brands-Main";
        } else if ($page_type == "19") {
            $this->_pageType = "Hidden-all";
        } else if ($page_type == "21") {
            $this->_pageType = "Home-Alt";
        }
    }

    /*
     * returns the translated page type
     */

    public function ReturnTranslatedPageType() {
        return $this->_pageType;
    }

    /*
     * Finds the children of the top page and return the count 
     */

    public function FindAllChildrenOfPage($page_id, $page_type, $page_parent, $page_name) {
        /*
         * Find all its children and count them
         */
        $data = array(
            "table" => "pages",
            "field" => "parent",
            "value" => $page_id
        );
        $option = 2;
        $this->_queries->_res = NULL;
        $get_children_count = $this->_queries->findChildren($data, $option);
        $get_children_count = $this->_queries->RetData();
        if (count($get_children_count) > 0) {
            $this->_child_count = count($get_children_count);
        } else {
            /*
             * If child count is zero check in the product table to see if there are anything matching this page name 
             * if page type is 5 get the parent name then look for it in the all_products page
             */

            if ($page_type == "5") {
                $this->_queries->_res = NULL;
                $data = array(
                    "table" => "pages",
                    "select" => "name",
                    "field" => "id",
                    "value" => $page_parent
                );

                $this->_queries->_parent = NULL;
                $get_parents = $this->_queries->findParent($data, $option = "1");
                if (count($get_parents) > 0) {
                    $parent_info = array();


                    if ($get_parents[1]['type'] == "9") {

                        $gender = $get_parents[0]['name'];
                        $brand = $get_parents[1]['name'];
                        $fields = array(
                            "field1" => "brand",
                            "field2" => "category",
                            "field3" => "gender"
                        );
                        $values = array(
                            "value1" => $brand,
                            "value2" => $page_name,
                            "value3" => $gender
                        );
                        $this->_queries->_res = NULL;
                        $find_products = $this->_queries->GetData("all_products", $fields, $values, $option = "14");
                        $find_products = $this->_queries->RetData();

                        $this->_child_count = count($find_products);
                    } else {

                        $this->_queries->_res = NULL;
                        $get_parent_name = $this->_queries->GetData("pages", "id", $page_parent, "0");
                        $get_parent_name = $this->_queries->RetData();

                        // var_dump($get_parent_name);

                        $this->_child_count = 0;
                    }
                }
            } else {
                $this->_child_count = 0;
            }
        }
    }

    /*
     * Returns the count for FindAllChildrenofPage 
     */

    public function ReturnChildCount() {
        return $this->_child_count;
    }

    public function EditImidiateChildren($parent_id) {

        $this->_queries->_res = NULL;
        $imidiate_children = $this->_queries->GetData("pages", "parent", $parent_id, "0");
        $imidiate_children = $this->_queries->RetData();
        if (count($imidiate_children) > 0) {
            $this->_children_data = $imidiate_children;
        }
    }

    public function ReturnPageChildData() {
        return $this->_children_data;
    }

    public function DeleteRecursivePages($page_id) {
        /*
         * Delete from Pages 
         * 1. Find all its children
         */

        $data = array(
            "table" => "pages",
            "field" => "parent",
            "value" => $page_id
        );
        $option = 2;
        $this->_queries->_res = NULL;
        $get_children_count = $this->_queries->findChildren($data, $option);
        $get_children_count = $this->_queries->RetData();
        if (count($get_children_count) > 0) {

            foreach ($get_children_count as $child_page_to_del) {
                $to_delete = array(
                    "table" => "pages",
                    "field1" => "id",
                    "value1" => $child_page_to_del['id']
                );
                $delete_child_pages = $this->_queries->DeleteServices($to_delete, $option = "2");


                if ($delete_child_pages) {
                    
                }
            }
        } else {
            
        }
    }

    public function AskQuestion($page_id) {
        ?>
        <div class="col-md-12" style="margin-top: 65px;">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        Warning
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <p>This will delete all associated pages under this page. Are you sure?</p>
                            <input type="hidden" name="del_page_id" value="<?= $page_id ?>"/>
                            <div class="btn-group" role="group">

                                <input type="submit" name="warn" value="No" class="btn btn-success"/>
                                <input type="submit" name="warn" value="Yes" class="btn btn-danger"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        <?php
    }

}
