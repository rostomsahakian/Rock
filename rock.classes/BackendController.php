<?php

error_reporting(E_ALL);

ini_set('display_errors', '1');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BackendController
 *
 * @author rostom
 */
class BackendController {

    public $_forms;
    public $_cmd_checker;
    public $_queries;
    public $_page_list = array();

    /*
     * Constructor for class BackendController
     */
    public function __construct() {
        $this->_forms = new forms();
        $this->_cmd_checker = new commands();
        $this->_queries = new queries();
    }

    /*
     * Logical Controller
     * Show things in the back end based on commands received 
     */

    public function controller(array $cmd) {
        /*
         * prevent url injection if user is not logged in !important
         */
        $cmd['cmd'] = (isset($_SESSION['userdata']) ? (isset($_REQUEST['cmd']) ? $_REQUEST['cmd'] : "menus") : "login");
        
        /*
         * Check if the command exists or not
         */
        $res = $this->_cmd_checker->checkCommand($cmd['cmd']);
        
        if ($res) {
            /*
             * If it does check if the command is for login
             */
            if ($cmd['cmd'] == "login") {
                $login = $this->_forms->login_proccess($_REQUEST);
                $login = $this->_forms->BackEndLoginForm();
                /*
                 * Otherwise show main content in the backend template
                 */
            } else {
                require '../rock.admin/backend-template.php';
            }
        } else {
            /*
             * if command does not exisit go to 404
             */
            require_once '../rock.admin/404.php';
        }
    }
    /*
     * Lists the pages of the front end
     * use side bar in backend template
     * Recursive function
     */
    public function show_pages($id, $pages) {
        if (!isset($pages[$id])) {
            return;
        }
        echo '<ul>';
        foreach ($pages[$id] as $page) {
          
            echo '<li id="page_' . $page['id'] . '">'
            . '<a href="?cmd=edit_page&option=true&page_id=' . $page['id'] . '" >'
            . '' . htmlspecialchars($page['name']) . ''
            . '</a>';
            $this->show_pages($page['id'], $pages);
            echo '</li>';
        }
        echo '</ul>';

    }
    /*
     * Shows the page in the back end
     */
    public function seePageLook(array $page_info, $extra_info) {

        foreach ($page_info as $page_look) {
            if ($page_look['id'] == $extra_info) {

               // echo $page_look['body'];
                $url = "http://dev.rock.webulence.com/".$page_look['name'];
                $iframe = '<iframe src="'.$url.'" width="100%" height="200"></iframe>';
                echo $iframe;

            }
        }
    }

}
