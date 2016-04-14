<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of uploads
 *
 * @author rostom
 */
class uploads {

    public $_files_name;
    public $_path;
    public $_file_info = array();
    public $_header = array();
    private $_mysqli;
    private $_db;
    public $_res = array();
    public $_parent = array();
    public $_child = array();
    public $_nav = array();
    public $_queries;
    public $_forms;
    public $_brand_info;
    public $_message = array();

    public function __construct() {
        $this->_db = basics::getInstance();
        $this->_mysqli = $this->_db->getConnection();
        $this->_queries = new queries();
        //$this->_forms = new forms();
    }

    public function UploadFileFunction($data = NULL) {
        if ($data != NULL) {
            $dir = ABSOLUTH_PATH_FILE_BACKEND;

            foreach ($_FILES as $k => $file) {
                // Create directory if it does not exist
                if (!is_dir($dir . "Rock_Uploads_files/")) {
                    mkdir($dir . "Rock_Uploads_files/");
                }

                $clear_spaces = str_replace(" ", "", basename($file['name']["uploads"]["uploadfile"]));
                $clean_name = preg_replace('/[^a-zA-Z0-9,-]/', '_', $clear_spaces);
                $upload_file = $dir . "Rock_Uploads_files/" . $clean_name;



                $path = $dir . "Rock_Uploads_files/";

                $uploadOk = 1;

                $uploadFileType = pathinfo($upload_file, PATHINFO_EXTENSION);
            }



            if ($file["size"]['uploads']['uploadfile'] > 5000000) {
                $uploadOk == 0;
            }
            if ($uploadFileType != "csv") {
                $uploadOk == 0;
            }
            if ($uploadOk == 0) {
                
            } else {
                if (file_exists("$path/$upload_file")) {
                    unlink("$path/$upload_file");
                }

                if (move_uploaded_file($file["tmp_name"]['uploads']['uploadfile'], $upload_file)) {
                    $clear_spaces = str_replace(" ", "", basename($file['name']["uploads"]["uploadfile"]));
                    $clean_name = preg_replace('/[^A-Za-z0-9,-]/', '_', $clear_spaces);
                    $file_name = $clean_name;



                    $this->_files_name = $file_name;
                    $this->_path = $path;

                    $this->_file_info = array(
                        "filename" => $this->_files_name,
                        "path" => $this->_path,
                    );

                    array_push($this->_message, "File succesfully uploaded");

                    return $this->_file_info;
                } else {

                    return false;
                }
            }
        }
    }

