<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of header
 *
 * @author rostom
 */
class header {
        /*
     * Public, private, and proteced methods go here
     */

    public $_header;

    /*
     * Control Constructor
     */

    public function __construct() {

        echo $this->GetHeader();
    }

    /*
     * @auth: Rostom
     * Desc: Builds the Back-end Header
     * @param: header_data[]
     * 1. page_title
     * 2. css_links
     * 3. js_links
     * 4.meta_links
     * Date: 03/21/2016
     */

    public function SetHeader(array $header_data) {
        $this->_header = "";
    
        ?>

<!DOCTYPE html>
   <html xmlns="http://www.w3.org/1999/xhtml" lang="en">
          
            <head>
                  <title><?= $header_data['page_title'] ?></title>
                <?php
                foreach ($header_data['meta_tags'] as $header_meta) {
                    echo $header_meta;
                }
                foreach ($header_data['css_links'] as $header_css) {
                    echo $header_css;
                }
                foreach ($header_data['js_links'] as $header_js) {
                    echo $header_js;
                    
                }
                ?>
            </head>
            <body>
                <?php
            }

            /*
             * @auth: Rostom
             * Desc: Retuns the built header for back-end
             * Date: 03/21/2016
             */

            public function GetHeader() {
                return $this->_header;
            }

}
