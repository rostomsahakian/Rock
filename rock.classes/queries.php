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
                /*
                 * This part deals with names under same parent 
                 * if the names are accidently inputed as the same then new name = name_$i 
                 */
                case "4":
                    $table[] = $table;
                    $fields[] = $fields;
                    $value[] = $value;
                    $sql = "SELECT `" . $fields['field1'] . "`  FROM `" . $table['table1'] . "`"
                            . " WHERE "
                            . "`" . $fields['field2'] . "` = '" . addslashes($value['value1']) . "'"
                            . " AND "
                            . "`" . $fields['field3'] . "` = '" . $value['value2'] . "'";


                    $result = $this->_mysqli->query($sql);
                    $num_rows = $result->num_rows;

                    if ($result && $num_rows > 1) {

                        $sql = "SELECT `" . $fields['field1'] . "`, `" . $fields['field2'] . "`   FROM `" . $table['table1'] . "`"
                                . " WHERE "
                                . "`" . $fields['field2'] . "` = '" . addslashes($value['value1']) . "'"
                                . " AND "
                                . "`" . $fields['field3'] . "` = '" . $value['value2'] . "'"
                                . "AND `" . $fields['field1'] . "` != '" . $value['value3'] . "'";

                        $result = $this->_mysqli->query($sql);
                        $num_rows = $result->num_rows;

                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }

                        $value_returned = $this->RetData();
                        if (count($value_returned > 0)) {
                            for ($i = 0; $i < count($value_returned); $i++) {
                                $new_name = $value_returned[$i]['name'] . "_" . $i;
                                $id = $value_returned[$i]['id'];
                                $tables_c = array("table1" => "pages");
                                $fields_c = array("field1" => "name", "field2" => "id");
                                $values_c = array("value1" => $new_name, "value2" => $id);
                                $data_to_update = array(
                                    "tables" => $tables_c,
                                    "fields" => $fields_c,
                                    "values" => $values_c
                                );
                                $fix_names = $this->UpdateQueriesServices($data_to_update, $option = "2");
                            }
                        }


                        return true;
                    } else {
                        return FALSE;
                    }

                    break;
                case "5":
                    $table[] = $table;
                    $fields[] = $fields;
                    $value[] = $value;
                    $sql = "SELECT COUNT(`" . $fields['field1'] . "`) AS '" . $value['value1'] . "' FROM `" . $table['table1'] . "`"
                            . " WHERE "
                            . "`" . $fields['field2'] . "` = '" . $value['value2'] . "'"
                            . " AND "
                            . "`" . $fields['field1'] . "` != '" . $value['value3'] . "'";

                    $result = $this->_mysqli->query($sql);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    if ((int) $row['num_specials'] > 1) {
                        $tables = array("table1" => $table['table1']);
                        $fields = array("field1" => $fields['field2'], "field2" => $fields['field2']);
                        $values = array("value1" => 0, "value2" => $value['value2']);
                        $only_one_page_as_home = array(
                            "tables" => $tables,
                            "fields" => $fields,
                            "values" => $values
                        );
                        $update_specials = $this->UpdateQueriesServices($only_one_page_as_home, $option = "2");
                    } else if ((int) $row['num_specials'] === 0) {

                        $tables = array("table1" => $table['table1']);
                        $fields = array("field1" => $fields['field2'], "field2" => $fields['field1']);
                        $values = array("value1" => 1, "value2" => $value['value3']);
                        $only_one_page_as_home = array(
                            "tables" => $tables,
                            "fields" => $fields,
                            "values" => $values
                        );
                        $update_specials = $this->UpdateQueriesServices($only_one_page_as_home, $option = "2");
                    }
                    $get_new_home_page_name = $this->GetData($table['table1'], $fields['field2'], 1, $option = "0");
                    break;
                    /*
                     * Return only the count
                     */
                case "6":
                    $sql = "SELECT COUNT(id) AS row_count FROM `".$table."` WHERE `".$fields."` = '".$value."'";
                    $result = $this->_mysqli->query($sql);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    if($result){
                        return $row;
                    }else{
                        return false;
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

                    $sql = "SELECT * FROM `" . $data['tables']['table1'] . "` WHERE `" . $data['fields']['field1'] . ""
                            . "`= '" . $this->_mysqli->real_escape_string($data['values']['value1']) . "'"
                            . " AND "
                            . "`" . $data['fields']['field2'] . "`"
                            . " = "
                            . "'" . $this->_mysqli->real_escape_string($data['values']['value2']) . "'";
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
                    $sql = "UPDATE `" . $data['tables']['table1'] . "` SET `" . $data['fields']['field1'] . ""
                            . "` = '" . (int) $data['values']['value1'] . "' WHERE `" . $data['fields']['field2'] . ""
                            . "` = '" . (int) $data['values']['value2'] . "'";
                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        return true;
                    } else {
                        return false;
                        exit;
                    }
                    break;
                case "2":
                    $sql = "UPDATE `" . $data['tables']['table1'] . "` SET `" . $data['fields']['field1'] . ""
                            . "` = '" . $data['values']['value1'] . "' WHERE `" . $data['fields']['field2'] . ""
                            . "` = '" . (int) $data['values']['value2'] . "'";
                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        return true;
                    } else {
                        return false;
                        exit;
                    }
                    break;
                case "3":
                    $sql = "UPDATE `" . $data['table'] . "` SET ";
                    for($i=0; $i < count($data['field']); $i++){
                    $sql .= "`" . $data['field'][$i] . "` =" . $data['value1'][$i];
                    }
                    $sql .= "WHERE `" . $data['field2'] . "` = '" . $data['value2'] . "'";
                  
                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        return true;
                    } else {
                        return false;
                    }
                    break;
            }
        }
    }

    public function findParent(array $data, $option = "0") {
        if ($option != "0") {

            switch ($option) {
                case "1":
                    $sql = "SELECT `".$data['select']."`, `parent` FROM `" . $data['table'] . "` WHERE `" . $data['field'] . "` = '" . (int) $data['value'] . "' ORDER BY `id` ASC";

                    $result = $this->_mysqli->query($sql);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $this->_parent[] = $row;
                    if ($row['parent'] != 0) {


                        $new_data = array(
                            "table" => "pages",
                            "field" => "id",
                            "select" => "name",
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
    
    public function Insertvalues(array $data, $option=0){
        
        if($option != 0){
            switch ($option){
                case "1":
                    $sql="INSERT INTO `".$data['tables']['table1']."`";
                        $sql .= " ( ";
                            $sql .= implode("," ,$data['columns']);
                        $sql .= " ) ";
                        $sql .= " VALUES ";
                        $sql .= " ( ";
                            $sql .= implode("," ,$data['values']);

                        $sql .= " ) ";
                       
                        
                        $result = $this->_mysqli->query($sql);
                        if($result){
                            return true;
                        }else{
                            return false;
                        }
                        
                    break;
            }
            
        }
    }

}
