<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require dirname(__FILE__) . '/basics.php';


require_once 'rock.includes/smarty-3.1.29/libs/Smarty.class.php';

function smarty_setup($cdir) {
    $smarty = new Smarty;
    if (!file_exists(ABSOLUTH_PATH_CACHE . $cdir)) {
        if (mkdir(ABSOLUTH_PATH_CACHE . $cdir)) {
            die(ABSOLUTH_PATH_CACHE . $cdir . 'not created.<br/> Please make sure that');
        }
    }
    $smarty->caching = false;
    $smarty->cache_lifetime = 120;
    $smarty->compile_dir = ABSOLUTH_PATH_CACHE . $cdir;
    $smarty->left_delimiter = '{{';
    $smarty->right_delimiter = '}}';
    //$smarty->register_function('MENU', 'menu_show_fg');
    return $smarty;
}
