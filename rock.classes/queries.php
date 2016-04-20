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
    public $_nav = array();

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
                /*
                 * Returns all data
                 */
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
                    $sql = "SELECT COUNT(id) AS row_count FROM `" . $table . "` WHERE `" . $fields . "` = '" . $value . "'";
                    $result = $this->_mysqli->query($sql);
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    if ($result) {
                        return $row;
                    } else {
                        return false;
                    }
                    break;
                case "7":
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
                case "8":
                    $sql = "SELECT DISTINCT `" . $fields . "` FROM `" . $table . "`";
                    $result = $this->_mysqli->query($sql);

                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                            $this->_res[] = $row;
                        }
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case "9":

                    $sql = "SELECT `" . $fields['field1'] . "`, `" . $fields['field2'] . "`, `parent` FROM `" . $table . "` WHERE `" . $fields['field1'] . "` = '" . $value['value1'] . "' AND `" . $fields['field3'] . "` = '" . $value['value2'] . "'";
                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }
                        return true;
                    } else {
                        return false;
                    }
                    break;
                case "10":

                    $sql = "SELECT DISTINCT `" . $fields['field1'] . "` FROM `" . $table . "` WHERE `" . $fields['field2'] . "` = '" . $value . "'";
//                            . "'" . $fields['limit'] . "'";
//                  var_dump($sql);

                    $result = $this->_mysqli->query($sql);

                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }

                        return true;
                    } else {
                        return false;
                    }

                    break;
                case "11":

                    $sql = "SELECT * FROM `" . $table . "` WHERE `" . $fields['field1'] . "` = '" . $value['value1'] . "' AND `" . $fields['field3'] . "` = '" . $value['value2'] . "'";
                    $result = $this->_mysqli->query($sql);
//                    echo "<br/>";
//                    var_dump($sql);
//                    echo "<br/>";
                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }
                        return true;
                    } else {
                        return false;
                    }
                    break;
                case "12":

                    $sql = "SELECT DISTINCT `" . $fields['field1'] . "`, `" . $fields['field2'] . "` FROM `" . $table . "` WHERE `" . $fields['field3'] . "` = '" . $value . "'";
                    $result = $this->_mysqli->query($sql);

                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }

                        return true;
                    } else {
                        return false;
                    }

                    break;
                case "13":
                    $sql = "SELECT DISTINCT `" . $fields['field1'] . "`  FROM `" . $table . "` WHERE `" . $fields['field2'] . "` = '" . $value . "' ORDER BY RAND() LIMIT 1";
//                    var_dump($sql);
                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case "14":
                    $sql = "SELECT *   FROM `" . $table . "` WHERE "
                            . "`" . $fields['field1'] . "`  = '" . $value['value1'] . "'"
                            . " AND "
                            . "`" . $fields['field2'] . "`  = '" . $value['value2'] . "'"
                            . " AND "
                            . "`" . $fields['field3'] . "`  = '" . $value['value3'] . "'";
//                echo "<br/>";        
//                var_dump($sql);
//                echo "<br/>";
                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }
                        return true;
                    } else {
                        return false;
                    }
                    break;
                case "15":
                    $sql = "SELECT id,name,parent FROM `pages` WHERE `parent` = '" . $value . "' ORDER BY ord, name ASC";
                    $cats = array();
                    $result = $this->_mysqli->query($sql);
                    while ($rows = $result->fetch_array(MYSQLI_ASSOC)) {

                        $this->GetData("", "", $rows['id'], $option = "15");

                        $this->_res[] = $rows;
                    }
                    break;
                case "16":
                    $sql = "SELECT *  FROM `" . $table . "` WHERE `" . $fields['field1'] . "` = '" . $value . "'  ORDER BY RAND() LIMIT {$fields['limit']}";
