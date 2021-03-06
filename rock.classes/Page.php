<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author rostom
 */
class Page {

//put your code here

    private $_db;
    private $_mysqli;
    public $keywords;
    public $urlname;
    public $id;
    public $name;
    public $body;
    public $parent;
    public $order;
    public $cdate;
    public $edate;
    public $title;
    public $template;
    public $type;
    public $description;
    public $associated_date;
    public $special;
    public $vars;
    public $queries;
    public $data = array();
    public $_files = array();
    public $_navs;
    public $_top_level = array();
    public $_sub_level = array();
    public $Navigation;
    public $_social_media = array();
    public $_footer_links = array();
    public $_breadcrumb;
    /*
     * For Items
     */
    public $_items;
    public $_front_items = array();
    public $_item_name;
    public $_item_image;
    public $_price;
    public $_brand;
    public $_gender;
    public $_description;
    public $_color;
    public $_size;
    public $_model_number;
    public $_category;
    public $_status;
    public $_version;
    public $_year;
    public $_added_date;
    public $_band_id;

    public function __construct() {
        $this->queries = new queries();
        $this->_items = new items();
        $this->SetFooterData();
    }

    /*
     * For id
     */

    public function getInstance($id = 0, array $data) {

        if (!isset($id) && !is_numeric($id)) {
            return false;
        } else if ($id != 0 && $this->queries->GetData($data['table'], $data['fields'], $data['value'], $data['option'])) {

            $this->data = $this->queries->RetData();

            foreach ($this->data as $page_info) {

                $this->id = $page_info['id'];
                $this->name = $page_info['name'];
                $this->body = $page_info['body'];
                $this->parent = $page_info['parent'];
                $this->order = $page_info['ord'];
                $this->cdate = $page_info['cdate'];
                $this->special = $page_info['special'];
                $this->edate = $page_info['edate'];
                $this->title = $page_info['title'];
                $this->template = $page_info['template'];
                $this->type = $page_info['type'];
                $this->keywords = $page_info['keywords'];
                $this->description = $page_info['description'];
                $this->associated_date = $page_info['associated_date'];
                $this->vars = $page_info['vars'];


                /*
                 * Get Additional data
                 */

                if (isset($this->id)) {
                    $this->queries->_res = NULL;

                    $get_files = $this->queries->GetData("page_files", "page_id", $this->id, $option = "0");
                    $get_files = $this->queries->RetData();

                    $this->_files = $get_files;
                }
            }

            return true;
        }
    }

    /*
     * By Name
     */

