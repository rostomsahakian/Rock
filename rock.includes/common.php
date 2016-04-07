<?php

//error_reporting(E_ALL);
//
//ini_set('display_errors', '1');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require dirname(__FILE__) . '/basics.php';


require_once 'rock.includes/smarty-3.1.29/libs/Smarty.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/public_html/rock.classes/Page.php';

function smarty_setup($cdir) {
   $nav = new Navigation();
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
    ///$smarty->register_function('MENU', array($nav ,"showNavigation"));
  
    //$smarty->registerPlugin("function","VALUE", array($nav ,"test_smarty_function"));
    $smarty->registerPlugin("function","MENU", array($nav ,"showNavigation"));
    return $smarty;
}



//function print_current_date($params, $smarty)
//{
//  if(empty($params["format"])) {
//    $format = "%b %e, %Y";
//  } else {
//    $format = $params["format"];
//  }
//  return strftime($format,time());
//}
