<?php

error_reporting(E_ALL);

ini_set('display_errors', '1');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of queries
 *
 * @author rostom
 */
class queries {

    private $_mysqli;
    private $_db;
    public $_res = array();

    public function __construct() {
        $this->_db = basics::getInstance();
        $this->_mysqli = $this->_db->getConnection();
    }

    public function GetData($table, $fields, $value, $option = NULL) {
        if ($option != NULL) {
            $rows = array();
            switch ($option) {
                case "0":

                    $sql = "SELECT * FROM `" . $table . "` WHERE `" . $fields . "`= '" . $value . "' LIMIT 1";

                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }
                        return true;
                    } else {
                        return FALSE;
                    }




                    break;
                case "1":

                    $sql = "SELECT * FROM `" . $table . "` WHERE `" . $fields . "` LIKE '" . addslashes($value) . "' LIMIT 1";

                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }
                        return true;
                    } else {
                        return FALSE;
                    }

                    break;
                case "2":

                    $sql = "SELECT * FROM `" . $table . "` WHERE `" . $fields . "`&'" . $value . "' LIMIT 1";

                    $result = $this->_mysqli->query($sql);

                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }
                        return true;
                    } else {
                        return FALSE;
                    }

                    break;
                case "3":

                    $sql = "SELECT * FROM `" . $table . "`";

                    $result = $this->_mysqli->query($sql);

                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }
                        return true;
                    } else {
                        return FALSE;
                    }

                    break;
            }
        }
    }

    public function RetData() {
        return $this->_res;
    }

    public function checkUserInDB(array $data, $option = "0") {

        if ($option != "0") {
            switch ($option) {

                /*
                 * Login validation
                 */
                case "1":

                    $sql = "SELECT * FROM `" . $data['tables']['table1'] . "` WHERE `" . $data['fields']['field1'] . "`= '" . $this->_mysqli->real_escape_string($data['values']['value1']) . "' AND `" . $data['fields']['field2'] . "` = '" . $this->_mysqli->real_escape_string($data['values']['value2']) . "'";
                    $result = $this->_mysqli->query($sql);
                    $num_rows = $result->num_rows;
                    if($num_rows == "1"){
                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        
                            unset($this->_res);
                            $this->_res[] = $row;
                        }
                        return true;
                    } else {
                        return false;
                    }
                    
                    }else{
                        return false;
                    }

                    break;
            }
        }
    }

}
