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
    public $_queries;
    public $_front_data = array();

    public function __construct() {

        $this->_queries = new queries();
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

            if (isset($data['type']) && $data['type'] == 0 || $data['type'] == "0" ||  $data['type'] == 3 || $data['type'] == "3" || $data['type'] == 5 || $data['type'] == "5" || $data['type'] == 7 || $data['type'] == "7" || $data['type'] == 9 || $data['type'] == "9") {

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
                        
                        $this->_queries->_res = NULL;
                        $fields = array(
                            "field1" => "category",
                            "field2" => "status"
                        );
                        $get_data_for_home_page = $this->_queries->GetData("all_products", $fields, "1", $option="10");
                        $get_data_for_home_page = $this->_queries->RetData();
                        
                        
                        
                        foreach($get_data_for_home_page as $home_data){
                            $fields_ran = array(
                                "field1" => "id",
                                "field2" => "category"
                                
                            );
                            
                            $this->_queries->_res = NULL;
                            $get_random_images_and_data = $this->_queries->GetData("all_products", $fields_ran, $home_data['category'], $option="13");
                            $get_random_images_and_data = $this->_queries->RetData();
                            
                            $get_random_id[] = $get_random_images_and_data;
                            
                            foreach ($get_random_images_and_data as $get_image_data){
                                
                                $this->_queries->_res = NULL;
                                $get_data = $this->_queries->GetData("all_products", "id" , $get_image_data['id'], $option= "0");
                                $get_data = $this->_queries->RetData();
                                
                                $get_random_data[] = $get_data;
                                
                                
                            }
                            
                        }
                        
                        $collect_data_for_home_page = array(
                            "categories" => $get_data_for_home_page,
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
                        $fields = array(
                            "field1" => "category",
                            "field2" => "gender"
                        );
                        /*
                         * Categoires
                         * (i.e. footwaare, clothing,...)
                         */
                        $this->_queries->_res = NULL;
                        $get_selected_category = $this->_queries->GetData("all_products", $fields, $data['name'], $option = "10");
                        $get_selected_category = $this->_queries->RetData();


                        $field_for_band_id = array(
                            "field1" => "brand_id",
                            "field2" => "gender"
                        );
                        /*
                         * Brand ID
                         */
                        $this->_queries->_res = NULL;
                        $get_selected_brands = $this->_queries->GetData("all_products", $field_for_band_id, $data['name'], $option = "10");
                        $get_selected_brands = $this->_queries->RetData();

                        foreach ($get_selected_brands as $brand_name) {
                            /*
                             * Find Categories Brands
                             * 
                             */
                            $fields_for_brand_name = array(
                                "field1" => "category",
                                "field3" => "brand_id",
                                "field2" => "gender"
                            );
                            /*
                             * Brand Name
                             * * (i.e. Converse, Champion,...)
                             */
                            $this->_queries->_res = NULL;
                            $get_category_brand = $this->_queries->GetData("brands", "id", $brand_name['brand_id'], $option = "0");
                            $get_category_brand = $this->_queries->RetData();

                            $brands[] = $get_category_brand;
                        }

                        $big_data = array(
                            "categories" => $get_selected_category,
                            "brand_ids" => $get_selected_brands,
                            "brands" => $brands
                        );
                        $this->_front_data[] = $big_data;

                      
                        break;
                    /*
                     * Sub Categories
                     */
                    case "5":
                       
                        break;
                    /*
                     * 
                     */
                    case "7":
                        
                        break;
                }
            }
        }
    }

}
