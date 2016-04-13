<?php

//error_reporting(E_ALL);
//
//ini_set('display_errors', '1');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'rock.includes/common.php';
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';

$id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : $_SESSION['id'];
$page = str_replace('-', ' ', $page);
$page = explode("/", $page);

foreach ($page as $page_name) {
    
}

//$page = substr($page_name, 12);
$page = $page_name;

$PAGEDATA = new Page();

if (!$id) {
    //Load by name
    if ($page && $id == 0) {

        $data_for_query = array(
            "table" => "pages",
            "fields" => "name",
            "value" => $page,
            "option" => "1");
        $PAGEDATA->getInstanceByName($page, $data_for_query);
        $PAGEDATA->body;

        if ($PAGEDATA->body && isset($PAGEDATA->id)) {

            $id = $PAGEDATA->id;
            unset($PAGEDATA->body);
        }
    }

    if (!$id) {
        $special = 1;
        if (!$page) {
            $data_for_query = array(
                "table" => "pages",
                "fields" => "special",
                "value" => $special,
                "option" => "2");

            $PAGEDATA->getInstanceBySpecial($special, $data_for_query);
            $PAGEDATA->body;

            if ($PAGEDATA->body && isset($PAGEDATA->id)) {
                $id = $PAGEDATA->id;
                unset($PAGEDATA->body);
            }
        }
    }
} else if ($id != 0) {
   
    $data_for_query = array(
        "table" => "pages",
        "fields" => "id",
        "value" => $id,
        "option" => "0");
}


if ($PAGEDATA->getInstance($id, $data_for_query)) {

    if (file_exists(THEME_DIR . '/' . THEME . '/html/' . $PAGEDATA->template . '.html')) {

        $template = THEME_DIR . '/' . THEME . '/html' . $PAGEDATA->template . '.html';
    } else if (file_exists(THEME_DIR . '/' . THEME . '/html/_default.html')) {
        
        
        
        
       
        
    switch ($PAGEDATA->type) {
        case "0": //Normal Page Type
            $template = THEME_DIR . '/' . THEME . '/html/_default.php';
            $page_title = $PAGEDATA->title;
            $page_name = $PAGEDATA->name;
            $page_meta = $PAGEDATA->description;
            $pagecontent = $PAGEDATA->body;
            $page_extra_data = $PAGEDATA->SetItemData();
            $page_extra_data = $PAGEDATA->_front_items;
             include $template;
            break;
        case "1": //Sub-menu
            
             $template = THEME_DIR . '/' . THEME . '/html/_default.php';
             include $template;
            break;
        case "3": //Category
            
             $template = THEME_DIR . '/' . THEME . '/html/categories.php';
            $pagecontent= $PAGEDATA->SetItemData();
            $pagecontent = $PAGEDATA->_front_items;
             include $template;

            break;
        case "5": //Sub-category
            
             $template = THEME_DIR . '/' . THEME . '/html/_categories.html';
             
            $pagecontent = $PAGEDATA->SetItemData();
            break;
        case "7": //item page
             $template = THEME_DIR . '/' . THEME . '/html/_item.html';
            $pagecontent = $PAGEDATA->body;
            break;
        case "9": //Designer page
            
             $template = THEME_DIR . '/' . THEME . '/html/_designers.html';
            $pagecontent = $PAGEDATA->body;
            break;
    }
        
    } else {
        $d = array();
        $dir = new DirectoryIterator(THEME_DIR . '/' . THEME . '/html/');
        foreach ($dir as $f) {
            if ($f->isDot())
                continue;
            $n = $f->getFilename();
            if (preg_match('/^includes\./', $n))
                continue;
            if (preg_match('/\.html/', $n))
                $d[] = preg_replace('/\.html', '', $n);
        }
        asort($d);
        $template = THEME_DIR . '/' . THEME . '/html/' . $d[0] . '.html';

        if ($template == '') {
            die(' No template created please create a template first.');
        }
    }

    $title = ($PAGEDATA->title != '') ? $PAGEDATA->title : str_replace('www.', '', $_SERVER['HTTP_HOST']) . '>' . $PAGEDATA->name;
    $metadata = '<title>' . htmlspecialchars($title) . '</title>';
    $metadata.='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';
    if ($PAGEDATA->keywords != NULL) {
        $metadata .= '<meta http-equiv="keywords" content="' . htmlspecialchars($PAGEDATA->keywords) . '"/>';
        if ($PAGEDATA->description != NULL) {
            $metadata .='<meta http-equiv="description" content="' . htmlspecialchars($PAGEDATA->description) . '"/>';
        }
    }


//    $smarty = smarty_setup('pages');
    if ($PAGEDATA->_files != NULL) {
        //var_dump($PAGEDATA->_files);

        $css = array();
        $js = array();
        foreach ($PAGEDATA->_files as $files) {

            if ($files['file_extension'] == "css") {
                $css[] = $files['file_path'] . $files['file_name'];

//                $smarty->assign('CSS', $css);
            } else if ($files['file_extension'] == "js") {

                $js[] = $files['file_path'] . $files['file_name'];
//                $smarty->assign('JS', $js);
            } else {
                $files = array();
            }
        }
    }

} else {

    echo "404 , page not found";
    exit;
}
//$root = realpath($_SERVER["DOCUMENT_ROOT"]);
//$navcss = "/r.frontend/css/styles.css";
//$navjs = "/r.frontend/js/script.js";
//$maincCSS = "/r.frontend/css/page_styles.css";
//$PAGEDATA->SetSocialMedia();
//$smarty->assign("SOCIALMEDIA", $PAGEDATA->getSocialMedia());
//
//
//$smarty->template_dir = THEME_DIR . '/' . THEME . '/html/';
//$smarty->assign('PAGECONTENT', $pagecontent);
//$smarty->assign('PAGEDATA', $PAGEDATA);
//$smarty->assign('METADATA', $metadata);
//$smarty->assign("CSS_INDEX", "file_path");
//$smarty->assign('FRONTEND_CSS', ABSOLUTH_PATH_FRONTEND_CSS);
//$smarty->assign("OWL_CAR", ABSOLUTH_PATH_OWL_CAR);
//$smarty->assign("JQUERY", "https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js");
//$smarty->assign("BOOTSRAP_JS", '<script src="../rock.assets/js/bootstrap.min.js"></script> ');
//$smarty->assign("NAVCSS", $navcss);
//$smarty->assign("NAVJS", $navjs);
//$smarty->assign("MAINCSS", $maincCSS);
//
//header('Content-type: text/html; Charset=utf-8');
//
//$smarty->display($template);
