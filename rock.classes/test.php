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
class test {

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

    public function __construct() {
        $this->queries = new queries();
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


            $nameIndex = preg_replace('#[^a-z0-9/]#', '-', $name);
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

}
