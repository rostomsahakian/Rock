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
    public $_parent = array();
    public $_child = array();

    public function __construct() {
        $this->_db = basics::getInstance();
        $this->_mysqli = $this->_db->getConnection();
    }

    public function RetData() {

        return $this->_res;
    }

    public function GetData($table, $fields, $value, $option = NULL) {
        if ($option != NULL) {
            $rows = array();
            switch ($option) {
                case "0":

                    $sql = "SELECT * FROM `" . $table . "` WHERE `" . $fields . "`= '" . $value . "'";

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

                    $sql = "SELECT * FROM `" . $table . "` ORDER BY ord ASC";

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
                    if ($num_rows == "1") {
                        if ($result) {
                            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                                unset($this->_res);
                                $this->_res[] = $row;
                            }
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }

                    break;
            }
        }
    }

    public function UpdateQueriesServices(array $data, $option = "0") {

        if ($option != "0") {
            switch ($option) {
                case "1":
                    $sql = "UPDATE `" . $data['tables']['table1'] . "` SET `" . $data['fields']['field1'] . "` = '" . (int) $data['values']['value1'] . "' WHERE `" . $data['fields']['field2'] . "` = '" . (int) $data['values']['value2'] . "'";
                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        return true;
                    } else {
                        return false;
                        exit;
                    }
                    break;
            }
        }
    }

    public function findParent(array $data, $option = "0") {
        if ($option != "0") {

            switch ($option) {
                case "1":
                    $sql = "SELECT `parent` FROM `" . $data['table'] . "` WHERE `" . $data['field'] . "` = '" . (int) $data['value'] . "'";

                    $result = $this->_mysqli->query($sql);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $this->_parent[] = $row;
                    if ($row['parent'] != 0) {


                        $new_data = array(
                            "table" => "pages",
                            "field" => "id",
                            "value" => $row['parent']
                        );
                        $find_parnet = $this->findParent($new_data, "1");

                        return $this->_parent;
                    } else {

                        return $this->_parent;
                    }
                    break;
                case "2": //Find immidiate parent 
                    if ($data['value'] != "0" || $data['value'] != 0) {
                        $sql = "SELECT * FROM `" . $data['table'] . "` WHERE `" . $data['field'] . "` = '" . (int) $data['value'] . "'";

                        $result = $this->_mysqli->query($sql);
                        if ($result) {
                            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                                $this->_child[] = $row;
                            }
                            return $this->_child;
                        } else {
                            return false;
                        }
                    } else {
                        $this->GetData($data['table'], $data['field'], $data['value'], $option = "0");
                    }
                    break;
            }
        }
    }

    public function findChildren(array $data, $option = 0) {
        if ($option != 0) {
            switch ($option) {
                case 1:
                    $sql = "SELECT `" . $data['fields']['field1'] . "`,`" . $data['fields']['field2'] . "` FROM `" . $data['tables']['table1'] . "` WHERE "
                            . "`" . $data['fields']['field3'] . "` = '" . $data['values']['value1'] . "' AND "
                            . "`" . $data['fields']['field1'] . "` != '" . $data['values']['value2'] . "'"
                            . " ORDER by `" . $data['fields']['field4'] . "` , `" . $data['fields']['field2'] . "` ";
                   // var_dump($sql);

                    $result = $this->_mysqli->query($sql);
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        if (count($row) < 1) {
                            return false;
                        } else {
                            $this->_res[] = $row;
                           // var_dump($row);
                            $data['values']['value1'] = $row['id'];

                            $find_all = $this->findChildren($data, $option = 1);
                        }
                    }
                    
                    break;
            }
        }
    }

}
