<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Navigation
 *
 * @author rostom
 */
class Navigation {

    public $queries;
    public $forms;
    public $_url;
    public $_children;

    public function __construct() {
        $this->queries = new queries();
        $this->forms = new forms();
//$this->GetNavUrls();
    }

    public function GetNavUrls() {

        $request = "0";
        $categories = array();
        $this->queries->_res = NULL;
        $get_parents = $this->queries->GetData("pages", "parent", $request, "0");
        $get_parents = $this->queries->RetData();
        if (count($get_parents) > 0) {
            foreach ($get_parents as $parent) {

                $data = array(
                    "table" => "pages",
                    "field" => "parent",
                    "value" => $parent['id']
                );

                $category = array();

                $category['id'] = $parent['id'];
                $category['name'] = $parent['name'];
                $category['parent'] = $parent['parent'];
                $category['type'] = $parent['type'];
                if ($this->HasChild($parent['id'])) {
                    $category['sub_categories'] = array();
                }
                $values = array(
                    "value1" => $parent['id'],
                    "value2" => "ord"
                );
                $this->queries->_res = NULL;
                $get_children = $this->queries->GetData("pages", "parent", $values, "21");
                $get_children = $this->queries->RetData();
                if (count($get_children) > 0) {
                    if ($parent['id'] != "1") {
                        foreach ($get_children as $child) {
                            if ($parent['id'] == $child['parent']) {

                                $subcat = array();
                                $subcat['id'] = $child['id'];
                                $subcat['name'] = $child['name'];
                                $subcat['parent'] = $child['parent'];

                                array_push($category['sub_categories'], $subcat);
                            }
                        }
                    }
                }
                array_push($categories, $category);
            }
//            $json = json_encode($categories);
//            header('Content-Type: application/json');
//            echo $json;
            return $categories;
        }
    }

    public function breadcrumbs($separator = ' » ', $home = 'Home') {

        $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
        $base_url = substr($_SERVER['SERVER_PROTOCOL'], 0, strpos($_SERVER['SERVER_PROTOCOL'], '/')) . '://' . $_SERVER['HTTP_HOST'] . '/';
        $breadcrumbs = array("<a href='$base_url'>$home</a>");
        $tmp = array_keys($path);
        $last = end($tmp);
        unset($tmp);

        foreach ($path as $x => $crumb) {
            $title = ucwords(str_replace(array('.php', '_'), array('', ' '), $crumb));
            if ($x == 1) {
                $breadcrumbs[] = "<a href='$base_url$crumb'>$title</a>";
            } else if ($x > 1 && $x < $last) {
                $tmp = "for($i = 1; $i <= $x; $i++){
    
             $tmp .= $path[$i] . '/'";


                $tmp .= "\">$title";
                $breadcrumbs[] = $tmp;
                unset($tmp);
            } else {
                $breadcrumbs[] = "$title";
            }
        }

        return implode($separator, $breadcrumbs);
    }

    public function GetUrl($page_id) {
        $this->queries->_res = NULL;
        $get_url = $this->queries->GetData("page_urls", NULL, NULL, $option = "7");
        $get_url = $this->queries->RetData();

        foreach ($get_url as $url) {
            if ($url['page_id'] == $page_id) {
                $this->_url = $url['long_url'];
            }
        }
    }

    public function RetUrl() {
        return $this->_url;
    }

    public function MegaNavigationMenu() {
        ?>
        <!-- Static navbar -->
        <nav class="navbar navbar-default megamenu">
            <div class="container-fluid">
                <div class="col-sm-12">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <?php
                            foreach ($this->GetNavUrls() as $no_child) {

                                if (!array_key_exists("sub_categories", $no_child)) {

                                    $this->GetUrl($no_child['id']);
                                    if ($no_child['parent'] == 0 || $no_child['parent'] == "0") {
                                        $page_id_ext = "";
                                    } else {
                                        $page_id_ext = "/" . $no_child['id'];
                                    }
                                    ?>
                                    <li ><a href="<?= $this->RetUrl() . $page_id_ext ?>"><?= $no_child['name'] ?></a></li>
                                    <?php
                                } else {
                                    ?>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $no_child['name'] ?><span class="caret"></span></a>

                                        <ul class="dropdown-menu rock-mega-menu">
                                            <div class="rock-drop-down-header-div">
                                                <h4 class="rock-drop-down-header">
                                                    <?php
                                                    $this->GetUrl($no_child['id']);
                                                    ?>


                                                    <a href="<?= $this->RetUrl() . "/" . $no_child['id'] ?>" title="<?= $no_child['name'] ?>" alt="<?= $no_child['name'] ?>">
                                                        <?php
                                                        echo $no_child['name'];
                                                        ?>
                                                    </a>
                                                </h4>
                                            </div>

                                            <?php
                                            $sorted_children = array();
                                            foreach ($no_child['sub_categories'] as $children) {
                                                $child_id = $children['id'];
                                                $child_parent = $children['parent'];
                                                $child_name = $children['name'];

                                                array_push($sorted_children, array("id" => $child_id, "parent" => $child_parent, "name" => $child_name));
                                            }
                                            /*
                                             * Sorts children
                                             */
                                           // usort($sorted_children, array($this, "compare_name"));
                                            foreach ($sorted_children as $child) {
                                                ?>
                                                <div>
                                                    <li>

                                                        <div class="col-sm-6 rock-drop-down-link">
                                                            <?php
                                                            $this->GetUrl($child['id']);
                                                            if ($child['parent'] == 0 || $child['parent'] == "0") {
                                                                $page_id_ext = "";
                                                            } else {
                                                                $page_id_ext = "/" . $child['id'];
                                                            }
                                                            ?>
                                                            <a href="<?= $this->RetUrl() . $page_id_ext ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;<?= $child['name'] ?></a>

                                                        </div>

                                                    </li>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </ul>
                                        <!--                                        </div>-->
                                        <?php
                                    }
                                }
                                ?>

                            </li>
                        </ul>
                    </div>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>

        <?php
    }

    /*
     * Sorst the sub-names for navigation menu
     */

    public function compare_name($a, $b) {
        return strnatcmp($a['name'], $b['name']);
    }

    /*
     * Checks to see if the given value has any children retuns true or false
     */

    public function HasChild($parent_id) {

        $data_to_ftech = array(
            "table" => "pages",
            "field" => "parent",
            "value" => $parent_id
        );


        $this->queries->_res = NULL;
        $get_children = $this->queries->findChildren($data_to_ftech, $option = 2);
        $get_children = $this->queries->RetData();
        $this->_children[] = $get_children;
        if (count($get_children) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Returns the fetched array of data for children
     */

    public function ReturnChildren() {
        return $this->_children;
    }

}
