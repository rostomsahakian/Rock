<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of items
 *
 * @author rostom
 */
class items {

    //put your code here
    public $_pagination;
    public $_queries;
    /*     * *******************************
     * This variable MUST be the last
     */
    public $_front_data = array();

    /*     * *********************************
     * DO NOT ADD ANY OTHER VARIABLES BELOW
     */

    public function __construct() {

        $this->_queries = new queries();
        $this->_pagination = new PagePagination();
    }

    public function GetItemsFromDB(array $data = NULL) {

        if ($data != NULL) {
            // var_dump($data);

            /*
             * Control
             * if page tyep is 0 = home page
             * if page type is 3 = category
             * if page type is 5 = sub-category
             * if page type is 7 = items
             * if page type is 9 = designers
             */

            if (isset($data['type']) && $data['type'] == 0 || $data['type'] == "0" || $data['type'] == 3 || $data['type'] == "3" || $data['type'] == 5 || $data['type'] == "5" || $data['type'] == 7 || $data['type'] == "7" || $data['type'] == 9 || $data['type'] == "9") {

                switch ($data['type']) {


                    /*
                     * Home
                     */
                    case "0":
                        /*
                         * For home page we will need to have the catagories diplayed on the left of carousel
                         * we will need images of four to five random images for the bottom of the carousel 
                         * (for now random but for future it should be the new arrivals or trending or if the customer wants to promote an item
                         */
                        $fields_ran = array(
                            "field1" => "status",
                            "limit" => "8"
                        );

                        $this->_queries->_res = NULL;
                        $get_random_images_and_data = $this->_queries->GetData("all_products", $fields_ran, "1", $option = "16");
                        $get_random_images_and_data = $this->_queries->RetData();

                        $get_random_id[] = $get_random_images_and_data;

                        foreach ($get_random_images_and_data as $get_image_data) {

                            $this->_queries->_res = NULL;
                            $get_data = $this->_queries->GetData("all_products", "id", $get_image_data['id'], $option = "0");
                            $get_data = $this->_queries->RetData();

                            $get_random_data[] = $get_data;
                        }

                        $collect_data_for_home_page = array(
                            "random_id" => $get_random_id,
                            "random_data" => $get_random_data
                        );
                        $this->_front_data[] = $collect_data_for_home_page;

                        break;

                    /*
                     * Categories
                     */
                    case "3":
                        /*
                         * Select from all_products that match the category type
                         * 1. get the parent information
                         * 2. get the page information
                         * 3. pass the information
                         */
                        /*
                         * First get the distinct fields that this category has 
                         * i.e. If it is Mens
                         * then get every single category that it has Limit by one
                         * for filtering purpases
                         */

                        /*
                         * Categories Array
                         */
                        $categories = array();



                        $fields = array(
                            "field1" => "category",
                            "field2" => "gender",
                            "limit" => ""
                        );
                        $table = "all_products";
                        $value = $data['name'];
                        /*
                         * SELECT DISTINCT
                         */
                        $this->_queries->_res = NULL;
                        $get_data_for_categories_filter = $this->_queries->GetData($table, $fields, $value, $option = "10");
                        $get_data_for_categories_filter = $this->_queries->RetData();
                        if (count($get_data_for_categories_filter) > 0) {

                            foreach ($get_data_for_categories_filter as $category) {
                                /*
                                 * Now for each category select one random product for the categories display
                                 */
                                $cats = array();
                                $cats['filter'] = $category['category'];
                                $cats['parent_id'] = $data['id'];
                                $cats['parent_name'] = $data['name'];
                                /*
                                 * Display Array
                                 */
                                $cats['display'] = array();


                                $fields_dispay = array(
                                    "field1" => "category",
                                    "field2" => "gender",
                                    "limit" => "1"
                                );
                                $table_display = "all_products";
                                $value_display = array("value1" => $category['category'], "value2" => $data['name']);
                                $this->_queries->_res = NULL;
                                $get_data_for_categories_for_display = $this->_queries->GetData($table_display, $fields_dispay, $value_display, $option = "17");
                                $get_data_for_categories_for_display = $this->_queries->RetData();
                                if (count($get_data_for_categories_for_display) > 0) {
                                    foreach ($get_data_for_categories_for_display as $cats_for_dispaly) {

                                        $displays = array();
                                        $displays['item_name'] = $cats_for_dispaly['item_name'];
                                        $displays['item_image_url'] = $cats_for_dispaly['item_image_url'];
                                        $displays['price'] = $cats_for_dispaly['price'];
                                        $displays['gender'] = $cats_for_dispaly['gender'];
                                        $displays['decription'] = $cats_for_dispaly['description'];
                                        $displays['color'] = $cats_for_dispaly['color'];
                                        $displays['size'] = $cats_for_dispaly['size'];
                                        $displays['model_number'] = $cats_for_dispaly['model_number'];
                                        $displays['brand'] = $cats_for_dispaly['brand'];
                                        $displays['category'] = $cats_for_dispaly['category'];
                                        $displays['gender'] = $cats_for_dispaly['gender'];
                                        $displays['page_real_id'] = array();

                                        /*
                                         * Select from table where parnet is equal to the id of the category page
                                         */
                                        $this->_queries->_res = NULL;
                                        $fields_c = array(
                                            "field1" => "name",
                                            "field3" => "parent"
                                        );
                                        $value_c = array(
                                            "value1" => $cats_for_dispaly['category'],
                                            "value2" => $data['id']
                                        );

                                        $children_of_categories = $this->_queries->GetData("pages", $fields_c, $value_c, $option = "11");
                                        $children_of_categories = $this->_queries->RetData();
                                        $c = array();
                                        if (count($children_of_categories) > 0) {
                                            foreach ($children_of_categories as $child_data) {
                                                $child = array();
                                                $child['child_id'] = $child_data['id'];

                                                array_push($displays['page_real_id'], $child);
                                            }
                                        }
                                        array_push($cats['display'], $displays);
                                    }
                                }
                                array_push($categories, $cats);
                            }
                        }

                        $this->_front_data[] = $categories;


                        break;
                    /*
                     * Sub Categories
                     */
                    case "5":
                        /*
                         * Get the information for specific sub-category
                         * select all from all_products where gender = gender and catgory = category
                         * i.e. Mens/pants
                         * Show all mens pants
                         * pagination required 
                         */
                        $this->_queries->_res = NULL;
                        $get_parent_name = $this->_queries->GetData("pages", "id", $data['parent'], $option = "0");
                        $get_parent_name = $this->_queries->RetData();
                        if (count($get_parent_name) > 0) {
                            foreach ($get_parent_name as $parent) {
                                
                            }
                        }

                        $page = $data['page'];
                        $page_data = array(
                            "table" => "all_products",
                            "field1" => "category",
                            "field2" => "gender",
                            "value1" => $data['name'],
                            "value2" => $parent['name'],
                            "limit" => "16",
                            "page" => $page
                        );

                        $data_for_cat_page = array();
                        $data_for_cat_page['pagination'] = array();
                        $data_for_cat_page['data'] = array();
                        $get_list = $this->_pagination->GetPageData($page_data);
                        $get_list = $this->_pagination->RetPageData();                       
                        $links = $this->_pagination->createLinks(2, "pagination pagination-sm");
                        array_push($data_for_cat_page['pagination'], $links);
                        array_push($data_for_cat_page['data'], $get_list);
                   
                        
                        $this->_front_data[] = $data_for_cat_page;
                        
                        break;
                    /*
                     * 
                     */
                    case "7":
                       /*
                        * get the model number 
                        */
                       $model_number = $data['model_number'];
                        
                       $this->_queries->_res = NULL;
                       $get_items_info = $this->_queries->GetData("all_products", "model_number", $model_number, $option="0");
                       $get_items_info = $this->_queries->RetData();
                       
                       $this->_front_data[] = $get_items_info;
                        
                        break;
                }
            }
        }
    }

}
