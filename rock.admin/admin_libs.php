<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require $_SERVER['DOCUMENT_ROOT'] . '/public_html/rock.includes/basics.php';

class admin_libs {

    public function __construct() {
        
    }

    public function is_admin() {
        if (!isset($_SESSION['userdata'])) {
            return false;
        }
        return(isset($_SESSION['userdata']['groups']['_administrarors']) || isset($_SESSION['userdata']['groups']['_superadministrators']));
    }

}

$check_if_logged_in = new admin_libs();

if (!$check_if_logged_in->is_admin()) {

    require SCRIPTBASE . 'public_html/rock.classes/main.php';
   
    exit;

}else{
   
       require SCRIPTBASE . 'public_html/rock.classes/main.php';
}