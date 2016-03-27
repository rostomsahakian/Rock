<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of footer
 *
 * @author rostom
 */
class footer {
    /*
     * Public, private, and proteced local variables 
     */

    public $_footer;

    /*
     * Footer Constructor
     */

    public function __construct() {
        $this->SetFooter();
    }

    public function GetFooter(array $footer_data) {
        $this->_footer = "";
        foreach ($footer_data['js'] as $footer_scripts) {
            echo $footer_scripts;
        }
        ?>

        <!--Footer Design goes here-->
        <footer>

        </footer>

        </body>
        </html>
        <?php
    }

    public function SetFooter() {
        return $this->_footer;
    }

}
