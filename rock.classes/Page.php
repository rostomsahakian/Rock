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

            //echo $name;
        } else if ($data['main_node'] == $data['last_child']) {
            //echo $name;
            $search_page = array(
                "table" => "pages",
                "fields" => "alias",
                "value" => $data['main_node'],
                "option" => "0"
            );

            $this->data = $this->queries->GetData($search_page['table'], $search_page['fields'], $search_page['value'], $search_page['option']);
            if ($this->data) {
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
                $nameIndex = preg_replace('#[^a-z0-9/]#', '-', $this->name);
            }
        } else {


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
                /*
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
        $page_data = array(
            "id" => $this->id,
            "type" => $this->type,
            "parent" => $this->parent,
            "name" => $this->name
        );
        $this->_items->GetItemsFromDB($page_data);

        foreach ($this->_items as $items) {
            $this->_front_items = $items;
        }
    }
    
    public function setBreadCrumb($page_name){
        
    }

}
