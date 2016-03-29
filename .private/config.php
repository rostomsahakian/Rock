<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define("WEBSITE_NAME", "101-Clothing"); //-->change this
$DBVARS =array(
    'username' => "rockadmin",
    'password' => "RockRoll1234#",
    'hostname' => "localhost",
    'db_name' => "rock_cmsdb"
);

define("DB_USERNAME", "rockadmin");
define("DB_PASSWORD", "RockRoll1234#");
define("DB_HOST", "localhost");
define("DB_NAME", "rock_cmsdb");
define('SCRIPTBASE', $_SERVER['DOCUMENT_ROOT'] . '/');
define("START_SESSION", session_start());

define("ABSOLUTH_PATH_CSS", "../rock.assets/r.css/");
define("ABSOLUTH_PATH_FONTS", "../rock.assets/fonts/");
define("ABSOLUTH_PATH_IMAGES", "../rock.assets/r.images/");
define("ABSOLUTH_PATH_JS", "../rock.assets/js/");
define("ABSOLUTH_PATH_ADMIN" , "../rock.admin/");