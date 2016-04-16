<?php
error_reporting(E_ALL);

ini_set('display_errors', '1');
/**
 * Description of NavApi
 *
 * @author rostom
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/public_html/vendor/autoload.php';

class NavApi {

    public $uri_value;
    public $_queries;

    public function __construct() {
        $this->_queries = new queries();
        $this->GetNavUrls();
    }

    public function GetNavUrls() {

        $request = "0";
        $categories = array();
        $this->_queries->_res = NULL;
        $get_parents = $this->_queries->GetData("pages", "parent", $request, "0");
        $get_parents = $this->_queries->RetData();
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
                if($this->HasChild($parent['id'])){
                $category['sub_categories'] = array();
                }

                $this->_queries->_res = NULL;
                $get_children = $this->_queries->GetData("pages", "parent", $parent['id'], "0");
                $get_children = $this->_queries->RetData();
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
            $json = json_encode($categories);
            header('Content-Type: application/json');
            echo $json;
        }
    }

    public function HasChild($parent_id) {

        $data_to_ftech = array(
            "table" => "pages",
            "field" => "parent",
            "value" => $parent_id
        );
        $this->_queries->_res = NULL;
        $get_children = $this->_queries->findChildren($data_to_ftech, $option = 2);
        $get_children = $this->_queries->RetData();
        $this->_children[] = $get_children;
        if (count($get_children) > 0) {
            return true;
        } else {
            return false;
        }
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

    //put your code here
    public function BuildNavigation() {

        $this->queries->_res = NULL;
        $page = $this->queries->GetData("pages", NULL, NULL, "3");
        $page = $this->queries->RetData();
        /*
         * Set the parent child relationship
         * Rostom 03/26/2016
         */
        $pages_array = array();
        foreach ($page as $p) {
            if (!isset($pages_array[$p['parent']])) {
                $pages_array[$p['parent']] = array();
            }
            $pages_array[$p['parent']][] = $p;
        }
        return $pages_array;
    }

    public function showNavigation($id, $pages = NULL) {

        $i = isset($id['id']) ? $id['id'] : $id;
        /*
         * To build a navigation system
         * 1. get all pages that the parent is zero and page type is zero (Top Level => Home, About us , etc.)
         * 2. get all pages that have a parent (from one) and the page type is either 1 or 3 
         * 3. get all page that their parent is 3 and the type is 5
         * 
         * page types:
         * 0 => top level
         * 1 => sub menu (normal pages)
         * 3 => Categories (i.e clothing, men,women ...)
         * 5 => sub-Categories (i.e T-shirt, pants)
         * 7 => item page (NOT SHOWN IN THE MENU
         */
        $pages = $this->BuildNavigation(0);

        if (!isset($pages[$i])) {
            return;
        }
        ?>

        <ul>
            <?php
            foreach ($pages[$i] as $page) {
                if ($page['type'] == 0 || $page['type'] == "0" || $page['type'] == 1 || $page['type'] == "1" || $page['type'] == 3 || $page['type'] == "3" || $page['type'] == 9 || $page['type'] == "9") {

                    $this->GetUrl($page['id']);
                    ?>

                    <li id="page_<?= $page['id'] ?>">
                        <?php
                        if ($page['parent'] == 0 || $page['parent'] == "0") {
                            $page_id_ext = "";
                        } else {
                            $page_id_ext = "/" . $page['id'];
                        }
                        ?>
                        <a href="<?= $this->RetUrl() . $page_id_ext ?>" ><?= htmlspecialchars($page['name']) ?></a>

                        <?php
                        $this->showNavigation($page['id'], $this->BuildNavigation(0));
                        ?>
                    </li>


                    <?php
                }
            }
            ?>
        </ul>

        <?php
    }

}

$n = new NavApi();