    public function getInstanceByName($name, array $data) {
        $name = strtolower($name);

        $qs = $_SERVER['QUERY_STRING'];
        $get_childern = explode('/', $qs);
//        var_dump($get_childern);
        /*
         * if page name is empty then page is home
         */
        //echo $name;
        //var_dump($data);
        if ($name = "") {
            header("Location: index.php");
            return false;
            /* !Important
             * Strict logic rules
             * if the child node does not exists then the uri is www.yourdomain.com/page-name
             * if the child node exists the the uri is www.yourdomain.com/page-name/child-page-name or model number
             * if it is child-page-name then query the pages 
             * if page name not found in the pages do not quit do below instructions:
             * 1. it is model number then search products table 
             * 2. set page type to 7 (item page)
             */
            /*
             * $data breakdown
             * parent = node 1
             * child = n-th node
             */
        } else if ($data['short_name'] != "") {

            $table = "pages";
            $fields = array(
                "field1" => "alias",
                "field2" => "parent"
            );
            $values = array(
                "value1" => $data['short_name'],
                "value2" => "0"
            );



            $this->data = $this->queries->GetData($table, $fields, $values, "24");
            $this->data = $this->queries->RetData();
            if (count($this->data) > 0) {
                foreach ($this->data as $page_info) {

                    $this->id = $page_info['id'];
                    $this->name = $page_info['name'];
                    $this->body = $page_info['body'];
                    $this->parent = $page_info['parent'];
                    $this->order = $page_info['ord'];
                    $this->cdate = $page_info['cdate'];
                    $this->special = $page_info['special'];
                    $this->edate = $page_info['edate'];
                    $this->title = $page_info['title'];
                    $this->template = $page_info['template'];
                    $this->type = $page_info['type'];
                    $this->keywords = $page_info['keywords'];
                    $this->description = $page_info['description'];
                    $this->associated_date = $page_info['associated_date'];
                    $this->vars = $page_info['vars'];
                }
                $nameIndex = preg_replace('#[^a-z0-9/]#', '-', $this->name);
            } else {
                /*
                 * If short name is not empty and the parent not equal to zero
                 */
                $table = "pages";
                $field = "alias";
                $value = $data['short_name'];
                $option = "0";
                $this->data = $this->queries->GetData($table, $field, $value, $option);
                $this->data = $this->queries->RetData();
                if (count($this->data) > 0) {
                    foreach ($this->data as $page_info) {

                        $this->id = $page_info['id'];
                        $this->name = $page_info['name'];
                        $this->body = $page_info['body'];
                        $this->parent = $page_info['parent'];
                        $this->order = $page_info['ord'];
                        $this->cdate = $page_info['cdate'];
                        $this->special = $page_info['special'];
                        $this->edate = $page_info['edate'];
                        $this->title = $page_info['title'];
                        $this->template = $page_info['template'];
                        $this->type = $page_info['type'];
                        $this->keywords = $page_info['keywords'];
                        $this->description = $page_info['description'];
                        $this->associated_date = $page_info['associated_date'];
                        $this->vars = $page_info['vars'];
                    }
                }
            }
            /*
             * Imortant naming convention:
             * page names and aliases must be alpha-numeric
             * 
             */
        } else if ($data['short_name'] == NULL && $data['main_node'] != $data['last_child'] && !is_numeric($data['last_child'])) {
            /*
             * Find all its children then compare values if there is a match
             * Fetch data
             * first get the id of the main node  
             */
            $table = "pages";
            $fields = array(
                "field1" => "alias",
                "field2" => "parent"
            );
            $values = array(
                "value1" => $data['main_node'],
                "value2" => "0"
            );
            $this->data = $this->queries->GetData($table, $fields, $values, "24");
            $this->data = $this->queries->RetData();
            if (count($this->data) > 0) {
                foreach ($this->data as $p_data) {
                    $main_node_id = $p_data['id'];
                }
                /*
                 * Then find all the children 
                 */
                $search_pages = array(
                    "table" => "pages",
                    "field" => "parent",
                    "value" => $main_node_id
                );
                $this->queries->_res = NULL;
                $this->data = $this->queries->findChildren($search_pages, 2);
                $this->data = $this->queries->RetData();
                if (count($this->data) > 0) {

                    foreach ($this->data as $page_info) {
                        if ($page_info['alias'] == $data['last_child']) {
                            $this->id = $page_info['id'];
                            $this->name = $page_info['name'];
                            $this->body = $page_info['body'];
                            $this->parent = $page_info['parent'];
                            $this->order = $page_info['ord'];
                            $this->cdate = $page_info['cdate'];
                            $this->special = $page_info['special'];
                            $this->edate = $page_info['edate'];
                            $this->title = $page_info['title'];
                            $this->template = $page_info['template'];
                            $this->type = $page_info['type'];
                            $this->keywords = $page_info['keywords'];
                            $this->description = $page_info['description'];
                            $this->associated_date = $page_info['associated_date'];
                            $this->vars = $page_info['vars'];
                        } else {
                            
                        }
                    }
                }
            }
        } else {

            /*
             * If last child is an id search by ID
             */
            //var_dump($_REQUEST['page']);
            $sub_pages = $this->queries->GetData("pages", 'id', $data['last_child'], "0");
            $sub_pages = $this->queries->RetData();
            if (count($sub_pages) > 0) {
                foreach ($sub_pages as $page_info) {

                    $this->id = $page_info['id'];
                    $this->name = $page_info['name'];
                    $this->body = $page_info['body'];
                    $this->parent = $page_info['parent'];
                    $this->order = $page_info['ord'];
                    $this->cdate = $page_info['cdate'];
                    $this->special = $page_info['special'];
                    $this->edate = $page_info['edate'];
                    $this->title = $page_info['title'];
                    $this->template = $page_info['template'];
                    $this->type = $page_info['type'];
                    $this->keywords = $page_info['keywords'];
                    $this->description = $page_info['description'];
                    $this->associated_date = $page_info['associated_date'];
                    $this->vars = $page_info['vars'];
                }
            } else {
                /* Page type 7
                 * Check if the model number is in the products page
                 */
                $search_page = array(
                    "table" => "all_products",
                    "fields" => "model_number",
                    "value" => $data['last_child'],
                    "option" => "0"
                );
                $this->queries->_res = NULL;
                $search_product = $this->queries->GetData($search_page['table'], $search_page['fields'], $search_page['value'], $search_page['option']);

                $search_product = $this->queries->RetData();
                if (count($search_product) > 0) {
                    foreach ($search_product as $page_info) {
                        $this->id = $page_info['id'];
                        $this->_item_name = $page_info['item_name'];
                        $this->_item_image = $page_info['item_image_url'];
                        $this->_price = $page_info['price'];
                        $this->_brand = $page_info['brand'];
                        $this->_gender = $page_info['gender'];
                        $this->_description = $page_info['description'];
                        $this->_color = $page_info['color'];
                        $this->_size = $page_info['size'];
                        $this->_model_number = $page_info['model_number'];
                        $this->type = "7";
                        $this->_category = $page_info['category'];
                        $this->_status = $page_info['status'];
                        $this->_version = $page_info['version'];
                        $this->_year = $page_info['year'];
                        $this->_added_date = $page_info['added_date'];
                        $this->_band_id = $page_info['brand_id'];
                    }
                } else {


                    echo 'page not found';
                }
            }
        }
    }

