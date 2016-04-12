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
    'db_name' => "rock_cmsdb",
    'theme' =>'template'
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
define("ABSOLUTH_PATH_FILE_BACKEND", "../rock.files/");
define("ABSOLUTH_PATH_FILE_FRONT_END", "/r.frontend/files/");
define("ABSOLUTH_PATH_IMAGE_FRONT_END", "/r.frontend/images/");
define("ABSOLUTH_PATH_FRONTEND_CSS", "/r.frontend/css/");
define("ABSOLUTH_PATH_OWL_CAR", "/r.frontend/owl.carousel/owl-carousel/");
define("ABSOLUTH_PATH_CACHE", "../rock.cache/");
define("DATE_ADDED", date("F j,Y, g:i a"));
define("THEME_DIR",SCRIPTBASE.'public_html/r.frontend');
define("ABSOLUTH_PATH_FONT_AWESOME", "/rock.assets/font-awesome-4.5.0/css/");

if(isset($DBVARS['theme'])&& $DBVARS['theme']){
    define("THEME" , $DBVARS['theme']);
}else{
    $dir = new DirectoryIterator(THEME_DIR);
    $DBVARS['theme'] = '';
    foreach ($dir as $file){
        if($file->isDot())
            continue;
        $DBVARS['theme'] = $file->getFilename();
        break;
    }
    define('THEME', $DBVARS['theme']);
}


###########################################
/*
 * FOR MODULES MANAGER
 * 1 = on
 * 0 = off
 */

define("CAROUSEL_MANAGER", "1");
define("THEME_MANAGER", "1");
define("FORMS_MANAGER", "1");
define("REPORTS", "1");
define("GAR", "1");
define("PAGE_MANAGER", "1");
define("SOCIAL_MEDIA", "1");