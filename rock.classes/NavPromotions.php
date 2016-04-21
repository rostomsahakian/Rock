<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NavPromotions
 *
 * @author rostom
 */
class NavPromotions {

    public $_queries;
    public $_pages_data;
    public $promo_images;

    public function __construct() {
        $this->_queries = new queries();
        $this->GetAllTopLevelpages();
    }

    public function PromotionsForNaviagtion() {
        $flag = 0;
        if (isset($_REQUEST['form']['promo']['douploadimage'])) {

            $page_id = $_REQUEST['form']['promo']['promo_page_info'];

            if ($page_id == "--") {
                $flag = 1;
                if ($flag == 1) {
                    echo "error please select a page";
                } else {
                    $flag = 0;
                }
            } else {

                $this->Do_Upload_images($_POST['form']['promo']['douploadimage'], ABSOLUTH_PATH_IMAGE_FRONT_END, DATE_ADDED, (int) $page_id, NULL);
            }
        }
        if (isset($_REQUEST['do_del'])) {



            $to_delete = array(
                "table" => "promotional_images",
                "field1" => "id",
                "value1" => $_REQUEST['image_id']
            );
            $do_delete = $this->_queries->DeleteServices($to_delete, $option = "2");
            if ($do_delete) {
                $message = "<li class='list-group-item list-group-item-warning'><i class='glyphicon glyphicon-info-sign'></i>&nbsp;"
                        . "Image deleted.</li>";
                $path = $_REQUEST['image_path'];
                if (file_exists($path)) {
                    unlink($path);
                }
                echo $message;
            }
        }
        ?>

        <div class="col-md-12">
            <ul class="list-group">

            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                    &nbsp; Upload images for your navigation promotions
                </div>
                <div class="panel-body">
                    <form method="post" enctype="multipart/form-data" name="form[promo]" >
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group">
                                    <label>Please select the dropdown page that you would like to add the promotional image.</label>
                                    <select name="form[promo][promo_page_info]">
                                        <option value="--">--Select a page--</option>
                                        <!--Get all the top level pages -->
        <?php
        if ($this->SetAllTopLevelpages() != NULL) {
            foreach ($this->SetAllTopLevelpages() as $top_levels_with_child) {
                ?>
                                                <option value="<?= $top_levels_with_child['id'] ?>"><?= $top_levels_with_child['name'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>



                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">

                                <input type="file" name="form[promo][uploadimage]"  class="btn btn-default btn-xs"/>

                                <input type="submit" class="btn btn-danger btn-xs" name="form[promo][douploadimage]" value="Upload" style="margin-top: 10px;"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Uploaded Promotional images
                </div>
                <div class="panel-body">
                    <div class="row">
        <?php
        $this->GetAllPromotionalImages();
        if ($this->SetAllPromotionalImages() != NULL) {
            foreach ($this->SetAllPromotionalImages() as $promo_images) {
                ?>

                                <div class="col-xs-7 col-md-2">
                                    <a href="#" class="thumbnail">                                    

                                        <img src="<?= $promo_images['image_path'] . $promo_images['image_name'] ?>"/>
                                    </a>
                                    <div class="caption" style="margin-bottom:10px;">
                                        <form method="post">
                                            <input type="hidden" name="image_path" value="<?= $promo_images['image_path'] . $promo_images['image_name'] ?>" />
                                            <input type="hidden" name="image_id" value="<?= $promo_images['id'] ?>" />
                                            <input type="submit" name="do_del" value="delete" class="btn btn-danger btn-xs" />
                                        </form>

                                    </div>
                                </div>




                <?php
            }
        } else {
            echo "No promotional images.";
        }
        ?>
                    </div>
                </div>
            </div>
        </div>


        <?php
    }

    public function GetAllTopLevelpages() {


        $this->_queries->_res = NULL;
        $get_top_levels = $this->_queries->GetData("pages", "parent", "0", "0");
        $get_top_levels = $this->_queries->RetData();
        //Now check to see if they have any children
        if (count($get_top_levels) > 0) {
            $save_info = array();
            foreach ($get_top_levels as $top_level) {
                $save_top_level = array();
                $save_top_level['id'] = $top_level['id'];
                $save_top_level['name'] = $top_level['name'];
                $save_top_level['children'] = array();

                $this->_queries->_res = NULL;
                $check_for_children = $this->_queries->GetData("pages", "parent", $top_level['id'], "0");
                $check_for_children = $this->_queries->RetData();
                if (count($check_for_children) > 0 && $check_for_children != NULL) {
                    foreach ($check_for_children as $child_of_top) {
                        $save_children = array();
                        $save_children['id'] = $child_of_top['id'];
                        $save_children['name'] = $child_of_top['name'];

                        array_push($save_top_level['children'], $save_children);
                    }
                    array_push($save_info, $save_top_level);
                    $this->_pages_data = $save_info;
                }
            }
        }
    }

    public function SetAllTopLevelpages() {
        return $this->_pages_data;
    }

    /*
     * Upload Images
     * It will got to a frontend fold and will have its own directory for each page type
     */

    public function Do_Upload_images($image, $path, $date_added, $page_uid, $page_type = NULL) {

        $this->_queries->_res = NULL;
        $get_number_of_images = $this->_queries->GetData("promotional_images", "page_id", $page_uid, $option = "6");


        $number = $get_number_of_images['row_count'];
        if ($number < "1") {
            var_dump($number);
            $dir = ABSOLUTH_PATH_IMAGES;

            foreach ($_FILES as $k => $file) {
                // Create directory if it does not exist
                if (!is_dir(ABSOLUTH_PATH_IMAGE_FRONT_END . "page_id_" . $page_uid . "_images/")) {
                    mkdir(ABSOLUTH_PATH_IMAGE_FRONT_END . "page_id_" . $page_uid . "_images/");
                }


                $upload_file_new_name = preg_replace('/^.*\.([^.]+)$/D', "image_" . $page_uid . "_" . ((int) $number + 1) . ".$1", basename($file['name']["promo"]["uploadimage"]));


                $upload_file = ABSOLUTH_PATH_IMAGE_FRONT_END . "page_id_" . $page_uid . "_images/" . $upload_file_new_name;


                $path = "/r.frontend/images/page_id_" . $page_uid . "_images/";
                $uploadOk = 1;

                $imageFileType = pathinfo($upload_file, PATHINFO_EXTENSION);
            }

            if (isset($_POST['form']['promo']['douploadimage'])) {

                $check = getimagesize($file["tmp_name"]['promo']['uploadimage']);

                if ($check !== FALSE) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
            }
            if (file_exists($upload_file)) {
                $uploadOk = 0;
            }
            if ($file["size"]['promo']['uploadimage'] > 5000000) {
                
            }
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                
            } else {

                if (move_uploaded_file($file["tmp_name"]['promo']['uploadimage'], $upload_file)) {

                    $image_name = preg_replace('/^.*\.([^.]+)$/D', "image_" . $page_uid . "_" . ((int) $number + 1) . ".$1", basename($file['name']["promo"]["uploadimage"]));

                    $table = array("table1" => "promotional_images");
                    $columns = array("`page_id`", "`image_name`", "`image_path`", "`date_added`");

                    $values = array("'" . $page_uid . "'", "'" . $image_name . "'", "'" . $path . "'", "'" . DATE_ADDED . "'");
                    $values_to_insert = array(
                        "tables" => $table,
                        "columns" => $columns,
                        "values" => $values
                    );
                    $insert_images_into = $this->_queries->Insertvalues($values_to_insert, $option = "1");
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            $flag = 1;
            if ($flag == 1) {
                $message = "<li class='list-group-item list-group-item-warning'><i class='glyphicon glyphicon-info-sign'></i>&nbsp;"
                        . "Only one image per page is allowed. Please delete the previous image.</li>";
                echo $message;
            }
        }
    }

    public function GetAllPromotionalImages() {

        $this->_queries->_res = NULL;
        $images = $this->_queries->GetData("promotional_images", NULL, NULL, "7");
        $images = $this->_queries->RetData();
        if ($images != NULL && count($images) > 0) {
            $this->promo_images = $images;
        }
    }

    public function SetAllPromotionalImages() {
        return $this->promo_images;
    }

}
