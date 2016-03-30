<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of commands
 *
 * @author rostom
 */
class commands {

    public $_cmd = array();

    public function __construct() {
        $this->globalCommands();
    }

    public function globalCommands() {

        $this->_cmd = array(
            "login",
            "add_page",
            "see_page",
            "menus",
            "move_page",
            "edit_page",
            "choose_edit_page"
        );
    }

    public function checkCommand($needle) {
        if (in_array($needle, $this->_cmd)) {

            return true;
        } else {
            return false;
        }
    }

}
