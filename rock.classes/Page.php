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
// var_dump($name);

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

    public function BuildNavigation($parent_id, $depth) {

        $page = $this->queries->NavigationQuaries($parent_id, "0", "1", $option = "0");
        /*
         * Get Data from body.php
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

    public function showNaigation($id, $pages) {

        if (!isset($pages[$id])) {
            return;
        }
        ?>
        <!-- Static navbar -->
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Project name</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">



                        <?php
                        foreach ($pages[$id] as $page) {
                            ?>

                            <li class="active"><a href="#"><?= htmlspecialchars($page['name']); ?></a>

                                <?php
                                $this->show_pages($page['id'], $pages);
                                ?>   

                                <?php
                            }
                            ?>



                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                            </ul>
                        </li>
                    </ul>

                </div><!--/.nav-collapse -->
            </div>
        </nav>




        <?php
    }

    public function BuildNavForFrontEnd($parent_id) {

        $this->queries->_nav = NULL;
        $top_links = $this->queries->NavigationQuaries($parent_id, "0", "1", $option = "0");

        foreach ($top_links as $top_link) {

            $this->_top_level[] = $top_link;
        }




        $this->queries->_nav = NULL;
        $sub_links = $this->queries->NavigationQuaries($parent_id, "0", "1", $option = "1");
        if ($sub_links != NULL) {
            foreach ($sub_links as $sub_link) {


                $this->_sub_level['sub'][$sub_link['parent']] = $sub_link;
            }
        }
        // var_dump($this->_sub_level['sub'][0]);


        $nav_links = array("top" => $this->_top_level, "sub" => $this->_sub_level);
    }

}