//                    var_dump($sql);
                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }
                        return true;
                    } else {
                        return false;
                    }
                    break;
                case "17":
                    $sql = "SELECT *  FROM `" . $table . "` WHERE `" . $fields['field1'] . "` = '" . $value['value1'] . "' AND `" . $fields['field2'] . "` = '" . $value['value2'] . "'  ORDER BY RAND() LIMIT {$fields['limit']}";

                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case "18":

                    $sql = "SELECT * FROM `" . $table . "` WHERE `" . $fields['field1'] . "` = '" . $value['value1'] . "' AND `" . $fields['field2'] . "` = '" . $value['value2'] . "' LIMIT {$value['value3']} , {$value['value4']}";
                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                        }
                        return true;
                    } else {
                        return false;
                    }
                case "19":

                    $sql = "SELECT * FROM `" . $table . "` WHERE `" . $fields['field1'] . "` = '" . $value['value1'] . "' AND `" . $fields['field2'] . "` = '" . $value['value2'] . "'";
                    $result = $this->_mysqli->query($sql);
                    $num_rows = $result->num_rows;
                    if ($result) {
                        return $num_rows;
                    } else {
                        return false;
                    }
                case "20":

                    $sql = "SELECT * FROM `" . $table . "` WHERE `" . $fields . "` = '" . $value['value1'] . "' LIMIT {$value['value2']}";

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
                case "21":

                    $sql = "SELECT * FROM `" . $table . "` WHERE `" . $fields . "`= '" . $value['value1'] . "' ORDER By {$value['value2']}";
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
                    for ($i = 0; $i < count($data['field']); $i++) {
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
                case "4":

                    for ($i = 0; $i < count($data['values']); $i++) {
                        $sql = "UPDATE `" . $data['table'] . "` SET  ";
                        for ($j = 0; $j < count($data['fields']); $j++) {
                            $sql .= "`" . $data['fields'][$j] . "`";
                            $sql .= " = " . $data['values'][$i][$j];
                        }
                        $sql .= " WHERE `" . $data['field2'] . "` = '" . $data['value2'][$i]['id'] . "'";
                        $result = $this->_mysqli->query($sql);
                    }

                    if ($result) {
                        return true;
                    } else {
                        return false;
                    }
                    break;
                case "5":

                    for ($i = 0; $i < count($data['values']); $i++) {
                        $sql = "UPDATE `" . $data['table'] . "` SET  ";
                        for ($j = 0; $j < count($data['fields']); $j++) {
                            $sql .= "`" . $data['fields'][$j] . "`";
                            $sql .= " = " . $data['values'][$i];
                            $sql .= " WHERE `" . $data['field2'] . "` = '" . $data['value2'][$i] . "'";
                        }


                        $result = $this->_mysqli->query($sql);
                    }

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
                    $sql = "SELECT `" . $data['select'] . "`, `parent` FROM `" . $data['table'] . "` WHERE `" . $data['field'] . "` = '" . (int) $data['value'] . "' ORDER BY `id` ASC";
//                    var_dump($sql);
                    $result = $this->_mysqli->query($sql);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $this->_parent[] = $row;
                    if ($row['parent'] != "0") {


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

                case "3":
                    if ($data['value1'] != 0 || $data['value1'] != "0") {

                        $sql = "SELECT * FROM `" . $data['table'] . "` WHERE `" . $data['field1'] . "` = '" . $data['value1'] . "'";

                        $result = $this->_mysqli->query($sql);
                        $row = $result->fetch_array(MYSQLI_ASSOC);

                        if ($row['parent'] != 0 || $row['parent'] != "0") {
                            // $data['value1'] = $row['id'];
                            $this->_res[] = $row;

                            $new_data = array(
                                "table" => "pages",
                                "field1" => "id",
                                "value1" => $row['parent']
                            );
                            $this->findParent($new_data, $option = "3");
                        }

                        return $this->_res;
                    } else {
                        $this->GetData("pages", $data['field2'], "0", $option = "0");
                    }
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

                    $result = $this->_mysqli->query($sql);
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        if (count($row) < 1) {

                            return false;
                        } else {
                            $this->_res[] = $row;

                            $data['values']['value1'] = $row['id'];

                            $find_all = $this->findChildren($data, $option = 1);
                        }
                    }

                    break;

                case 2:
                    $sql = "SELECT * FROM `" . $data['table'] . "` WHERE `" . $data['field'] . "` = '" . $data['value'] . "'";
                    $result = $this->_mysqli->query($sql);
                    $num_rows = $result->num_rows;
                    if ($num_rows > 0) {

                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_res[] = $row;
                            $data['value'] = $row['id'];
                            $this->findChildren($data, $option = 2);
                        }
                    } else {
                        return false;
                    }
                    break;
            }
        }
    }

    public function Insertvalues(array $data, $option = 0) {

        if ($option != 0) {
            switch ($option) {
                case "1":
                    $sql = "INSERT INTO `" . $data['tables']['table1'] . "`";
                    $sql .= " ( ";
                    $sql .= implode(",", $data['columns']);
                    $sql .= " ) ";
                    $sql .= " VALUES ";
                    $sql .= " ( ";
                    $sql .= implode(",", $data['values']);

                    $sql .= " ) ";
                    echo "<br/>";
                    var_dump($sql);
                    echo "<br/>";
                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        return true;
                    } else {
                        return false;
                    }

                    break;
                case "2":
                    for ($i = 0; $i < count($data['values']); $i++) {
                        $sql = "INSERT INTO `" . $data['tables']['table1'] . "`";
                        $sql .= " ( ";

                        $sql .= implode(",", $data['columns']);
                        $sql .= " ) ";
                        $sql .= " VALUES ";
                        $sql .= " ( ";
                        $sql .= implode(",", $data['values'][$i]);

                        $sql .= " ) ";


                        $result = $this->_mysqli->query($sql);
                    }
                    if ($result) {
                        return true;
                    } else {
                        return false;
                    }

                    break;
                case "3":
                    for ($i = 0; $i < count($data['values']); $i++) {
                        $sql = "INSERT INTO `" . $data['tables']['table1'] . "`";
                        $sql .= " ( ";

                        $sql .= trim(implode(",", $data['columns']));
                        $sql .= " ) ";
                        $sql .= " VALUES ";
                        $sql .= " ( ";
                        $sql .= trim(implode(", ", $data['values'][$i]));

                        $sql .= " ) ";
                        $result = $this->_mysqli->query($sql);
                    }
                    if ($result) {
                        return true;
                    } else {
                        return false;
                    }

                    break;
            }
        }
    }

    public function NavigationQuaries($id, $self, $option = NULL) {
        $nav = array();
        /*
         * Navigation options
         * 0 => with order of id
         * 1 => alphbetically 
         * 2 => TBD
         */
        if ($option != NULL) {
            switch ($option) {
                /*
                 * Case 0 with id order
                 */
                case "0":
                    $sql = "SELECT * FROM `pages` WHERE `parent`= '" . $id . "' ";
                    $result = $this->_mysqli->query($sql);
                    if ($result) {

                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                            $this->_nav[] = $row;
                            $parent_id = $row['id'];
                            $type = $row['type'];

                            $find_nav = $this->NavigationQuaries($parent_id, $parent_id, "0");
                        }
                        return $this->_nav;
                    }

                    break;
                case "1":
                    $sql = "SELECT * FROM `pages` WHERE `parent` != '" . $id . "' AND `type` ='" . $page_type . "'";
                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                            $this->_nav[] = $row;
                        }
                        return $this->_nav;
                    } else {
                        return false;
                    }
            }
        }
    }

    public function DeleteServices($to_delete, $option = NULL) {
        if ($option != NULL) {

            switch ($option) {

                case "0":
                    $sql = "SELECT COUNT(id) AS number_pages FROM `pages`";
                    $result = $this->_mysqli->query($sql);
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    if ($row['number_pages'] < 2) {
                        return false;
                    } else {
                        for ($i = 0; $i < count($to_delete['tables']); $i++) {
                            $sql = "DELETE FROM `" . $to_delete['tables'][$i] . "`  WHERE `" . $to_delete['fields'][$i] . "` = '" . $to_delete['value'] . "'";
                            $result = $this->_mysqli->query($sql);
                        }

                        if ($result) {
                            return true;
                        }
                    }
                    break;
                case "1":
                    $sql = "DELETE FROM `" . $to_delete['table'] . "` WHERE `" . $to_delete['field1'] . "` = '" . $to_delete['value1'] . "' AND `" . $to_delete['field2'] . "` = '" . $to_delete['value2'] . "'";
                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        return true;
                    }
                    break;

                case "2":
                    $sql = "DELETE FROM `" . $to_delete['table'] . "` WHERE `" . $to_delete['field1'] . "` = '" . $to_delete['value1'] . "'";

                    $result = $this->_mysqli->query($sql);
                    if ($result) {
                        return true;
                    }
                    break;
            }
        }
    }

    public function CreateTableServices(array $table_to_create, $option = NULL) {
        if ($option != NULL) {
            switch ($option) {
                case "0":
//                    $sql = "SHOW TABLES LIKE '" . $table_to_create['tablename'] . "'";
//                    $Table_exists = $this->_mysqli->query($sql);
//                    $table_num = $Table_exists->num_rows;
//                    if ($table_num > 0) {
//                        return false;
//                    } else {

                    $sql = "CREATE TABLE IF NOT EXISTS `" . $table_to_create['tablename'] . "`"
                            . " ("
                            . "id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, ";
                    for ($i = 0; $i < count($table_to_create['f']); $i++) {

                        $sql .= implode(", ", $table_to_create['f'][$i]);
                    }
                    $sql.= " ,added_date DATETIME, brand_id INT NOT NULL";

                    $sql.= " )";

                    $result = $this->_mysqli->query($sql);

                    if ($result) {
                        return true;
                    } else {
                        return false;
                    }
//                    }
                    break;
                case "1":
                    $sql = "SHOW TABLES FROM rock_cmsdb LIKE '%" . $table_to_create['patern'] . "%'";

                    $table_res = $this->_mysqli->query($sql);
                    while ($row = $table_res->fetch_array(MYSQLI_ASSOC)) {
                        $this->_res[] = $row;
                    }

                    break;
            }
        }
    }

}
