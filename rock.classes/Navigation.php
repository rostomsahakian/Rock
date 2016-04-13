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

    public function __construct() {
        $this->queries = new queries();
        $this->forms = new forms();
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
                if ($page['type'] == 0 || $page['type'] == "0" || $page['type'] == 1 || $page['type'] == "1" || $page['type'] == 3 || $page['type'] == "3" || $page['type'] == 5 || $page['type'] == "5" || $page['type'] == 9 || $page['type'] == "9") {

                    $this->GetUrl($page['id']);
                    ?>

                    <li id="page_<?= $page['id'] ?>">

                        <a href="<?= $this->RetUrl(); ?>?id=<?= $page['id'] ?>" ><?= htmlspecialchars($page['name']) ?></a>

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


    public function GetUrl($page_id){
        $this->queries->_res = NULL;
        $get_url = $this->queries->GetData("page_urls", NULL, NULL, $option="7");
        $get_url = $this->queries->RetData();
        
        foreach ($get_url as $url){
            if($url['page_id'] == $page_id){
                $this->_url = $url['long_url'];
            }
        }
    }

    public function RetUrl() {
        return $this->_url;
    }

}
