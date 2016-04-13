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
    public $_items;
    public $_front_items = array();

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

        if ($name = "") {
            header("Location: index.php");
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


            $nameIndex = preg_replace('#[^a-z0-9/]#', '-', $this->name);
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
    
    public function SetSocialMedia(){
        $this->queries->_res = NULL;
        $this->_social_media = $this->queries->GetData("social_media", "status", 1, $option ="0");
        $this->_social_media = $this->queries->RetData();
    }
    
    public function getSocialMedia(){
        return $this->_social_media;
    }
    
    
    public function SetItemData(){
        $page_data = array(
            "id" => $this->id,
            "type" => $this->type,
            "parent" => $this->parent,
            "name" => $this->name
        );
        $this->_items->GetItemsFromDB($page_data);
        
        foreach ($this->_items as $items){
            $this->_front_items = $items;
        }
        
    }
 
   

}
