<?php

/* * *******************************************************************
 * !IMPORTANT
 * Rock URI convension
 * STRICT Rule
 * [1] = parent node
 * [$i] = the n-th node 
 * ******************************************************************
 */
include_once 'rock.includes/common.php';
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
$query_string = explode('/', $_SERVER['QUERY_STRING']);
for ($i = 0; $i < count($query_string); $i++) {
    
}

$child = $query_string[count($query_string) - 1]; //N-th node
if (count($query_string) > 1) {

    $parent = $query_string[1];
} else {
    $parent = $child;
}
$page = str_replace('-', ' ', $page);
$page = explode("/", $page);

foreach ($page as $page_name) {
    
}
$page = substr($page_name, 12);
$page = $page_name;
$page_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0; //By id

$PAGEDATA = new Page(); //New instance of page class

/*
 * Index login
 * case by name if name is set then search page by name 
 * case id if id is been set then search by id
 * case if name/gender or name/gender/brand or name/gender/brand/model_number then again search by name
 */

if (!$page_id) {

    if ($page && $page_id == 0) {

        $data_for_query = array(
            "main_node" => $parent,
            "last_child" => $child,
        );

        /*
         * get instance by NAME
         */
        $PAGEDATA->getInstanceByName($page, $data_for_query);
        $PAGEDATA->type;
        $footer_data = $PAGEDATA->GetFooterData();
        $footer_data = $PAGEDATA->_footer_links;
        switch ($PAGEDATA->type) {
            case "0": //Normal Page Type
                $template = THEME_DIR . '/' . THEME . '/html/_default.php';
                $page_title = $PAGEDATA->title;
                $page_name = $PAGEDATA->name;
                $page_meta = $PAGEDATA->description;
                $pagecontent = $PAGEDATA->body;
                $page_extra_data = $PAGEDATA->SetItemData();
                $page_extra_data = $PAGEDATA->_front_items;
                include $template;
                include_once 'r.frontend/template/footer.php';
                break;
            case "1": //Sub-menu

                $template = THEME_DIR . '/' . THEME . '/html/_default.php';
                include $template;
                include_once 'r.frontend/template/footer.php';
                break;
            case "3": //Category

                $template = THEME_DIR . '/' . THEME . '/html/categories.php';
                $page_title = $PAGEDATA->title;
                $pagecontent = $PAGEDATA->body;
                $pag_data = $PAGEDATA->SetItemData();
                $page_data = $PAGEDATA->_front_items;
                include $template;
                include_once 'r.frontend/template/footer.php';

                break;
            case "5": //Sub-category

                $template = THEME_DIR . '/' . THEME . '/html/sub-categories.php';
                $page_title = $PAGEDATA->title;
                $page_data_sub = $PAGEDATA->SetItemData();
                $page_data_sub = $PAGEDATA->_front_items;
                include $template;
                include_once 'r.frontend/template/footer.php';
                break;
            case "7": //item page
                $template = THEME_DIR . '/' . THEME . '/html/_items.php';
                $page_title = $PAGEDATA->_brand . "|" . $PAGEDATA->_item_name;
                $pagecontent = $PAGEDATA->body;
                $page_data_item = $PAGEDATA->SetItemData();
                $page_data_item = $PAGEDATA->_front_items;
                include $template;
                include_once 'r.frontend/template/footer.php';
                break;
            case "9": //Designer page

                $template = THEME_DIR . '/' . THEME . '/html/_designers.php';
                $page_title = $PAGEDATA->title;
                $pagecontent = $PAGEDATA->body;
                include $template;
                include_once 'r.frontend/template/footer.php';
                break;
        }
    }
    /*
     * if no uri then use special to load home page
     */
    if (!$page_id) {
        $special = 1;
        if (!$page) {
            $data_for_query = array(
                "table" => "pages",
                "fields" => "special",
                "value" => $special,
                "option" => "2");

            $PAGEDATA->getInstanceBySpecial($special, $data_for_query);
            $PAGEDATA->body;
            $PAGEDATA->type;

            $template = THEME_DIR . '/' . THEME . '/html/_default.php';
            $page_title = $PAGEDATA->title;
            $page_name = $PAGEDATA->name;
            $page_meta = $PAGEDATA->description;
            $pagecontent = $PAGEDATA->body;
            $page_extra_data = $PAGEDATA->SetItemData();
            $page_extra_data = $PAGEDATA->_front_items;
            $footer_data = $PAGEDATA->GetFooterData();
            $footer_data = $PAGEDATA->_footer_links;
            include $template;
            include_once 'r.frontend/template/footer.php';
        }
    }
} else if ($page_id != 0) {
    
}
    