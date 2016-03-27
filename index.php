<?php
error_reporting(E_ALL);

ini_set('display_errors', '1');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'rock.includes/common.php';

$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
$id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;


$page = substr($page, 12);
$class_page = new Page();
$PAGEDATA = "";
if (!$id) {
    //Load by name
    if ($page && $id == 0) {

        $data_for_query = array(
            "table" => "pages",
            "fields" => "name",
            "value" => $page,
            "option" => "1");
        $class_page->getInstanceByName($page, $data_for_query);
        $class_page->body;

        if ($class_page->body && isset($class_page->id)) {

            $id = $class_page->id;
            unset($class_page->body);
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

            $class_page->getInstanceBySpecial($special, $data_for_query);
            $class_page->body;

            if ($class_page->body && isset($class_page->id)) {
                $id = $class_page->id;
                unset($class_page->body);
            }
        }
    }
} else if ($id) {

    $data_for_query = array(
        "table" => "pages",
        "fields" => "id",
        "value" => $id,
        "option" => "0");
}

if ($class_page->getInstance($id, $data_for_query)) {
    $PAGEDATA = $class_page->body;
    echo $PAGEDATA;
} else {

    echo "404 , page not found";
    exit;
}

