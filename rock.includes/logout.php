<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$url ='/';
session_start();
//set up redirect
if(isset($_REQUEST['redirect'])){
    $url = preg_replace('/[\?\&].*/', '', $_REQUEST['redirect']);
    if($url == ''){
        $url="/";
    }
    unset($_SESSION['userdata']);
    header("Location:" .$url);
    echo '<a href="'.htmlspecialchars($url).'">redrect</a>';
}