    public function getInstanceBySpecial($special = 0, array $data) {
        if (!is_numeric($special)) {
            return false;
        } else if ($this->queries->GetData($data['table'], $data['fields'], $data['value'], $data['option'])) {
            $this->data = $this->queries->RetData();
            foreach ($this->data as $page_info) {
                $this->id = $page_info['id'];
                $this->name = $page_info['name'];
                $this->body = $page_info['body'];
                $this->parent = $page_info['parent'];
                $this->order = $page_info['ord'];
                $this->cdate = $page_info['cdate'];
                $this->special = $page_info['special'];
                $this->edate = $page_info['edate'];
                $this->title = $page_info['title'];
                $this->template = $page_info['template'];
                $this->type = $page_info['type'];
                $this->keywords = $page_info['keywords'];
                $this->description = $page_info['description'];
                $this->associated_date = $page_info['associated_date'];
                $this->vars = $page_info['vars'];
            }
        }
    }

    public function SetSocialMedia() {
        $this->queries->_res = NULL;
        $this->_social_media = $this->queries->GetData("social_media", "status", 1, $option = "0");
        $this->_social_media = $this->queries->RetData();
    }

    public function getSocialMedia() {
        return $this->_social_media;
    }

    public function SetItemData() {


        $page_id = isset($_GET['p']) ? $_GET['p'] : "1";


        $page_data = array(
            "id" => $this->id,
            "type" => $this->type,
            "parent" => $this->parent,
            "name" => $this->name,
            "page" => $page_id,
            "model_number" => $this->_model_number
        );
        $this->_items->GetItemsFromDB($page_data);

        foreach ($this->_items as $items) {
            $this->_front_items = $items;
        }
    }

    public function setBreadCrumb($page_name = NULL) {

        if ($page_name != NULL) {


            $long_url_array = explode("/", $page_name);
            $public_html = array_shift($long_url_array);
            $url_depth = count($long_url_array);
            $breadcrumb = array();
            if ($url_depth == 1) {
                foreach ($long_url_array as $b_link) {
                    if ($b_link != "home") {
                        $breadcrumb['active_link'] = array("home");
                        $breadcrumb['inactive_link'] = $b_link;
                     //   var_dump($breadcrumb);
                    }
                }
            } else {

                for ($i = 0; $i < ($url_depth - 1); $i++) {
                    if ($long_url_array[$i] != $long_url_array[$url_depth - 1]) {
                      
                        $breadcrumb['active_link'] = $long_url_array[$i];
                                                
                    }
                   // array_push($breadcrumb, $temp_array);
                }
                
             //   var_dump($breadcrumb);
            }
        }
    }

    public function GetFooterData() {

        /*
         * If the retailer is for apperal then we should use a different footer type
         * Footer type: Clothing
         * It must show the top designers for each brand.
         * Footer type: regular
         * It will show all the top and sub-menu pages, if they have designers or services, store and payment information
         */
        if (defined('DISIGNER_FOOTER') && DISIGNER_FOOTER == "1") {

            $footer_top_designers = array();
            $footer_top_designers["m"] = array();
            $footer_top_designers['w'] = array();
            $footer_top_designers['b'] = array();
            $footer_top_designers['g'] = array();
            $this->queries->_res = NULL;
            $get_mens_brands = $this->queries->GetData("brand_promotions", "gender", "Mens", "0");
            $get_mens_brands = $this->queries->RetData();
            $mens = array();
            $mens['mens'] = $get_mens_brands;
            array_push($footer_top_designers['m'], $mens);

            $this->queries->_res = NULL;
            $get_womens_brands = $this->queries->GetData("brand_promotions", "gender", "Womens", "0");
            $get_womens_brands = $this->queries->RetData();
            $womens = array();
            $womens['womens'] = $get_womens_brands;
            array_push($footer_top_designers['w'], $womens);

            $this->queries->_res = NULL;
            $get_boys_brands = $this->queries->GetData("brand_promotions", "gender", "Boys", "0");
            $get_boys_brands = $this->queries->RetData();
            $boys = array();
            $boys['boys'] = $get_boys_brands;
            array_push($footer_top_designers['b'], $boys);

            $this->queries->_res = NULL;
            $get_girls_brands = $this->queries->GetData("brand_promotions", "gender", "Girls", "0");
            $get_girls_brands = $this->queries->RetData();
            $girls = array();
            $girls['girls'] = $get_girls_brands;
            array_push($footer_top_designers['g'], $girls);

            array_push($this->_footer_links, $footer_top_designers);
        } else {


            $values = array(
                "value1" => "9", //Page type
                "value2" => "10" //Limit
            );
            $this->queries->_res = NULL;
            $get_designers = $this->queries->GetData("pages", "type", $values, $option = "20");
            $get_designers = $this->queries->RetData();

            $this->_footer_links = $get_designers;
        }
    }

    public function SetFooterData() {
        return $this->_footer_links;
    }

}