    public function ReturnFileHeaders($table_name) {

        $clear_spaces = str_replace(" ", "", $table_name);
        $clean_name = preg_replace('/[^A-Za-z0-9,-]/', '_', $clear_spaces);
        $new_table_name = "rock_" . $clean_name . "_brand";

        $csv_file = $this->_file_info['path'] . $this->_file_info['filename']; // Name of your CSV file
        $row = 1;
        if (($handle = fopen($csv_file, "r")) !== FALSE) {
            fgetcsv($handle);
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                $row++;
                $csv_data[] = array($data);
            }



            /*
             * if table exists update that table values
             * Table Fields
             * 0. id
             * 1. item_name
             * 2. item_image_url
             * 3. price
             * 4. brand
             * 5. gender (if applicable)
             * 6. description
             * 7. color (if applicable)
             * 8. size (if applicable)
             * 9. model_number
             * 10. catergory
             * 11. status
             * 12. version
             * 13. year
             * 14. date_added 
             */

            $header_array = array(
                // 0 => "id", // (INT) 
                1 => "item_name VARCHAR (300)", //(VARCHAR 500)
                2 => "item_image_url VARCHAR (300)", //(VARCHAR 500)
                3 => "price VARCHAR (100)", //(VARCHAR 100)
                4 => "brand VARCHAR (300) ", // (VARCHAR 100)
                5 => "gender VARCHAR (35)", // (VARCHAR 35)
                6 => "description TEXT", //(TEXT)
                7 => "color VARCHAR (20)", //(VARCHAR 20)
                8 => "size VARCHAR (20)", // (VARCHAR 20)
                9 => "model_number VARCHAR (300)", //(VARCHAR 500)
                10 => "category VARCHAR (150)", // (VARCHAR 150)
                11 => "status INT NOT NULL", // (INT 2)
                12 => "version VARCHAR (120)", // (VARCHAR 300)
                13 => "year VARCHAR (10)", // (VARCHAR 10)
                    //14 => "date_added DATE" // (DATE)
            );



            /*
             * Now check for if the table exsists
             */



            $fields_for_table[] = $header_array;
            for ($j = 0; $j < count($fields_for_table); $j++) {
                
            }

            $table = "rock_" . $table_name . "_brand";

            $f = array();


            $create_table = array(
                "tablename" => $new_table_name,
                "f" => $fields_for_table,
            );
            $create = $this->_queries->CreateTableServices($create_table, $option = "0");
            if ($create) {


                /*
                 * Update Data or Insert new data to table
                 */
                $this->_queries->_res = NULL;
                $get_data_from_tabel = $this->_queries->GetData($new_table_name, NULL, NULL, $option = "7");
                $get_data_from_tabel = $this->_queries->RetData();


                $this->_queries->_res = NULL;
                $get_brand_infor = $this->_queries->GetData("brands", "brand", trim(addslashes($table_name)), $option = "0");
                $get_brand_infor = $this->_queries->RetData();
                if (count($get_brand_infor) < 1) {
                    $sql = "INSERT INTO `brands` (brand, table_name ,last_update) VALUES ('" . trim(addslashes($table_name)) . "', '" . $new_table_name . "' ,'" . date('Y,m,d') . "')";
                    $result = $this->_mysqli->query($sql);
                    $this->_queries->_res = NULL;
                    $get_brand_info = $this->_queries->GetData("brands", "brand", trim(addslashes($table_name)), $option = "0");
                    $get_brand_info = $this->_queries->RetData();
                    foreach ($get_brand_info as $brand) {
                        $this->_brand_info = $brand['id'];
                    }
                } else {

                    foreach ($get_brand_infor as $brand) {
                        $this->_brand_info = $brand['id'];
                    }
                }


                array_push($this->_message, "Table {$new_table_name} was created");
                array_push($this->_message, "Brand ID: {$this->_brand_info}");
                $count = count($get_data_from_tabel);
                /*
                 * If the table is empty insert the new data
                 */
                if ($count < 1) {



                    $data_value = array();

                    for ($i = 0; $i < count($csv_data); $i++) {

                        $header_array = array(
                            1 => "item_name",
                            2 => "item_image_url",
                            3 => "price",
                            4 => "brand",
                            5 => "gender",
                            6 => "description",
                            7 => "color",
                            8 => "size",
                            9 => "model_number",
                            10 => "category",
                            11 => "status",
                            12 => "version",
                            13 => "year",
                            14 => "added_date",
                            15 => "brand_id"
                        );


                        $insert_csv = array();

                        $insert_csv['item_name'] = $csv_data[$i][0][1];
                        $insert_csv['item_image_url'] = $csv_data[$i][0][2];
                        $insert_csv['price'] = $csv_data[$i][0][3];
                        $insert_csv['brand'] = $csv_data[$i][0][4];
                        $insert_csv['gender'] = $csv_data[$i][0][5];
                        $insert_csv['description'] = $csv_data[$i][0][6];
                        $insert_csv['color'] = $csv_data[$i][0][7];
                        $insert_csv['size'] = $csv_data[$i][0][8];
                        $insert_csv['model_number'] = $csv_data[$i][0][9];
                        $insert_csv['category'] = $csv_data[$i][0][10];
                        $insert_csv['status'] = $csv_data[$i][0][11];
                        $insert_csv['version'] = $csv_data[$i][0][12];
                        $insert_csv['year'] = $csv_data[$i][0][13];
                        $insert_csv['added_date'] = date("Y,m,d");
                        $insert_csv['brand_id'] = $this->_brand_info;



                        $data_for_insertion = array(
                            "'" . trim($insert_csv['item_name']) . "'",
                            "'" . trim($insert_csv['item_image_url']). "'",
                            "'" . trim($insert_csv['price']). "'",
                            "'" . trim($insert_csv['brand']). "'",
                            "'" . trim($insert_csv['gender']). "'",
                            "'" . trim($insert_csv['description']). "'",
                            "'" . trim($insert_csv['color']). "'",
                            "'" . trim($insert_csv['size']). "'",
                            "'" . trim($insert_csv['model_number']). "'",
                            "'" . trim($insert_csv['category']). "'",
                            "'" . $insert_csv['status']. "'",
                            "'" . trim($insert_csv['version']). "'",
                            "'" . trim($insert_csv['year']). "'",
                            "'" . $insert_csv['added_date'] . "'",
                            "'" . trim($insert_csv['brand_id']) . "'"
                        );




                        $data_value[] = $data_for_insertion;
                    }


                    //var_dump($data_value);
                    $table_to_insert = array("table1" => $new_table_name);
                    $data_to_insert = array(
                        "tables" => $table_to_insert,
                        "columns" => $header_array,
                        "values" => $data_value
                    );


                    $table_to_insert_all_products = array("table1" => "all_products");
                    $data_to_insert_all_products = array(
                        "tables" => $table_to_insert_all_products,
                        "columns" => $header_array,
                        "values" => $data_value
                    );





                    $insert_new_data_into_all_table = $this->_queries->Insertvalues($data_to_insert_all_products, $option = "3");
                    $insert_new_data_into_table = $this->_queries->Insertvalues($data_to_insert, $option = "3");
                    if ($insert_new_data_into_table) {
                        $rows_effected = (int) $row - 1;
                        array_push($this->_message, "{$rows_effected} rows were inserted");
                    } else {

                        array_push($this->_message, "Unable to insert");
                    }
                    fclose($handle);
                } else {
                    /*
                     * If there are values then
                     * read file line by line and compare value with table value
                     * if the same ignore
                     * if diffenet update
                     * if no value match enter line
                     */
                    array_push($this->_message, "Data Updated");
                    $row = 1;
                    if (($handle = fopen($csv_file, "r")) !== FALSE) {
                        fgetcsv($handle);
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $num = count($data);
                            $row++;

                            $sql = "SELECT * FROM `" . $new_table_name . "` WHERE `model_number` = '" . $data[9] . "'";
                            $result = $this->_mysqli->query($sql);
                            $num_rows = $result->num_rows;
                            if ($num_rows > 0) {

                                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                                    
                                }

                                if ($row['item_name'] == $data[1]) {

                                    continue;
                                } else {
                                    $sql = "UPDATE `" . $new_table_name . "` SET `item_name` = '" . $data[1] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result = $this->_mysqli->query($sql);
                                    $sql_all = "UPDATE `all_products` SET `item_name` = '" . $data[1] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result_all = $this->_mysqli->query($sql_all);
                                }


                                if ($row['item_image_url'] != $data[2]) {
                                    $sql = "UPDATE `" . $new_table_name . "` SET `item_image_url` = '" . $data[2] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result = $this->_mysqli->query($sql);
                                    $sql_all = "UPDATE `all_products` SET `item_name` = '" . $data[2] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result_all = $this->_mysqli->query($sql_all);
                                }



                                if ($row['price'] != $data[3]) {
                                    $sql = "UPDATE `" . $new_table_name . "` SET `price` = '" . $data[3] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result = $this->_mysqli->query($sql);
                                    $sql_all = "UPDATE `all_products` SET `item_name` = '" . $data[3] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result_all = $this->_mysqli->query($sql_all);
                                }
                                if ($row['brand'] != $data[4]) {
                                    $sql = "UPDATE `" . $new_table_name . "` SET `price` = '" . $data[4] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result = $this->_mysqli->query($sql);
                                    $sql_all = "UPDATE `all_products` SET `item_name` = '" . $data[4] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result_all = $this->_mysqli->query($sql_all);
                                }

                                if ($row['gender'] != $data[5]) {
                                    $sql = "UPDATE `" . $new_table_name . "` SET `gender` = '" . $data[5] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result = $this->_mysqli->query($sql);
                                    $sql_all = "UPDATE `all_products` SET `item_name` = '" . $data[5] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result_all = $this->_mysqli->query($sql_all);
                                }

                                if ($row['description'] != $data[6]) {
                                    $sql = "UPDATE `" . $new_table_name . "` SET `description` = '" . $data[6] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result = $this->_mysqli->query($sql);
                                    $sql_all = "UPDATE `all_products` SET `item_name` = '" . $data[6] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result_all = $this->_mysqli->query($sql_all);
                                }



                                if ($row['color'] != $data[7]) {
                                    $sql = "UPDATE `" . $new_table_name . "` SET `color` = '" . $data[7] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result = $this->_mysqli->query($sql);
                                    $sql_all = "UPDATE `all_products` SET `item_name` = '" . $data[7] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result_all = $this->_mysqli->query($sql_all);
                                }



                                if ($row['size'] != $data[8]) {
                                    $sql = "UPDATE `" . $new_table_name . "` SET `size` = '" . $data[8] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result = $this->_mysqli->query($sql);
                                    $sql_all = "UPDATE `all_products` SET `item_name` = '" . $data[8] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result_all = $this->_mysqli->query($sql_all);
                                }



                                if ($row['model_number'] != $data[9]) {
                                    $sql = "UPDATE `" . $new_table_name . "` SET `model_number` = '" . $data[9] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result = $this->_mysqli->query($sql);
                                    $sql_all = "UPDATE `all_products` SET `item_name` = '" . $data[9] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result_all = $this->_mysqli->query($sql_all);
                                }


                                if ($row['category'] != $data[10]) {
                                    $sql = "UPDATE `" . $new_table_name . "` SET `category` = '" . $data[10] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result = $this->_mysqli->query($sql);
                                    $sql_all = "UPDATE `all_products` SET `item_name` = '" . $data[10] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result_all = $this->_mysqli->query($sql_all);
                                }


                                if ($row['status'] != $data[11]) {
                                    $sql = "UPDATE `" . $new_table_name . "` SET `status` = '" . $data[11] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result = $this->_mysqli->query($sql);
                                    $sql_all = "UPDATE `all_products` SET `item_name` = '" . $data[11] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result_all = $this->_mysqli->query($sql_all);
                                }



                                if ($row['version'] != $data[12]) {
                                    $sql = "UPDATE `" . $new_table_name . "` SET `version` = '" . $data[12] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result = $this->_mysqli->query($sql);
                                    $sql_all = "UPDATE `all_products` SET `item_name` = '" . $data[12] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result_all = $this->_mysqli->query($sql_all);
                                }


                                if ($row['year'] != $data[13]) {
                                    $sql = "UPDATE `" . $new_table_name . "` SET `year` = '" . $data[13] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result = $this->_mysqli->query($sql);
                                    $sql_all = "UPDATE `all_products` SET `item_name` = '" . $data[13] . "' WHERE `model_number` ='" . $data[9] . "'";
                                    $result_all = $this->_mysqli->query($sql_all);
                                }
                            } else {


                                $sql = "INSERT INTO `" . $new_table_name . "` (item_name, item_image_url, price, brand, gender, description, color, size, model_number, category, status,"
                                        . "version, year, added_date) VALUES ('" . $data[1] . "','" . $data[2] . "','" . $data[3] . "','" . $data[4] . "','" . $data[5] . "','" . $data[6] . "','" . $data[7] . "',"
                                        . "'" . $data[8] . "','" . $data[9] . "','" . $data[10] . "','" . $data[11] . "','" . $data[12] . "','" . $data[13] . "', '" . date("Y, m,d") . "', '" . $this->_brand_info . "')";
                                $result = $this->_mysqli->query($sql);


                                $sql_all = "INSERT INTO `all_products` (item_name, item_image_url, price, gender, description, color, size, model_number, category, status,"
                                        . "version, year, added_date) VALUES ('" . $data[1] . "','" . $data[2] . "','" . $data[3] . "','" . $data[4] . "','" . $data[5] . "','" . $data[6] . "','" . $data[7] . "',"
                                        . "'" . $data[8] . "','" . $data[9] . "','" . $data[10] . "','" . $data[11] . "','" . $data[12] . "','" . $data[13] . "', '" . date("Y, m,d") . "', '" . $this->_brand_info . "')";
                                $result_all = $this->_mysqli->query($sql_all);

                                if ($result) {
                                    array_push($this->_message, "New data inserted");
                                } else {
                                    array_push($this->_message, "unable to insert");
                                }
                            }
                        }
                        fclose($handle);
                    }
                }
            }
        }
    }

    /*
     * By Designer or by different category
     */

    public function SelectionOfParentNode() {
        
    }

    public function returnSelection() {
        
    }

    public function CreateTableBasedOnselection() {
        
    }

    public function BegingUploadingToDB() {
        
    }

    public function RetMessageTo() {
        return $this->_message;
    }

}
